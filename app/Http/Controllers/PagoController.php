<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoDomiciliarioRequest;
use App\Http\Requests\PagoEstadoRequest;
use App\Mail\CambioDeEstadoMail;
use App\Models\Cliente;
use App\Models\Domiciliario;
use App\Models\Pago;
use App\Models\PagoDomiciliario;
use App\Models\PagoEstado;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PagoController extends Controller
{
    public function tabla()
    {

        $pagos = Pago::whereNotIn("estado", ['ENTREGADO', 'CANCELADO'])->get();

        return view('pago.tabla', [
            'pagos' => $pagos
        ]);
    }

    public function detalles($id)
    {

        $pago = Pago::find($id);
        $productos = Producto::join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $id)
            ->orderBy("orden_cat")
            ->get();

        return view('pago.detalles', [
            'pago' => $pago,
            'productos' => $productos
        ]);
    }

    public function verificarExistencia(Request $request)
    {
        $pago = Pago::find($request->id_pedido);
        if (isset($pago)) {
            return redirect()->route('pago.detalles', ['id' => $request->id_pedido]);
        } else {
            return redirect()->route('pago.tabla')->with('error', 'El ID de pedido ' . $request->id_pedido . ' no existe');
        }
    }

    public function imprimir($id)
    {
        $pago = Pago::find($id);
        $productos = Producto::select("producto.*", "producto_pago.*")
            ->join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $id)
            ->orderBy("orden_cat")
            ->get();

        return view('pago.imprimir', [
            'pago' => $pago,
            'productos' => $productos
        ]);
    }

    public function generarXLS($id)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=pedidoid_" . $id . ".xls");
        $pago = Pago::find($id);
        $productos = Producto::select("producto.*", "producto_pago.*")
            ->join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $id)
            ->orderBy("orden_cat")
            ->get();
        echo view('pago.reportes.productosPedido', [
            'pago' => $pago,
            'productos' => $productos
        ]);
    }

    public function mostrarFormCEstado($id)
    {
        $pago = Pago::find($id);
        $ultimoEstado = PagoEstado::where("fk_pago", "=", $id)->orderBy("idpago_estado", "desc")->first();
        return view('pago.c_estado', [
            'pago' => $pago,
            'ultimoEstado' => $ultimoEstado
        ]);
    }

    public function cambiarEstado($id, PagoEstadoRequest $request)
    {
        $pago_estado = new PagoEstado();
        $pago_estado->estado = $request->estado;
        $pago_estado->descripcion = $request->descripcion;
        $pago_estado->fk_pago = $id;
        $pago_estado->save();

        $pago = Pago::find($id);
        $pago->tipo_pago = $request->tipo_pago;
        $pago->estado = $request->estado;
        $pago->save();

        if ($request->estado == "ENTREGADO" || $request->estado == "CANCELADO") {
            PagoDomiciliario::where("fk_pago", "=", $id)->delete();
        }
        $mailData = [
            'title' => 'Tu pedido ha cambiado de estado',
            'body' => 'Tu pedido # ' . $id . ' ha cambiado a estado ' . $request->estado
        ];
        try {
            Mail::to($pago->cliente->email)->send(new CambioDeEstadoMail($mailData));
        } catch (Exception $e) {
            return redirect()->route('pago.tabla', ['id' => $id])->with('warning', 'Estado actualizado, sin embargo no se pudo enviar el email al usuario');
        }
        return redirect()->route('pago.tabla', ['id' => $id])->with('mensaje', 'Estado actualizado correctamente');
    }

    public function reporteReferidos()
    {
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=Referidos.xls");
        $clientes = Cliente::select(
            "cliente.idcliente",
            "cliente.nombre",
            "cliente.apellido",
            "cliente.email",
            "cliente.celular",
            "cliente.fijo",
            DB::raw("GROUP_CONCAT(CONCAT_WS(' ',c2.idcliente,c2.nombre,c2.apellido,c2.fijo) SEPARATOR ', ') as 'misreferidos'")
        )
            ->join("pago as p", "p.cd_referido", "=", "cliente.fijo")
            ->join("cliente as c2", "c2.idcliente", "=", "p.fk_cliente")
            ->groupBy(
                "cliente.idcliente",
                "cliente.nombre",
                "cliente.apellido",
                "cliente.email",
                "cliente.celular",
                "cliente.fijo",
            )
            ->get();






        echo view('pago.reportes.referidos', [
            'clientes' => $clientes
        ]);
    }
    public function reportePedidosHoy()
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=PedidosHoy" . date("Y-m-d") . ".xls");

        $pagos = Pago::select(
            "pago.estado",
            "pago.idpago",
            "pago.fecha_recib",
            "pago.hora_recib",
            "c.nombre as nombre_cliente",
            "c.apellido as apellido_cliente",
            "d.direccionCompleta",
            "d.barrio",
            "c.celular",
            "dom.nombre as nombre_domiciliario",
            "dom.apellido as apellido_domiciliario"
        )
            ->join("cliente as c", "c.idcliente", "=", "pago.fk_cliente")
            ->join("direccion as d", "d.iddireccion", "=", "pago.fk_direccion")
            ->leftJoin("pago_domiciliario as pg_dom", "pg_dom.fk_pago", "=", "pago.idpago")
            ->leftJoin("domiciliario as dom", "dom.iddomiciliario", "=", "pg_dom.fk_domiciliario")
            ->where(function ($query) {
                $query->where("pago.fecha_recib", "=", date("Y-m-d"))
                    ->orWhere("pago.estado", "=", 'ALISTAMIENTO');
            })
            ->whereNotIn("pago.estado", ['CANCELADO', 'ENTREGADO'])
            ->get();

        echo view('pago.reportes.pedidosHoy', [
            'pagos' => $pagos
        ]);
    }


    public function mostrarEstados($id)
    {
        $pago = Pago::find($id);
        $estados = PagoEstado::where("fk_pago", "=", $id)->get();
        return view('pago.estados', [
            'estados' => $estados,
            'pago' => $pago
        ]);
    }

    public function mostrarFormDomiciliario($id)
    {
        $pago = Pago::find($id);
        $domiciliarioSel = Domiciliario::select("domiciliario.*")
                                       ->join("pago_domiciliario as pd","pd.fk_domiciliario","=","domiciliario.iddomiciliario")
                                       ->where("pd.fk_pago","=",$id)->first();
        $domiciliarios = Domiciliario::all();
        return view('pago.asignarDomiciliario', [
            'domiciliarios' => $domiciliarios,
            'domiciliarioSel' => $domiciliarioSel,
            'pago' => $pago
        ]);
    }

    public function asignarDomiciliario($id, PagoDomiciliarioRequest $request)
    {
        $domiciliario = Domiciliario::find($request->domiciliario);
        //FALTANTE
        //Enviar Push a domiciliario

        $pg_dom = new PagoDomiciliario();
        $pg_dom->fk_pago = $id;
        $pg_dom->fk_domiciliario = $request->domiciliario;
        $pg_dom->save();

        $pago_estado = new PagoEstado();
        $pago_estado->estado = "ALISTAMIENTO";
        $pago_estado->descripcion = "";
        $pago_estado->fk_pago = $id;
        $pago_estado->save();

        $pago = Pago::find($id);
        $pago->estado = "ALISTAMIENTO";
        $pago->save();

        $mailData = [
            'title' => 'Tu pedido ha cambiado de estado',
            'body' => 'Tu pedido # ' . $id . ' ha cambiado a estado ALISTAMIENTO'
        ];

        try {
            Mail::to($pago->cliente->email)->send(new CambioDeEstadoMail($mailData));
        } catch (Exception $e) {
            return redirect()->route('pago.tabla', ['id' => $id])->with('warning', 'Estado actualizado, sin embargo no se pudo enviar el email al usuario');
        }
        return redirect()->route('pago.tabla', ['id' => $id])->with('mensaje', 'Domiciliario actualizado correctamente');
    }
    
}
