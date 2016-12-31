<html>
<head>
    
        @php
        session_start();
        if (!isset($_SESSION['user']))
        {
            echo '<script type="text/javascript">
                window.location = "http://localhost/distdigus/public/sesiones"
            </script>';
            die();
        }            
        @endphp

<title>Inicio de sesion</title>
</head>

<body>
    <h2>Ke ace cabeza</h2>
    @php
        echo $_SESSION['user'];
    @endphp
    <form action="cerrarSesion" method="POST">

        <input type="hidden" value={{csrf_token()}} name = "_token">
        <input type="submit" value="Cerrar sesión">

    </form>
</body>

</html>