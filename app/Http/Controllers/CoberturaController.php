<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoberturaRequest;
use App\Models\Cobertura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoberturaController extends Controller
{
    public function mapaGeneral(){
        $coberturas = Cobertura::all();
        
        return view('cobertura.mapa',[
            "coberturas" => $coberturas
        ]);
    }

    public function formAgregar(){
        return view('cobertura.agregar',[]);
    }


    public function agregar(CoberturaRequest $request){

        $perimetro_txt = "GeomFromText('POLYGON((".$request->perimetro."))')";
        $perimetro_txt2 = $request->perimetro;
        $cobertura = new Cobertura();
        $cobertura->perimetro = DB::raw($perimetro_txt);
        $cobertura->perimetro_txt = $perimetro_txt;
        $cobertura->perimetro_txt2 = $perimetro_txt2;
        $cobertura->nombre = $request->nombre;
        $cobertura->save();
        
        return redirect()->route('cobertura.mapa')->with('mensaje', 'Perimetro agregado correctamente');
    }

    public function formModificar($id){
        $cobertura = Cobertura::find($id);
        
        return view('cobertura.modificar',[
            "cobertura" => $cobertura
        ]);
    }

    public function modificar($id, CoberturaRequest $request){

        $perimetro_txt = "GeomFromText('POLYGON((".$request->perimetro."))')";
        $perimetro_txt2 = $request->perimetro;

        $cobertura = Cobertura::find($id);
        $cobertura->perimetro = DB::raw($perimetro_txt);
        $cobertura->perimetro_txt = $perimetro_txt;
        $cobertura->perimetro_txt2 = $perimetro_txt2;
        $cobertura->nombre = $request->nombre;
        $cobertura->save();      
        return redirect()->route('cobertura.mapa')->with('mensaje', 'Perimetro modificado correctamente');
    }

    public function eliminar($id){
        Cobertura::find($id)->delete();        
        return redirect()->route('cobertura.mapa')->with('mensaje', 'Perimetro eliminado correctamente');
    }
}
