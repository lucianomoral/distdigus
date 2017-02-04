<DOCTYPE!>
<html>
<head>
    <meta charset = 'utf-8'>
    <style>
        td, th, .caption
        {
            border: 1px solid black;
            text-align:center;
        }

        .lineas td
        {
            color:blue;
        }

        .caption
        {
            font-weight:bold; 
            color:red;
        }

        .cabecera td
        {
            font-weight:bold;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td class = 'caption' colspan = 5>Distribuidora DIGUS</td>
        </tr>
        <tr>
            <th>Nro:</th>
            <th colspan = 4>{{$invoiceid}}</th>
        </tr>
        <tr class = 'cabecera'>
            <td>Cód.</td>
            <td>Nombre</td>
            <td>Cantidad</td>
            <td>Precio</td>
            <td>Total</td>
        </tr>
        @php
        $total = 0;
        @endphp
        @foreach($invoiceline as $line)
        <tr class='lineas'>
            <td>{{$line->ITEMID}}</td>
            <td>{{$line->ITEMNAME}}</td>
            <td>{{$line->QTY}}</td>
            <td>$ {{$line->PRICE}} </td>
            <td>$ {{$line->TOTAL}} </td></tr>
            @php
            $total += $line->TOTAL;
            @endphp
        <tr>
        @endforeach
            <td colspan = 3></td>
            <td>Total</td>
            <td> $ {{$total}}</td>
        </tr>
    </table>
</body>
</html>