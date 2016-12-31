<?php

session_start();

unset($_SESSION['user']);

session_destroy();

echo '<script type="text/javascript">
        window.location = "http://localhost/distdigus/public/sesiones"
    </script>';

?>