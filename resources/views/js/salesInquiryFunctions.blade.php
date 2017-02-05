<div class="filter">

    <div>
        <label for="invoice">Factura:</label>&nbsp;&nbsp;<input id="invoice" type="text" class= "input-inline text-center" value = "{{$invoiceid or ''}}">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="customer">Cliente:</label>&nbsp;&nbsp;<input id="customer" type="text" class="input-inline text-center">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button id="search" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Buscar</button>
    </div>

</div>

<br>

<script>

    function search()
    {
        //Primero muestra todo
        $(".invoiceid").each(function()
        {
            $(this).parent().css("display", "table-row");
        });

        //Si el filtro de factura tiene algun valor, filtra por ese valor
        if (invoice.value != "")
        {
            $(".invoiceid").each(function()
            {
                if( $(this).text() != invoice.value )        
                {
                    $(this).parent().css("display", "none")
                }
            });
        }

        //Si el filtro de cliente tiene algún valor, filtra por ese valor
        if (customer.value != "")
        {
            $(".custname").each(function()
            {
                var custname = $(this).text();
                custname = custname.toLowerCase();

                if ( !custname.includes(customer.value) )
                {
                    $(this).parent().css("display", "none")
                }
            });
        }
        //Si no entra en ningún filtro, entonces muestra todo

    }

    $("#search").click(search);
    $("#invoice").keydown(function(e){if(e.keyCode == 13) {search()}});
    $("#customer").keydown(function(e){if(e.keyCode == 13) {search()}});

</script>