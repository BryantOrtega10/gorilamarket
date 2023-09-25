<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria\AgregarRequest;
use App\Http\Requests\Categoria\ModificarRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function inicio(){
        $categorias = Categoria::where("tipo","=","1")->get();
        $categoria_s = null;
        if(old('m_idcategorias') !== null){
            $categoria_s = Categoria::find(old('m_idcategorias'));
        }
        return view('categorias.inicio', [
            'categorias' => $categorias,
            'categoria_s' => $categoria_s
        ]);
    }
    
    public function agregar(AgregarRequest $request){
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->slug =  Str::slug($request->nombre);
        $categoria->tipo = $request->tipo;
        $categoria->id_categoria_sup = ($request->padre_gen ?? 0);
        $categoria->save();

        return redirect()->route('categoria.inicio')->with('mensaje', 'Categoria agregada correctamente');
    }


    public function formModificar($idcategorias){
        $categoria = Categoria::find($idcategorias);
        $categorias = Categoria::where("tipo","=","1")->get();

        return view('categorias.ajax.modificar', [
            'categoria_s' => $categoria,
            'categorias' => $categorias
        ]);
    }

    public function modificar($idcategorias,ModificarRequest $request){
        $categoria = Categoria::find($idcategorias);        
        if(sizeof($categoria->sub_categorias) > 0 && $request->m_tipo == "2" && $categoria->tipo == "1"){
            return redirect()->route('categoria.inicio')->with('error', 'La categoria aun tiene sub categorias');
        }


        $file = $request->file('m_foto');
        if($request->hasFile("m_foto")){
            $folder = "public/categorias/";
            $file_name =  time()."_".$file->getClientOriginalName();                
            $file->move(public_path("storage/categorias"), $file_name);
            Funciones::resizeImage($folder,$file_name, "min", 200, 200);
            Funciones::resizeImage($folder,$file_name, "max", 1000, 1000);
            $fileFinal = $folder.$file_name;
            Storage::delete($fileFinal);
            if(isset($categoria->imagen) && $categoria->imagen != ""){
                Storage::delete('public/categorias/min_'.$categoria->imagen);
                Storage::delete('public/categorias/max_'.$categoria->imagen);    
            }            
            $categoria->imagen = $file_name;
        }

        $categoria->nombre = $request->m_nombre;
        $categoria->slug =  Str::slug($request->m_nombre);
        $categoria->tipo = $request->m_tipo;
        $categoria->id_categoria_sup = ($request->m_padre_gen ?? 0);
        $categoria->save();

        return redirect()->route('categoria.inicio')->with('mensaje', 'Categoria modificada correctamente');
    }
    
    public function eliminar($idcategorias){
        $categoria = Categoria::find($idcategorias);        
        if(sizeof($categoria->sub_categorias) > 0){
            return redirect()->route('categoria.inicio')->with('error', 'La categoria aun tiene sub categorias');
        }
        $productos = Producto::where("fk_categorias","=",$idcategorias)->count();
        if($productos > 0){
            return redirect()->route('categoria.inicio')->with('error', 'La categoria aun tiene productos relacionados');
        }

        $categoria->delete();

        return redirect()->route('categoria.inicio')->with('mensaje', 'Categoria eliminada correctamente');
    }

    public function subCategorias($idcategorias){
        $categoria = Categoria::find($idcategorias);        
        return response()->json([
            "success" => true,
            "sub_categorias" => $categoria->sub_categorias
        ]);
    }

    public function orden(){
        $categorias = Categoria::where("tipo","=","2")->orderBy("orden_cat")->get();

        return view('categorias.orden', [
            'categorias' => $categorias
        ]);
    }

    public function actualizarOrden(Request $request){
        $idCategorias = $request->idcategorias;
        $orden = $request->orden;
        foreach($idCategorias as $i => $idCategoria){
            $categoria = Categoria::find($idCategoria);
            $categoria->orden_cat = $orden[$i];
            $categoria->save();  
        }
        return redirect()->route('despacho.orden')->with('mensaje', 'Orden actualizado correctamente');
    }

}
