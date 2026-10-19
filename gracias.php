<?php
    require 'sesiones/sessionMonitorIndex.php';
    require 'sesiones/sesionMonitorGracias.php';

?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedidos</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="img/favicon.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>





    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <!--Migrar el css de las imagenes al archivo css principal de la pagina para eliminar zoomimg-->
    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">



    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />





    <!--Fancy Zoom-->
    <link rel="stylesheet" href="css/zoomimg.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="css/toastr.css">
    <link rel="stylesheet" href="css/personalizado.css">

    <!--Javascript Toolkit-->
    <script src='js/a076d05399.js'></script>
    <script src="js/toastr.js"></script>


</head>

<body>
    <?php
    require 'layouts/navbar.php';
   // $cc=parseJSON($_GET['w1']);

    ?>

 <div class="row mggr">
    <div class="col-md-4"></div>
    <div class="ctEs col-md-4">
        <div class="row">
 <!--          <a href="https://portalclientes.prosanatural.com/"> <button type="button" class="btn gp">Regresar al Portal</button></a>
-->         <a href="./"> <button type="button" class="btn gp">Regresar al Portal</button></a>

        </div>
        <div class="row">
            <img class="gr" src="img/gracias.png">

        </div>
    </div>
    <div class="ctMo col-md-4">
        <img class="gr" src="img/graciasMovil.png">
    </div>
    <div class="col-md-4"></div>

    
 </div>








</body>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/list.min.js"></script>
<script src="js/list.js"></script>
<script src="js/fs.js"></script>
<script src="js/gracias.js"></script>



</html>