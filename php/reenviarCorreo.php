

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    $objtMOD = new addOrderToMOD();
    $numCte = $_POST["datos"]["cliente"][0];
    $nameCte = $_POST["datos"]["cliente"][1];
    $facts = $_POST["datos"]["cliente"][2];
    $saldo = $_POST["datos"]["cliente"][3];
    $limcred = $_POST["datos"]["cliente"][4];
    $serverResponse = $objtMOD->sendOrder($numCte, $nameCte, $facts, $saldo, $limcred);

date_default_timezone_set('America/Mexico_City');

class MODconstruct{
    static function prepareMod($clieNum, $modFileName){
        $clieNumLg = str_pad($clieNum, 10, " ", STR_PAD_LEFT);
        $vendFijo = "15";
        $cveVendedor = str_pad($vendFijo, 5, " ", STR_PAD_LEFT);;
        $modProds = "";

        foreach ($_POST["datos"]["prods"] as $value) {

            if (isset($value['cv'])) {
                
                $cveArt = $value['cv'];
                $cant = $value['np'];
                $costoProm = $value['pr'];
                $precio = $value['pr'];
                $observaciones = "";
                $ordenCompra = "";
                //            contenido de array POST-push "cve_art", "cant"','"costo_prom"','"precio", "email", "ordComp", "observaciones"
                if ($cveArt != null && $cant>0) {
                    $modProds .= '<ROWdtfield CANT="' . $cant . '" CVE_ART="' . $cveArt .
                        '" DESC1="0" DESC2="0" DESC3="0" IMPU1="0" IMPU2="0" IMPU3="0" IMPU4="16" COMI="0" PREC="' . $precio .
                        '" NUM_ALM="1" STR_OBS="" REG_GPOPROD="0" COSTO="' . $costoProm .
                        '" TIPO_PROD="P" TIPO_ELEM="N" TIP_CAM="1" UNI_VENTA="PIEZAS" IMP1APLA="4" IMP2APLA="4" IMP3APLA="4" IMP4APLA="0" PREC_SINREDO="' . $precio . '" COST_SINREDO="' .
                        $costoProm . '"/>';
                }
            }

             
        }
        $modProds .= '<ROWdtfield CANT="1" CVE_ART="SERV-027" DESC1="0" DESC2="0" DESC3="0" IMPU1="0" IMPU2="0" IMPU3="0" IMPU4="16" COMI="0" PREC="' . $_POST["datos"]["flete"][4] . '" NUM_ALM="13" STR_OBS="" REG_GPOPROD="0" COSTO="0" TIPO_PROD="S" TIPO_ELEM="N" TIP_CAM="1" UNI_VENTA="N/A" IMP1APLA="4" IMP2APLA="4" IMP3APLA="4" IMP4APLA="0" PREC_SINREDO="' . $_POST["datos"]["flete"][4] . '" COST_SINREDO="0"/>';


        $mod = '<?xml version="1.0" standalone="yes"?>
                <DATAPACKET Version="2.0">
                    <METADATA>
                        <FIELDS>
                            <FIELD attrname="CVE_CLPV" fieldtype="string" WIDTH="10"/>
                            <FIELD attrname="NUM_ALMA" fieldtype="i4"/>
                            <FIELD attrname="CVE_PEDI" fieldtype="string" WIDTH="20"/>
                            <FIELD attrname="ESQUEMA" fieldtype="i4"/>
                            <FIELD attrname="DES_TOT" fieldtype="r8"/>
                            <FIELD attrname="DES_FIN" fieldtype="r8"/>
                            <FIELD attrname="CVE_VEND" fieldtype="string" WIDTH="5"/>
                            <FIELD attrname="COM_TOT" fieldtype="r8"/>
                            <FIELD attrname="NUM_MONED" fieldtype="i4"/>
                            <FIELD attrname="TIPCAMB" fieldtype="r8"/>
                            <FIELD attrname="STR_OBS" fieldtype="string" WIDTH="255"/>
                            <FIELD attrname="ENTREGA" fieldtype="string" WIDTH="25"/>
                            <FIELD attrname="SU_REFER" fieldtype="string" WIDTH="20"/>
                            <FIELD attrname="TOT_IND" fieldtype="r8"/>
                            <FIELD attrname="MODULO" fieldtype="string" WIDTH="4"/>
                            <FIELD attrname="CONDICION" fieldtype="string" WIDTH="25"/>
                            <FIELD attrname="dtfield" fieldtype="nested">
                                <FIELDS>
                                    <FIELD attrname="CANT" fieldtype="r8"/>
                                    <FIELD attrname="CVE_ART" fieldtype="string" WIDTH="20"/>
                                    <FIELD attrname="DESC1" fieldtype="r8"/>
                                    <FIELD attrname="DESC2" fieldtype="r8"/>
                                    <FIELD attrname="DESC3" fieldtype="r8"/>
                                    <FIELD attrname="IMPU1" fieldtype="r8"/>
                                    <FIELD attrname="IMPU2" fieldtype="r8"/>
                                    <FIELD attrname="IMPU3" fieldtype="r8"/>
                                    <FIELD attrname="IMPU4" fieldtype="r8"/>
                                    <FIELD attrname="COMI" fieldtype="r8"/>
                                    <FIELD attrname="PREC" fieldtype="r8"/>
                                    <FIELD attrname="NUM_ALM" fieldtype="i4"/>
                                    <FIELD attrname="STR_OBS" fieldtype="string" WIDTH="255"/>
                                    <FIELD attrname="REG_GPOPROD" fieldtype="i4"/>
                                    <FIELD attrname="REG_KITPROD" fieldtype="i4"/>
                                    <FIELD attrname="NUM_REG" fieldtype="i4"/>
                                    <FIELD attrname="COSTO" fieldtype="r8"/>
                                    <FIELD attrname="TIPO_PROD" fieldtype="string" WIDTH="1"/>
                                    <FIELD attrname="TIPO_ELEM" fieldtype="string" WIDTH="1"/>
                                    <FIELD attrname="MINDIRECTO" fieldtype="r8"/>
                                    <FIELD attrname="TIP_CAM" fieldtype="r8"/>
                                    <FIELD attrname="FACT_CONV" fieldtype="r8"/>
                                    <FIELD attrname="UNI_VENTA" fieldtype="string" WIDTH="10"/>
                                    <FIELD attrname="IMP1APLA" fieldtype="i4"/>
                                    <FIELD attrname="IMP2APLA" fieldtype="i4"/>
                                    <FIELD attrname="IMP3APLA" fieldtype="i4"/>
                                    <FIELD attrname="IMP4APLA" fieldtype="i4"/>
                                    <FIELD attrname="PREC_SINREDO" fieldtype="r8"/>
                                    <FIELD attrname="COST_SINREDO" fieldtype="r8"/>
                                    <FIELD attrname="LOTE" fieldtype="string" WIDTH="16"/>
                                    <FIELD attrname="PEDIMENTO" fieldtype="string" WIDTH="16"/>
                                    <FIELD attrname="FECHCADUC" fieldtype="dateTime"/>
                                    <FIELD attrname="FECHADUANA" fieldtype="dateTime"/>
                                </FIELDS>
                                <PARAMS/>
                            </FIELD>
                        </FIELDS>
                        <PARAMS/>
                    </METADATA>
                    <ROWDATA>
                        <ROW CVE_CLPV="' . $clieNumLg . '" NUM_ALMA="1" CVE_PEDI="' . $modFileName . '" ESQUEMA="0" DES_TOT="0" DES_FIN="0" CVE_VEND="' . $cveVendedor . '" COM_TOT="0" NUM_MONED="1" TIPCAMB="1" STR_OBS="' . $observaciones . '" MODULO="FACT" CONDICION="">
                            <dtfield>' . $modProds . '</dtfield>
                        </ROW>
                    </ROWDATA>
                </DATAPACKET>';

        return $mod;
    }
}

class addOrderToMOD{
    static function sendOrder($clieNum, $clieNom,$facts,$saldo,$limcred){
        $objtConstMOD = new MODconstruct();
        $srvResp = array();
        $nombre="";
        if($clieNum==3981){
            $nombre=$_POST["datos"]["datosFiscales"][0];
        }
        else{
            $nombre=$clieNom;
        }

        $pdf = '<table style="width: 100%; margin-left: auto; margin-right: auto; height: 188px;" border="0";>
        <tbody>
        <tr style="height: 25px;background-color:rgb(230,230,230);">
        <td style="width: 10%; color: black; text-align: center; height: 15px;" border="0";>SKU</td>
        <td style="width: 60%; color: black; text-align: center; height: 15px;" border="0";>PRODUCTO</td>
        <td style="width: 10%; color: black; text-align: center; height: 15px;" border="0";>PRECIO</td>
        <td style="width: 10%; color: black; text-align: center; height: 15px;" border="0";>CANTIDAD</td>
        <td style="width: 10%; color: black; text-align: center; height: 15px;" border="0";>TOTAL</td>
        </tr>';
        $np = 0;


        foreach ($_POST["datos"]["prods"] as $value) {
            if (isset($value['cv']) && isset($value['np']) && isset($value['pr']) && isset($value['de'])) {
                if($value['np']>0){
                    $cveArt = $value['cv'];
                    $cant = $value['np'];
                    $precio = $value['pr'];
                    $desc = $value['de'];
                
                    $total = $cant * $precio;
                    $np = isset($np) ? $np + $cant : $cant;
    
                    if ($cveArt != null) {
                        $pdf .= '<tr style="height: 15px;">
                            <td style="width: 10%; color: black; padding-top:15px; text-align: center; height: 15px;" border="0";>'.$cveArt.'</td>
                            <td style="width: 60%; color: black; padding-top:15px; text-align: center; height: 15px;" border="0";>'.$desc.'</td>
                            <td style="width: 10%; color: black; padding-top:15px; text-align: center; height: 15px;" border="0";>'.$precio.'</td>
                            <td style="width: 10%; color: black; padding-top:15px; text-align: center; height: 15px;" border="0";>'.number_format($cant).'</td>
                            <td style="width: 10%; color: black; padding-top:15px; text-align: center; height: 15px;" border="0";>'.number_format($total, 2, '.', ',').'</td>
                        </tr>';
                    } else {
                        break;
                    }
                }
              
            } 
        }

        $pdf .= '
         <tr style="height: 158px;">
            <td style="width: 100%; height: 158px;" colspan="5"; border="0";>
            <table style="border-collapse: collapse; width: 100%; height: 72px;" border="0">
            <tbody>
            <tr style="height: 18px;">
            <td  style="width: 10%; height: 0px;"></td>

            <td style="width: 40%;padding-top:40px; height: 18px;text-align: end;color:black;">    
                <label for="cmpSubTotales">PESO TOTAL EN KILOS&nbsp;&nbsp;</label>
                <span style="display: block;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;color:black; float:right;width:50%;">' . $_POST["datos"]["datosAdicionales"][0] . '</span>
            </td>
            <td style="width: 30%;padding-top:40px; height: 18px;text-align: end;color:black;">
                <label for="cmpSubTotales">&nbsp;&nbsp;SUBTOTAL&nbsp;</label>
                <span style="display: block;width:65%;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;color:black;float:right;"><span style="float:left;display: block;">$</span>' . $_POST["datos"]["flete"][1] . '</span>
            </td>
            <td  style="width: 20%; height: 0px;">
            </td>

            </tr>
            <tr style="height: 18px;">
            <td  style="width: 10%; height: 0px;"></td>
            <td style="width: 40%; padding-top:15px;height: 18px;text-align: end;color:black;">
                <label for="cmpEnvio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOLUMEN CÚBICO&nbsp;&nbsp;</label>
                <span style="display: block;width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;">' . $_POST["datos"]["datosAdicionales"][1] . '</span></td>
            <td style="width: 40%; padding-top:15px;height: 18px;text-align: end;color:black;">';
            
            if ($facts == "S"){
                $pdf.='
            <label for="cmpEnvio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENVÍO&nbsp;&nbsp;</label>
            <span style="display: block;width:65%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;"><span style="float:left"></span>Por cotizar(en caso de requerirse)</span>';
            
          }
        else{
            $pdf.='
            <label for="cmpEnvio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENVÍO&nbsp;&nbsp;</label>
            <span style="display: block;width:65%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;"><span style="float:left">$</span>' . $_POST["datos"]["flete"][0] . '</span>';
             }
            
            $pdf.='</td>
            <td  style="width: 10%; height: 0px;"></td>
            </tr>
            <tr style="height: 18px;">
            <td  style="width: 10%; height: 0px;"></td>
            <td style="width: 40%;padding-top:15px; height: 18px;text-align: end;color:black;">         
            <label for="cmpImpuestos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE PIEZAS&nbsp;&nbsp;</label>
            <span style="display: block;width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;">' .  number_format($np, 2, '.', ',') . '</span></td>
            <td style="width: 30%;padding-top:15px; height: 18px;text-align: end;color:black;">
            <label>IMPUESTOS&nbsp;</label>
            <span style="display: block;width:65%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;"><span style="float:left">$</span>' . $_POST["datos"]["flete"][2] . '</span></td>
            <td  style="width: 20%; height: 0px;"></td>

            </tr>
            <tr style="height: 18px;">
            <td  style="width: 10%; height: 0px;"></td>
            <td style="width: 40%;padding-top:15px;padding-bottom:50px; height: 18px;text-align: end;color:black;">
            <label for="cmpCostoTotal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. DE CAJAS&nbsp;&nbsp;</label>
            <span style="display: block;width:50%;float:right;font-size:20px;background-color: rgb(233,236,239);font-weight:bold;">' . $_POST["datos"]["datosAdicionales"][2] . '</span></td>
            <td style="width: 30%;padding-top:15px;padding-bottom:50px; height: 18px;text-align: end;color:black;"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;</label>
            <span style="display: block;width:65%;float:right;font-size:25px;background-color: rgb(57,181,74);font-weight:bold;color:white"><span style="float:left">$</span>' . $_POST["datos"]["flete"][3] . '</span></td>
            <td style="width: 20%; height: 0px;"></td>
            </tr>
            </tbody>
            </table>
           
            </td>
        </tr>
        </tbody>
        </table>';


        foreach ($_POST["datos"]["prods"] as $value) {
            if (isset($value['email'])) {
                $mailCte =  $value['email'];

            }

        }
        $name = "Portal de Pedidos PROSA";
        $from_email = "pedidosmayoristas@prosanatural.com";

        $subject = 'Nuevo pedido';
        $message  = "<html><body>";
        $message .= '
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        </head>';
        //$message .= "<h4>Gracias por tu solicitud ($clieNum) $clieNom </h4> <p>En breve nos pondremos en contacto contigo</p> <p>Tu pedido esta en proceso de surtido</p><p>Vive Naturalmente</p><p>PROSA Productos Naturales</p>";
        $message .= '
        <div style="background-color: rgba(245,246,247);">&nbsp;</div>
            <table style="width: 80%; margin-left: auto; margin-right: auto; border: rgba(5,3,17) 1px solid;">
                <tbody>
                        <tr style="width: 100%;">
                                <td style="width: 10%;">&nbsp;</td>';


                                
                        if ($facts == "S"){
                            $message .= '<td style="width: 80%;"><img style="width: 100%; display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/Encabezado-Correo.webp" /></td>';

                        }
                        else{
                            $message .= '<td style="width: 80%;"><img style="width: 100%; display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/cabecera-correo-distribuidores.jpg" /></td>';
                        }
                        $message .= '
                                
                                <td style="width: 10%">&nbsp;</td>
                        </tr>
                        <tr style="width: 100%;">
                                <td style="width: 10%;">&nbsp;</td>
                                <td style="width: 80%">
                                        <p style="font-size: 19px;"><span style="color: #000000;">&nbsp;</span></p>
                                        <p style="font-size: 19px;"><span style="color: #000000;"><span style="color: #006837;"><strong>GRACIAS <span style="text-transform: uppercase;">' . $nombre . "</span> (Clave de cliente: " . $clieNum .')</strong></span></span></p>
                                    </td>
                                <td style="width:10%;">&nbsp;</td>
                        </tr>
                        <tr style="width: 100%;">
                            <td style="width: 10%;">&nbsp;</td>
                            <td style="width: 80%;; text-align: left;">';





                            if ($facts == "S"){
                                $message .= '<p style="font-size: 19px;"><span style="color: black;"><strong>Hemos recibido tu pedido. Para continuar con el proceso es necesario que realices lo siguiente en tiempo y forma:</strong></span></p>';
                            }
                            else{
                                $message .= '<p style="font-size: 19px;"><span style="color: black;"><strong>Hemos recibido tu pedido. Para continuar con el proceso es necesario que realices lo siguiente en tiempo y forma:</strong></span></p>';

                            }


                            $message .= '
                                <ol>
                                <li style="font-size: 19px;color:black;">Pago de tu pedido <strong>$' . $_POST["datos"]["flete"][3] . '</strong> con la referencia: <strong>' . date("Hi") . '</strong></li>
                                <li style="font-size: 19px;"><span style="color: #000000;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Reenv&iacute;o de este correo a la siguiente direcci&oacute;n: <a href="mailto:comunicacionweb@prosaenlinea.com.mx"><strong><span style="color: #339966;">comunicacionweb@prosaenlinea.com.mx</span></strong></a> donde adjuntar&aacute;s tu comprobante de pago.</span></span></span></span><span style="color: #000000;"><span style="color: #000000;"><br /><strong>IMPORTANTE: Al reenviar este correo no olvides verificar que est&eacute;n incluidos:</strong></span></span></li>
                                <li style="font-size: 19px;color:black;">Tu archivo adjunto de pedido que viene en este correo.</li>
                                <li style="font-size: 19px;"><span style="color: #000000;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Documento o imagen legible de tu comprobante de pago.<br /><br /></span></span></span></span></li>
                                </ol>';
                                if ($facts == "S"){
                                    $message .= '<p style="font-size: 19px;"><span style="color: black;font-weight:bold;">**EN CASO DE CONTAR CON LÍNEA DE CRÉDITO LOS PASOS 1 AL 5 NO SON NECESARIOS**</span></p>';
                                }
                                
                                $message .= '
                                <p style="font-size: 19px;"><span style="color: #f15a24;">CONSIDERACIONES: Para garantizar que todos tus productos solicitados sean surtidos en su totalidad, cuentas con un m&aacute;ximo de 3 d&iacute;as h&aacute;biles para hacer tu pago a partir de la recepci&oacute;n de este correo.</span><br /><span style="color:black;">Con ello podremos iniciar el proceso de surtido para entregarte lo antes posible la <span style="color: rgb(20,64,47);"><strong>GU&Iacute;A DE PEDIDO</strong></span> que corresponde al seguimiento de paqueter&iacute;a &iexcl;Gracias!</span></p>
                                <p style="font-size: 19px; text-align: left;color:black;"><strong><span>TU PEDIDO ES</span></strong></p>
                                ' . $pdf . '
                            </td>
                            <td style="width: 10%;">&nbsp;</td>
                        </tr><tr style="width: 100%;"><td style="width: 10%;padding-bottom: 50px;">&nbsp;</td>';



                        if ($facts == "S"){
                            $message .= ' <td style="width: 80%;padding-bottom: 0px;"><img style="width: 100%; display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/db2.webp" /> <br /></td>
                            <td style="width: 10%;padding-bottom: 50px;">&nbsp;</td>
                            </tr>';
                        }
                        else{
                            $message .= ' <td style="width: 80%;padding-bottom: 50px;"><img style="width: 100%; display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/db.webp" /> <br /></td>
                            <td style="width: 10%;padding-bottom: 50px;">&nbsp;</td>
                            </tr>';
                        }

                        $message .= '<td style="width: 10%;padding-bottom: 50px;">&nbsp;</td>
                        </tr>';

                    if ($_POST["datos"]["datosFiscales"][0] != '' || $_POST["datos"]["datosFiscales"][1] != '') {
                        $message .= '
                        <tr style="width: 100%;">
                            <td style="width: 10%;">&nbsp;</td>
                            <td style="width:80%;">
                                <p><span style="font-size: 19px; text-align: left; color: #000000;"><strong style="background-color: #e6e6e6; padding: 10px;">&nbsp; TUS DATOS FISCALES&nbsp;&nbsp;</strong></span></p>
                                <table style="width: 100%;" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="color: #000000;"><span style="font-size: 19px; text-align: left;">Nombre del cliente o raz&oacute;n social</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][0] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">RFC </span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][1] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">Correo electr&oacute;nico </span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><a  href="mailto:'.$_POST["datos"]["datosFiscales"][2].'" style="color: #000000;">'.$_POST["datos"]["datosFiscales"][2].'</a></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">Tel&eacute;fono&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][3] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">Calle&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][4] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">No. exterior&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][6] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">No. interior&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][5] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; height: 18px;"><span style="color: #000000;"><span style="font-size: 19px; text-align: left;">C&oacute;digo postal</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][7] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="color: #000000;"><span style="font-size: 19px; text-align: left;">Colonia</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][8] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Municipio o Alcald&iacute;a</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;">' . $_POST["datos"]["datosFiscales"][9] . '</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Estado</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;">' . $_POST["datos"]["datosFiscales"][10] . '</span></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Régimen Fiscal</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;">' . $_POST["datos"]["datosFiscales"][11] . '</span></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Uso de CFDI</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;">' . $_POST["datos"]["datosFiscales"][12] . '</span></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Método de Pago</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;">' . $_POST["datos"]["datosFiscales"][13] . '</span></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Forma de Pago</span></span></td>
                                            <td style="width: 50%;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;">' . $_POST["datos"]["datosFiscales"][14] . '</span></span></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span style="font-size: 19px; text-align: left;"><br /><span style="font-size: 19px; text-align: left; color: #000000;"><strong style="background-color: #e6e6e6; padding: 10px;">&nbsp; TUS DATOS DE ENV&Iacute;O&nbsp;&nbsp;</strong></span></span></p>
                                <table style="width: 100%;" border="0">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">Calle&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"> ' . $_POST["datos"]["datosEnvio"][0] . '</span></span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">No. exterior&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][2] . '</span></span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left; color: #000000;">No. interior&nbsp;</span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left; color: #000000;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"> ' . $_POST["datos"]["datosEnvio"][1] . '</span></span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="color: #000000;"><span style="font-size: 19px; text-align: left;">C&oacute;digo postal</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][3] . '</span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="color: #000000;"><span style="font-size: 19px; text-align: left;">Colonia</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][4] . '</span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Municipio o Alcald&iacute;a</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][5] . '</span></span></strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Estado</span></span></td>
                                            <td style="width: 50%; height: 18px;"><strong><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][6] . '</span></span></strong></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;padding-bottom:50px;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">Referencia</span></span></td>
                                            <td style="width: 50%;padding-bottom:50px;"><strong><span style="font-size: 19px; text-align: left;"><span style="color: #000000;">' . $_POST["datos"]["datosEnvio"][7] . '</span></span></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width: 10%;">&nbsp;</td>
                        </tr>';
                    }



                    $message .= '<tr style="width: 100%;"><td style="width:10%;">&nbsp;</td>';

        if ($facts == "S"){
            $message .= '
            <td style="width:80%;">
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">En caso de error o actualizaci&oacute;n en los datos de facturaci&oacute;n o env&iacute;o, deber&aacute;s notificarlo a la brevedad para su actualizaci&oacute;n a: <a href="mailto:recepcion@prosaenlinea.com.mx "><strong><span style="color: #339966;">recepcion@prosaenlinea.com.mx</span></strong></a> </span></span></span></span></p>
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Recuerda que una vez emitida la factura no se podr&aacute;n cancelar o modificar tus datos.</span></span></span></span><br /><br /><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Para conocer nuestros tiempo de entrega de tus pedidos, revisa nuetras secci&oacute;n <strong><a style="color: #339966; text-decoration: underline;" href="https://portalclientes.prosanatural.com/php/terminos-condiciones.php">t&eacute;rminos y condiciones</a></strong> en <span style="color: #339966;"><strong><a style="color: #339966;" href="https://prosanatural.com">prosanatural.com</a></strong></span></span></span></span></span><br /><span style="font-size: 19px; text-align: left;">&nbsp;</span><br /><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #000000;"><strong style="font-size: 19px;">Cualquier duda ponte en contacto con nosotros en:</strong><br /></span></span></span></p>
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #339966;"><a style="font-size: 19px; color: #339966;font-weight: bold;" href="mailto:recepcion@prosaenlinea.com.mx ">recepcion@prosaenlinea.com.mx </a> </span></span></span><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><strong><span style="color: #000000;">o al teléfono <a style="font-size: 19px; color: #339966;font-weight: bold;" href="tel:+5557417400">55 5741 7400</a></span></strong></span></span></p>
                <p style="text-align: center;"><span style="font-size: 19px; text-align: left;">&nbsp;</span><br /><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #000000;">S&iacute;guenos en nuestras redes sociales</span><br /></span></span></p>
            </td>';
        }
        else{
            $message .= '
            <td style="width:80%;">
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">En caso de error o actualizaci&oacute;n en los datos de facturaci&oacute;n o env&iacute;o, deber&aacute;s notificarlo a la brevedad para su actualizaci&oacute;n a: <a href="mailto:comunicacionweb@prosaenlinea.com.mx"><strong><span style="color: #339966;">comunicacionweb@prosaenlinea.com.mx</span></strong></a> </span></span></span></span></p>
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Recuerda que una vez emitida la factura no se podr&aacute;n cancelar o modificar tus datos.</span></span></span></span><br /><br /><span style="font-size: 19px; text-align: left;"><span style="color: #000000;"><span style="color: #339966;"><span style="color: #000000;">Para conocer nuestros tiempo de entrega de tus pedidos, revisa nuetras secci&oacute;n <strong><a style="color: #339966; text-decoration: underline;" href="https://portalclientes.prosanatural.com/php/terminos-condiciones.php">t&eacute;rminos y condiciones</a></strong> en <span style="color: #339966;"><strong><a style="color: #339966;" href="https://prosanatural.com">prosanatural.com</a></strong></span></span></span></span></span><br /><span style="font-size: 19px; text-align: left;">&nbsp;</span><br /><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #000000;"><strong style="font-size: 19px;">Cualquier duda ponte en contacto con nosotros en:</strong><br /></span></span></span></p>
                <p style="text-align: left;"><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #339966;"><a style="font-size: 19px; color: #339966;font-weight: bold;" href="mailto:comunicacionweb@prosaenlinea.com.mx">comunicacionweb@prosaenlinea.com.mx</a> </span></span></span><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><strong><span style="color: #000000;">o al WhatsApp Prosa <a style="font-size: 19px; color: #339966;font-weight: bold;" href="https://wa.me/525569652570">55 6965 2570</a></span></strong></span></span></p>
                <p style="text-align: center;"><span style="font-size: 19px; text-align: left;">&nbsp;</span><br /><span style="font-size: 19px; text-align: left;"><span style="color: #339966;"><span style="color: #000000;">S&iacute;guenos en nuestras redes sociales</span><br /></span></span></p>
            </td>';
        }



        $message .= '
                <td style="width:10%;"></td></tr>
            <tr style="width: 100%;">
                <td style="width: 10%;"></td>
                <td style="width: 80%;">
                    <table style="width: 100%;" border="0" align="center">
                    <tbody>
                        <tr style="width: 100%;">
                            <td style="width: 36%;"></td>
                            <td style="width: 6%;"><a href="https://www.facebook.com/PROSA-productos-naturales-467623640273801/"><img style="display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/facebook.jpeg" alt="" width="51" height="46" /></a></td>
                            <td style="width: 6%;">
                            <a href="https://www.instagram.com/prosaproductosnaturales/"><img style="display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/instagram.jpeg" width="51" height="46" /></a>
                            </td>
                            <td style="width: 6%;"><a href="https://vm.tiktok.com/J13aGCM/"><img style="display: block; margin-left: auto; margin-right: auto;" src="https://portalclientes.prosanatural.com/img/tiktok.jpeg" width="51" height="46" /></a></td>
                            <td style="width: 36%;"></td>
                        </tr>
                    </tbody>
                    </table>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 10%;">&nbsp;</td>
                <td style="width: 80%; text-align: center; font-size: 20px; height: 30px;"><div align="center"><img src="https://portalclientes.prosanatural.com/img/redes-prosa-1.jpg" /></div></td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            </tbody>
            </table>';






        $message .= "</body></html>";
        $mail = new PHPMailer;

       $mail->CharSet = "utf-8";
       $mail->IsSMTP();
       $mail->Host = "mail.prosanatural.com";

       $mail->SMTPAuth = true;
      
        $mail->Username = 'pedidosmayoristas@prosanatural.com';
       /* $mail->Password = "@^5-IH#@Bhp`~3D&55*^oau%AK7@";*/
        $mail->Password = "K{mIFu.zoMrpZ@sRdN.*2026";
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        $mail->smtpConnect([

        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            ]
        ]);

        $mail->setFrom($from_email, $name);
        $mail->addAddress('alansrmani127@gmail.com');
        // $mail->addAddress('leonardo@pass.com.mx');$mail->addAddress('atencionaclientes@prosaenlinea.com.mx');
        $mail->addAddress('prosapronatuawj@gmail.com');
  
        //$mail->addAddress('atencionaclientes@prosaenlinea.com.mx');

        $modFileName = "";

       if ($facts == "S"){

                $total2=$_POST["datos"]["flete"][3];
                $total3=$limcred-$saldo;
                $total21=str_replace ( ',', '', $total2);
                if($total3 < $total21){
                    $modFileName = "X-A-".$clieNum . "-" . date("dmy-Hi") . ".mod";
                    // $modFileName = "X-A-".$clieNum . "-" . date("dmy-Hi") . ".txt";


                }
                else{
                    $modFileName = $clieNum . "-" . date("dmy-Hi") . ".mod";
                    // $modFileName = $clieNum . "-" . date("dmy-Hi") . ".txt";


                }
        }
        else{

            $modFileName = $clieNum . "-" . date("dmy-Hi") . ".mod";
            // $modFileName = $clieNum . "-" . date("dmy-Hi") . ".txt";
        }
      

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);


   
        $mod = $objtConstMOD->prepareMod($clieNum, $modFileName);
        $modfile = fopen($modFileName, "w") or die("Unable to open file!");
        fwrite($modfile, $mod);
        fclose($modfile);
        $modPath = realpath($modFileName);
        $mail->addAttachment($modPath);
        if ($mail->send()) {
            echo "Exito";
        } else {
            $srvResp['message'] =  "Mailer Error: " . $mail->ErrorInfo;
            echo json_encode($srvResp, JSON_FORCE_OBJECT);
        }
        unlink($modPath);
   
    }
}

