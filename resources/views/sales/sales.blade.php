@extends('layouts.layout')

@section('scripts')

    $(document).ready(function(){

        $("#SalesMenuItem").addClass("active");
    });

@endsection

@section('content')

<div class="btn-group btn-group-justified">
    <a href="{{url('salesNew')}}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</a>
    <a href="{{url('salesClose')}}" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span> Consultar cerrados</a>
    <a href="{{url('salesOpen')}}" class="btn btn-default"><span class="glyphicon glyphicon-remove-sign"></span> Consultar abiertos</a>
</div>

<br>

@yield('subcontent')

@endsection