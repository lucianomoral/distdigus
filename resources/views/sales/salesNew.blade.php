@extends('sales.sales')

@section('subcontent')
<form class="form-inline" method="get">
    <div id="validate-info"></div>
    <div class="form-group">
        <label for="CustomerList">Cliente:</label>
        <select class="form-control" id="CustomerList">
            @foreach ($customer as $cust)
                <option value="{{$cust->CUSTID}}">{{$cust->CUSTNAME}}</option>
            @endforeach
        </select>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="form-group">
        <label for="ListList">Lista:</label>
        <select class="form-control" name="ListList" id="ListList">
            @foreach ($listheader as $list)
                <option value="{{$list->LISTID}}">{{$list->LISTNAME}}</option>
            @endforeach
        </select>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="form-group">
        <label for="DescriptionText">Descripcion:</label>
        <input type="text" class="form-control" id="DescriptionText">
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="btn btn-default" id = "CreateNewSales">Crear</button>
</form>

@include('js.functions')

<script>

   $("#CreateNewSales").click(function(){
    
       var cust = $("#CustomerList").val();
       var list = $("#ListList").val();
       var desc = $("#DescriptionText").val();
       

       if (!cust || !list){

           showError("Falta completar cliente o lista");

       } else {

           $.ajax({
            
                url: "{{url('salesCreate')}}",
                data:{customerid:   $("#CustomerList option:selected").val(),
                      listid:       $("#ListList option:selected").val(),
                      description:  $("#DescriptionText").val()
                    },
                success: function($invoice){
                    var redir = "{{url('salesAddLines')}}";
                    redir += "/";
                    redir += $invoice.invoiceid;
                    window.location=redir;},
                    //alert(redir);},
                error:  function(){showError("Error al crear nuevo pedido.");}

           });

       }

       return false;

    });

</script>

@endsection