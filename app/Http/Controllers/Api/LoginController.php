<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistrarClienteRequest;
use App\Http\Requests\Web\CelularRequest;
use App\Http\Requests\Web\FinalizarRegistroRequest;
use App\Models\Cliente;
use App\Models\Reclutador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{

    public function loginSMS(CelularRequest $request){
        
        $user = env("NRSGATEWAY_USER");
        $password = env("NRSGATEWAY_PASS");
        $codigoSMS = rand(1000, 9999);
        $telefono = str_replace(" ", "", $request->numeroTelefono);
        if (strlen($telefono) != 10) {
            return response()->json([
                "success" => false,
                "message" => 'Número de celular invalido'
            ]);
        }

        $result = Http::withHeaders([
            "Content-Type" => "application/json; charset=utf-8",
            "Accept" => "application/json",
            "Authorization" => "Basic " . base64_encode($user . ":" . $password)
        ])->post("https://gtw.nrsgateway.com/rest/message", [
            "to" => "57" . $telefono,
            "text" =>  "Su código para ingreso en Gorila Market es: " . $codigoSMS,
            "from" => "Gorila Market"
        ]);
        $mensajeRespuesta = "Código enviado correctamente";
        $success = true;
        if (!isset($result[0]["accepted"]) && (isset($result["error"]) && $result["error"]["code"] != "111")) {
            return response()->json([
                "success" => false,
                "message" => 'Error en el envio de mensajes SMS, intente de nuevo mas tarde',
                "result" => $result
            ]);
        }

        $nm_usuario = '*' . $telefono . '*';
        $usuario = User::where("email", "=", $nm_usuario)->first();
        if (!isset($usuario)) {
            $usuario = new User();
            $usuario->name = $telefono;
            $usuario->email = $nm_usuario;
            $usuario->role = 0;
            $usuario->password = bcrypt($nm_usuario);
        }
        $usuario->codigoSMS = $codigoSMS;
        $usuario->save();
        $token = $usuario->createToken("auth_token")->plainTextToken;
        
        //No hay saldo en la cuenta de SMS's
        
        if(isset($result["error"]) && $result["error"]["code"] == "111") {
            $mensajeRespuesta = 'El código no pudo ser enviado, el código es: ' . $codigoSMS;
            $success = false;
        }
        return response()->json([
            "success" => $success,
            "message" => $mensajeRespuesta,
            "token" => $token
        ]);
    }   

    public function validarSMS(Request $request){
        $user = auth()->user();

        $codigoSMS = $request->codigoD1 . $request->codigoD2 . $request->codigoD3 . $request->codigoD4;
        $user = User::where("id", "=", $user->id)->where("codigoSMS", "=", $codigoSMS)->first();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => 'Código invalido, intenta otra vez'
            ]);
        }

        
        $cliente = Cliente::where("fk_usuario","=",$user->id)->first();
        if(isset($cliente)){
            return response()->json([
                "success" => true,
                "message" => 'Bienvenido!',
                "status" => 1,
                "cliente" => $cliente
            ]);
        }
        $reclutador = Reclutador::where("fk_usuario","=",$user->id)->first();
        if(isset($reclutador)){
            return response()->json([
                "success" => true,
                "message" => 'Bienvenido!',
                "status" => 2,
                "reclutador" => $reclutador
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => 'Debes completar tus datos!',
            "status" => 0
        ]);
    }

    public function finalizarRegistro(FinalizarRegistroRequest $request){
        $user = auth()->user();
        $usuario = User::find($user->id);
        $usuario->name = $request->nombre . " " . $request->apellido;
        $usuario->save();
        if (!isset($request->distribuidor) ) {
            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->email = $request->correo;
            $cliente->celular = str_replace("*","",$usuario->email);
            $cliente->fk_usuario = $usuario->id;
            $cliente->fijo = $this->crearCodigoReferido($request->nombre, $request->apellido);            
            $cliente->save();
        }
        else{
            $file = $request->file('rut');
            if ($request->hasFile("rut")) {
                $distribuidor = new Cliente();
                $distribuidor->nombre = $request->nombre;
                $distribuidor->apellido = $request->apellido;
                $distribuidor->email = $request->correo;
                $distribuidor->celular = str_replace("*","",$usuario->email);
                $distribuidor->fk_usuario = $usuario->id;
                $distribuidor->fijo = $this->crearCodigoReferido($request->nombre, $request->apellido);
                $folder = "public/ruts/";
                $file_name =  time() . "_" . $file->getClientOriginalName();
                $file->storeAs($folder, $file_name, "local");
                $distribuidor->rut = $file_name;
                $distribuidor->tipoCliente = "2";
                $distribuidor->save();
            }
            else{
                return response()->json([
                    "success" => false,
                    "message" => 'Seleccione el rut para poder validar sus datos'
                ]);
            }
        }

        return response()->json([
            "success" => true,
            "message" => 'Bienvenido'
        ]);
    }


    public function registrarCliente(RegistrarClienteRequest $request){

        $user_reclutador = auth()->user();
        $nm_usuario = $request->celular;
        $usuario = new User();
        $usuario->name = $request->nombre . " " . $request->apellido;
        $usuario->email = $nm_usuario;
        $usuario->role = 0;
        $usuario->password = bcrypt($nm_usuario);
        $usuario->save();
        if (!isset($request->distribuidor) ) {
            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->email = $request->correo;
            $cliente->celular = str_replace("*","",$nm_usuario);
            $cliente->fk_usuario = $usuario->id;
            $cliente->fk_reclutador = $user_reclutador->id;
            $cliente->fijo = $this->crearCodigoReferido($request->nombre, $request->apellido);            
            $cliente->save();
        }
        else{
            $file = $request->file('rut');
            if ($request->hasFile("rut")) {
                $distribuidor = new Cliente();
                $distribuidor->nombre = $request->nombre;
                $distribuidor->apellido = $request->apellido;
                $distribuidor->email = $request->correo;
                $distribuidor->celular = str_replace("*","",$nm_usuario);
                $distribuidor->fk_usuario = $usuario->id;
                $distribuidor->fk_reclutador = $user_reclutador->id;
                $distribuidor->fijo = $this->crearCodigoReferido($request->nombre, $request->apellido);
                $folder = "public/ruts/";
                $file_name =  time() . "_" . $file->getClientOriginalName();
                $file->storeAs($folder, $file_name, "local");
                $distribuidor->rut = $file_name;
                $distribuidor->tipoCliente = "2";
                $distribuidor->save();
            }
            else{
                return response()->json([
                    "success" => false,
                    "message" => 'Seleccione el rut para poder validar sus datos'
                ]);
            }
        }

        return response()->json([
            "success" => true,
            "message" => 'Cliente agregado correctamente'
        ]);
    }

    public function micuenta(){
        $user = auth()->user();
        $reclutador = Reclutador::where("fk_usuario","=",$user->id)->first();
        return response()->json([
            "success" => true,
            "message" => 'Se cerró la sesión correctamente',
            "reclutador" => $reclutador         
        ]);
    }


    public function logout(Request $request){
        $tokenId = $request->bearerToken();
        $user = auth()->user();
        $user->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            "success" => true,
            "message" => 'Se cerró la sesión correctamente'            
        ]);
    }

    private function crearCodigoReferido($nombre, $apellido){
        $ptNom = explode(" ",trim($nombre));
        $ptNom = strtolower($ptNom[0]);
        $ptApe = explode(" ",trim($apellido));
        $ptApe = strtolower($ptApe[0]);
        $codigo = $ptNom.$ptApe;
        //Verificar que no exista
        $cliente = Cliente::where("fijo","like",$codigo."%")->orderBy("idcliente","desc")->first();
        if(isset($cliente)){
            $num = str_replace($codigo, "",$cliente->fijo);
            if($num == ""){
                $num = 1;
            }
            else{
                $num = intval($num) + 1;
            }
            $codigo = $codigo.$num;
        }
        return $codigo;
    }
}
