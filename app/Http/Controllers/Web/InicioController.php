<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Http\Requests\Web\ActualizarMicuentaRequest;
use App\Http\Requests\Web\CelularRequest;
use App\Http\Requests\Web\FinalizarRegistroRequest;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Distribuidor;
use App\Models\Foto;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Publicidad;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class InicioController extends Controller
{
    public function index()
    {        
        $hoy = date("Y-m-d");
        $publicidades_web1 = Publicidad::where("tipo", "=", 1)->get();
        $promociones = Producto::join("promociones as p", "p.fk_producto", "=", "producto.idproducto")
            ->where("p.fecha_inicio", "<=", $hoy)
            ->where("p.fecha_fin", ">=", $hoy)
            ->where("producto.visible", "=", 1)->get();
        $categoriasPrincipales = Categoria::where("tipo", "=", "1")->get();
        //$publicidades_web1 = [];

        return view("web.index", [
            'publicidades_web1' => $publicidades_web1,
            'promociones' => $promociones,
            'categorias_principales' => $categoriasPrincipales
        ]);
    }

    public function verProductos(Categoria $categoria, Categoria $sub_categoria = null)
    {
        $categoriasPrincipales = Categoria::where("tipo", "=", "1")->get();
        $productos = [];
        if ($sub_categoria == null) {
            foreach ($categoria->sub_categorias as $subcategoria) {
                $productos_cat = Producto::where("visible", "=", 1)
                    ->where("fk_categorias", "=", $subcategoria->idcategorias)
                    ->limit(10)
                    ->get();
                $productos[$subcategoria->idcategorias] = $productos_cat;
            }
        } else {
            $productos = Producto::where("visible", "=", 1)
                ->where("fk_categorias", "=", $sub_categoria->idcategorias)
                ->get();
        }

        return view('web.verProductos', [
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriaSelect' => $categoria,
            'subCategoriaSelect' => $sub_categoria,
            'productos' => $productos
        ]);
    }

    public function verProductoUnico(Producto $producto)
    {
        $categoriasPrincipales = Categoria::where("tipo", "=", "1")->get();
        $fotos = Foto::where("fk_producto","=",$producto->idproducto)->orderBy("orden","asc")->get();

        $productosSugeridos = Producto::where("visible", "=", 1)
        ->where("fk_categorias", "=", $producto->fk_categorias)
        ->where("idproducto","<>",$producto->idproducto)
        ->limit(10)
        ->orderBy(DB::raw('rand()'))
        ->get();

        return view('web.verProductoUnico', [
            'fotos' => $fotos,
            'producto' => $producto,
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriaSelect' => $producto->categoria->categoria_superior,
            'productosSugeridos' => $productosSugeridos
        ]);
    }


    public function ingresar()
    {
        return view("web.ingresar");
    }

    public function ingresarGoogle(Request $request)
    {
        $token = $request->credential;
        $decoded = JWT::decode($token, new Key('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', 'RS256'));
        dd($decoded);
    }




    public function registroCelular()
    {
        return view("web.registroCelular");
    }

    public function cuentaCelular()
    {
        return view("web.cuentaCelular");
    }

    public function codigoSMS() {
        return view("web.codigoSMS");
    }

    public function codigoSMSIngreso() {
        return view("web.codigoSMSIngreso");
    }
    
    public function enviarCodigoIngreso(CelularRequest $request) {
        $user = "dobleenroque";
        $password = "Mdc*1800";
        $codigoSMS = rand(1000, 9999);
        $telefono = str_replace(" ", "", $request->numeroTelefono);
        if (strlen($telefono) != 10) {
            return redirect()->route('web.registroCelular')->with('error', 'Número de celular invalido');
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

        if (isset($result[0]["accepted"])) {
            //Verificar si hay algun cliente con ese celular si no crear al cliente
            $nm_usuario = '*' . $telefono . '*';
            $usuario = User::where("email", "=", $nm_usuario)->first();
            if (!isset($usuario)) {
                $usuario = new User();
                $usuario->name = $telefono;
                $usuario->email = $nm_usuario;
                $usuario->role = 0;
                $usuario->password = bcrypt($nm_usuario);
                $usuario->codigoSMS = $codigoSMS;
                $usuario->save();
                Session::put("iduser", $nm_usuario);
                return redirect()->route('web.codigoSMS');
            } else {
                $usuario->codigoSMS = $codigoSMS;
                $usuario->save();
                Session::put("iduser", $nm_usuario);
                return redirect()->route('web.codigoSMSIngreso');
            }
        } else if (isset($result["error"])) {
            if ($result["error"]["code"] == "111") {
                //Verificar si hay algun cliente con ese celular si no crear al cliente
                $nm_usuario = '*' . $telefono . '*';
                $usuario = User::where("email", "=", $nm_usuario)->first();
                if (!isset($usuario)) {
                    $usuario = new User();
                    $usuario->name = $telefono;
                    $usuario->email = $nm_usuario;
                    $usuario->role = 0;
                    $usuario->password = bcrypt($nm_usuario);
                    $usuario->codigoSMS = $codigoSMS;
                    $usuario->save();
                    Session::put("iduser", $nm_usuario);
                    return redirect()->route('web.codigoSMS')->with('mensaje', 'El código no pudo ser enviado, el código es: ' . $codigoSMS);
                } else {
                    $usuario->codigoSMS = $codigoSMS;
                    $usuario->save();
                    Session::put("iduser", $nm_usuario);
                    return redirect()->route('web.codigoSMSIngreso')->with('mensaje', 'El código no pudo ser enviado, el código es: ' . $codigoSMS);
                }
            }
        }
        return redirect()->route('web.registroCelular')->with('error', 'Número de celular invalido');
    }

    public function enviarCodigoRegistro(CelularRequest $request) {
        $user = "dobleenroque";
        $password = "Mdc*1800";
        $codigoSMS = rand(1000, 9999);
        $telefono = str_replace(" ", "", $request->numeroTelefono);
        if (strlen($telefono) != 10) {
            return redirect()->route('web.registroCelular')->with('error', 'Número de celular invalido');
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

        if (isset($result[0]["accepted"])) {
            //Verificar si hay algun cliente con ese celular si no crear al cliente
            $nm_usuario = '*' . $telefono . '*';
            $usuario = User::where("email", "=", $nm_usuario)->first();
            if (!isset($usuario)) {
                $usuario = new User();
                $usuario->name = $telefono;
                $usuario->email = $nm_usuario;
                $usuario->role = 0;
                $usuario->password = bcrypt($nm_usuario);
                $usuario->codigoSMS = $codigoSMS;
                $usuario->save();
                Session::put("iduser", $nm_usuario);
                return redirect()->route('web.codigoSMS');
            } else {
                $usuario->codigoSMS = $codigoSMS;
                $usuario->save();
                Session::put("iduser", $nm_usuario);
                return redirect()->route('web.codigoSMS');
            }
        } else if (isset($result["error"])) {
            if ($result["error"]["code"] == "111") {
                //Verificar si hay algun cliente con ese celular si no crear al cliente
                $nm_usuario = '*' . $telefono . '*';
                $usuario = User::where("email", "=", $nm_usuario)->first();
                if (!isset($usuario)) {
                    $usuario = new User();
                    $usuario->name = $telefono;
                    $usuario->email = $nm_usuario;
                    $usuario->role = 0;
                    $usuario->password = bcrypt($nm_usuario);
                    $usuario->codigoSMS = $codigoSMS;
                    $usuario->save();
                    Session::put("iduser", $nm_usuario);
                    return redirect()->route('web.codigoSMS');
                } else {
                    $usuario->codigoSMS = $codigoSMS;
                    $usuario->save();
                    Session::put("iduser", $nm_usuario);
                    return redirect()->route('web.codigoSMS')->with('mensaje', 'El código no pudo ser enviado, el código es: ' . $codigoSMS);
                }
            }
        }
        return redirect()->route('web.registroCelular')->with('error', 'Número de celular invalido');
    }

    public function validarCodigoSMS(Request $request){
        if (!Session::has("iduser")) {
            return redirect()->route('web.registroCelular')->with('error', 'Sesión vencida');
        }

        $iduser = Session::get("iduser");
        $codigoSMS = $request->codigoD1 . $request->codigoD2 . $request->codigoD3 . $request->codigoD4;
        $user = User::where("email", "=", $iduser)->where("codigoSMS", "=", $codigoSMS)->first();
        if (!isset($user)) {
            return redirect()->route('web.codigoSMS')->with('error', 'Código invalido, intenta otra vez');
        }

        Auth::attempt(['email' => $iduser, 'password' => $iduser], true);
        $cliente = Cliente::where("fk_usuario","=",Auth::user()->id)->first();
        if(isset($cliente)){
            return redirect()->route('web.index');
        }       

        return redirect()->route('web.completarRegistro');
    }

    public function completarRegistro() {
        return view("web.completarRegistro");
    }

    public function finalizarRegistro(FinalizarRegistroRequest $request){
        
        $usuario = User::find(Auth::user()->id);
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
                $file->move(public_path("storage/ruts"), $file_name);
                $distribuidor->rut = $file_name;
                $distribuidor->tipoCliente = "2";
                $distribuidor->save();
            }
            else{
                return redirect()->route('web.completarRegistro')->with('error',"Seleccione un rut para poder validarlo");
            }
        }

        return redirect()->route('web.index');
    }

    public function buscarProducto(Request $request){
        $query = "";
        if(isset($request->query)){
            $query = $request->input("query");
        }

        $productos = [];
        if(strlen($query) > 3){
            $productos = Producto::where("nombre","like",'%'.$query.'%')->where("visible","=","1")->get();
        }

        $categoriasPrincipales = Categoria::where("tipo", "=", "1")->get();
        return view('web.buscarProducto',[
            'productos' => $productos,
            'query' => $query,
            'categoriasPrincipales' => $categoriasPrincipales,
            'categoriaSelect' => null
        ]);
    }

    public function verMiCuenta(){
        $idusuario = Auth::user()->id;
        $cliente = Cliente::where("fk_usuario","=",$idusuario)->first();

        return view('web.micuenta',[
            'cliente' => $cliente
        ]);
    }
    
    public function actualizarMiCuenta(ActualizarMicuentaRequest $request){
        $usuario = User::find(Auth::user()->id);
        $usuario->name = $request->nombre . " " . $request->apellido;
        $usuario->save();
        $cliente = Cliente::where("fk_usuario","=",$usuario->id)->first();
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->email = $request->correo;
        $cliente->save();

        return redirect()->route('web.micuenta')->with('message','Cliente modificado correctamente');

    }

    public function verMiHistorial(){
        $idusuario = Auth::user()->id;
        $cliente = Cliente::where("fk_usuario","=",$idusuario)->first();
        $pagos = Pago::where("fk_cliente", "=", $cliente->idcliente)->orderBy("idpago","desc")->get();

        return view('web.mihistorial',[
            'pagos' => $pagos
        ]);
    }

    public function verDetallePago($idPago)
    {
        $idusuario = Auth::user()->id;
        $cliente = Cliente::where("fk_usuario","=",$idusuario)->first();
        
        $pago = Pago::where("idpago","=",$idPago)
                    ->where("fk_cliente", "=", $cliente->idcliente)
                    ->first();
        if(!isset($pago)){
            return redirect()->route('web.index');
        }
        $productos = Producto::join("producto_pago", "fk_producto", "=", "idproducto")
            ->join("categorias", "idcategorias", "=", "fk_categorias")
            ->where("fk_pago", "=", $idPago)
            ->orderBy("orden_cat")
            ->get();

        return view('web.verDetalle', [
            'pago' => $pago,
            'productos' => $productos
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
