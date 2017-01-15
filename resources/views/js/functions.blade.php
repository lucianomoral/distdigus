<script>

function showError(message)
{
    $("#validate-info").addClass("alert alert-danger").html(message);
}

function hideError()
{
    $("#validate-info").removeClass("alert alert-danger").html("");
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

function redirToAddSalesLine(invoiceid)
{
    var redir = "{{url('salesAddLines')}}";
    redir += '/';
    redir += invoiceid;

    if ($("#packageqtyactive").is(":checked"))
    {
        redir += '/1'
    }
    else
    {
        redir += '/0'
    }

    window.location = redir;
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
            redirToAddSalesLine(line.invoiceid);
        },
        error:function(){showError("Error al ingresar la linea.")}
    });
    clearLineData();
}

function getItemPriceByMargin(itemid, margin)
{
    alert (margin);
    alert (itemid);
}

function getItemPriceByListId(itemid, listid)
{
    //alert (itemid);
    //alert (listid);
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
        success:function(){},
        error:function(){showError("No se pudo borrar la/s linea/s.")}
    });
}
</script>