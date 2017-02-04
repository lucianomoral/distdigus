@extends('sales.sales')

@section('subcontent')

<table class="table table-bordered table-condensed table-hover kg-table">
    <thead>
        <tr>
            <th class="col-md-2 text-center">Id. factura</th>
            <th class="col-md-2 text-center">Cliente</th>
            <th class="col-md-2 text-center">Fecha de creación</th>
            <th class="col-md-2 text-center">Descripción</th>
            <th class="col-md-2 text-center">Cant. de lineas</th>
            <th class="col-md-2 text-center">Total</th>
            <th class="col-md-2 text-center">Acciones</th>
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
            <td class="text-center"><a href="{{url('salesAddLines')}}/{{$header->INVOICEID}}" class="btn btn-default">Abrir</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection