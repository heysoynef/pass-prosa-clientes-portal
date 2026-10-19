
<?php
        require 'sesiones/sessionMonitorLogin.php';
    ?>

<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap Core WEB CSS-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Custom Style CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/loginStyle.css" rel="stylesheet">
        <link rel="stylesheet" href="css/toastr.css">

        <!--Javascript Toolkit-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src='js/a076d05399.js'></script>
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
        <title>Portal de Distribuidores PROSA</title>

        <link rel="icon" href="img/prosa.png" sizes="16x16 32x32 48x48" type="image/png">


    </head>

    <body class="bg">
        <div class="row">
            <div class="contenedorDegradado col-sm-3">
                <div>
                    <img src="img/prosalogo-negativo.png" alt="Logo Prosa" style="margin-top: 15%;">
                </div>
                <form action="#" style="align-items: justify; margin: 15%">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class='far fa-user' style='font-size:24px; color: #80C41C;'></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="userName" name="userName" required="true">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class='fas fa-lock' style='font-size:24px; color: #80C41C;'></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required="true">
                    </div>
                    <div class="input-group" style="align-content: center;">
                        <button type="button" class="btn" id="btn-login">Acceder</button>
                    </div>
                </form>
            <div class="row">
                <span style="position:absolute;bottom:0px; right:0px; background-color:rgba(94,163,103);padding:5px;"><a href="http://www.pass.com.mx" target="_blank" class="text-muted">Desarrollado por: PASS Consultores</a></span>
            </div>
            </div>
            <div class="col-sm-5"></div>
            <div class="col-sm-4"></div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
        <script src="clls/lg.js?v=3"></script>

    </body>

</html>