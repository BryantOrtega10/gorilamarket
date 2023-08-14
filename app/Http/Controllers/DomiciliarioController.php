<?php

namespace App\Http\Controllers;

use App\Http\Requests\Domiciliario\ModificarRequest;
use App\Http\Requests\Domiciliario\CrearRequest;
use App\Models\Domiciliario;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class DomiciliarioController extends Controller
{
    public function tabla(){
        $domiciliarios = Domiciliario::all();

        return view('domiciliario.tabla',[
            'domiciliarios' => $domiciliarios
        ]);
    }

    public function formAgregar(){
        return view('domiciliario.agregar',[]);
    }
    
    public function agregar(CrearRequest $request){

        $usuario = new User();
        $usuario->name = $request->nombre." ".$request->apellido;
        $usuario->email = $request->usuario;
        $usuario->role = 3;
        $usuario->password = bcrypt($request->pass);
        $usuario->save();

        $domiciliario = new Domiciliario();
        $domiciliario->cedula = $request->cedula;
        $domiciliario->nombre = $request->nombre;
        $domiciliario->apellido = $request->apellido;
        $domiciliario->email = $request->email;
        $domiciliario->celular = $request->celular;
        $domiciliario->fk_usuario = $usuario->id;        
        $domiciliario->save();
        
        return redirect()->route('domiciliario.tabla')->with('mensaje', 'Domiciliario agregado correctamente');
    }


    public function formModificar($id){
        $domiciliario = Domiciliario::find($id);
        return view('domiciliario.modificar',[
            "domiciliario" => $domiciliario
        ]);
    }

    public function modificar($id, ModificarRequest $request){
        $domiciliario = Domiciliario::find($id);
        $domiciliario->cedula = $request->cedula;
        $domiciliario->nombre = $request->nombre;
        $domiciliario->apellido = $request->apellido;
        $domiciliario->email = $request->email;
        $domiciliario->celular = $request->celular;        
        $domiciliario->save();

        
        $usuario = User::find($domiciliario->fk_usuario);
        $usuario->name = $request->nombre." ".$request->apellido;
        $usuario->email = $request->usuario;
        if($request->pass != ""){
            $usuario->password = bcrypt($request->pass);
        }
        $usuario->save();
        
        return redirect()->route('domiciliario.tabla')->with('mensaje', 'Domiciliario modificado correctamente');
    }

    public function cambiarEstado($id){
        $domiciliario = Domiciliario::find($id);
        $domiciliario->estado = ($domiciliario->estado == "1" ? "0" : "1");
        $domiciliario->save();

        return redirect()->route('domiciliario.tabla')->with('mensaje', 'Domiciliario modificado correctamente');
    }

    public function mostrarHistorial($id)
    {
        $pagos = Pago::join("pago_domiciliario as pd","pd.fk_pago","=","idpago")
                     ->where("pd.fk_domiciliario", "=", $id)
                     ->get();

        $domiciliario = Domiciliario::find($id);
        return view('domiciliario.historial', [
            'pagos' => $pagos,
            'domiciliario' => $domiciliario
        ]);
    }

    public function verDetallePago($idDomiciliario, $idPago)
    {

        $pago = Pago::find($idPago);
        $productos = Producto::join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $idPago)
            ->orderBy("orden_cat")
            ->get();

        return view('domiciliario.detalles', [
            'pago' => $pago,
            'productos' => $productos,
            'idDomiciliario' => $idDomiciliario
        ]);
    }
}
