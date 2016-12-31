<?php

if (isset($_POST['user']) & $_POST["user"] == 'lu')
{
    session_start();

    $_SESSION['user'] = $_POST['user'];

    //{{redirect()->route('sesionAceptada');}}

    //header("Location: http://localhost/distdigus/public/sesionAceptada");

    echo '<script type="text/javascript">
           window.location = "http://localhost/distdigus/public/sesionAceptada"
      </script>';

} 
else 
{

    //{{redirect()->route('sesiones');}}

    //header("Location: http://localhost/distdigus/public/sesiones");

    echo '<script type="text/javascript">
           window.location = "http://localhost/distdigus/public/sesiones"
      </script>';

}

?>