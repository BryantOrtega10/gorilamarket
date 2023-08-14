@extends('adminlte::page')

@section('title', 'Cobertura')

@section('plugins.Sweetalert2', true)

@section('content_header')
    <div class="row">
        <div class="col-12 col-md-8">
            <h1>Cobertura</h1>
        </div>
        <div class="col-12 col-md-4 text-right">
            <a href="{{ route('cobertura.agregar') }}" class="btn btn-outline-azul">Agregar perimetro</a>
        </div>
    </div>
@stop

@section('content')
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            @foreach ($coberturas as $cobertura)
                <input type="hidden" name="idperimetro[]" class="idPerimetro" value="{{$cobertura->idperimetro}}" />
                <input type="hidden" name="perimetroJson[]" class="perimetroJson" value="{{$cobertura->getPerimetroJson()}}" />
                <input type="hidden" name="nombre[]" class="nombre" value="{{$cobertura->nombre}}" />
                <input type="hidden" name="modificar[]" class="r_modificar" value="{{route('cobertura.modificar',['id'=>$cobertura->idperimetro])}}" />
                <input type="hidden" name="eliminar[]" class="r_eliminar" value="{{route('cobertura.eliminar',['id'=>$cobertura->idperimetro])}}" />
            @endforeach
            <div id="map"></div>
        </div>
    </div>

    
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')

    <script>
        let poly = null;
        let isClosed = false;
        let polys = [];
        function obtenerColorAleatorio() {
            const rojo = Math.floor(Math.random() * 256);
            const verde = Math.floor(Math.random() * 256);
            const azul = Math.floor(Math.random() * 256);
            return "rgb(" + rojo + ", " + verde + ", " + azul + ")";
        }

        function IniciarMapaPerimetro(lat,long){
            let map = new google.maps.Map(document.getElementById('map'), { center: new google.maps.LatLng(lat, long), zoom: 12, scaleControl: true });
            let infowindow = new google.maps.InfoWindow({
              size: new google.maps.Size(250, 50)
            });
            let elements = document.querySelectorAll('.perimetroJson');
            
            for (let i = 0; i < elements.length; i++) {
                let path = JSON.parse(elements[i].value);
                let colorAle = obtenerColorAleatorio();
                let poly = new google.maps.Polygon({ map: map, path: path, strokeColor: colorAle, fillColor: colorAle, fillOpacity: 0.35, strokeOpacity: 0.8, strokeWeight: 2 });
                polys.push(poly);
                google.maps.event.addListener(polys[polys.length - 1], 'click', function(event) {
                    let contentString = `<h4>${document.querySelectorAll('.nombre')[i].value}</h4><br>
                    <a href="${document.querySelectorAll('.r_modificar')[i].value}" class="btn btn-verde">Modificar</a>
                    <a href="${document.querySelectorAll('.r_eliminar')[i].value}" class="btn btn-danger eliminar">Eliminar</a>
                    `;
                    infowindow.setContent(contentString);
                    infowindow.setPosition(event.latLng);
                    infowindow.open(map);
                });
                
            }
        }
        function initMap(){
            IniciarMapaPerimetro(4.675932, -74.066347);
        }
        


        $("body").on("click",".eliminar",function(e){
            e.preventDefault();
            const link = $(this).attr("href");
            Swal.fire({
                title: '<b>Eliminar perimetro</b>',
                type: 'warning',
                text: 'En verdad desea eliminar este perimetro?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: 'var(--color-verde)'
            }).then((result) => {
                if (result.value) {
                    window.open(link,'_self');
                }
            });
        });
    </script>
    <script src="//maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap"></script>
@stop
