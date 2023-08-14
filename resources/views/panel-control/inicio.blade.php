@extends('adminlte::page')

@section('title', 'Panel de control')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <ul data-widget="treeview">
        <li><a href="#3">One Level</a></li>
        <li class="nav-item">
            <a class="nav-link" href="#1">Multilevel</a>
            <ul class="nav-treeview">
                <li><a href="#2">Level 2</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#3">Multilevel</a>
            <ul class="nav-treeview">
                <li><a href="#4">Level 2</a></li>
                <li><a href="#5">Level 2</a></li>
                <li><a href="#6">Level 2</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#10">Multilevel</a>
            <ul class="nav-treeview">
                <li><a href="#7">Level 2</a></li>
                <li><a href="#8">Level 2</a></li>
                <li><a href="#9">Level 2</a></li>
            </ul>
        </li>
    </ul>
@stop

@section('css')

@stop

@section('js')
    <script>
        $('ul').Treeview();
    </script>
@stop
