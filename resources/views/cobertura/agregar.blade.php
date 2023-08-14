@extends('adminlte::page')


@section('plugins.Sweetalert2', true)

@section('title', 'Agregar perimetro')

@section('content_header')
    <h1>Agregar perimetro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('cobertura.mapa') }}" class="color-azul">Cobertura</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar perimetro</li>
        </ol>
    </nav>

@stop

@section('content')
    <div class="container-fluid">
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
                <div class="card card-verde my-4">
                    <form id="form_mapa" method="POST" action="{{ route('cobertura.agregar') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="perimetro" id="perimetro" />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input id="nombre" type="text"
                                            class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                            value="{{ old('nombre') }}" autocomplete="nombre" autofocus>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Has clic en el mapa para agregar puntos al
                                            perimetro</label>
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
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

        function IniciarMapaPerimetro(lat, long) {
            let map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(lat, long),
                zoom: 12,
                scaleControl: true
            });

            let path1 = [];
            poly = new google.maps.Polygon({
                map: map,
                path: path1,
                strokeColor: "#FF0000",
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                strokeOpacity: 0.8,
                strokeWeight: 2
            });
            path1.forEach(function(item, index) {

                let marker = new google.maps.Marker({
                    map: map,
                    position: item,
                    draggable: true
                });
                google.maps.event.addListener(marker, 'drag', function(dragEvent) {
                    poly.getPath().setAt(index, dragEvent.latLng);
                });
            });


            google.maps.event.addListener(map, 'click', function(clickEvent) {
                if (isClosed) {
                    //return;
                    let markerIndex = poly.getPath().length;
                    let marker = new google.maps.Marker({
                        map: map,
                        position: clickEvent.latLng,
                        draggable: true
                    });
                    google.maps.event.addListener(marker, 'drag', function(dragEvent) {
                        poly.getPath().setAt(markerIndex, dragEvent.latLng);
                    });
                    //poly.getPath().insertAt(poly.getPath().length, clickEvent.latLng);
                    poly.getPath().push(clickEvent.latLng);
                } else {
                    let markerIndex = poly.getPath().length;
                    let isFirstMarker = markerIndex === 0;
                    let marker = null;
                    if (isFirstMarker) {
                        marker = new google.maps.Marker({
                            map: map,
                            position: clickEvent.latLng,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            draggable: true
                        });
                    } else {
                        marker = new google.maps.Marker({
                            map: map,
                            position: clickEvent.latLng,
                            draggable: true
                        });
                    }
                    if (isFirstMarker) {
                        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');


                        google.maps.event.addListener(marker, 'click', function() {
                            if (isClosed)
                                return;
                            let path = poly.getPath();
                            poly.setMap(null);
                            poly = new google.maps.Polygon({
                                map: map,
                                path: path,
                                strokeColor: "#FF0000",
                                fillColor: '#FF0000',
                                fillOpacity: 0.35,
                                strokeOpacity: 0.8,
                                strokeWeight: 2
                            });
                            isClosed = true;
                        });
                    }
                    google.maps.event.addListener(marker, 'drag', function(dragEvent) {
                        poly.getPath().setAt(markerIndex, dragEvent.latLng);
                    });
                    poly.getPath().push(clickEvent.latLng);
                }

            });


        }
        
        function initMap(){
            IniciarMapaPerimetro(4.675932, -74.066347);
        }
        

        $(document).ready(function(e) {
            $("#form_mapa").submit(function(e) {
                if (isClosed) {
                    let vertices = poly.getPath();
                    let contentString = "";
                    let elfin = "";
                    for (let i = 0; i < vertices.getLength(); i++) {
                        let xy = vertices.getAt(i);
                        contentString += xy.lat() + ' ' + xy.lng() + ',';
                        if (elfin == "") {
                            elfin = xy.lat() + ' ' + xy.lng();
                        }

                    }
                    contentString += elfin;
                    $("#perimetro").val(contentString);
                }
                else{
                    e.preventDefault();
                    Swal.fire({
                        title: '<b>El perimetro no está cerrado</b>',
                        type: 'error',
                        text: 'Verifique el perimetro, recuerde que debe cerrar el perimetro dando click nuevamente en el pin azul',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: 'var(--color-verde)'
                    });
                }
            });
        });
    </script>
    <script src="//maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap"></script>
@stop
