<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\PedidoRealizadoMail;
use App\Mail\RecomendarProductoMail;
use App\Models\Cliente;
use App\Models\Cupon;
use App\Models\Direccion;
use App\Models\Pago;
use App\Models\PorcentajesDescuento;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use stdClass;

class CarritoController extends Controller
{
    public function mostrar()
    {

        $carrito = [];
        if (Session::has('carrito')) {
            $productos_carro = Session::get('carrito')->productos;
            $productos_carro = array_keys($productos_carro);
            $carrito = Producto::whereIn("idproducto", $productos_carro)->get();
        }
        return view('web.ajax.carrito', [
            'carrito' => $carrito
        ]);
    }

    public function agregarProducto($id, $unidades = 1)
    {
        $carrito = new stdClass;
        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
        }

        $producto = Producto::find($id);

        if (isset($carrito->productos[$id])) {
            $carrito->productos[$id] += $unidades;
        } else {
            $carrito->productos[$id] = $unidades;
        }

        $carrito->cuentaProductos = sizeof($carrito->productos);
        if (!isset($carrito->subtotal)) {
            $carrito->subtotal = 0;
        }
        $carrito->subtotal += ($producto->precioPromo() * $unidades);
        $cuponResp = $this->calcularCupon($carrito->subtotal);
        $carrito->tieneCupon = $cuponResp["success"];
        Session::put('carrito', $carrito);
        $this->calcularCostoDomicilio();
        $descuento = $cuponResp['descuento'];       
        $total = $carrito->subtotal - $descuento;

        if($total < 0){
            $total = 0;
        }
        $total += Session::get('carrito')->costoDomicilio ?? 0;

        return response()->json([
            "carrito" => $carrito,
            "idproducto" => $id,
            "precio1" => '$' . number_format($producto->precioPromo() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            "precio2" => '$' . number_format($producto->precioClDi() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            'subtotal_txt' => '$' . number_format($carrito->subtotal, 0, ".", "."),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            "total" => '$' . number_format($total, 0, ".", ".")
        ]);
    }

    public function quitarProducto($id)
    {
        $carrito = new stdClass;
        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
        }
        $producto = Producto::find($id);

        if (isset($carrito->productos[$id])) {
            $carrito->productos[$id]--;
            $carrito->subtotal -= $producto->precioPromo();
            if ($carrito->productos[$id] == 0) {
                unset($carrito->productos[$id]);
            }
        }

        $carrito->cuentaProductos = sizeof($carrito->productos);

        
        $cuponResp = $this->calcularCupon($carrito->subtotal);
        $carrito->tieneCupon = $cuponResp["success"];
        Session::put('carrito', $carrito);
        $this->calcularCostoDomicilio();

        $descuento = $cuponResp['descuento'];       
        $total = $carrito->subtotal - $descuento;
        
        if($total < 0){
            $total = 0;
        }
        $total += Session::get('carrito')->costoDomicilio ?? 0;

        return response()->json([
            "carrito" => $carrito,
            "idproducto" => $id,
            "precio1" => '$' . number_format($producto->precioPromo() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            "precio2" => '$' . number_format($producto->precioClDi() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            'subtotal_txt' => '$' . number_format($carrito->subtotal, 0, ".", "."),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            "total" => '$' . number_format($total, 0, ".", ".")
        ]);
    }

    public function quitarTodoProducto($id)
    {
        $carrito = new stdClass;
        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
        }
        $producto = Producto::find($id);

        if (isset($carrito->productos[$id])) {
            $carrito->subtotal -= $producto->precioPromo() * $carrito->productos[$id];
            unset($carrito->productos[$id]);
        }

        $carrito->cuentaProductos = sizeof($carrito->productos);
        $cuponResp = $this->calcularCupon($carrito->subtotal);
        $carrito->tieneCupon = $cuponResp["success"];
        Session::put('carrito',$carrito);
        $this->calcularCostoDomicilio();
        $descuento = $cuponResp['descuento'];       
        $total = $carrito->subtotal - $descuento;
        if($total < 0){
            $total = 0;
        }
        $total += Session::get('carrito')->costoDomicilio ?? 0;

        return response()->json([
            "carrito" => $carrito,
            "idproducto" => $id,
            "precio1" => '$' . number_format($producto->precioPromo() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            "precio2" => '$' . number_format($producto->precioClDi() * ($carrito->productos[$producto->idproducto] ?? 0), 0, ".", "."),
            "subtotal_txt" => '$' . number_format($carrito->subtotal, 0, ".", "."),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            "total" => '$' . number_format($total, 0, ".", "."),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
        ]);
    }

    public function vaciar()
    {

        if (Session::has('carrito')) {
            Session::remove('carrito');
        }


        return response()->json([
            "success" => true
        ]);
    }

    public function verPagar(){
        $carrito = [];
        $productos_carro = [];
        $descuento = 0;        
        if (Session::has('carrito')) {
            $productos_carro = Session::get('carrito')->productos;
            $productos_carro = array_keys($productos_carro);
            $carrito = Producto::whereIn("idproducto", $productos_carro)->get();
        }
        
        $carritoObj = new stdClass;
        if (Session::has('carrito')) {
            $carritoObj = Session::get('carrito');               
        }
        else{
            return redirect()->route('web.index');
        }
        $total = $carritoObj->subtotal;
        $cuponResp = $this->calcularCupon($total);
        $carritoObj->tieneCupon = $cuponResp["success"];
        Session::put('carrito',$carritoObj);
        $this->calcularCostoDomicilio();
        $descuento = $cuponResp['descuento'];
        $total -= $descuento;
        if($total < 0){
            $total = 0;
        }
        $total += Session::get('carrito')->costoDomicilio ?? 0;


        $horaDelDia = date("H");
        $diasPedido = [];
        if($horaDelDia <= 12){
            array_push($diasPedido, date("Y-m-d",strtotime(date("Y-m-d")." + 1 days")));
        }
        for ($i=2; $i < 5; $i++) { 
            array_push($diasPedido, date("Y-m-d",strtotime(date("Y-m-d")." + ".$i." days")));
        }
        
        $productosDestacados = Producto::where("visible","=",'1')
                                       ->where("destacado","=","1")
                                       ->whereNotIn("idproducto",$productos_carro)
                                       ->limit(3)
                                       ->orderBy(DB::raw("RAND()"))
                                       ->get();
        

        return view('web.pagar', [
            'carrito' => $carrito,
            'total' => $total,
            'descuento' => $descuento,
            'diasPedido' => $diasPedido,
            'respuestaTexto' => $cuponResp['respuestaCodigo'],
            'successCupon' => $cuponResp['success'],
            'productosDestacados' => $productosDestacados
        ]);
    }   

    public function verificarCupon($cupon = null){
        $carrito = [];
        $productos_carro = [];
        $descuento = 0;
        $total = 0;
        Session::put('cupon',$cupon);
        if (Session::has('carrito')) {
            $productos_carro = Session::get('carrito')->productos;
            $productos_carro = array_keys($productos_carro);
            $carrito = Producto::whereIn("idproducto", $productos_carro)->get();
        }

        
        $carritoObj = new stdClass;
        if (Session::has('carrito')) {
            $carritoObj = Session::get('carrito');               
        }
        $total = $carritoObj->subtotal;
        $cuponResp = $this->calcularCupon($total);
        $descuento = $cuponResp['descuento'];       
        $total -= $descuento;
        if($total < 0){
            $total = 0;
        }
        $carritoObj->tieneCupon = $cuponResp["success"];
        Session::put('carrito',$carritoObj);
        $this->calcularCostoDomicilio();
        $total += Session::get('carrito')->costoDomicilio ?? 0;

        return response()->json([
            "success" => $cuponResp["success"],
            'total' => '$' .number_format($total, 0, '.', '.'),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
            "respuestaTexto" => $cuponResp["respuestaCodigo"]
        ]);
    }

    public function quitarCupon(){
        $carrito = [];
        $productos_carro = [];
        $descuento = 0;
        $total = 0;
        Session::remove('cupon');
        if (Session::has('carrito')) {
            $productos_carro = Session::get('carrito')->productos;
            $productos_carro = array_keys($productos_carro);
            $carrito = Producto::whereIn("idproducto", $productos_carro)->get();
        }

 

        $carritoObj = new stdClass;
        if (Session::has('carrito')) {
            $carritoObj = Session::get('carrito');               
        }
        $total = $carritoObj->subtotal;
        $carritoObj->tieneCupon = false;
        Session::put('carrito',$carritoObj);
        $this->calcularCostoDomicilio();
        $total += Session::get('carrito')->costoDomicilio ?? 0;
        

        return response()->json([
            "success" => true,
            'total' => '$' .number_format($total, 0, '.', '.'),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
            "respuestaTexto" => ""
        ]);
    }

    public function cambiarHora($hora = null){
        $carritoObj = new stdClass;
        if (Session::has('carrito')) {
            $carritoObj = Session::get('carrito');               
        }
        $total = $carritoObj->subtotal;
        $cuponResp = $this->calcularCupon($total);
        $descuento = $cuponResp['descuento'];       
        $total -= $descuento;
        if($total < 0){
            $total = 0;
        }
        $carritoObj->horaEntrega = $hora;
        Session::put('carrito',$carritoObj);
        $this->calcularCostoDomicilio();
        $total += Session::get('carrito')->costoDomicilio ?? 0;
        

        return response()->json([
            "success" => true,
            'total' => '$' .number_format($total, 0, '.', '.'),
            'descuento' => '$' .number_format($descuento, 0, '.', '.'),
            'costoDomicilio' => '$'.number_format(Session::get('carrito')->costoDomicilio ?? 0, 0, '.', '.'),
            "respuestaTexto" => ""
        ]);
    }

    public function realizarPago(Request $request){
        if (!Session::has('carrito')) {
            return redirect()->route('web.index')->with('error',"El carrito esta vacio");
        }
        $descuento = 0;        
        
        $carrito = Session::get('carrito');
        $total = $carrito->subtotal;
        $cuponResp = $this->calcularCupon($total);
        $carrito->tieneCupon = $cuponResp["success"];
        Session::put('carrito',$carrito);
        $this->calcularCostoDomicilio();
        $descuento = $cuponResp['descuento'];
        $total -= $descuento;
        if($total < 0){
            $total = 0;
        }
        $total += Session::get('carrito')->costoDomicilio ?? 0;
        
        $cliente = Cliente::where("fk_usuario","=",Auth::user()->id)->first();
        //Crear direccion en bd en caso de que no exista el id
        if(Session::get('direccion')->idDireccion == null){
            $direccion = new Direccion;
            $direccion->fk_cliente = $cliente->idcliente;
            $direccion->adicional = $request->direccion_adicional_carrito;
            $direccion->lat = Session::get('direccion')->lat;
            $direccion->lng = Session::get('direccion')->lng;
            $direccion->direccionCompleta = Session::get('direccion')->direccionCompleta;
            $direccion->cobertura = Session::get('direccion')->cobertura;
            $direccion->save();    
            
            $direccionObj = Session::get('direccion');
            $direccionObj->idDireccion = $direccion->iddireccion;
            Session::put('direccion',$direccionObj);
        }
        else{
            $direccion = Direccion::find(Session::get('direccion')->idDireccion);
            $direccion->adicional = $request->direccion_adicional_carrito;
            $direccion->save();  
        }

        $pedido = new Pago;
        $pedido->estado = 'pendiente';
        $pedido->valor = $total;
        $pedido->direccion = Session::get('direccion')->direccionCompleta;
        $pedido->cd_referido = $cuponResp["cupon"];
        $pedido->fk_usuario = Auth::user()->id;
        $pedido->tipo_pago = $request->metodo_pago;
        $pedido->fecha_recib = $request->fechaPedido;
        $pedido->hora_recib = $request->horaPedido;
        $pedido->fk_cliente = $cliente->idcliente;
        $pedido->csto_Dom = Session::get('carrito')->costoDomicilio;
        $pedido->descuento = $descuento;
        $pedido->fk_direccion = Session::get('direccion')->idDireccion;
        $pedido->plataforma = "WEB";
        $pedido->save();
        
        $ids_productos_carro = Session::get('carrito')->productos;
        $ids_productos_carro = array_keys($ids_productos_carro);
        $productos_carro = Producto::whereIn("idproducto", $ids_productos_carro)->get();
        foreach($productos_carro as $producto){
            DB::table('producto_pago')->insert([
                'fk_producto' => $producto->idproducto,
                'fk_pago' => $pedido->idpago,
                'cantidad' => Session::get('carrito')->productos[$producto->idproducto],
                'precioMos' => $producto->precioPromo() * Session::get('carrito')->productos[$producto->idproducto],
                'apPromocion' => ($producto->promocion() === null ? '0' : '1')
            ]);
        }
        Session::remove('carrito');
        Session::remove('cupon');
        
        if(isset($request->producto_no_encontrado) && !empty(trim($request->producto_no_encontrado))){
            $mailData = [
                'sugerencia' => $request->producto_no_encontrado,
                'email' => $cliente->email
            ];
            try {
                Mail::to(config('MAIL_TO_ADDRESS'))->send(new RecomendarProductoMail($mailData));
            } catch (Exception $e) {
                //Do nothing
            }
        }


        $mailData = [
            'title' => 'Detalles de tu pedido',
            'body' => 'Has realizado un pedido en gorila market con el ' . $pedido->idpago . ' recuerda que tu pedido llegará el '.$pedido->fecha_recib.' en las horas de la '.$pedido->hora_cast()
        ];
        try {
            Mail::to($cliente->email)->send(new PedidoRealizadoMail($mailData));
        } catch (Exception $e) {
            //Do nothing
        }


        return redirect()->route('web.gracias')->with('info', 'Has realizado un pedido en gorila market con el ' . $pedido->idpago . ' recuerda que tu pedido llegará el '.$pedido->fecha_recib.' en las horas de la '.$pedido->hora_cast());
    }

    public function verGracias(){
        return view('web.gracias');
    }

    private function calcularCostoDomicilio(){
        $carrito = new stdClass;
        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');               
        }
        $carrito->costoDomicilio = 0;
        if($carrito->tieneCupon){
            $domCup = PorcentajesDescuento::find(5);
            $carrito->costoDomicilio = $domCup->valor;
        }
        else{
            if(!isset($carrito->horaEntrega)){
                $carrito->horaEntrega = "horaMan";
            }

            if($carrito->horaEntrega == "horaMan"){
                $dom = PorcentajesDescuento::find(2);
                $carrito->costoDomicilio = $dom->valor;
            }
            else if($carrito->horaEntrega == "horaTar"){
                $dom = PorcentajesDescuento::find(3);
                $carrito->costoDomicilio = $dom->valor;
            }
            else if($carrito->horaEntrega == "horaNoc"){
                $dom = PorcentajesDescuento::find(4);
                $carrito->costoDomicilio = $dom->valor;
            }
            $domLimite = PorcentajesDescuento::find(6);
            
            if($carrito->subtotal >= $domLimite->valor){
                $carrito->costoDomicilio = 0;
            }
        }
        Session::put('carrito',$carrito);
    }
    
    private function calcularCupon($total){
        $respuestaCodigo = "";
        $descuento = 0;
        $success = false;
        $cuponUsado = "";
        if (Session::has('cupon')) {
            $cuponUsado = Session::get('cupon');
            $cupon = Cupon::where('cupon', '=', Session::get('cupon'))->first();
            $paso = 1;
            if (isset($cupon)) {
                if ($cupon->apFecha == '1' && $paso == 1) {
                    $fecha_actual = strtotime(date("Y-m-d H:i:s"));
                    $fechai = strtotime($cupon->fecha_inicio);
                    $fechaf = strtotime($cupon->fecha_fin);
                    if (($fecha_actual < $fechai) || ($fecha_actual > $fechaf)) {
                        $respuestaCodigo = "Este cupon ya esta vencido.";
                        $paso = 0;
                    }
                }
                if ($cupon->apPrecio == "1" && $paso == 1) {
                    if (($total < $cupon->precio_inicial) || ($total > $cupon->precio_final)) {
                        $respuestaCodigo = "Para aplicar este cupon debes hacer un pedido de minimo " . number_format($cupon->precio_inicial, 0,".",".") . " y maximo " . number_format($cupon->precio_final, 0,".",".") . ".";
                        $paso = 0;
                    }
                }
                if ($cupon->no_cupones <= 0) {
                    $respuestaCodigo = "No hay mas cupones disponibles.";
                    $paso = 0;
                }
                if (Auth::check()) {
                    $cuponesxUser = Pago::join('cliente', "cliente.idcliente", "=", "pago.fk_cliente")
                        ->where('cliente.fk_usuario', "=", Auth::user()->id)
                        ->where('pago.cd_referido', "=", Session::get('cupon'))
                        ->get();
                    if (sizeof($cuponesxUser) > 0) {
                        $respuestaCodigo = "No hay mas cupones disponibles, ya has usado este cupon.";
                        $paso = 0;
                    }
                }
                if ($paso == 1) {
                    if ($cupon->tipoValor == "1") {
                        $descuento = intval(($total * $cupon->valor) / 100);
                    } else {
                        $descuento = $cupon->valor;
                    }
                    $success = true;
                    $respuestaCodigo = "Cupon valido!!!, equivalente " . ($cupon->tipoValor == "1" ? 'al ' . $cupon->valor . ' % de tu compra' : '$' . number_format($cupon->valor, 0, ".","."));
                }
            }
            else{
                $respuestaCodigo = "No se ha encontrado este cupon";
            }
        }

        return [
            "success" => $success,
            "descuento" => $descuento, 
            "respuestaCodigo" => $respuestaCodigo,
            "cupon" => $cuponUsado
        ];
    }
}