@extends('sales.sales')

@section('subcontent')

@include('js.salesInquiryFunctions')

<div id="validate-info"></div>

<table class="table table-bordered table-condensed table-hover kg-table">
    <thead>
        <tr>
            <th class="col-md-1 text-center">Factura</th>
            <th class="col-md-2 text-center">Cliente</th>
            <th class="col-md-1 text-center">Cerrada el</th>
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
            <td class="text-center">{{$header->MODIFIEDAT}}</td>
            <td class="text-center">{{$header->DESCRIPTION}}</td>
            <td class="text-center">{{$header->QTYOFLINES}}</td>
            <td class="text-center">$ {{$header->TOTAL}}</td>
            <td class="text-center">
                <a href="{{url('salesReportInvoice')}}/{{$header->INVOICEID}}" target="_blank" class="btn btn-default">
                    <span class="glyphicon glyphicon-zoom-in"></span> Ver
                </a>
                <a href="{{url('salesReOpen')}}/{{$header->INVOICEID}}" class="btn btn-default">
                    <span class = "glyphicon glyphicon-inbox"></span> Re-abrir
                </a>
                <!--a href="{{url('sendInvoiceByMail')}}/{{$header->INVOICEID}}" target="_blank" class="btn btn-default">Enviar</a-->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    search();
</script>

@endsection