@extends('sales.sales')

@section('subcontent')

<form class="form-inline">
    <div id="validate-info"></div>
    <div class="form-group col-xs-2 margin-right">
        <label for="CustomerText">Cliente:</label>
        <input type="text" class="text-center form-control" value = '{{$custname}}' id = "CustomerText" readonly>
    </div>
    
    <div class="form-group col-xs-2 margin-right">
        <label for="InvoiceText">Pedido:</label>
        <input type="text" class="text-center form-control" value = '{{$invoiceid}}' id = "InvoiceText" readonly name = "InvoiceText">
    </div>

    <div class="form-group col-xs-2 margin-right">
        <label for="ListList">Lista por defecto:</label>
        <select class = "form-control" id="ListList" name="ListList">
            @foreach($listheader as $list)
                @if($list->LISTID == $listid)
                    <option selected value = "{{$list->LISTID}}">{{$list->LISTNAME}}</option>
                @else
                    <option value = "{{$list->LISTID}}">{{$list->LISTNAME}}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group col-xs-2 margin-right">
        <label for="MarginNumber">Margen:</label>
        <input type="number" class="text-center form-control" id = "MarginNumber">
    </div>

    <div class="form-group col-xs-2 margin-right">
        <input id="packageqtyactive" type="checkbox"
        @if($invoiceperpackqty == 1)
        checked
        @endif
        >
        <label for="PackageQty">Cant. por bulto:</label>
        <input type="number" class="text-center form-control" id = "PackageQty" readonly>
    </div>

</form>


    <div class="sales-lines-table">
        <div class="btn-group btn-group-justified">
            <a href="#" class="btn btn-default" id="save"><span class="glyphicon glyphicon-floppy-saved"></span> Guardar cambios</a>
            <a href="#" class="btn btn-default" id="delete"><span class="glyphicon glyphicon-trash"></span> Eliminar lineas marcadas</a>
        </div>
        <br>
        <table class="table table-bordered table-condensed table-hover kg-table">
            <thead>
                <tr>
                    <th class="col-md-1 text-center"><input class="sales-input-data" type="checkbox" id="checkAll"></th>
                    <th class="col-md-2 text-center">Id.</th>
                    <th class="col-md-8 text-center">Nombre</th>
                    <th class="col-md-2 text-center">Cantidad</th>
                    <th class="col-md-2 text-center">Precio</th>
                    <th class="col-md-2 text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr id="input-data-row">
                    <td></td>
                    <td><input id="itemid" name="" class="sales-input-data" type="number" autocomplete="off" autofocus></td>
                    <td id="itemnamerow"><input id="itemname" name="" class="sales-input-data" type="text" autocomplete="off"></td>
                    <td><input id="qty" name="" class="sales-input-data" type="number" autocomplete="off"></td>
                    <td><input id="price" name="" class="sales-input-data" type="number" autocomplete="off"></td>
                    <td><input id="total" name="" class="sales-input-data" type="number" autocomplete="off"></td>
                </tr>
            @if($custinvoiceline[0]->LINENUM != "")
                @foreach($custinvoiceline as $line)
                    <tr>
                        <td><input value = '{{$line->LINENUM}}' class = "checkbox sales-line-checkbox" type="checkbox"></td>
                        <td><input class = "sales-line-data" type="number" value = '{{$line->ITEMID}}' readonly></td>
                        <td><input class = "sales-line-data" type="text" value = '{{$line->ITEMNAME}}' readonly></td>
                        <td><input class = "sales-line-data" type="number" value = '{{$line->QTY}}'></td>
                        <td><input class = "sales-line-data" type="number" value = '{{$line->PRICE}}'></td>
                        <td><input class = "sales-line-data" type="text" value = '$ {{$line->QTY * $line->PRICE}}' readonly></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan = 3></td>
                    <td colspan = 2 class="text-center"><strong>Total: </strong></td>
                    <td class = 'text-center'>$ {{$total}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@include('js.functions')

<script>

    $("#itemid").keydown(function(e){

    if (e.keyCode == 13)
        {
            getProductById();
        }
    });

    $("#qty").keydown(function(e)
    {
        if (e.keyCode == 13)
        {
            //Primero se valida que el código no esté vacío.
            if ($("#itemid").val() == "")
            {     
                showError("Falta completar el código de producto.");
            }
            else
            {
                hideError();
                //Se verifica si está activo el 'Facturar por bulto' para multiplicar por esa cantidad.
                if ($("#packageqtyactive").is(":checked"))
                {
                    $(this).val( $(this).val() * $("#PackageQty").val() );
                }

                getItemPrice();
            }

        }

    });

    $("#price").keydown(function(e)
    {
        //Carga el campo 'Total' multiplicando Precio por Cantidad y redondeando a 2 decimales
        if (e.keyCode == 13)
        {
            $("#total").val( Math.round( (qty.value * price.value) * 100 ) / 100 ).focus();
        }
    });

    $("#total").keydown(function(e)
    {
        if (e.keyCode == 13)
        {
            if (itemid.value == "" || qty.value <= 0 || price.value == 0 || InvoiceText.value == "")
            {
                showError("Faltan datos o algunos son incorrectos.");
            }
            else
            {
                saveInvoiceLine();
            }
        }
    });

    $("tr input.sales-line-data").change(function()
    {
        $(this).parent().parent().addClass("danger hasChanged");
    });

    $("#delete").click(function()
    {
        var linesToDelete = 0;
        var invoiceid = InvoiceText.value;
        var linenum;

        $(".sales-line-checkbox:checked").each(function()
        {
            linenum = $(this).val();
            deleteInvoiceLine(invoiceid, linenum);
            linesToDelete++;
        });

        if (linesToDelete > 0)
        {
            redirToAddSalesLine(invoiceid);
        }

    });

    $("#checkAll").click(function()
    {
        if ($(this).is(":checked"))
        {
            $(".sales-line-checkbox").each(function()
            {
                $(this).prop("checked", true)
            });
        }
        else
        {
            $(".sales-line-checkbox").each(function()
            {
                $(this).prop("checked", false)
            });
        }
    });

    loadItemNameEvent();

</script>

@endsection