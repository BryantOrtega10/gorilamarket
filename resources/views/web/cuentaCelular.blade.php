@extends('layouts.web_sin_header')

@section('title')
Ingreso
@endsection

@section('content')
    <form action="{{ route('web.enviarCodigoIngreso') }}" method="POST">
        @csrf
        <div class="container vh-100 text-center registro">
            <div class="align-content-between h-100 row">
                <div class="col-12">
                    <h1>Ingreso</h1>
                    <h2>Numero de télefono</h2>
                    <p>Escribe el numero de tu teléfono donde llegara el código de confirmación </p>
                    <div>
                        <b>+57</b>
                        <input type="text" id="numeroTelefono" name="numeroTelefono" />
                    </div>
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
    <script></script>
@endsection
