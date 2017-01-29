<script>

function showError(message)
{
    $("#validate-info").addClass("alert alert-danger").html(message);
}

function showWarning(message)
{
    $("#validate-info").addClass("alert alert-warning").html(message);
}

function hideError()
{
    $("#validate-info").removeClass("alert alert-danger").html("");
}

function hideWarning()
{
    $("#validate-info").removeClass("alert alert-warning").html("");
}

function roundTwoDecimals(numberToRound)
{
    var roundedNumber = 0;
    
    roundedNumber = Math.round(numberToRound * 100) / 100

    return roundedNumber;
}

function getProductById()
{

    var itemid = $("#itemid").val();
    var margin = $("#MarginNumber").val();
    var listid = $("#ListList").val();

    $.ajax({

            url:"{{url('getProductNameById')}}",
            data: {
                    itemid: itemid,
                    margin: margin,
                    listid: listid
            },
            success: function(item){
                                    //Si no vuelve "null", quiere decir que encontro algo
                                    if (item.item != null)
                                    {
                                    //Limpia el div validador
                                        hideError();
                                    //Agrega el nombre
                                        $("#itemnamerow").html("<input id='itemname' name='' class='sales-input-data' type='text' value='" + item.item.ITEMNAME + "'>");
                                        $("#PackageQty").val(item.item.PACKAGEQTY);
                                        loadItemNameEvent();
                                        $("#qty, #price, #total").val("");
                                        $("#qty").focus();

                                    }
                                        //Si vuelve "null", muestra mensaje de error
                                        else 
                                    {
                                        
                                        showError("No se encontró ningún producto.");

                                    }

                                    
            },
            error: function(){showError("No se encontró ningún producto.")}
        })

}

function loadItemNameEvent()
{
    $("#itemname").keydown(function(e)
    {

        if (e.keyCode == 13) 
        {

            var itemname = $(this).val();

            $.ajax({

                url:"{{url('getProductNamesByName')}}",
                data:{
                    itemname: itemname
                },
                success: function(itemname){
                                            //Si el array que devuelve no está vacío, se genera una variable con código HTML para cargar un <select> con los resultados
                                            if (itemname.itemname.length != 0)
                                            {
                                                var itemnameoptions = "<select id='itemnamesearchresult' class='sales-input-data'><option value = ''></option>";

                                                hideError();

                                                itemname.itemname.forEach(function(item){

                                                    itemnameoptions += "<option value ='" + item.ITEMID + "'>" + item.ITEMID + " - " + item.ITEMNAME + "</option>";
 
                                                });

                                                itemnameoptions += "</select>";

                                                $("#itemnamerow").html(itemnameoptions);

                                                $('#itemnamesearchresult').change(

                                                        function()
                                                        {
                                                            $("#itemid").val($(this).val());
                                                            getProductById();
                                                        }
                                                );

                                                $("#itemnamesearchresult").focus();
                                            }
                                            else 
                                            {
                                                showError("No se encontró ningún producto.");
                                            }

                },
                error: function(){showError("No se encontró ningún producto.")}

            });

        }

    });

}

function clearLineData()
{
    $("#itemid, #itemname, #qty, #price, #total").val("");
    $("#itemid").focus();
}

function calculateNewInvoiceTotal()
{
    var newTotal = 0;

    $(".sales-line-total").each(function()
        {
            var totalVal = $(this).val();
            
            newTotal += parseFloat(totalVal.substring(2));

        });

    newTotal = roundTwoDecimals(newTotal);

    $("#sales-total").text( "$ " + newTotal );

}

function loadChangeLinesEvent()
{
    $("tr input.sales-line-data").change(function()
    {

        $(this).parent().parent().addClass("danger hasChanged");

        if ($(this).hasClass("sales-line-qty"))
        {
           //Si se modificó la cantidad, se cambia el valor del total de la linea por el de la nueva cantidad por el precio.

           //Valor del total
           $(this).parent().next().next().children().val( 

               //Signo pesos
               "$ "
               +
               //Se redondea a 2 decimales
               roundTwoDecimals(
                    //Valor de la nueva cantidad
                    $(this).val() * 

                    //Valor del precio
                    $(this).parent().next().children().val()

                )
            );
        }
        else if ($(this).hasClass("sales-line-price"))
        {
            //Si se modificó el precio, se cambia el valor del total de la linea por el del nuevo precio por la cantidad.

           //Valor del total
           $(this).parent().next().children().val( 

               //Signo pesos
               "$ "
               +
               
               //Se redondea a 2 decimales
               roundTwoDecimals(
                        //Valor de la cantidad
                        $(this).parent().prev().children().val() * 

                        //Valor del nuevo precio
                        $(this).val()
               )
           );

        }

        calculateNewInvoiceTotal();

    });
}

function saveInvoiceLine()
{

    var invoiceid = $("#InvoiceText").val();
    var itemid = $("#itemid").val();
    var qty = $("#qty").val();
    var price = $("#price").val();

    $.ajax({
        url: "{{url('saveInvoiceLine')}}",
        data:{
                invoiceid: invoiceid,
                itemid: itemid,
                qty: qty,
                price: price
            },
        success:function(line)
        {
            $("#total-line").before(
                "<tr><td><input name='" + line.linenum + "' value = '" + line.linenum + "' class = 'checkbox sales-line-checkbox' type='checkbox'" +
                "</td><td><input class = 'sales-line-data' type = 'number' readonly value='" + line.itemid + 
                "'></td><td><input class = 'sales-line-data' type = 'text' readonly value='" + line.itemname + 
                "'></td><td><input class = 'sales-line-data sales-line-qty' type = 'number' value='" + line.qty + 
                "'></td><td><input class = 'sales-line-data sales-line-price' type = 'number' value='" + line.price + 
                "'></td><td><input class = 'sales-line-data sales-line-total' type = 'text' readonly value='$ " + roundTwoDecimals(line.qty * line.price) + 
                "'></td></tr>"
            );

            loadChangeLinesEvent();
            calculateNewInvoiceTotal();

        },
        error:function(){showError("Error al ingresar la linea.")}
    });
    clearLineData();
}

function getItemPriceByMargin(itemid, margin)
{
    $.ajax({
        url: "{{url('getItemPriceByMargin')}}",
        data:{
                itemid: itemid,
                margin: margin
            },
        success:function(itemprice)
                {
                    $("#price").val(roundTwoDecimals(itemprice.price)).focus();
                },
        error: function(){showError("Error al buscar el precio.")}
    });

}

function getItemPriceByListId(itemid, listid)
{
    $.ajax({
        url: "{{url('getItemPriceByListId')}}",
        data:{
                itemid: itemid,
                listid: listid
            },
        success:function(itemprice)
                {
                    $("#price").val(itemprice.price).focus();
                },
        error: function(){showError("Error al buscar el precio.")}
    });

}

function getItemPrice()
{

    var listid = $("#ListList option:selected").val();
    
    var itemid = $("#itemid").val();

    var margin = $("#MarginNumber").val();

    if (margin == "" || margin <= 0)
    {
        getItemPriceByListId(itemid, listid);
    }
    else
    {
        getItemPriceByMargin(itemid, margin);
    }

}

function deleteInvoiceLine(invoiceid, linenum)
{   
    $.ajax({
        url: "{{url('deleteInvoiceLine')}}",
        data:{
            invoiceid: invoiceid,
            linenum: linenum
        },
        success:function(response)
                {
                    if (response.qtyOfLinesDeleted > 0)
                    {
                        $(".sales-line-checkbox:checked[name='" + linenum + "']").parent().parent().remove();
                        calculateNewInvoiceTotal();
                    }
                    else
                    {
                        linesWithErrors.value += linenum + ", ";
                        showError("Error al borrar la/s linea/s " + linesWithErrors.value.substring(0, linesWithErrors.value.length - 2))
                    }
                },
        error:function()
                {
                    showError("No se pudo borrar la/s linea/s por un error inesperado.")
                }
    });
}

function updateInvoiceLine(invoiceid, linenum, qty, price)
{

    $.ajax({
        url: "{{url('updateInvoiceLine')}}",
        data: {
            invoiceid: invoiceid,
            linenum: linenum,
            qty: qty,
            price: price
        },
        success: function(response)
        {
            if(response.qtyOfLinesUpdated > 0)
            {
                $("input[name='" + linenum + "']").parent().parent().removeClass('danger hasChanged');
                if (linesWithErrors.value == ""){
                    hideError();
                }
            }
            else
            {
                linesWithErrors.value += linenum + ", ";
                showError("Error al actualizar la/s linea/s " + linesWithErrors.value.substring(0, linesWithErrors.value.length - 2));
            }
        },
        error: function(){showError("Error al actualizar la linea.")}

    });

}

function closeInvoice(invoiceid)
{
    $.ajax({
        url: "{{url('closeInvoice')}}",
        data: {
            invoiceid: invoiceid
        },
        success: function(response)
        {
            if (response.status == true)
            {
                hideError();
                window.location = "{{url('salesClose')}}"
            }
            else
            {
                showError("No hay lineas en la factura para cerrar o ya se encuentra cerrada.")
            }
        },
        error: function(){showError("No se pudo cerrar la factura por un error inesperado.")}
    });
}

</script>