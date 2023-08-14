<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h5>Preguntas frecuentes</h5>
            </div>
            <div class="col-md-3">
                <h5>Términos y condiciones</h5>
            </div>
            <div class="col-md-3">
                <h5>Políticas de privacidad</h5>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="footer-legal">
        <div class="container">
            Todos los derechos reservados {{ date('Y') }} <a href="#">Términos y condiciones</a>
        </div>
    </div>
</footer>
<div class="contenedor-ajax-carrito"></div>
<div class="contenedor-ajax-direccion"></div>
<input type="hidden" id="url_verificar" value="{{route('web.direccion.verificar')}}" />
<input type="hidden" id="url_pop_direccion" value="{{route('web.direccion.mostrar')}}" />
<input type="hidden" id="url_quitar_cupon" value="{{route('web.quitarCupon')}}" />
<input type="hidden" id="url_verificar_cupon" value="{{route('web.cupon')}}" />
<input type="hidden" id="url_cambiar_hora" value="{{route('web.cambiarHora')}}" />


<form method="post" action="{{route('logout')}}" id="logout">@csrf</form>