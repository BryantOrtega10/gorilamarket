@extends('layouts.web_sin_header')

@section('title')
Registro
@endsection

@section('content')
    <form action="{{ route('web.validarCodigoSMS') }}" method="POST" autocomplete="off">
        @csrf
        <div class="container vh-100 text-center registro introducir_codigo">
            <div class="align-content-between h-100 row">
                <div class="col-12">
                    <h1>Registro</h1>
                    <h2>Numero de télefono</h2>
                    <p>Escribe el código de confirmación que enviamos a tu celular </p>
                    <div>
                        <input type="text" id="codigoD1" name="codigoD1" maxlength="1"/> - 
                        <input type="text" id="codigoD2" name="codigoD2" maxlength="1"/> - 
                        <input type="text" id="codigoD3" name="codigoD3" maxlength="1"/> - 
                        <input type="text" id="codigoD4" name="codigoD4" maxlength="1"/>
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
                    <button class="btn btn-verde">Continuar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.querySelector("#codigoD1").addEventListener("keyup",(e) => {
            document.querySelector("#codigoD2").focus();
        });
        document.querySelector("#codigoD2").addEventListener("keyup",(e) => {
            document.querySelector("#codigoD3").focus();
        });
        document.querySelector("#codigoD3").addEventListener("keyup",(e) => {
            document.querySelector("#codigoD4").focus();
        });
        
    </script>
@endsection
