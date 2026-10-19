<?php
    require 'sesiones/sessionMonitorIndex.php';
?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedidos</title>
    <link rel="icon" href="img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="css/popup.css">
    <!-- <script src="js/toastr.js"></script> -->
    <!--Javascript Toolkit-->
    <script src='js/a076d05399.js'></script>
</head>

<body>
    <?php $pagina="Principal";?>

    <?php
        require 'php/sessionMonitor.php';
        require 'layouts/navbar.php';
    ?>


    <div class="loader"></div>

    <div class="row" style="background-color:rgb(244,244,244);">
        <div class="col-md-1">
        </div>

        <div class="col-md-2 mg ctEs">
            <p class="me" name="me" style="color:rgb(25,61,48);font-weight:bold;">Todos los productos</p>
            <!--<p class="me" name="me" id="promociones" style="padding-left:5%;color:rgb(11,137,65);font-weight:bold;">Promociones</p>-->
            <p class="me" name="me" id="Cosméticos" style="padding-left:5%;color:rgb(11,137,65);font-weight:bold;">Cosméticos</p>
            <p class="me" name="me" id="Cuidado de la Piel" style="padding-left:5%;color:rgb(11,137,65);font-weight:bold;">Cuidado de la Piel</p>
            <p class="me" name="me" id="Cápsulas" style="padding-left:5%;color:rgb(11,137,65);;font-weight:bold;">Cápsulas</p>
            <p class="me" name="me" id="Otros" style="padding-left:10%;">Otros</p>
            <p class="me" name="me" id="Suplementos Líquidos" style="padding-left:5%;color:rgb(11,137,65);;font-weight:bold;">Suplementos Líquidos</p>
            <p class="me" name="me" id="Jarabes" style="padding-left:5%;color:rgb(11,137,65);;font-weight:bold;">Jarabes</p>
            <p class="me" name="me" id="Polvos" style="padding-left:5%;color:rgb(11,137,65);;font-weight:bold;">Polvos</p>


        </div>

        <select class="form-select ctMo mx-auto" id="tpr" aria-label="Default select example">
            <option disabled selected>Selecciona una categoría</option>
            <option class="me">Todos los productos</option>
             <!--<option class="me" value="promociones">Promociones</option>-->
            <option class="me" value="Cosméticos">Cosméticos</option>
            <option class="me" value="Cuidado de la Piel">Cuidado de la Piel</option>
            <option class="me" value="Cápsulas">Cápsulas</option>
            <option class="me" value="Otros">Otros</option>
            <option class="me" value="Suplementos Líquidos">Suplementos Líquidos</option>
            <option class="me" value="Jarabes">Jarabes</option>
            <option class="me" value="Polvos">Polvos</option>

        </select>

        


        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <img loading='lazy' src="img/Portal-de-Distribuidores-Prosa-Productos-Naturales.webp" class="img-fluid" alt="Responsive image">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding-top:20px;">
                    <img loading='lazy' src="img/Envio-Portal-Dsitribuidores-Prosa-Natural.png" class="img-fluid" alt="Responsive image" style="width:100%;">
                </div>
            </div>
            
            <div class="row mg">
                <div class="table-responsive" style="background-color:white;padding:2%;">
                    <table id="pdEs" class="ctEs table table-striped table-hover" style="width:100%;">
                        <tbody>
                        </tbody>
                    </table>
                    <table id="pdMov" class="ctMo table table-striped table-hover" style="width: 100%;">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
        <div class="col-md-2 ctEs mg" >
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10" style="background-color:white;">
                    <p class="datosAdicionalesTitulo"><span id="clien"><?= $cliente ?></span></p>
                    
                    <p class="datosAdicionales facturasSaldo">Estatus<br><span class="infoAdicionalPers"><span id="statusIA"><?= $status ?></span></span></p>
                    <p class="datosAdicionales facturasSaldo">Saldo Pendiente<br><span class="infoAdicionalPers"><span id="saldopendienteIA"></span></span></p>
                    <p class="datosAdicionales facturasSaldo">Credito<br><span class="infoAdicionalPers infoAdicionalPersCred"><span id="creditoIA"></span></span></p>
                    <p class="mg factsAdic facturasSaldo"  data-toggle="modal" data-target="#exampleModal"><u>Ver mis Facturas con pagos pendientes</u></p>

                    <hr>
                    <p class="datosAdicionales">Valor del pedido<br><span class="infoAdicionalPers" id="prectot" val="">$0</span></p>

                </div>
                <div class="col-md-1"></div>

              

            </div>
            <div class="row">
                <div class="text-center" style="margin:auto;padding-top:40px;">
                    <a href="catalogo.pdf" target="_blank">
                        <img loading='lazy' src="img/catalogo.jpeg" style="width:80%">
                    </a>
                </div>
            </div>
         
        </div>
        <div class="col-md-1"></div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-3"></div>

        <div class="col-md-5 ctEs">
            <table style="border-collapse: collapse; width: 100%;padding-top:5px;" border="0">
                <tbody>

                    <tr>
                        <td rowspan="2" style="width:60px;"><img loading='lazy' src="img/bM.png"></td>
                        <td class="tm">Importe mínimo de compra $2,000 MXN antes</td>
                    </tr>
                    <tr>
                        <td class="tm">de impuestos. Solo disponible para México</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-2 ctEs">
            <button type="button" class="gpvp btn gp" style="font-family: 'Exo', sans-serif;" data-toggle="modal" data-target=".bd-example-modal-xl">Ver Pedido</button>

        </div>

        <div class="ctMo container" style="margin-bottom:100px;">
            <div class="col" style="margin-bottom:20px;">
                <table style="border-collapse: collapse; width: 100%;padding-top:5px;padding-bottom:15px;" border="0">
                    <tbody>

                        <tr>
                            <td>
                                <div align="center"><img loading='lazy' src="img/bM.png"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="tm" style="text-align:center;">Importe mínimo de compra $2,000 MXN antes de Impuestos. Solo disponible para México</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <div align="center"><button type="button" class="gpvp btn gp" style="font-family: 'Exo', sans-serif;" btn gp data-toggle="modal" data-target=".bd-example-modal-xl">Ver Pedido</button></div>

            </div>
        </div>


  



        <!-- Large modal -->

        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table id="cp" class="ctEs table table-striped table-hover" style="width:100%;">
                                            <thead style="background:rgb(57,181,74);color:white;font-family:roboto:sans-serif,font-size:300;">
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Producto</th>
                                                    <th>Clave</th>
                                                    <th>Descripcion</th>
                                                    <th>Unidad</th>
                                                    <th>Descripcion</th>
                                                    <th>Unidad</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                        <table id="cp2" class="ctMo table table-striped table-hover" style="width:100%;">
                                            <thead style="background:rgb(57,181,74);color:white;font-family:roboto:sans-serif,font-size:300;">
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Producto</th>
                                                    <th>Clave</th>
                                                    <th>Descripcion</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>



                        </div>

                        <div class="row" style="margin-top:20px;">

                            <div class="col-md-6 justify-content-end">
                                <div class="subTotal form-group" style="text-align: end;">
                                    <label for="cmpSubTotales">PESO TOTAL EN KILOS</label>
                                    <div id="pt" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="task form-group" style="text-align: end;">
                                    <label for="cmpEnvio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOLUMEN CÚBICO</label>
                                    <div id="vct" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="task form-group" style="text-align: end;">
                                    <label for="cmpImpuestos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE PIEZAS</label>
                                    <div id="pi" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="totalCost form-group" style="text-align: end;">
                                    <label for="cmpCostoTotal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE CAJAS</label>
                                    <div id="nc" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>
                            </div>
                            <div class="col-md-5 justify-content-end">
                                <div class="subTotal form-group" style="text-align: end;">
                                    <label for="cmpSubTotales">SUBTOTAL&nbsp;&nbsp;</label>
                                    <div id="st" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="task form-group enenvio" style="text-align: end;">
                                    <label for="cmpEnvio">ENVÍO</label>
                                    <div id="en" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="task form-group" style="text-align: end;">
                                    <label>IMPUESTOS&nbsp;&nbsp;</label>
                                    <div id="im" style="width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;font-family: 'Exo', sans-serif;"></div>
                                </div>

                                <div class="totalCost form-group" style="text-align: end;">
                                    <label>TOTAL&nbsp;&nbsp;</label>
                                    <div id="to" style="width:50%;float:right;font-size:25px;background-color: rgb(57,181,74);font-weight:bold;color:white;font-family: 'Exo', sans-serif;"></div>
                                </div>



                            </div>
                            <div class="col-md-1"></div>

                        </div>


                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <table style="width:auto;" border="0">
                                    <tbody>

                                        <tr>
                                            <td rowspan="2" style="width:60px;"><img loading='lazy' src="img/bM.png"></td>
                                            <td class="tm">Importe mínimo de compra $2,000 MXN antes de impuestos. Solo disponible para México</td>
                                        </tr>
                                        <tr>
                                            <td class="tm"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">

                                <div class="totalCost form-group" style="text-align: end;">
                                    <button type="button" class="btn cpE" data-dismiss="modal">Seguir Comprando</button>
                                    <button type="button" class="btn gp" id="gp" name="">Generar Pedido</button>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">

                </div>

            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Facturas con Pagos Pendientes en 2022</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <table id="facts" class="ctEs table table-striped table-hover" style="width:100%;">
                            <tbody>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn page-item active page-link" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

    </div>


    



</body>
<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>
<!-- jQuery UI -->
<script src="js/jquery-ui.js"></script>
<!-- List JS -->
<script src="js/list.min.js"></script>
<script src="js/list.js"></script>
<script type="text/javascript">
    var id = "<?php echo $usuario ; ?>";
    var mail = "<?php echo $mailUser ; ?>";
    var factus="<?php echo $facts ; ?>";
    var saldo="<?php echo $saldo ; ?>";
    var limcred="<?php echo $limcred ; ?>";
    var pedsValue = <?php echo json_encode($pedsValue); ?>;
</script>

<script src="clls/portal.js"></script>
<script src="clls/popup.js"></script>

<script src="js/fs.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!--
<?php 
//include 'layouts/popup.php'; ?>
<script src="clls/popup.js"></script>
-->
<script src="js/toastr.js"></script><!-- Agregue  -->
</html>


</html>