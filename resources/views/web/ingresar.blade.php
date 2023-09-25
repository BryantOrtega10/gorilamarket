@extends('layouts.web_sin_header')

@section('title')
    Ingresar
@endsection

@section('content')
    <div id="g_id_onload" data-client_id="838832911627-b7o7ajf1f3n3cj7ccls1l214lpkhltgn.apps.googleusercontent.com"
        data-callback="handleCredentialResponse">
    </div>
    <div class="container iniciar">
        <div class="row align-content-center vh-100">
            <div class="d-none d-md-block col-md-7">
                <img src="{{ asset('img/web/inicio.png') }}" class="mw-100" />
            </div>
            <div class="align-content-center col-12 col-md-5 d-flex flex-column flex-wrap justify-content-center">
                <div class="text-center"><img src="{{ asset('img/web/logo_grande.png') }}" /></div>
                <h2>Inicia sesión con</h2>
                <a class="btn btn-iniciar-google">
                    <div class="g_id_signin" data-type="standard"
                        data-size="large"
                        data-width="330"
                        data-locale="es_CO"
                        data-theme="outline"
                        data-text="sign_in_with"
                        data-shape="circle"
                        data-logo_alignment="left"
                    ></div>
                </a>
                <a class="btn btn-iniciar-facebook">Sigue con Facebook</a>
                <div class="seguir_div text-center"><span>o sigue con tu celular</span></div>
                <a class="btn btn-iniciar-celular" href="{{ route('web.registroCelular') }}">Continua con tu celular</a>
                <b class="text-center">¿Ya tienes una cuenta?</b>
                <a class="btn btn-continuar-verde" href="{{ route('web.cuentaCelular') }}">Continuar</a>
            </div>
        </div>
    </div>
@endsection

@section('imports')
    <script src="https://accounts.google.com/gsi/client" async defer></script>
@endsection

@section('scripts')
    <script>
        document.querySelector(".btn-iniciar-google").addEventListener('click', () => {
            document.querySelector('.g_id_signin div[role=button]').click();
        });

        function handleCredentialResponse(response) {
            console.log(response);
            let url_verificar = '{{route("web.ingresarGoogle")}}';
            let data = { credential: response.credential};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            fetch(url_verificar, {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "X-CSRF-Token": csrfToken,
                    "Content-Type": "application/json",
                },
            })
                .then((res) => res.json())
                .catch((error) => console.error("Error:", error))
                .then((response) => {
                    console.log(response);
                    // if (response.success == true) {
                    //     window.location.reload();
                    // } else {
                    //     alert(response.error);
                    // }
                });
        }
    </script>
@endsection
