<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicidadRequest;
use App\Models\Publicidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicidadController extends Controller
{
    public function tabla(){
        
        $publicidades = Publicidad::all();

        return view('publicidad.tabla', [
            'publicidades' => $publicidades
        ]);
    }
    
    public function formAgregar(){
        return view('publicidad.agregar',[]);
    }


    public function agregar(PublicidadRequest $request){
        $publicidad = new Publicidad();
        $file = $request->file('imagen');
        if($request->hasFile("imagen")){
            $folder = "public/imagenes_p/";
            $file_name =  time()."_".$file->getClientOriginalName();                
            $file->move(public_path("storage/imagenes_p"), $file_name);
            if($request->tipo == "1"){
                Funciones::resizeImage($folder,$file_name, "min", 100, 100);
                Funciones::resizeImage($folder,$file_name, "max", 1440, 424);            
            }
            else{
                Funciones::resizeImage($folder,$file_name, "min", 100, 100);
                Funciones::resizeImage($folder,$file_name, "max", 1000, 1000);            
            }
            $fileFinal = $folder.$file_name;
            Storage::delete($fileFinal);
            $publicidad->imagen = $file_name;
        }       
        $publicidad->link = $request->link;
        $publicidad->tipo = $request->tipo;
        $publicidad->save();        
        return redirect()->route('publicidad.tabla')->with('mensaje', 'Publicidad agregada correctamente');
    }

    public function formModificar($id){
        $publicidad = Publicidad::find($id);
        
        return view('publicidad.modificar',[
            "publicidad" => $publicidad
        ]);
    }

    public function modificar($id, PublicidadRequest $request){
        $publicidad = Publicidad::find($id);
        $publicidad->link = $request->link;
        $publicidad->tipo = $request->tipo;
        $file = $request->file('imagen_n');
        if($request->hasFile("imagen_n")){
            $folder = "public/imagenes_p/";
            $file_name =  time()."_".$file->getClientOriginalName();                
            $file->move(public_path("storage/imagenes_p"), $file_name);
            Funciones::resizeImage($folder,$file_name, "min", 100, 100);
            Funciones::resizeImage($folder,$file_name, "max", 1000, 1000);            
            $fileFinal = $folder.$file_name;
            Storage::delete($fileFinal);
            Storage::delete('public/imagenes_p/min_'.$publicidad->imagen);
            Storage::delete('public/imagenes_p/max_'.$publicidad->imagen);
            $publicidad->imagen = $file_name;
        }
        
        $publicidad->save();
        return redirect()->route('publicidad.tabla')->with('mensaje', 'Publicidad modificada correctamente');
    }

    public function eliminar($id){
        $publicidad = Publicidad::find($id);
        Storage::delete('public/imagenes_p/min_'.$publicidad->imagen);
        Storage::delete('public/imagenes_p/max_'.$publicidad->imagen);
        $publicidad->delete();
        return redirect()->route('publicidad.tabla')->with('mensaje', 'Publicidad eliminada correctamente');
    }
}
