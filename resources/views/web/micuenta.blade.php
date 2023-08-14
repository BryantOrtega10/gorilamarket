@extends('layouts.web_perfil')

@section('title')
    Mi cuenta
@endsection

@section('content')
    <section class="container-fluid mi-cuenta">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1><i class="fa-regular fa-user"></i> Mi cuenta</h1>
            </div>
            <div class="col-md-4 color-azul text-end"><span class="text-start mi-codigo">Mi código de referido</span>
                <br>
                <span class="s_codigo_referido">
                    {{ $cliente->fijo }} 
                    <img src="{{asset('img/web/copiar.png')}}" />
                </span>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <form action="{{route('web.micuenta')}}" method="POST">
            @csrf
            <input type="hidden" name="nombreAnt" id="nombreAnt" value="{{$cliente->nombre}}" />
            <input type="hidden" name="apellidoAnt" id="apellidoAnt" value="{{$cliente->apellido}}" />
            <input type="hidden" name="correoAnt" id="correoAnt" value="{{$cliente->email}}" />
            
            <div class="row mt-5">
                <div class="form-group col-4">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control w-90 @error('nombre') is-invalid @enderror" value="{{old('nombre',$cliente->nombre)}}" />
                    @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control w-90 @error('apellido') is-invalid @enderror" value="{{old('apellido',$cliente->apellido)}}"/>
                    @error('apellido')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control w-90 @error('correo') is-invalid @enderror" value="{{old('correo',$cliente->email)}}"/>
                    @error('correo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label for="celular">Celular</label>
                    <input type="number" name="celular" id="celular" disabled class="form-control w-90 @error('celular') is-invalid @enderror" value="{{old('celular',$cliente->celular)}}"/>
                    <img src="{{asset('img/web/bloquear.png')}}" />
                    @error('celular')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="foot-mi-cuenta align-items-end d-flex justify-content-end mh-100">
                <button class="btn btn-verde btn-guardar" disabled>Guardar cambios</button>
            </div>
        </form>
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
        document.querySelector(".s_codigo_referido").addEventListener("click", (e) => {
            let tempInput = document.createElement("textarea");
            tempInput.style.position = "fixed";
            tempInput.style.opacity = 0;
            tempInput.value = `{{$cliente->fijo}}`;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        });
        
    </script>
@endsection
