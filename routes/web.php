<?php

use App\Http\Controllers\AdministradorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\PanelControlController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CoberturaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CuponesController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\DomiciliarioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\PublicidadController;
use App\Http\Controllers\ReclutadorController;
use App\Http\Controllers\Web\InicioController;
use App\Http\Controllers\Web\CarritoController;
use App\Http\Controllers\Web\DireccionController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    //$exitCode2 = Artisan::call('db:seed');
    return '<h3>Migraci&oacute;n completada '.$exitCode.' </h3>';
});

Route::get('/', [InicioController::class, 'index'])->name('web.index');
Route::get('/ingresar', [InicioController::class, 'ingresar'])->name('web.ingresar');
Route::post('/ingresarGoogle', [InicioController::class, 'ingresarGoogle'])->name('web.ingresarGoogle');

Route::get('/registroCelular', [InicioController::class, 'registroCelular'])->name('web.registroCelular');
Route::get('/ingresoCelular', [InicioController::class, 'cuentaCelular'])->name('web.cuentaCelular');

Route::post('/enviarCodigoRegistro', [InicioController::class, 'enviarCodigoRegistro'])->name('web.enviarCodigoRegistro');
Route::post('/enviarCodigoIngreso', [InicioController::class, 'enviarCodigoIngreso'])->name('web.enviarCodigoIngreso');


Route::get('/codigoSMS', [InicioController::class, 'codigoSMS'])->name('web.codigoSMS');
Route::get('/codigoSMSIngreso', [InicioController::class, 'codigoSMSIngreso'])->name('web.codigoSMSIngreso');

Route::post('/validarCodigoSMS', [InicioController::class, 'validarCodigoSMS'])->name('web.validarCodigoSMS');
Route::get('/completar-registro', [InicioController::class, 'completarRegistro'])->name('web.completarRegistro');
Route::post('/completar-registro', [InicioController::class, 'finalizarRegistro']);



Route::get('/ver-productos/{categoria}/{sub_categoria?}', [InicioController::class, 'verProductos'])->name('web.verProductos');
Route::get('/p/{producto?}', [InicioController::class, 'verProductoUnico'])->name('web.verProductoUnico');

Route::get('/b', [InicioController::class, 'buscarProducto'])->name('web.buscarProducto');



Route::get('/carrito/mas/{id}/{unidades?}', [CarritoController::class, 'agregarProducto'])->name('web.agregarCarrito');
Route::get('/carrito/menos/{id}', [CarritoController::class, 'quitarProducto'])->name('web.quitarCarrito');
Route::get('/carrito/quitar/{id}', [CarritoController::class, 'quitarTodoProducto'])->name('web.quitarTodoCarrito');
Route::get('/carrito/mostrar', [CarritoController::class, 'mostrar'])->name('web.mostrar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('web.vaciar');

Route::get('/cupon/{cupon?}', [CarritoController::class, 'verificarCupon'])->name('web.cupon');
Route::get('/quitar-cupon', [CarritoController::class, 'quitarCupon'])->name('web.quitarCupon');
Route::get('/cambiar-hora/{hora?}', [CarritoController::class, 'cambiarHora'])->name('web.cambiarHora');


Route::get('/pagar', [CarritoController::class, 'verPagar'])->name('web.pagar');
Route::post('/pagar', [CarritoController::class, 'realizarPago']);
Route::get('/gracias', [CarritoController::class, 'verGracias'])->name('web.gracias');

Route::get('/direccion', [DireccionController::class, 'verForm'])->name('web.direccion.mostrar');
Route::post('/direccion/verificar', [DireccionController::class, 'verificar'])->name('web.direccion.verificar');



Route::get('/mi-cuenta', [InicioController::class, 'verMiCuenta'])
	->middleware(['auth','user-role:cliente|distribuidor'])
	->name('web.micuenta');
Route::post('/mi-cuenta', [InicioController::class, 'actualizarMiCuenta'])
	->middleware(['auth','user-role:cliente|distribuidor']);
	

Route::get('/mi-historial', [InicioController::class, 'verMiHistorial'])
	->middleware(['auth','user-role:cliente|distribuidor'])
	->name('web.mihistorial');
Route::get('/mi-historial/{id}', [InicioController::class, 'verDetallePago'])
	->middleware(['auth','user-role:cliente|distribuidor'])
	->name('web.verDetallePago');

	

















//Auth::routes();
Route::get('/admin', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');
Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

//Link
Route::get("storage-link", function(){
    File::link(
        storage_path('app/public'), public_path('storage')
    );	
});

Route::get('/cache', function() {
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    
    return '<h3>Cache eliminado</h3>';
});

// Ruta panel de control
Route::group([
	'prefix' => 'panel-control',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[PanelControlController::class, 'inicio'])->name("panel.inicio");
});

// Ruta Catagorias
Route::group([
	'prefix' => 'categorias',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[CategoriaController::class, 'inicio'])->name("categoria.inicio");
	Route::post("/agregar",[CategoriaController::class, 'agregar'])->name("categoria.agregar");
	Route::get("/modificar/{id}",[CategoriaController::class, 'formModificar'])->name("categoria.modificar");
	Route::post("/modificar/{id}",[CategoriaController::class, 'modificar']);
	Route::get("/eliminar/{id}",[CategoriaController::class, 'eliminar'])->name("categoria.eliminar");
	Route::get("/sub-categorias/{id?}",[CategoriaController::class, 'subCategorias'])->name("categoria.sub-categorias");	
});

Route::group([
	'prefix' => 'productos',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[ProductoController::class, 'tabla'])->name("producto.tabla");
	Route::get("/masivo",[ProductoController::class, 'formMasivo'])->name("producto.masivo");
	Route::post("/masivo",[ProductoController::class, 'cargarMasivo']);
	Route::get("/agregar",[ProductoController::class, 'formAgregar'])->name("producto.agregar");
	Route::post("/agregar",[ProductoController::class, 'agregar']);
	Route::get("/modificar/{id}",[ProductoController::class, 'formModificar'])->name("producto.modificar");
	Route::post("/modificar/{id}",[ProductoController::class, 'modificar']);
	Route::get("/eliminar/{id}",[ProductoController::class, 'eliminar'])->name("producto.eliminar");
	Route::get("/fotos/{id}",[ProductoController::class, 'formEditarFotos'])->name("producto.fotos");
	Route::post("/fotos/{id}/agregar",[ProductoController::class, 'agregarFotos'])->name("producto.fotos.agregar");
	Route::post("/fotos/{id}/actualizar",[ProductoController::class, 'actualizarFotos'])->name("producto.fotos.actualizar");
	Route::post("/fotos/{id}/eliminar",[ProductoController::class, 'eliminarFotos'])->name("producto.fotos.eliminar");
	
});

Route::group([
	'prefix' => 'publicidad',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[PublicidadController::class, 'tabla'])->name("publicidad.tabla");
	Route::get("/agregar",[PublicidadController::class, 'formAgregar'])->name("publicidad.agregar");
	Route::post("/agregar",[PublicidadController::class, 'agregar']);
	Route::get("/modificar/{id}",[PublicidadController::class, 'formModificar'])->name("publicidad.modificar");
	Route::post("/modificar/{id}",[PublicidadController::class, 'modificar']);
	Route::get("/eliminar/{id}",[PublicidadController::class, 'eliminar'])->name("publicidad.eliminar");
});


Route::group([
	'prefix' => 'promociones',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[PromocionController::class, 'tabla'])->name("promocion.tabla");
	Route::get("/agregar",[PromocionController::class, 'formAgregar'])->name("promocion.agregar");
	Route::post("/agregar",[PromocionController::class, 'agregar']);
	Route::get("/modificar/{id}",[PromocionController::class, 'formModificar'])->name("promocion.modificar");
	Route::post("/modificar/{id}",[PromocionController::class, 'modificar']);
	Route::get("/eliminar/{id}",[PromocionController::class, 'eliminar'])->name("promocion.eliminar");
});

Route::group([
	'prefix' => 'cobertura',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[CoberturaController::class, 'mapaGeneral'])->name("cobertura.mapa");
	Route::get("/agregar",[CoberturaController::class, 'formAgregar'])->name("cobertura.agregar");
	Route::post("/agregar",[CoberturaController::class, 'agregar']);
	Route::get("/modificar/{id}",[CoberturaController::class, 'formModificar'])->name("cobertura.modificar");
	Route::post("/modificar/{id}",[CoberturaController::class, 'modificar']);
	Route::get("/eliminar/{id}",[CoberturaController::class, 'eliminar'])->name("cobertura.eliminar");
});


Route::group([
	'prefix' => 'pedidos',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[PagoController::class, 'tabla'])->name("pago.tabla");
	Route::get("/{id}/detalles",[PagoController::class, 'detalles'])->name("pago.detalles");
	Route::post("verificarExistencia",[PagoController::class, 'verificarExistencia'])->name("pago.verificarExistencia");
	Route::get("/{id}/imprimir",[PagoController::class, 'imprimir'])->name("pago.imprimir");
	Route::get("/{id}/generarXLS",[PagoController::class, 'generarXLS'])->name("pago.generarXLS");
	Route::get("/{id}/c_estado",[PagoController::class, 'mostrarFormCEstado'])->name("pago.c_estado");
	Route::post("/{id}/c_estado",[PagoController::class, 'cambiarEstado']);
	Route::get("/{id}/estados",[PagoController::class, 'mostrarEstados'])->name("pago.estados");
	Route::get("/{id}/domiciliario",[PagoController::class, 'mostrarFormDomiciliario'])->name("pago.domiciliario");
	Route::post("/{id}/domiciliario",[PagoController::class, 'asignarDomiciliario']);

	Route::get("/referidos",[PagoController::class, 'reporteReferidos'])->name("pago.referidos");
	Route::get("/pedidosHoy",[PagoController::class, 'reportePedidosHoy'])->name("pago.pedidosHoy");
	
});


Route::group([
	'prefix' => 'cliente',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
	Route::get("/",[ClienteController::class, 'tabla'])->name("cliente.tabla");
	Route::get("/{id}/cambiarEstado",[ClienteController::class, 'cambiarEstado'])->name("cliente.cambiarEstado");
	Route::get("/{id}/historial",[ClienteController::class, 'mostrarHistorial'])->name("cliente.historial");
	Route::get("/{idCliente}/historial/{idPago}",[ClienteController::class, 'verDetallePago'])->name("cliente.verPago");
	Route::get("/reporteClientes",[ClienteController::class, 'reporteClientes'])->name("cliente.reporteClientes");
	
});




Route::group([
	'prefix' => 'cupones',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[CuponesController::class, 'tabla'])->name("cupones.tabla");
	Route::get("/agregar",[CuponesController::class, 'formAgregar'])->name("cupones.agregar");
	Route::post("/agregar",[CuponesController::class, 'agregar']);
	Route::get("/modificar/{id}",[CuponesController::class, 'formModificar'])->name("cupones.modificar");
	Route::post("/modificar/{id}",[CuponesController::class, 'modificar']);
	Route::get("/cambiarEs/{id}",[CuponesController::class, 'cambiarEstado'])->name("cupones.cambiarEs");
	Route::get("/reporte",[CuponesController::class, 'reporte'])->name("cupones.reporte");
});


Route::group([
	'prefix' => 'domiciliario',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[DomiciliarioController::class, 'tabla'])->name("domiciliario.tabla");
	Route::get("/agregar",[DomiciliarioController::class, 'formAgregar'])->name("domiciliario.agregar");
	Route::post("/agregar",[DomiciliarioController::class, 'agregar']);
	Route::get("/modificar/{id}",[DomiciliarioController::class, 'formModificar'])->name("domiciliario.modificar");
	Route::post("/modificar/{id}",[DomiciliarioController::class, 'modificar']);
	Route::get("/cambiarEs/{id}",[DomiciliarioController::class, 'cambiarEstado'])->name("domiciliario.cambiarEs");
	Route::get("/{id}/historial",[DomiciliarioController::class, 'mostrarHistorial'])->name("domiciliario.historial");
	Route::get("/{idDomiciliario}/historial/{idPago}",[DomiciliarioController::class, 'verDetallePago'])->name("domiciliario.verPago");
});


Route::group([
	'prefix' => 'configuracion',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[ConfiguracionController::class, 'inicio'])->name("configuracion.inicio");
	Route::post("/referidos",[ConfiguracionController::class, 'modificarReferido'])->name("configuracion.referidos");
	Route::post("/domicilios",[ConfiguracionController::class, 'modificarValoresDomicilio'])->name("configuracion.domicilios");	
});

Route::group([
	'prefix' => 'despacho',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[CategoriaController::class, 'orden'])->name("despacho.orden");
	Route::post("/",[CategoriaController::class, 'actualizarOrden']);
});

Route::group([
	'prefix' => 'administrador',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[AdministradorController::class, 'tabla'])->name("administrador.tabla");
	Route::get("/agregar",[AdministradorController::class, 'formAgregar'])->name("administrador.agregar");
	Route::post("/agregar",[AdministradorController::class, 'agregar']);
	Route::get("/modificar/{id}",[AdministradorController::class, 'formModificar'])->name("administrador.modificar");
	Route::post("/modificar/{id}",[AdministradorController::class, 'modificar']);
	// Route::get("/eliminar/{id}",[PromocionController::class, 'eliminar'])->name("administrador.eliminar");
});


Route::group([
	'prefix' => 'distribuidor',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
	Route::get("/",[DistribuidorController::class, 'tabla'])->name("distribuidor.tabla");
	Route::get("/{id}/cambiarEstado",[DistribuidorController::class, 'cambiarEstado'])->name("distribuidor.cambiarEstado");
	Route::get("/{id}/activarDistribuidor",[DistribuidorController::class, 'activarDistribuidor'])->name("distribuidor.activarDistribuidor");
	Route::get("/{id}/desactivarDistribuidor",[DistribuidorController::class, 'desactivarDistribuidor'])->name("distribuidor.desactivarDistribuidor");

	Route::get("/{id}/historial",[DistribuidorController::class, 'mostrarHistorial'])->name("distribuidor.historial");
	Route::get("/{idCliente}/historial/{idPago}",[DistribuidorController::class, 'verDetallePago'])->name("distribuidor.verPago");
	Route::get("/reporteClientes",[DistribuidorController::class, 'reporteClientes'])->name("distribuidor.reporteClientes");
	
});


Route::group([
	'prefix' => 'reclutador',
	'middleware' => ['auth','user-role:superadmin|admin']
], function() {
    Route::get("/",[ReclutadorController::class, 'tabla'])->name("reclutador.tabla");
	Route::get("/agregar",[ReclutadorController::class, 'formAgregar'])->name("reclutador.agregar");
	Route::post("/agregar",[ReclutadorController::class, 'agregar']);
	Route::get("/modificar/{id}",[ReclutadorController::class, 'formModificar'])->name("reclutador.modificar");
	Route::post("/modificar/{id}",[ReclutadorController::class, 'modificar']);
	Route::get("/cambiarEs/{id}",[ReclutadorController::class, 'cambiarEstado'])->name("reclutador.cambiarEs");
	Route::get("/pago/{id}",[ReclutadorController::class, 'formPago'])->name("reclutador.pago");
	Route::post("/pago/{id}",[ReclutadorController::class, 'pagar']);
});