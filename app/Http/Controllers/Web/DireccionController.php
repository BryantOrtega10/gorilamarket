<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Cobertura;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class DireccionController extends Controller
{
    public function verForm(){
        $direcciones = [];
        if(Auth::check()){
            $cliente = Cliente::where("fk_usuario","=",Auth::user()->id)->first();
            if(isset($cliente)){
                $direcciones = Direccion::where("fk_cliente","=",$cliente->idcliente)->get();
            }
        }

        return view('web.ajax.direccion',[
            'direcciones' => $direcciones
        ]);
    }
    public function verificar(Request $request){
        if(isset($request->idDir)){
            $direccionBD = Direccion::find($request->idDir);
            $lat = $direccionBD->lat;
            $lng = $direccionBD->lng;
        }
        else{
            $lat = $request->lat;
            $lng = $request->lng;
        }

        
        $perimetro = Cobertura::whereRaw('ST_CONTAINS(perimetro, POINT('.$lat.','.$lng.'))')->first();
        if(isset($perimetro)){
            $direccion = new stdClass;
            $direccion->cobertura = $perimetro->idperimetro;
            $direccion->lat = $lat;
            $direccion->lng = $lng;
            if(isset($direccionBD)){
                $direccion->direccionCompleta = $direccionBD->direccionCompleta;
                $direccion->idDireccion = $direccionBD->iddireccion;
                $direccion->adicionales = $direccionBD->adicional;
            }
            else{
                $direccion->direccionCompleta = $request->dirComp;
                $direccion->idDireccion = null;
                $direccion->adicionales = null;
            }
            
            Session::put('direccion', $direccion);
            return response()->json([
                "success" => true,
            ]);
        }else{
            Session::remove('direccion');
            return response()->json([
                "success" => false,
                "error" => "Tu dirección no cuenta con cobertura"
            ]);
        }

    }
}
