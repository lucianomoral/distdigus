<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>

    $(document).ready(function(){

        $("#submit").click(function(){

            $.ajax({

                url: "http://localhost/distdigus/public/ajaxPrueba",
                data: {dato: dato.value},
                success: function(dato){alert(dato['mensaje'])},
                error: function(){alert("Error");}

            });

        });

    });

</script>

</head>

<body>
        <label for="prueba">Ingrese dato: </label><br><br>
        <input type="text" name = "dato" id = "dato"><br><br>
        <input type="submit" id = "submit">

</body>


</html>