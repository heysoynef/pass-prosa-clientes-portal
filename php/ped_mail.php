<?php
/**
 * This example shows sending a message using PHP's mail() function.
 */
session_start();
$clieNum = $_SESSION["userName"];
$clieNom = $_SESSION["clieNom"];
$observaciones= $_POST["observaciones"];

$name = "Inventario Web";
//Correo Emisor
$from_email ="portalweb@prosaenlinea.com";
//$from_email = "creditoycobranza@prosaenlinea.com.mx";

$subject = utf8_decode('Nuevo pedido');
$bodyText = "Haz recibido un nuevo pedido del cliente ($clieNum) $clieNom ";
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

$mail->CharSet="utf-8";
$mail->IsSMTP();
$mail->Host = "mail.pass.com.mx";
$mail->SMTPAuth = true;
$mail->Username = 'pruebas@pass.com.mx';
$mail->Password = 'G%Qy}AFSk{AA';
//$mail->SMTPSecure = 'tls';
$mail->Port = 26;


$mail->setFrom($from_email, $name);
//$mail->addAddress($_POST["email"]);






//$mail->addAddress('desarrollo2@pass.com.mx');
$mail->addAddress('leonardo@pass.com.mx');
//$mail->addAddress('creditoycobranza@prosaenlinea.com.mx');
$mail->Subject = $subject;
$mail->Body = $bodyText;
$mail->IsHTML(true);

$modFileName = "Pedido_Clie".$clieNum."_".date("d-m-Y\THi").".mod";

$mod = prepareMod($clieNum);
//echo $modFileName;
$modfile = fopen($modFileName, "w") or die("Unable to open file!");
fwrite($modfile, $mod);
fclose($modfile);
$modPath = realpath($modFileName);
//echo $modPath;
//Attach an image file
$mail->addAttachment($modPath);

//send the message, check for errors
if ($mail->send()) {
    echo "Message sent!";
} else {
    
    echo "Mailer Error: ".$mail->ErrorInfo;
}

unlink($modPath);

function prepareMod ($clieNum) {
    //function prepareMod () {
        $clieNumLg = str_pad($clieNum, 10, " ", STR_PAD_LEFT);  
        $modProds = "";
        
        foreach ($_POST["prods"] as $value) {
            $cveArt = $value['cve_art'];
            $cant = $value['cant'];
            $costoProm = $value['costo_prom'];
            $precio = $value['precio'];
            $modProds .= '<ROWdtfield CANT="'.$cant.'" CVE_ART="'.$cveArt.'" DESC1="0" DESC2="0" DESC3="0" IMPU1="0" IMPU2="0" IMPU3="0" IMPU4="16" COMI="0" PREC="'.$precio.'" NUM_ALM="1" STR_OBS="'.$observaciones.'" REG_GPOPROD="0" COSTO="'.$costoProm.'" TIPO_PROD="P" TIPO_ELEM="N" TIP_CAM="1" UNI_VENTA="PIEZAS" IMP1APLA="4" IMP2APLA="4" IMP3APLA="4" IMP4APLA="0" PREC_SINREDO="" COST_SINREDO="'.$costoProm.'" />';
        }
        
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
                        <ROW CVE_CLPV="'.$clieNumLg.'" NUM_ALMA="1" CVE_PEDI="" ESQUEMA="0" DES_TOT="0" DES_FIN="0" CVE_VEND="" COM_TOT="0" NUM_MONED="1" TIPCAMB="1" STR_OBS="" MODULO="FACT" CONDICION="'.$_POST["ordComp"].'">
                            <dtfield>'.$modProds.'</dtfield>
                        </ROW>
                    </ROWDATA>
                </DATAPACKET>';
        
        return $mod;
    }

?>