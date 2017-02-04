@extends('layouts.loginLayout')

@section('content')

<script>

    @include('js.commonFunctions')

</script>

<style>

    .login-form{
        width: 30%;
        margin: auto;
        margin-top:5%;
    }

</style>

<script>

    function showUserError(message)
    {
        $("#user-validate").html(message);
        $(".user").addClass("has-error");
    }

    function showPassError(message)
    {
        $("#pass-validate").html(message);
        $(".pass").addClass("has-error");
    }

    function hideUserError()
    {
        $("#user-validate").html("");
        $(".user").removeClass("has-error");
    }

    function hidePassError()
    {
        $("#pass-validate").html("");
        $(".pass").removeClass("has-error");
    }

    $(document).ready(function()
    {
        $("#submit").click(function()
        {
            var user = $("#user").val();
            var pass = $("#pass").val();

            if (user == "")
            {
                showUserError("<i>Debe completar un usuario</i>");
                hidePassError();
            }
            else if (pass == "")
            {
                showPassError("<i>Debe completar una contraseña</i>");
                hideUserError();
            }
            else
            {
                hideUserError();
                hidePassError();

                $.ajax({
                    url: "{{url('checkUserLogin')}}",
                    type: "POST",
                    data: {
                        user: user,
                        pass: pass
                    },
                    success: function(response){
                        switch(response.status){
                            case 0:
                                showUserError("<i>Usuario inexistente</i>");
                                hidePassError();
                            break;

                            case 1:
                                showPassError("<i>Contraseña incorrecta</i>");
                                hideUserError();
                            break;

                            case 2:
                                hideUserError();
                                hidePassError();
                                window.location = "{{url('index')}}";
                            break;

                            default:
                                alert("Error inesperado. Contactar al administrador.");
                            break;
                        }
                    },
                    error: function(){
                        showError("Se produjo un error al validar usuario y contraseña.");
                    }
                });
            }
            return false;
        });
    });

</script>

<div class="login-form">
    <div id="validate-info"></div>
    <h2 class="center">Iniciar sesión</h2>
    <form>
    <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
    <div class="form-group user">
        <label for="user">Usuario:</label>
        <input type="text" class="form-control" id="user">
        <span id="user-validate"></span>
    </div>
    <div class="form-group pass">
        <label for="pass">Contraseña:</label>
        <input type="password" class="form-control" id="pass">
        <span id="pass-validate"></span>
    </div>
    <button type="submit" class="btn btn-default" id="submit">Ingresar</button>
    </form>
</div>

@endsection