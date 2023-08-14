@extends('layouts.web_perfil')

@section('title')
    Mi Historial
@endsection

@section('content')
    <section class="container-fluid mi-cuenta mb-5 pe-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1><i class="fa-solid fa-scroll"></i> Historial de compras</h1>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @foreach ($pagos as $pago)
            <hr>
            <div class="row color-azul">
                <div class="col-md-2">
                    <b>Fecha</b><br>
                    <span class="color-gris">{{$pago->fecha_recib}}</span>
                </div>
                <div class="col-md-2">
                    <b>Tipo de pago</b><br>
                    <span class="color-gris">{{ucfirst($pago->tipo_pago)}}</span>
                </div>
                <div class="col-md-2">
                    <b>Dirección</b><br>
                    <span class="color-gris">{{$pago->direccion}}</span>
                </div>
                <div class="col-md-2">
                    <b>Valor</b><br>
                    <span class="color-gris">${{number_format($pago->valor,0,".",".")}}</span>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{route('web.verDetallePago',['id' => $pago->idpago])}}" class="color-verde ver-mas-historial">
                        Ver más <img src="{{asset('img/web/flecha_verde.png')}}" />
                    </a>
                </div>
            </div>
        @endforeach
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
