<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuracion\ReferidoRequest;
use App\Http\Requests\Configuracion\ValoresDomicilioRequest;
use App\Models\PorcentajesDescuento;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function inicio(){
        $porcentajeReferido = PorcentajesDescuento::find(1);
        $valoresDomicilio = PorcentajesDescuento::where("idporcentajes_descuento",">=","2")->orderBy("idporcentajes_descuento","asc")->get();

        return view('configuracion.inicio', [
            'porcentajeReferido' => $porcentajeReferido,
            'valoresDomicilio' => $valoresDomicilio
        ]);
    }

    public function modificarReferido(ReferidoRequest $request){
        $porcentajeReferido = PorcentajesDescuento::find(1);
        $porcentajeReferido->valor = $request->valor;
        $porcentajeReferido->tipo_valor = $request->tipo_valor;
        $porcentajeReferido->save();
        return redirect()->route('configuracion.inicio')->with('mensaje', 'Valor de descuento del referido modificado correctamente');
    }

    public function modificarValoresDomicilio(ValoresDomicilioRequest $request){
        
        $domMan = PorcentajesDescuento::find(2);
        $domTar = PorcentajesDescuento::find(3);
        $domNoc = PorcentajesDescuento::find(4);
        $domCup = PorcentajesDescuento::find(5);
        $domGratis = PorcentajesDescuento::find(6);
        
        $domMan->valor = $request->valorMan;
        $domTar->valor = $request->valorTar;
        $domNoc->valor = $request->valorNoc;
        $domCup->valor = $request->valorCup;
        $domGratis->valor = $request->valorGratis;

        $domMan->save();
        $domTar->save();
        $domNoc->save();
        $domCup->save();
        $domGratis->save();
        
        return redirect()->route('configuracion.inicio')->with('mensaje', 'Costo del domicilio modificado correctamente');
    }
}
