@extends('layouts.web_perfil')

@section('title')
    Mi Historial
@endsection

@section('content')
    <section class="container-fluid mi-cuenta mb-5 pe-5 pt-3">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center justify-content-start">
                <a href="{{route('web.mihistorial')}}"><img class="me-3" src="{{asset('img/web/volver.png')}}" /></a>
                <h1 class="d-inline-block"><i class="fa-solid fa-scroll"></i> Historial de compras</h1>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row pt-5">
            <div class="col-6">
                <span class="color-azul">Fecha</span>
            </div>
            <div class="col-6 text-end">
                <span class="color-gris">{{date("d/m/Y",strtotime($pago->fecha_recib))}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <span class="color-azul">Dirección</span>
            </div>
            <div class="col-6 text-end">
                <span class="color-gris">{{$pago->direccion}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <span class="color-azul">Hora</span>
            </div>
            <div class="col-6 text-end">
                <span class="color-gris">{{$pago->hora_cast()}}</span>
            </div>
        </div>
        <div class="cont-productos-historial py-5">
            @foreach ($productos as $producto)
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="producto-hist">
                            <span class="cantidad @if ($producto->cantidad <= 1) d-none @endif">{{$producto->cantidad}}</span>
                            <div class="img-cont">
                                @if ($producto->fotoPpal() !== null && Storage::disk('public')->exists('productos/min_' . $producto->fotoPpal()->ruta))
                                    <img src="{{ Storage::url('productos/min_' . $producto->fotoPpal()->ruta) }}"
                                        alt="{{ $producto->nombre }}" loading="lazy" />
                                @else
                                    <img src="{{ asset('img/web/placeholder-producto.png') }}" loading="lazy" />{{$producto->fotoPpal()}}
                                @endif
                            </div>
                        </div>
                        <div class="datos-prod">
                            <b class="color-azul">{{$producto->nombre}}</b><br>
                            <span class="color-gris">{{$producto->descripcion}}</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <b class="color-azul">${{number_format($producto->precioMos,0,'.','.')}}</b>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const inputs = document.querySelectorAll(".form-control");
        inputs.forEach(element => {
            element.addEventListener("focus", (e) => {
                const label = e.target.previousElementSibling;
                label.classList.add('focus-label');
            });
            element.addEventListener("blur", (e) => {
                const label = e.target.previousElementSibling;
                label.classList.remove('focus-label');
                let cambio = false;
                inputs.forEach(element2 => {
                    const input_h = document.querySelector(`#${element2.id}Ant`);
                    if(input_h !== null && input_h.value != element2.value){
                        cambio = true;
                    }
                });
                const btnGuardar = document.querySelector(`.btn-guardar`);
                btnGuardar.disabled = !cambio;
            });
        });
        // document.querySelector("#distribuidor").addEventListener("change",(e) => {
        //     if(document.querySelector("#distribuidor").checked){
        //         document.querySelector(".rut-cont").classList.remove("d-none");
        //     }
        //     else{
        //         document.querySelector(".rut-cont").classList.add("d-none");
        //     }
        // });
    </script>
@endsection
