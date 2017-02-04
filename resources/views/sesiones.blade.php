<html>
<head>
<title>Inicio de sesion</title>
</head>

<body>
    <form action="comprobarLogin" method= 'POST'>

        <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="user">Usuario: </label><input type="text" name = 'user'><br><br>
        <input type="submit">

        @php
        session_start();
        if (isset($_SESSION['user'])){
            echo $_SESSION['user'] ;
        } else {
            echo "NO";
        }
        @endphp

    </form>
</body>

</html>