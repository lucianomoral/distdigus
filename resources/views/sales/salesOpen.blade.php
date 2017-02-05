@extends('sales.sales')

@section('subcontent')

@include('js.salesFunctions')

@include('js.salesInquiryFunctions')

<div id="validate-info"></div>

<table class="table table-bordered table-condensed table-hover kg-table">
    <thead>
        <tr>
            <th class="col-md-1 text-center">Factura</th>
            <th class="col-md-2 text-center">Cliente</th>
            <th class="col-md-1 text-center">Creada el</th>
            <th class="col-md-2 text-center">Descripción</th>
            <th class="col-md-1 text-center">Lineas</th>
            <th class="col-md-1 text-center">Total</th>
            <th class="col-md-3 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($custinvoiceheader as $header)
        <tr>
            <td class="text-center invoiceid">{{$header->INVOICEID}}</td>
            <td class="text-center custname">{{$header->CUSTNAME}}</td>
            <td class="text-center">{{$header->CREATEDAT}}</td>
            <td class="text-center">{{$header->DESCRIPTION}}</td>
            <td class="text-center">{{$header->QTYOFLINES}}</td>
            <td class="text-center">$ {{$header->TOTAL}}</td>
            <td class="text-center">
                <a href="{{url('salesAddLines')}}/{{$header->INVOICEID}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-share-alt"></span> Abrir
                </a>
                <a href="{{url('deleteInvoice')}}/{{$header->INVOICEID}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-trash"></span> Borrar
                </a>
                <a href="" onclick = "closeInvoice({{$header->INVOICEID}}); return false;" class="btn btn-default">
                    <span class="glyphicon glyphicon-check"></span> Cerrar
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection