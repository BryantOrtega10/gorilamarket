<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromocionRequest;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function tabla(){
        
        $promociones = Promocion::all();

        return view('promocion.tabla', [
            'promociones' => $promociones
        ]);
    }
    
    public function formAgregar(){
        return view('promocion.agregar',[]);
    }


    public function agregar(PromocionRequest $request){
        $promocion_verif = Promocion::where("fk_producto","=",$request->fk_producto)->get();

        if(sizeof($promocion_verif) > 0){
            return redirect()->route('promocion.tabla')->with('error', 'Ya existe una promocion para este producto');
        }

        $promocion = new Promocion();
        $promocion->fk_producto = $request->fk_producto;
        $promocion->porcentaje = $request->porcentaje;
        $promocion->fecha_inicio = $request->fecha_inicio;
        $promocion->fecha_fin = $request->fecha_fin;
        $promocion->save();        
        return redirect()->route('promocion.tabla')->with('mensaje', 'Promoción agregada correctamente');
    }

    public function formModificar($id){
        $promocion = Promocion::find($id);
        
        return view('promocion.modificar',[
            "promocion" => $promocion
        ]);
    }

    public function modificar($id, PromocionRequest $request){
        $promocion_verif = Promocion::where("fk_producto","=",$request->fk_producto)
                                    ->where("idpromociones","<>",$id)->get();
        if(sizeof($promocion_verif) > 0){
            return redirect()->route('promocion.tabla')->with('error', 'Ya existe una promocion para este producto');
        }

        $promocion = Promocion::find($id);
        $promocion->fk_producto = $request->fk_producto;
        $promocion->porcentaje = $request->porcentaje;
        $promocion->fecha_inicio = $request->fecha_inicio;
        $promocion->fecha_fin = $request->fecha_fin;
        $promocion->save();        
        return redirect()->route('promocion.tabla')->with('mensaje', 'Promoción modificada correctamente');
    }

    public function eliminar($id){
        Promocion::find($id)->delete();        
        return redirect()->route('promocion.tabla')->with('mensaje', 'Promoción eliminada correctamente');
    }
}
