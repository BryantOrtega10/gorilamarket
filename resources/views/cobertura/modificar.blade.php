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
                    <form id="form_mapa" method="POST"
                        action="{{ route('cobertura.modificar', ['id' => $cobertura->idperimetro]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="perimetro" id="perimetro" />
                        <input type="hidden" name="perimetro_ant" id="perimetro_ant"
                            value="{{ $cobertura->getPerimetroJson() }}" />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input id="nombre" type="text"
                                            class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                            value="{{ old('nombre', $cobertura->nombre) }}" autocomplete="nombre" autofocus>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Has clic en el mapa para modificar los
                                            puntos del
                                            perimetro</label>
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-verde">Modificar</button>
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
        let isClosed = true;


        function IniciarMapaPerimetro(lat, long) {
            /**
             * A menu that lets a user delete a selected vertex of a path.
             * @constructor
             */
            function DeleteMenu() {
                this.div_ = document.createElement('div');
                this.div_.className = 'delete-menu';
                this.div_.innerHTML = 'Delete';

                var menu = this;
                google.maps.event.addListener(this.div_, 'click', function() {
                    menu.removeVertex();
                });
            }
            DeleteMenu.prototype = new google.maps.OverlayView();

            DeleteMenu.prototype.onAdd = function() {
                var deleteMenu = this;
                var map = this.getMap();
                this.getPanes().floatPane.appendChild(this.div_);

                // mousedown anywhere on the map except on the menu div will close the
                // menu.
                this.divListener_ = google.maps.event.addListener(map.getDiv(), 'mousedown', function(e) {
                    if (e.target != deleteMenu.div_) {
                        deleteMenu.close();
                    }
                }, true);
            };

            DeleteMenu.prototype.onRemove = function() {
                google.maps.event.removeListener(this.divListener_);
                this.div_.parentNode.removeChild(this.div_);

                // clean up
                this.set('position');
                this.set('path');
                this.set('vertex');
            };

            DeleteMenu.prototype.close = function() {
                this.setMap(null);
            };

            DeleteMenu.prototype.draw = function() {
                var position = this.get('position');
                var projection = this.getProjection();

                if (!position || !projection) {
                    return;
                }

                var point = projection.fromLatLngToDivPixel(position);
                this.div_.style.top = point.y + 'px';
                this.div_.style.left = point.x + 'px';
            };

            /**
             * Opens the menu at a vertex of a given path.
             */
            DeleteMenu.prototype.open = function(map, path, vertex) {
                this.set('position', path.getAt(vertex));
                this.set('path', path);
                this.set('vertex', vertex);
                this.setMap(map);
                this.draw();
            };

            /**
             * Deletes the vertex from the path.
             */
            DeleteMenu.prototype.removeVertex = function() {
                var path = this.get('path');
                var vertex = this.get('vertex');

                if (!path || vertex == undefined) {
                    this.close();
                    return;
                }

                path.removeAt(vertex);
                this.close();
            };

            let map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(lat, long),
                zoom: 12,
                scaleControl: true
            });


            let path1 = JSON.parse($("#perimetro_ant").val());
            poly = new google.maps.Polygon({
                map: map,
                path: path1,
                editable: true,
                strokeColor: "#FF0000",
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                strokeOpacity: 0.8,
                strokeWeight: 2
            });
            var deleteMenu = new DeleteMenu();
            google.maps.event.addListener(path1, 'rightclick', function(e) {
                // Check if click was on a vertex control point
                if (e.vertex == undefined) {
                    return;
                }
                deleteMenu.open(map, flightPath.getPath(), e.vertex);
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

        function initMap() {

            IniciarMapaPerimetro({{ $cobertura->getPrimerPunto()['lat'] }},
                {{ $cobertura->getPrimerPunto()['lng'] }});
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
                } else {
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
    <script src="//maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
@stop
