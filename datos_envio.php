<?php 
    include 'sesiones/sessionMonitorIndex.php';
    include 'sesiones/sesionMonitorDatosEnvio.php';

$pagina="Datos Envio";
?>

<!DOCTYPE html>
<html lang="es-MX">
<?php
   
        $pedidoProsa=$_SESSION["peds"];    
      
      
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datos de Facturación</title>
        <link rel="icon" href="img/favicon.png" type="image/x-icon">

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
    <link rel="stylesheet" href="css/zoomimg.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="css/toastr.css">
    <link rel="stylesheet" href="css/personalizado.css">

    <!--Javascript Toolkit-->
    <script src='js/a076d05399.js'></script>
    <script src="js/toastr.js"></script>
    <script>
        function clearDataFunction() {
            $('.taskValue').hide();
            $('#cmpDescProd').val('');
            $('#cmpPolProd').val('');
            $('#cmpTotales').val(0);
            var factura = $('#facturar').val();

            if (factura == 'NO') {
                $('.task').hide();
                $('.subTotal').hide();
                //toastr.success('Cliente NO requiere factura');
            } else {
                $('.task').show();
                $('.subTotal').show();
                //toastr.info('Cliente Requiere factura');
            }
            $('.modal').hide();
        }
        $("#cmpSubTotales").change(function() {
            toastr.success('Cambiando totales');
        });
    </script>

</head>

<body>
    <?php
      require 'layouts/navbar.php';
    ?>

<div class="loader"></div>




<input type"text" name="result" style="display:none;" id="pedidoProsa" value = '"<?php echo $pedidoProsa;?>"'>  
<div class="row mg">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <h4 class="modal-title" style="background-color:rgb(57,181,74);color:white;font-family: 'Exo', sans-serif;">&nbsp;&nbsp;DATOS FISCALES</h4>

      <div class="form-group" style="margin:20px;">
        <div class="row mg2">
          <div class="col-md-6 mg3">
            <input type="text" class="form-control" id="nombreFiscal" placeholder="Nombre del cliente o razón social*">
          </div>
          <div class="col-md-6 mg3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="trfc" name="rfc">
              <label class="form-check-label" for="defaultCheck1">
                Tengo RFC
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="ntrfc" name="rfc">
              <label class="form-check-label" for="defaultCheck2">
                No tengo RFC, utilizaré el RFC genérico: XAXX010101000
              </label>
            </div>
          </div>
        </div>

        <div class="row inf rfg">
            <div class="col-md-12 mg2">
              <input type="text" class="form-control" id="rfcFiscal" placeholder="RFC del cliente o de razón social*">

            </div>
            <div class="col-md-12 mg2">
              <select id="regfis" class="form-select" style="width:100%;">
                <option value="Selecciona" selected="">Selecciona una Opción de Régimen Fiscal</option>
                <option value="601 General de Ley Personas Morales">601 General de Ley Personas Morales</option>
                <option value="603 Personas Morales con Fines no Lucrativos">603 Personas Morales con Fines no Lucrativos</option>
                <option value="605 Sueldos y Salarios e Ingresos Asimilados a Salarios">605 Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                <option value="606 Arrendamiento">606 Arrendamiento</option>
                <option value="607 Règimen de Enajenaciòn o Adquisiciòn de Bienes">607 Règimen de Enajenaciòn o Adquisiciòn de Bienes</option>
                <option value="608 Demás ingresos">608 Demás ingresos</option>
                <option value="610	Residentes en el Extranjero sin Establecimiento Permanente en México">610	Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                <option value="611	Ingresos por Dividendos (socios y accionistas)">611	Ingresos por Dividendos (socios y accionistas)</option>
                <option value="612	Personas Físicas con Actividades Empresariales y Profesionales">612	Personas Físicas con Actividades Empresariales y Profesionales</option>
                <option value="614	Ingresos por intereses">614	Ingresos por intereses</option>
                <option value="615	Régimen de los ingresos por obtención de premios">615	Régimen de los ingresos por obtención de premios</option>
                <option value="616	Sin obligaciones fiscales">616	Sin obligaciones fiscales</option>
                <option value="620	Sociedades Cooperativas de Producción que optan por diferir sus ingresos">620	Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                <option value="621	Incorporación Fiscal">621	Incorporación Fiscal</option>
                <option value="622	Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras">622	Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                <option value="623	Opcional para Grupos de Sociedades">623	Opcional para Grupos de Sociedades</option>
                <option value="624	Coordinados">624	Coordinados</option>
                <option value="625	Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas">625	Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
                <option value="626	Régimen Simplificado de Confianza">626	Régimen Simplificado de Confianza</option>
              </select>

            </div>
            <div class="col-md-12 mg2">
              
             <select class="form-select" id="catcomp" style="width:100%;">
                <option value="Selecciona" selected="">Selecciona una opción del Catálogo de Uso de CFDI</option>
                <option value="G01 Adquisición de mercancías">G01 Adquisición de mercancías</option>
                <option value="G02 Devoluciones, descuentos o bonificaciones">G02 Devoluciones, descuentos o bonificaciones</option>
                <option value="G03 Gastos en general">G03 Gastos en general</option>
                <option value="I01 Construcciones">I01 Construcciones</option>
                <option value="I02 Mobiliario y equipo de oficina por inversiones">I02 Mobiliario y equipo de oficina por inversiones</option>
                <option value="I03 Equipo de transporte">I03 Equipo de transporte</option>
                <option value="I04 Equipo de cómputo y accesorios">I04 Equipo de cómputo y accesorios</option>
                <option value="I05 Dados, troqueles, moldes, matrices y herramental">I05 Dados, troqueles, moldes, matrices y herramental</option>
                <option value="I06 Comunicaciones telefónicas">I06 Comunicaciones telefónicas</option>
                <option value="I07 Comunicaciones satelitales">I07 Comunicaciones satelitales</option>
                <option value="I08 Otra maquinaria y equipo">I08 Otra maquinaria y equipo</option>
                <option value="D01 Honorarios médicos, dentales y gastos hospitalarios.">D01 Honorarios médicos, dentales y gastos hospitalarios</option>
                <option value="D02 Gastos médicos por incapacidad o discapacidad">D02 Gastos médicos por incapacidad o discapacidad</option>
                <option value="D03 Gastos funerales">D03 Gastos funerales</option>
                <option value="D04 Donativos">D04 Donativos</option>
                <option value="D05 Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación)">D05 Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación)</option>
                <option value="D06 Aportaciones voluntarias al SAR">D06 Aportaciones voluntarias al SAR</option>
                <option value="D07 Primas por seguros de gastos médicos">D07 Primas por seguros de gastos médicos</option>
                <option value="D08 Gastos de transportación escolar obligatoria">D08 Gastos de transportación escolar obligatoria</option>
                <option value="D09 Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones">D09 Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones</option>
                <option value="D10 Pagos por servicios educativos (colegiaturas)">D10 Pagos por servicios educativos (colegiaturas)</option>
                <option value="CP01 Pagos">CP01 Pagos</option>
                <option value="CN01 Nómina">CN01 Nómina</option>
                <option value="S01	Sin Efectos Fiscales">S01	Sin Efectos Fiscales</option>
              </select>

          
            </div>
            <div class="col-md-12 mg2">
              <select class="form-select" id="metopagcfdi" style="width:100%;">
                <option value="Selecciona" selected="">Selecciona una opción del Catálogo de Método de Pago</option>
                <option value="PUE Pago en una sola exhibición">PUE Pago en una sola exhibición</option>
                <option value="PPD Pago en parcialidades o diferido">PPD Pago en parcialidades o diferido</option>
              </select>

      
            </div>
            <div class="col-md-12 mg2">
              <select id="formpagcfdi" class="form-select" style="width:100%;">
                <option value="Selecciona" selected="">Selecciona una Opción de Forma de Pago</option>
                <option value="01 Efectivo">01 Efectivo</option>
                <option value="02 Cheque nominativo">02 Cheque nominativo</option>
                <option value="03 Transferencia electrónica de fondos">03 Transferencia electrónica de fondos</option>
                <option value="04 Tarjeta de crédito">04 Tarjeta de crédito</option>
                <option value="05 Monedero electrónico">05 Monedero electrónico</option>
                <option value="06 Dinero electrónico">06 Dinero electrónico</option>
                <option value="08 Vales de despensa">08 Vales de despensa</option>
                <option value="12 Dación en pago">12 Dación en pago</option>
                <option value="13 Pago por subrogación">13 Pago por subrogación</option>
                <option value="14 Pago por consignación">14 Pago por consignación</option>
                <option value="15 Condonación">15 Condonación</option>
                <option value="17 Compensación">17 Compensación</option>
                <option value="23 Novación">23 Novación</option>
                <option value="24 Confusión">24 Confusión</option>
                <option value="25 Remisión de deuda">25 Remisión de deuda</option>
                <option value="26 Prescripción o caducidad">26 Prescripción o caducidad</option>
                <option value="27 A satisfacción del acreedor">27 A satisfacción del acreedor</option>
                <option value="28 Tarjeta de débito">28 Tarjeta de débito</option>
                <option value="29 Tarjeta de servicios">29 Tarjeta de servicios</option>
                <option value="30 Aplicación de anticipos">30 Aplicación de anticipos</option>
                <option value="31 Intermediario pagos">31 Intermediario pagos</option>
                <option value="99 Por definir">99 Por definir</option>
              </select>
            </div>
            <div class="col-md-12 mg2">
                  <a href="https://api.whatsapp.com/send?phone=5215564899265" target="_blank" style="color:rgba(92,168,95);">
                    <img style="width: 30px;" class="btn-whats" src="img/boton-whatsapp.png" alt="">
                    Envíanos por whatsapp tu constancia de Situación Fiscal (100% Requerido)
                  </a>
            </div>
          </div>

        <div class="row mg2">
          <div class="col-md-6 mg3">
            <input type="email" class="form-control" id="correoEFiscal" placeholder="Correo electrónico*">
          </div>
          <div class="col-md-6 mg3">
            <input type="number" class="form-control" id="telefonoFisical" placeholder="Teléfono Celular*">
          </div>
        </div>

        <div class="row mg2">
          <div class="col-md-12 mg3">
            <select id="single" class="js-states form-control estados" style="width:100%;">
              <option></option>
            </select>
          </div>
        </div>

        <div class="row mg2">
          <div class="col-md-12 mg3">
            <select id="single2" class="js-states form-control codigoscolonias" style="width:100%;">
              <option></option>
            </select>
          </div>
        </div>

        <div class="row mg2">
          <div class="col-md-6 mg3">
            <input type="text" class="form-control" id="calleFiscal" placeholder="Calle*">
          </div>
          <div class="col-md-3 mg3">
            <input type="text" class="form-control" id="numExtFiscal" placeholder="Número exterior">
          </div>
          <div class="col-md-3 mg3">
            <input type="text" class="form-control" id="numIntFiscal" placeholder="Número interior">
          </div>
        </div>
      </div>


      <h4 class="modal-title" style="background-color:rgb(206,236,210);color:rgb(128,128,128);font-family: 'Exo', sans-serif;">&nbsp;&nbsp;DATOS DE ENVÍO</h4>
      <div class="form-group" style="margin:20px;">
        <div class="col-md-6 mg3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="uddf" name="dde">
            <label class="form-check-label" for="defaultCheck1">
              Usar mis datos fiscales como datos de envío
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="nuddf" name="dde">
            <label class="form-check-label" for="defaultCheck2">
              Mis datos de envío son diferentes
            </label>
          </div>
        </div>
        <div class="ddeyf def">
          <div class="row mg2">
            <div class="col-md-6 mg3">
              <select id="single3" class="js-states form-control estados2" style="width:100%;">
                <option></option>
              </select>
            </div>
          </div>

          <div class="row mg2">
            <div class="col-md-6 mg3">
              <select id="single4" class="js-states form-control codigoscolonias2" style="width:100%;">
                <option></option>
              </select>
            </div>
          </div>

          <div class="row mg2">
            <div class="col-md-6 mg3">
              <input type="text" class="form-control" id="calleenvio" placeholder="Calle*">
            </div>
            <div class="col-md-3 mg3">
              <input type="text" class="form-control" id="numExtenvio" placeholder="Número exterior">
            </div>
            <div class="col-md-3 mg3">
              <input type="text" class="form-control" id="numIntenvio" placeholder="Número interior">
            </div>
          </div>
        </div>

        <div class="row mg2">
          <div class="col-md-12 mg3">
            <textarea class="form-control" id="referenciaenvio" rows="3" placeholder="Escribe alguna referencia como calles, negocios, algo significativo de los alrededores*"></textarea>
          </div>
        </div>
        <div class="row mg2">
          <div class="col-md-2"></div>
          <div class="col-md-9 mg3" style="font-weight:500;">Tus datos personales se utilizarán para procesar tu pedido, mejorar tu experiencia en nuestro sitio y otros propósitos descritos en nuestra <a href="https://prosanatural.com/aviso-privacidad" target="_blank" style="font-weight:bold;color:rgb(7,149,74);">política de privacidad.</a> <br>Revisa nuestros<a href="terminos-condiciones.php" target="_blank" style="font-weight:bold;color:rgb(7,149,74);">  términos y condiciones</a></div>
          <div class="col-md-1">
            <button type="submit" id="enviarInfoFiscalEnvio" class="btn gp" style="float:right;">enviar</button>
          </div>
        </div>
        <br><br>
      </div>
      <div class="col-md-3"></div>
    </div>

</body>
<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>
<!-- jQuery UI -->
<script src="js/jquery-ui.js"></script>
<!-- List JS -->
<script src="js/list.min.js"></script>
<script src="js/list.js"></script>
<script src="js/cookie.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>


<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="js/ie.js" type="text/javascript"></script>
<script src="js/datos_envio.js"></script>
<script src="js/fs.js"></script>
</html>