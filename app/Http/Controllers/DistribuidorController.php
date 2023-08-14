<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Finder;

class DistribuidorController extends Controller
{
    public function tabla()
    {
        $clientes = Cliente::select("cliente.*", DB::raw("(select count(p.idpago) from pago p where p.fk_cliente = cliente.idcliente and p.estado = 'ENTREGADO') as 'no_pedidos' "))
                            ->where("tipoCliente","=","2")->get();

        return view('distribuidor.tabla', [
            'clientes' => $clientes
        ]);
    }

    public function cambiarEstado($id)
    {
        $cliente = Cliente::find($id);
        $cliente->estado = ($cliente->estado == "1" ? "0" : "1");
        $cliente->save();

        return redirect()->route('distribuidor.tabla')->with('mensaje', 'Distribuidor modificado correctamente');
    }

    public function activarDistribuidor($id)
    {
        $cliente = Cliente::find($id);
        $cliente->estadoDistribuidor = "2";
        $cliente->save();
        $usuario = User::find($cliente->fk_usuario);
        $usuario->role = 4;
        $usuario->save();

        return redirect()->route('distribuidor.tabla')->with('mensaje', 'Distribuidor modificado correctamente');
    }


    public function desactivarDistribuidor($id)
    {
        $cliente = Cliente::find($id);
        $cliente->estadoDistribuidor = "1";
        $cliente->save();
        $usuario = User::find($cliente->fk_usuario);
        $usuario->role = 0;
        $usuario->save();

        return redirect()->route('distribuidor.tabla')->with('mensaje', 'Distribuidor modificado correctamente');
    }


    public function mostrarHistorial($id)
    {
        $pagos = Pago::where("fk_cliente", "=", $id)->get();
        $cliente = Cliente::find($id);
        return view('distribuidor.historial', [
            'pagos' => $pagos,
            'cliente' => $cliente
        ]);
    }

    public function verDetallePago($idCliente, $idPago)
    {

        $pago = Pago::find($idPago);
        $productos = Producto::join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $idPago)
            ->orderBy("orden_cat")
            ->get();

        return view('distribuidor.detalles', [
            'pago' => $pago,
            'productos' => $productos,
            'idCliente' => $idCliente
        ]);
    }

    public function reporteClientes()
    {

        $clientes = Cliente::select("cliente.*", DB::raw("(select count(p.idpago) from pago p where p.fk_cliente = cliente.idcliente and p.estado = 'ENTREGADO') as 'no_pedidos'"), DB::raw("GROUP_CONCAT(Concat(d.direccionCompleta, ', ', d.adicional) SEPARATOR '\n') as 'direccionesG'"))
            ->leftJoin("direccion as d", "cliente.idcliente", "=", "d.fk_cliente")
            ->groupBy(
                "cliente.idcliente",
                "cliente.cedula",
                "cliente.nombre",
                "cliente.apellido",
                "cliente.email",
                "cliente.fecha_nacimiento",
                "cliente.genero",
                "cliente.celular",
                "cliente.fijo",
                "cliente.fk_usuario",
                "cliente.estado"
            )
            ->where("cliente.tipoCliente","=","1")
            ->get();

        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=ReporteClientes_" . date("Y-m-d") . ".xls");
        echo view('distribuidor.reportes.clientes', [
            'clientes' => $clientes
        ]);
    }
}
