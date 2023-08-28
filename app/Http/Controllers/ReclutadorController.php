<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reclutador\CrearRequest;
use App\Http\Requests\Reclutador\ModificarRequest;
use App\Http\Requests\Reclutador\PagoRequest;
use App\Models\PagoReclutador;
use App\Models\Reclutador;
use App\Models\User;
use Illuminate\Http\Request;

class ReclutadorController extends Controller
{
    public function tabla(){
        $reclutadores = Reclutador::all();

        return view('reclutador.tabla',[
            'reclutadores' => $reclutadores
        ]);
    }

    public function formAgregar(){
        return view('reclutador.agregar',[]);
    }
    
    public function agregar(CrearRequest $request){
        //Verificar numero de celular
        $nm_usuario = $request->celular;
        $usuario = new User();
        $usuario->name = $request->nombre." ".$request->apellido;
        $usuario->email = $nm_usuario;
        $usuario->role = 5;
        $usuario->password = bcrypt($nm_usuario);
        $usuario->save();

        $reclutador = new Reclutador();
        $reclutador->cedula = $request->cedula;
        $reclutador->nombre = $request->nombre;
        $reclutador->apellido = $request->apellido;
        $reclutador->email = $request->email;
        $reclutador->celular = str_replace("*","",$request->celular);
        $reclutador->fk_usuario = $usuario->id;        
        $reclutador->save();
        
        return redirect()->route('reclutador.tabla')->with('mensaje', 'Reclutador agregado correctamente');
    }


    public function formModificar($id){
        $reclutador = Reclutador::find($id);
        return view('reclutador.modificar',[
            "reclutador" => $reclutador
        ]);
    }

    public function modificar($id, ModificarRequest $request){
        $reclutador = Reclutador::find($id);
        $reclutador->cedula = $request->cedula;
        $reclutador->nombre = $request->nombre;
        $reclutador->apellido = $request->apellido;
        $reclutador->email = $request->email;
        $reclutador->celular = str_replace("*","",$request->celular);
        $reclutador->save();

        $nm_usuario = $request->celular;

        $usuario = User::find($reclutador->fk_usuario);
        $usuario->name = $request->nombre." ".$request->apellido;
        $usuario->email = $nm_usuario;
        $usuario->password = bcrypt($nm_usuario);        
        $usuario->save();
        
        return redirect()->route('reclutador.tabla')->with('mensaje', 'Reclutador modificado correctamente');
    }

    public function cambiarEstado($id){
        $reclutador = Reclutador::find($id);
        $reclutador->estado = ($reclutador->estado == "1" ? "0" : "1");
        $reclutador->save();

        return redirect()->route('reclutador.tabla')->with('mensaje', 'Reclutador modificado correctamente');
    }

    
    public function formPago($id){
        $pagosAnteriores = PagoReclutador::where("fk_reclutador","=",$id)->orderBy("num_pago","desc")->get();
        return view('reclutador.pago',[
            "pagosAnteriores" => $pagosAnteriores,
            "id_reclutador" => $id
        ]);
    }

    
    public function pagar($id, PagoRequest $request){

        $pagoMax = PagoReclutador::selectRaw("max(num_pago) as maximo")->where("fk_reclutador","=",$id)->first();
        $numPago = 1;
        if(isset($pagoMax)){
            $numPago = $pagoMax->maximo + 1;
        }

        $pagoRec = new PagoReclutador();
        $pagoRec->fk_reclutador = $id;
        $pagoRec->num_pago = $numPago;
        $pagoRec->valor_pagado = $request->valor_pagado;
        $pagoRec->save();

        $reclutador = Reclutador::find($id);
        $reclutador->valor_pagado += $request->valor_pagado;
        $reclutador->save();
        
        return redirect()->route('reclutador.tabla')->with('mensaje', 'Pago almacenado correctamente');
    }

    
    
}
