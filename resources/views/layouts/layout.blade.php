<html>
<head>
<title></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    @yield('scripts')
</script>
</head>
<body>
    <h2 class="center">Bienvenido, {{ $user or "DIGUS" }}</h2>
    
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li id="HomeMenuItem"><a href="{{url('index')}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li id="ItemMenuItem"><a href="{{url('item')}}"><span class="glyphicon glyphicon-apple"></span> Articulos</a></li>
                    <li id="PriceMenuItem"><a href="{{url('price')}}"><span class="glyphicon glyphicon-usd"></span> Precios</a></li>
                    <li id="CustomerMenuItem"><a href="{{url('customer')}}"><span class="glyphicon glyphicon-user"></span> Clientes</a></li>
                    <li id="SalesMenuItem"><a href="{{url('sales')}}"><span class="glyphicon glyphicon-shopping-cart"></span> Pedidos</a></li>
                    <li id="ListMenuItem"><a href="{{url('list')}}"><span class="glyphicon glyphicon glyphicon-list-alt"></span> Listas</a></li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> {{ $user or "DIGUS"}}</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout </a></li>
                </ul>
        </div>
    </nav>

    <div class="container">

        @yield('content')

    </div>

</body>
</html>