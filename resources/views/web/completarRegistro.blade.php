@extends('layouts.web_sin_header')

@section('title')
    Registro
@endsection

@section('content')
    <form action="{{ route('web.completarRegistro') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="container vh-100 text-center registro datos-finales">
            <div class="align-content-between h-100 row">
                <div class="col-md-4 offset-4 text-start">
                    <h1 class="text-center">Continuar</h1>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{old('nombre')}}" />
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{old('apellido')}}"/>
                        @error('apellido')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{old('correo')}}"/>
                        @error('correo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="distribuidor" name="distribuidor" value="1" @if(old('distribuidor')=="1") checked @endif>
                        <label class="form-check-label" for="distribuidor">Soy distribuidor?</label>
                    </div>
                    <div class="form-group @if(old('distribuidor')!="1") d-none @endif rut-cont">
                        <label for="formFile" class="form-label">Rut</label>
                        <input class="form-control @error('rut') is-invalid @enderror" type="file" id="rut" name="rut">
                        @error('rut')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                    
                    @if (session('mensaje'))
                        <div class="alert alert-alert  d-inline-block mt-4">
                            <strong>{{ session('mensaje') }}</strong>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger  d-inline-block mt-4">
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="col-12">
                    <button class="btn btn-verde">Finalizar</button>
                </div>
            </div>
        </div>
    </form>
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
            });
        });
        document.querySelector("#distribuidor").addEventListener("change",(e) => {
            if(document.querySelector("#distribuidor").checked){
                document.querySelector(".rut-cont").classList.remove("d-none");
            }
            else{
                document.querySelector(".rut-cont").classList.add("d-none");
            }
        });
    </script>
@endsection
