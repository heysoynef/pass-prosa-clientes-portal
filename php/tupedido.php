<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedidos</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
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
    <link rel="stylesheet" href="../css/zoomimg.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/personalizado.css">

    <!--Javascript Toolkit-->
    <script src='../js/a076d05399.js'></script>
    <script src="../js/toastr.js"></script>


</head>

<body>
    <?php
    require './sessionMonitor.php';
    require './navbar.php';
    // $cc=parseJSON($_GET['w1']);

    $cc = $_GET['w1'];
    ?>

    <div class="row mg"></div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <p class="tp">TU PEDIDO</p>
        </div>
        <div class="col-md-2"></div>

    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="subTotal form-group" style="text-align: left;">
                        <label for="cmpSubTotales">PESO TOTAL EN KILOS</label>
                        <input class="form-control" type="text" id="pt" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="task form-group" style="text-align: left;">
                        <label for="cmpEnvio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOLUMEN CÚBICO</label>
                        <input class="form-control" type="text" id="vct" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="task form-group" style="text-align: left;">
                        <label for="cmpImpuestos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE PIEZAS</label>
                        <input class="form-control" type="text" id="pi" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="totalCost form-group" style="text-align: left;">
                        <label for="cmpCostoTotal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE CAJAS</label>
                        <input class="form-control" type="text" id="nc" placeholder="0" style="text-align: end; font-weight: bold;font-size: 150%;width:50%;" readonly="true">
                    </div>
                </div>
                <div class="col-md-5 justify-content-end">
                    <div class="subTotal form-group" style="text-align: end;">
                        <label for="cmpSubTotales">SUBTOTAL</label>
                        <input class="form-control" type="text" id="su" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="task form-group" style="text-align: end;">
                        <label for="cmpEnvio">ENVÍO</label>
                        <input class="form-control" type="text" id="en" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="task form-group" style="text-align: end;">
                        <label for="cmpImpuestos">IMPUESTOS</label>
                        <input class="form-control" type="text" id="im" placeholder="0" style="text-align: end; font-weight: bold; font-size: 150%;width:50%;" readonly="true">
                    </div>

                    <div class="totalCost form-group" style="text-align: end;">
                        <label for="cmpCostoTotal">TOTAL</label>
                        <input class="form-control" type="text" id="to" placeholder="0" style="text-align: end; font-weight: bold;font-size: 150%;width:50%;background-color:rgb(57,181,74);color:white;" readonly="true">
                    </div>


                    <div class="task form-group">
                        <button type="button" class="btn gp" style="margin-top: 10%; width: 50%; margin-left: 50%;" id="gp">Generar Pedido</button>
                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>



        </div>

        <div class="col-md-2"></div>
    </div>









</body>

<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/list.min.js"></script>
<script src="../js/list.js"></script>
<script type="text/javascript">
    var cc = "<?php echo $cc; ?>";
</script>
<script src="../js/tupedido.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</html>