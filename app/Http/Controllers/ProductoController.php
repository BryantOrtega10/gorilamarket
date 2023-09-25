<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductoRequest;
use App\Models\Categoria;
use App\Models\Foto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class ProductoController extends Controller
{
    public function tabla(){
        
        $productos = Producto::where("visible","<>",-1)->get();

        return view('productos.tabla', [
            'productos' => $productos
        ]);
    }
    
    public function formMasivo(){
        return view('productos.masivo');
    }

    public function cargarMasivo(Request $request){
        if ($request->hasFile('archivoCSV')) {
            $resultados = [];
            $archivo = $request->file('archivoCSV');
    
            // Obtén el contenido del archivo utilizando el objeto Storage
            $contenido = File::get($archivo->getPathname());
            // Divide el contenido del archivo en filas
            $filas = explode("\n", $contenido);
            for ($i = 1; $i < count($filas); $i++) {
                $fila = $filas[$i];
                // Parsea la fila del CSV en un arreglo utilizando str_getcsv
                $columnas = str_getcsv($fila,";");
                
                $columnas = array_map('trim', $columnas);
                if(sizeof($columnas) <= 1){
                    continue;
                }
                $producto = Producto::where("cd_barras","=",$columnas[0])->first();
                if(isset($producto)){
                    array_push($resultados, "El producto con codigo de barras:".$columnas[0]." ya existe, se omite este registro");
                    continue;
                }
                if($columnas[1] == ""){
                    continue;
                }
                $producto = new Producto();
                $producto->nombre = $columnas[1];
                $producto->descripcion = $columnas[6];
                $producto->precio = intval($columnas[2]);
                $producto->precioDist = intval($columnas[3]);        
                $producto->unidades = 1;
                $producto->destacado = 0;        
                $producto->fk_categorias = intval($columnas[4]);
                $producto->cd_barras = intval($columnas[0]);
                $producto->orden = 999;
                $producto->slug = Str::slug($columnas[1]);
                $producto->save();
                array_push($resultados, "El producto con codigo de barras:".$columnas[0]." fue agregado");
            }
            return view('productos.resultadosMasivo', ['resultados' => $resultados]);
        }
    
        return redirect()->route('producto.masivo')->with('mensaje', 'No se seleccionó ningún archivo');
    }

    public function formAgregar(){
        $categorias = Categoria::where("tipo","=","1")->get();
        
        $errors = Session::get('errors');
        $sub_categorias = [];
        if(isset($errors)){
            $olds = Session::getOldInput();
            $sub_categorias = Categoria::where("id_categoria_sup","=",$olds['cat_sup'])->get();
        }

        return view('productos.agregar',[
            "categorias" => $categorias,
            "sub_categorias" => $sub_categorias
        ]);
    }


    public function agregar(ProductoRequest $request){
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->precioDist = $request->precioDist;        
        $producto->unidades = $request->unidades;
        $producto->destacado = $request->destacado;        
        $producto->fk_categorias = $request->fk_categorias;
        $producto->cd_barras = $request->cd_barras;
        $producto->orden = $request->orden;
        $producto->slug = Str::slug($request->nombre);
        $producto->save();
        $files = $request->file('fotos');
        if($request->hasFile("fotos")){
            foreach ($files as $i => $file) {
                $folder = "public/productos/";
                $file_name =  time()."_".$file->getClientOriginalName();                
                $file->move(public_path("storage/productos"), $file_name);
                Funciones::resizeImage($folder,$file_name, "min", 100, 100);
                Funciones::resizeImage($folder,$file_name, "max", 1000, 1000);
                $fileFinal = $folder.$file_name;
                Storage::delete($fileFinal);
                $foto = new Foto();
                $foto->ruta = $file_name;
                $foto->orden = $i + 1;
                $foto->fk_producto = $producto->idproducto;
                $foto->save();                
            }
        }       

        return redirect()->route('producto.tabla')->with('mensaje', 'Producto agregado correctamente');
    }

    public function formModificar($id){
        $producto = Producto::find($id);
        $categorias = Categoria::where("tipo","=","1")->get();
        
        $errors = Session::get('errors');
        $sub_categorias = Categoria::where("id_categoria_sup","=",$producto->categoria->categoria_superior->idcategorias)->get();
        if(isset($errors)){
            $olds = Session::getOldInput();
            $sub_categorias = Categoria::where("id_categoria_sup","=",$olds['cat_sup'])->get();
        }

        return view('productos.modificar',[
            "categorias" => $categorias,
            "sub_categorias" => $sub_categorias,
            "producto" => $producto
        ]);
    }

    public function modificar($id, ProductoRequest $request){
        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->precioDist = $request->precioDist;        
        $producto->unidades = $request->unidades;
        $producto->destacado = $request->destacado;        
        $producto->fk_categorias = $request->fk_categorias;
        $producto->cd_barras = $request->cd_barras;
        $producto->orden = $request->orden;
        $producto->visible = $request->visible;
        $producto->slug = Str::slug($request->nombre);
        $producto->save();

        return redirect()->route('producto.tabla')->with('mensaje', 'Producto modificado correctamente');
    }

    public function eliminar($id){
        $producto = Producto::find($id);
        $producto->visible = -1;
        $producto->save();
        return redirect()->route('producto.tabla')->with('mensaje', 'Producto eliminado correctamente');
    }

    public function formEditarFotos($id){
        $fotos = Foto::where("fk_producto","=",$id)->orderBy("orden","asc")->get();
        
        return view('productos.fotos',[
            "fotos" => $fotos,
            "idproducto" => $id
        ]);
    }

    public function agregarFotos($id, Request $request){
        $fotos = Foto::where("fk_producto","=",$id)->orderBy("orden","asc")->get();
        $fileFinal = "";
        if($request->hasFile("file")){            
            $file = $request->file('file');
            $file_name =  time()."_".$file->getClientOriginalName();                
            $folder = "public/productos/";
            $file->move(public_path("storage/productos"), $file_name);
            Funciones::resizeImage($folder,$file_name, "min", 150, 150);
            Funciones::resizeImage($folder,$file_name, "max", 1500, 1500);
            $fileFinal = $folder.$file_name;
            Storage::delete($fileFinal);
            $foto = new Foto();
            $foto->ruta = $file_name;
            $foto->orden = 1 + sizeof($fotos);
            $foto->fk_producto = $id;
            $foto->save();  
            $fileFinal = $folder."min_".$file_name;    
            return response()->json([
                "success" => true,
                "foto" =>[
                    "ruta" => Storage::url($fileFinal),
                    "orden" => $foto->orden,
                    "idfotos" => $foto->idfotos
                ]
            ]);      
        }
        
        return response()->json([
            "success" => false
        ], 403);    
    }

    public function actualizarFotos($id,Request $request){
        
        $idFotos = $request->orden;
        foreach($idFotos as $i => $idFoto){
            $foto = Foto::find($idFoto);
            $foto->orden = $i + 1;
            $foto->save();  
        }
        return redirect()->route('producto.fotos',['id' => $id])->with('mensaje', 'Orden actualizado correctamente');
    }

    public function eliminarFotos($id,Request $request){
        
        $idFotos = $request->fotos_select;
        foreach($idFotos as $idFoto){
            $foto = Foto::find($idFoto);
            Storage::delete('public/productos/min_'.$foto->ruta);
            Storage::delete('public/productos/max_'.$foto->ruta);
            $foto->delete();  
        }
        return redirect()->route('producto.fotos',['id' => $id])->with('mensaje', 'Fotos eliminadas correctamente');
    }
}
