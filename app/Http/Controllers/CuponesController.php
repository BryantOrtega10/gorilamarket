<?php

namespace App\Http\Controllers;

use App\Http\Requests\CuponesRequest;
use App\Models\Cupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuponesController extends Controller
{
    public function tabla(){
        $cupones = Cupon::select("cupon.*",DB::raw("(Select count(idpago) from pago where cd_referido = cupon.cupon and estado not in('CANCELADO', 'ENTREGADO')) as diff_cupon"))->get();

        return view('cupones.tabla',[
            'cupones' => $cupones
        ]);
    }

    public function formAgregar(){
        return view('cupones.agregar',[]);
    }

    public function agregar(CuponesRequest $request){
        $cupon = new Cupon();
        
        $cupon->cupon = $request->cupon;
        $cupon->valor = $request->valor;
        $cupon->tipoValor = $request->tipoValor;
        $cupon->no_cupones = $request->no_cupones;
        $cupon->apFecha = ($request->apFechas ?? "0");
        $cupon->fecha_inicio = $request->fecha_inicio;
        $cupon->fecha_fin = $request->fecha_fin;
        $cupon->apPrecio = ($request->apPrecio ?? "0");
        $cupon->precio_inicial = $request->precioMin;
        $cupon->precio_final = $request->precioMax;
        $cupon->save();
        
        return redirect()->route('cupones.tabla')->with('mensaje', 'Cupón agregado correctamente');
    }
    public function formModificar($id){
        $cupon = Cupon::find($id);
        return view('cupones.modificar',[
            "cupon" => $cupon
        ]);
    }
    public function modificar($id,CuponesRequest $request){
        $cupon = Cupon::find($id);
        
        $cupon->cupon = $request->cupon;
        $cupon->valor = $request->valor;
        $cupon->tipoValor = $request->tipoValor;
        $cupon->no_cupones = $request->no_cupones;
        $cupon->apFecha = ($request->apFechas ?? "0");
        $cupon->fecha_inicio = $request->fecha_inicio;
        $cupon->fecha_fin = $request->fecha_fin;
        $cupon->apPrecio = ($request->apPrecio ?? "0");
        $cupon->precio_inicial = $request->precioMin;
        $cupon->precio_final = $request->precioMax;
        $cupon->save();

        return redirect()->route('cupones.tabla')->with('mensaje', 'Cupón modificado correctamente');
    }
    public function cambiarEstado($id){
        $cupon = Cupon::find($id);
        $cupon->estado = ($cupon->estado == "Activo" ? "Bloqueado" : "Activo");
        $cupon->save();

        return redirect()->route('cupones.tabla')->with('mensaje', 'Cupón modificado correctamente');
    }

    public function reporte(){
        $cupones = Cupon::selectRaw("cupon.cupon,concat(c2.nombre, ' ', c2.apellido, ' - ', c2.email) as 'cliente',
                                   p2.idpago,(p2.descuento + p2.valor) as 'montoOriginal', p2.descuento, p2.csto_Dom,
                                   p2.valor as 'montoFinal',p2.fecha")
                      ->join("pago as p2","p2.cd_referido","=", "cupon.cupon")
                      ->join("cliente as c2","c2.idcliente","=", "p2.fk_cliente")
                      ->whereRaw("(SELECT count(p.idpago) from pago p WHERE p.estado not in('CANCELADO') and p.cd_referido = cupon.cupon) > 0")
                      ->whereNotIn("p2.estado",['CANCELADO'])
                      ->get();

        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=ReporteCupones_" . date("Y-m-d") . ".xls");
        echo view('cupones.reportes.cupones', [
            'cupones' => $cupones
        ]);              

    }
}
