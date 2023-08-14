<div class="direccion-pop">
    <div class="text-end">
        <div class="cerrar cerrar-direccion"></div>
    </div>
    <div class="text-center">
        <img src="{{asset('img/web/direccion-lg.png')}}" />
        <h2>¿Dónde quieres recibir tu pedido?</h2>
        <p>Escribe la dirección donde vamos a entregar tu pedido para verificar la cobertura</p>
        @if (sizeof($direcciones) > 0)
            <h3>Direcciones guardadas</h3>
            <select class="form-select direccion-input" name="direccion_g" id="direccion_g">
                <option class="d-none" value="">Selecciona tu dirección</option>
                @foreach ($direcciones as $direccion)
                    <option value="{{$direccion->iddireccion}}" 
                        @if (Session::get('direccion')!== null && Session::get('direccion')->idDireccion === $direccion->iddireccion)
                            selected
                        @endif
                    >{{$direccion->direccionCompleta}}</option>        
                @endforeach
            </select>
            <h3>Nueva dirección</h3>
        @endif
        <input class="form-control direccion-input" name="direccion" id="direccion" placeholder="Escribe tu dirección"
        @if (!isset(Session::get('direccion')->idDireccion))
        value="{{ Session::get('direccion')->direccionCompleta ?? ""}}"
        @endif
        />
        <button type="button" class="btn btn-verde verificarDireccion">Confirmar Dirección</button>
        
    </div>
</div>
<div class="overlay-direccion"></div>