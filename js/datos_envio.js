$(document).ready(function () {
  $('.contenedor').css('display', 'none');

    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });

    $('.barrasup').addClass('barrasup2'); 
    $('.barrasup').removeClass('btn-light'); 

    //var arr = decodeBase64(cc);
    //console.log("el pedido es:" + arr);
    var cc= ""+$("#pedidoProsa").val();
    //console.log(cc);

    cc=cc.substring(1,(cc.length-1));
    //console.log(cc);

    var obj = JSON.parse(cc);
    var prods=obj;
    var pe = 0; var vo = 0; var pi = 0; var ca = 0; var su = 0; var en = 0; var im = 0; var to = 0; var en = 0;var np=0;var en2=0;
    isu();
    $(".shopping_cart_dropdown").append("Llena los campos de datos de envío y datos fiscales, para poder enviarte un correo con tu pedido");
   
    $('input:checkbox[name=rfc]').click(function() {
        var val = $(this).attr("id");
        if (val == "trfc") {
          if ($('#trfc').is(":checked") == false) {
            $('#trfc').prop('checked', false);
            $('.inf').addClass('rfg').removeClass('rfc');
            $("#rfcFiscal").val("XAXX010101000");
            $("#regfis option[value=Selecciona]").val("No Aplica");
            $("#catcomp option[value=Selecciona]").val("No Aplica");
            $("#metopagcfdi option[value=Selecciona]").val("No Aplica");
            $("#formpagcfdi option[value=Selecciona]").val("No Aplica");
          } else {
            $('#ntrfc').prop('checked', false);
            $('.inf').addClass('rfc').removeClass('rfg');
            $("#regfis option[value=Selecciona]").attr("selected",true);
            $("#catcomp option[value=Selecciona]").attr("selected",true);
            $("#metopagcfdi option[value=Selecciona]").attr("selected",true);
            $("#formpagcfdi option[value=Selecciona]").attr("selected",true);
          }
        } else {
          $('#trfc').prop('checked', false);
          $('.inf').addClass('rfg').removeClass('rfc');
          $("#rfcFiscal").val("XAXX010101000");
          $("#regfis option[value=Selecciona]").val("No Aplica");
          $("#catcomp option[value=Selecciona]").val("No Aplica");
          $("#metopagcfdi option[value=Selecciona]").val("No Aplica");
          $("#formpagcfdi option[value=Selecciona]").val("No Aplica");
  
        }
      });

    $('input:checkbox[name=dde]').click(function() {
        var val = $(this).attr("id");
        if(val=="nuddf"){
            if($('#nuddf').is(":checked") ==false){
                $('#nuddf').prop('checked',false);
                $('.ddeyf').addClass('def').removeClass('dep');
                $("#single3").val($("#single").val());
                $("#single4").val($("#single2").val());
                $("#calleenvio").val($("#calleFiscal").val());
                $("#numIntenvio").val($("#numIntFiscal").val());
                $("#numExtenvio").val($("#numExtFiscal").val());
            
            }
            else{
                $('#uddf').prop('checked',false);
                $('.ddeyf').addClass('dep').removeClass('def');
                $("#single3").val("");
                $("#single4").val("");
                $("#calleenvio").val("");
                $("#numIntenvio").val("");
                $("#numExtenvio").val("");
            }
       
        }
        else{
            $('#nuddf').prop('checked',false);
            $('.ddeyf').addClass('def').removeClass('dep');
            $("#single3").val($("#single").val());
            $("#single4").val($("#single2").val());
            $("#calleenvio").val($("#calleFiscal").val());
            $("#numIntenvio").val($("#numIntFiscal").val());
            $("#numExtenvio").val($("#numExtFiscal").val());
        }
    })


    $("#enviarInfoFiscalEnvio").click(function () {
        var alert="";
        var alert1="";
        var alert2="";
        var cont=0;
        var sep="";

        if($('#uddf').is(":checked")==true){
            $("#single3").val($("#single").val());
            $("#single4").val($("#single2").val());
            $("#calleenvio").val($("#calleFiscal").val());
            $("#numIntenvio").val($("#numIntFiscal").val());
            $("#numExtenvio").val($("#numExtFiscal").val());
        }

        if($('#ntrfc').is(":checked")==true){
            $("#rfcFiscal").val("XAXX010101000");
        }


        if ($("#nombreFiscal").val() == '' || $("#rfcFiscal").val() == '' || $("#correoEFiscal").val() == '' || $("#telefonoFisical").val() == '' || $("#calleFiscal").val() == '' || $("#single").val() == '' || $("#single").val() == null || $("#single2").val() == null || $("#single2").val() == '' || $("#single2").val() == 'Escribe' || $("#referenciaenvio").val() == '' || ($("#regfis").val() == '' || $("#regfis").val() == null || $("#regfis").val() == 'Selecciona') || ($("#catcomp").val() == '' || $("#catcomp").val() == null || $("#catcomp").val() == 'Selecciona') || ($("#metopagcfdi").val() == '' || $("#metopagcfdi").val() == null || $("#metopagcfdi").val() == 'Selecciona') || ($("#formpagcfdi").val() == '' || $("#formpagcfdi").val() == null || $("#formpagcfdi").val() == 'Selecciona') ) {
            if($("#nombreFiscal").val() == ''){ $('#nombreFiscal').addClass('alerta'); alert=alert+" nombre";sep=",";} else $('#nombreFiscal').removeClass('alerta');
            if($("#rfcFiscal").val() == ''){ $('#rfcFiscal').addClass('alerta');alert=alert+sep+" RFC";sep=",";}else $('#rfcFiscal').removeClass('alerta');
            if($("#correoEFiscal").val() == ''){ $('#correoEFiscal').addClass('alerta'); alert=alert+sep+" correo eletrónico";sep=",";}else $('#correoEFiscal').removeClass('alerta');
            if($("#telefonoFisical").val() == ''){ $('#telefonoFisical').addClass('alerta'); alert=alert+sep+" telefono";sep=",";}else $('#telefonoFisical').removeClass('alerta');
            if($("#calleFiscal").val() == ''){ $('#calleFiscal').addClass('alerta'); alert=alert+sep+" calle Fiscal";sep=",";} else $('#calleFiscal').removeClass('alerta');
            if($("#numExtFiscal").val() == ''){ $('#numExtFiscal').addClass('alerta'); alert=alert+sep+" número exterior Fiscal";sep=",";}else $('#numExtFiscal').removeClass('alerta');
            if($("#single2").val() == '' || $("#single2").val() == null || $("#single2").val() == 'Escribe'){ $('.select2').addClass('alerta'); alert=alert+sep+" codigo postal-colonia-municipio o alcaldia";sep=",";}else $('.select2').removeClass('alerta');            
            if($("#calleenvio").val() == ''){ $('#calleenvio').addClass('alerta'); alert=alert+sep+" calle de Envío";sep=",";} else $('#calleenvio').removeClass('alerta');
            if($("#numExtenvio").val() == ''){ $('#numExtenvio').addClass('alerta'); alert=alert+sep+" número exterior de Envio";sep=",";}else $('#numExtenvio').removeClass('alerta');
            
            if(($("#regfis").val() == '' || $("#regfis").val() == null || $("#regfis").val() == 'Selecciona') && $("#rfcFiscal").val()!='XAXX010101000'){ $('.regfis').addClass('alerta'); alert=alert+sep+" Régimen Fiscal CFDI";sep=",";}else $('.regfis').removeClass('alerta');            
            if(($("#catcomp").val() == '' || $("#catcomp").val() == null || $("#catcomp").val() == 'Selecciona') && $("#rfcFiscal").val()!='XAXX010101000'){ $('.catcomp').addClass('alerta'); alert=alert+sep+" Comprobante CFDI";sep=",";}else $('.catcomp').removeClass('alerta');    
            if(($("#metopagcfdi").val() == '' || $("#metopagcfdi").val() == null || $("#metopagcfdi").val() == 'Selecciona') && $("#rfcFiscal").val()!='XAXX010101000'){ $('.metopagcfdi').addClass('alerta'); alert=alert+sep+" Método de Pago CFDI";sep=",";}else $('.metopagcfdi').removeClass('alerta');            
            if(($("#formpagcfdi").val() == '' || $("#formpagcfdi").val() == null || $("#formpagcfdi").val() == 'Selecciona') && $("#rfcFiscal").val()!='XAXX010101000'){ $('.formpagcfdi').addClass('alerta'); alert=alert+sep+" Forma de Pago CFDI";sep=",";}else $('.formpagcfdi').removeClass('alerta');            



            if($("#referenciaenvio").val() == ''){ $('#referenciaenvio').addClass('alerta'); alert=alert+sep+" referencias de envio";sep=",";}else $('#referenciaenvio').removeClass('alerta');

            alert1="Te hacen falta los campos:(";
            alert2="), para poder poder continuar";

            toastr.error( alert1+alert+alert2 , { timeOut: 5000 });
            
        }
        else {
            if(ValidaRfc($("#rfcFiscal").val())){
                sendOrder2();

            }
        }
       
    });

    function ValidaRfc(rfcStr) {
        var strCorrecta;
        strCorrecta = rfcStr;	
        if (rfcStr.length == 12){
        var valid = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
        }else{
        var valid = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
        }
        var validRfc=new RegExp(valid);
        var matchArray=strCorrecta.match(validRfc);
        if (matchArray==null) {
            alert('Ingresa un RFC válido');
    
            return false;
        }
        else
        {
            return true;
        }
        
    }

    function sendOrder2() {
        var costoTotal = $('#cmpSubTotales').val();
        var mail = $("#cmpEmail").val();
        var ordComp = $("#cmpOrdenCompra").val();
        var obs = $("#cmpObservaciones").val();
 
            toastr.info('Procesando pedido...');
            var idx = 0;
            var cap = false;
            var cant = 0;
            prods.push({
                "email": mail,
                "ordComp": "",
                "observaciones": ""
            });
            var mun1="";
            var mun2="";
            estadoFacturacion = ($("#single").val()).split(',');
            fragmentoTexto = ($("#single2").val()).split(',');  

            mun1=fragmentoTexto[2].replace('Alcaldía:', '');
            mun1=mun1.replace('Municipio:', '');
            if($('#nuddf').is(":checked") ==false){
                estadoFacturacion2=estadoFacturacion;
                fragmentoTexto2=fragmentoTexto;
                mun2=mun1;
               
            }
            else{
                estadoFacturacion2 = ($("#single3").val()).split(',');
                fragmentoTexto2 = ($("#single4").val()).split(',');              

                mun2=fragmentoTexto2[2].replace('Alcaldía:', '');
                mun2=mun2.replace('Municipio:', '');
            }
            


            var datosFiscales = new Array($("#nombreFiscal").val(), $("#rfcFiscal").val(), $("#correoEFiscal").val(), $("#telefonoFisical").val(), $("#calleFiscal").val(), $("#numIntFiscal").val(), $("#numExtFiscal").val(), fragmentoTexto[0].replace('Código Postal:', ''), fragmentoTexto[1].replace('Colonia:', ''), mun1, estadoFacturacion[1],$("#regfis").val(),$("#catcomp").val(),$("#metopagcfdi").val(),$("#formpagcfdi").val());
            var datosEnvio = new Array($("#calleenvio").val(), $("#numIntenvio").val(), $("#numExtenvio").val(), fragmentoTexto2[0].replace('Código Postal:', ''), fragmentoTexto2[1].replace('Colonia:', ''), mun2, estadoFacturacion2[1], $("#referenciaenvio").val());
     
            

            var flete = new Array(en,su,im,to,en2);
            var datosAdicionales = new Array(pe,vo,ca);

            var datos = {
                'prods': prods,
                'datosFiscales': datosFiscales,
                'datosEnvio': datosEnvio,
                'flete': flete,
                'datosAdicionales': datosAdicionales
            }
            $(".loader").fadeIn("slow");

              $.post("ms/insertDatosCompra.php", {datos}).done(function (data) {
                  var p = JSON.parse(data);
                
                  if (p.estatus.includes('Exito')) {
                      $.post("php/ped_mail_V1.0.php", { datos }).done(function (data) {
                        console.log("el mensaje es:" + data + ".");
                        $(".loader").fadeOut("slow");

                        if (data.includes('Exito')) {
                          console.log("el mensaje es:" + data + ".");
                          window.location.href='gracias';
                        }
                      }); 
                  }
              })

    }

    function isu() {
        for (var x in obj) {
            np= parseInt(obj[x]["np"]);
            pe = pe + (parseFloat(obj[x]["pe"])*np);
            vo = vo + (parseFloat(obj[x]["vo"])*np);
            pi = pi + np;
            ca = ca + (np*(1/parseFloat(obj[x]["ue"])));
            su = su + (parseFloat(obj[x]["pr"])*np);

        }

        if (pe > vo) {
            en = Math.trunc((200 + (100 * (Math.trunc(pe / 5)))));
        }
        else {
            en = Math.trunc((200 + (100 * (Math.trunc(vo / 5)))));
        }

        su=su;
                im=(en+su)*0.16;
                to=su+en+im;


        pe=comasMiles(pe.toFixed(2));
        vo=comasMiles(vo.toFixed(2));
        pi=comasMiles(pi.toFixed(2));
        ca=comasMiles((ca).toFixed(2));
        su=comasMiles(su.toFixed(2));
        en2=en.toFixed(2);
        en=comasMiles(en.toFixed(2));
        im=comasMiles(im.toFixed(2));
        to=comasMiles(to.toFixed(2));


    }

    function decodeBase64(textoBase64) {
        let base64s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        let bits, decOut = '', i = 0;
        let undecOut = null;
        for (; i < textoBase64.length; i += 4) {
            bits =
                (base64s.indexOf(textoBase64.charAt(i)) & 0xff) << 18 |
                (base64s.indexOf(textoBase64.charAt(i + 1)) & 0xff) << 12 |
                (base64s.indexOf(textoBase64.charAt(i + 2)) & 0xff) << 6 |
                base64s.indexOf(textoBase64.charAt(i + 3)) & 0xff;
            decOut += String.fromCharCode((bits & 0xff0000) >> 16, (bits & 0xff00) >> 8, bits & 0xff);
        }
        if (textoBase64.charCodeAt(i - 2) === 61) {
            undecOut = decOut.substring(0, decOut.length - 2);
        } else if (textoBase64.charCodeAt(i - 1) === 61) {
            undecOut = decOut.substring(0, decOut.length - 1);
        } else {
            undecOut = decOut;
        }
        return unescape(undecOut);
    }


    function comasMiles(valor) {
        var i = 0;
        var valord = "" + valor;
        var valordef = "";
        if (valor < 1000) {
          return valor;
        } else {
          if (valor < 10000) {
            for (i; i < 9; i++) {
              if (i == 1) {
                valordef = valordef + "," + valord.charAt(i);
              } else {
                valordef = valordef + valord.charAt(i);
              }
            }
          } else {
            if (valor < 100000) {
              for (i; i < 10; i++) {
                if (i == 2) {
                  valordef = valordef + "," + valord.charAt(i);
                } else {
                  valordef = valordef + valord.charAt(i);
                }
              }
            } else {
              if (valor < 1000000) {
                for (i; i < 11; i++) {
                  if (i == 3) {
                    valordef = valordef + "," + valord.charAt(i);
                  } else {
                    valordef = valordef + valord.charAt(i);
                  }
                }
              } else {
                if (valor < 10000000) {
                  for (i; i < 12; i++) {
                    if (i == 1) {
                      valordef = valordef + "," + valord.charAt(i);
                    } else {
                      if (i == 4) {
                        valordef = valordef + "," + valord.charAt(i);
                      } else {
                        valordef = valordef + valord.charAt(i);
                      }
                    }
                  }
                } else {
                  if (valor < 100000000) {
                    for (i; i < 13; i++) {
                      if (i == 2) {
                        valordef = valordef + "," + valord.charAt(i);
                      } else {
                        if (i == 5) {
                          valordef = valordef + "," + valord.charAt(i);
                        } else {
                          valordef = valordef + valord.charAt(i);
                        }
                      }
                    }
                  }
                }
              }
            }
          }
          return valordef;
        }
      }




});