$(document).ready(function() {
    /*La siguiente función sirve para poder poner coma a los miles, se manda a llamar en la linea 69*/ 
    function comasMiles(valor){
        var i=0;
        var valord=""+valor;
        var valordef="";
        if(valor<1000){
            return valor;
        }
        else{
            if(valor<10000){
                for(i; i<9;i++){
                    if(i==1){
                        valordef = valordef+","+valord.charAt(i);
                    }
                    else{
                        valordef=valordef+valord.charAt(i);
                    }
                }
            }
            else{
                for(i; i<10;i++){
                    if(i==2){
                        valordef = valordef+","+valord.charAt(i);
                    }
                    else{
                        valordef=valordef+valord.charAt(i);
                    }
                }
            }
            return valordef;
        }
    }

    

    var inveTable;
    $(".filtro-consulta input").val("");
   
    $("#email").click(function() { $(this).select(); });
    $(".textAre").hide();
    //--Imprime todos los productos del inventario
    $.post("php/inve_sae.php", {get_existencias: true})
        .done( function(data) {
        if (data != "0 results") {
            //$("#loader").addClass("hidden");    
            var prods = JSON.parse(data);
            var ad, a2, a4;
            var adTd = "";
            var adTh = true;
            for (var x in prods){
                if ( (prods[x]!=null) && (prods[x]["CVE_ART"]) && prods[x]["LIN_PROD"]!=null && prods[x]["LIN_PROD"].indexOf("PRO")===2){
                    a2 = (prods[x]["A2"]) ? prods[x]["A2"]:0;
                    if (parseInt(prods[x]["NUMALM"])>0) {
                        if (adTh) {
                            $("#inveTable thead th:last-child").before("<th width='10%'>A"+prods[1]["NUMALM"]+"</th>");
                            adTh = false;
                        }
                        ad = (prods[x]["AD"]) ? prods[x]["AD"]:0;
                        adTd = "<td class='ad'>"+round(ad, 4)+"</td>";
                    }
                   
                   var prec=round(prods[x]["PRECIO"],4);
                   var precC=""+ comasMiles(prec);
                   var total=(prods[x]["PRECIO"])*(adTd);
                   var imagen="Imagenes/"+prods[x]["CVE_ART"]+".jpg";
                   var existencias= comasMiles(a2);
                    
                    $("#inveTable tbody")
                        .append("<tr>"+
                                    "<td class='imagen'>"+ "<img src='"+imagen+"' border='0' width='144' height='123'>" +"</td>"+
                                    "<td class='cve_art'>"+prods[x]["CVE_ART"]+"</td>"+
                                    "<td class='prodDescr'>"+prods[x]["DESCR"]+"</td>"+
                                    "<td class='uniSal'>"+prods[x]["UNI_ALT"]+"</td>"+
                                    "<td class='precio'>"+precC+"</td>"+
                                    "<td class='a2'>"+existencias+"</td>"+ 
                                    "<td class='peso' hidden='true'>"+prods[x]["PESO"]+"</td>"+
                                    "<td class='volumen' hidden='true'>"+prods[x]["VOLUMEN"]+"</td>"+
                                    "<td class='distribucion' hidden='true'>"+prods[x]["UNI_EMP"]+"</td>"+ 
                                    adTd+
                                    "<td><input class='form-control input-cant'></td>"+
                                    "<td class='cant hidden'></td>"+
                                    "<td class='costo_prom '>"+"</td>"+
                                "</tr>"); 
                    
                }
            }
            //--Activa la búsqueda y paginación de la tabla de materiales para la remisión
            inveTable = new List('inveTable', {
              valueNames: ['cve_art', 'prodDescr', 'cant', 'costo_prom','peso','volumen', 'empaque'],
              page: 10,
              pagination: true
            });
            //inveTable.get("cve_art", "1AG").values({a1: "30"});
            //inveTable.update();
            //console.log(inveTable.get("cve_art", "1AG").values());

            //--Busca un material por clave de producto
            $("input[name='claveMat']").keyup(function() {
                $("input[name='descMat']").val("");
                inveTable.search($(this).val(), ['cve_art']);
            });

            //--Busca un material por descripción de producto
            $("input[name='descMat']").keyup(function() {
                $("input[name='claveMat']").val("");
                inveTable.search($(this).val(), ['prodDescr']);
            });

        } else {
            $("#inveTable tbody").append("<tr><td colspan='5'>No hay materiales en el inventario</td></tr>");
        }
    });
    
    $(document).on('keyup', '.input-cant', function(e) {
        $(this).parents("tr").find(".cant").text($(this).val());

        var esIE = (document.all);
        var esNS = (document.layers);
        tecla = (esIE) ? event.keyCode : e.which;
        if (tecla == 13) {
            showCart();
            return false;
        }

    });

    $(document).on('onkeypress',".input-cant"), function(e) {
        var esIE = (document.all);
        //var esNS = (document.layers);
        tecla = (esIE) ? event.keyCode : e.which;
        if (tecla == 13) {
            alert("Ud. ha presionado la tecla Enter");
            return false;
        }
    }


    function showCart(){
        $(".textAre").show();
        var btnMostrar = $("this");
        $(".filtro-consulta #claveMat").val("");
        $(".filtro-consulta #descMat").val("");
        if ($(this).attr("data_control") == "0") {
            $("#btn-mostrar").text("Mostrar Inventario");
            $(this).attr("data_control", "1");
            
            inveTable.reindex(); //Actualiza la tabla con los actuales valores
            //--Filtra los resultados de la tabla
            //console.log("prueba");
            inveTable.filter();
            inveTable.search();
            inveTable.filter(function(item) {
                if (item.values().cant > 0) {
                    return true;
                } else {
                    return false;
                }
            });
            //console.log($(".list tr").length);
            if ($(".list tr").length == 0) {
                $(".textAre").hide();
                $("#inveTable tbody").append("<tr><td colspan='5'>Ninguna cantidad capturada!</td></tr>");
            }
            else{
                // console.log("el tamaño de los productos son ");
                // console.log( $(".list tr").find("td:eq(Precio)").text()); 
               // document.getElementById("Tabla1").rows[0].cells[0].innerHTML
               //console.log(document.getElementsByTagName("tr")[1].innerHTML);
 
               //var els = document.getElementsByClassName("X");
 
                 //for (var i = 1; i < $(".list tr").length; i++) {
                     var table = document.getElementById("inveTable");
                     var cells = table.getElementsByTagName("tr");
                     var total=0;
                     var totalP=0;
                     var totalV=0;
                     var totalD=0;
 
                     for (var i = 1; i < cells.length; i++) {
                         var resulta="";
                             var url = cells[i].innerHTML;
 
                             var frg = url.split('precio">');
                             var num= url.split('<td class="cant hidden">');
                             var peso=url.split('<td class="peso" hidden="true">');
                             var volumen=url.split('<td class="volumen" hidden="true">');
                             var dist = url.split('<td class="distribucion" hidden="true">');
                             
                             var frg2= frg[1];
                             var num2= num[1];
                             var peso2=peso[1];
                             var volumen2=volumen[1];
                             var dist1 = dist[1];
 
 
                             var url2 =frg2;
                             var url3=num2;
                             var peso3=peso2;
                             var volumen3=volumen2;
                             var dist2 = dist1;
 
 
                             var frg3 = url2.split("<");
                             var num3=url3.split("<");
                             var peso4=peso3.split("<");
                             var volumen4=volumen3.split("<");
                             var dist3= dist2.split("<");
 
                             var cantidad= frg3[0];
                             var numProd= num3[0];
                             var peso5=peso4[0];
                             var volumen5=volumen4[0];
                             var dist4 = dist3[0];
 
                             for(var j=0; j<cantidad.length;j++){
                                 if(cantidad.charAt(j)!=','){                           
                                   // alert("el caracter  es  :  " + cantidad.charAt(j));
                                   /*El precio del producto por si en determinado caso llegar a tener una coma*/ 
                                     resulta=resulta.concat(cantidad.charAt(j));
                                 }
                                 else{
                                     resulta=resulta;
                                 }
                             }
                             /*el número total de productos*/
                             var total2= parseInt(numProd);
                             /*El total del peso*/ 
                              totalP=totalP+ (total2*(parseInt(peso5)));
                              totalV=totalV+ (total2*(parseInt(volumen5)));
                              totalD=totalD+ (total2/(parseInt(dist4)));
                              /*El total del volumen */
                            //  alert("el total del peso es : " + totalP)
                              //el iva que se le aplica al producto
                              total=total+(parseInt(resulta)*total2);
                              //los dos decimales que se le aplican a la cifra
                              total=round((total*1.16),2);
 
                     }
                     var totalf= total+"0";
                     totalf=comasMiles(totalf);
                     
                     $("#inveTable tbody")
                     .append("<tr style='font-size:20px; font-weight:bold; text-align:left;'>"+
                                 "<td></td>"+
                                 "<td></td>"+
                                 "<td></td>"+
                                 "<td colspan='6'><br> Importe: " +  totalf + " <br> El peso total es : " + totalP +  " el volumén total es : " + totalV + " <br> El Importe no incluye envío</td>"+
                             "</tr>"+
                             "<tr style='font-size:20px; font-weight:bold; text-align:left;'>"+
                                 "<td></td>"+
                                 "<td></td>"+
                                 "<td></td>"+
                                 "<td colspan='6'><br> Cajas: " + totalD +"</td>"+
                             "</tr>"                            
                             );
 
                 }
          
        } else {
            $("#btn-mostrar").text("Mostrar Captura");
            $(this).attr("data_control", "0");
            $(".textAre").hide();
            inveTable.filter(); // Remove all filters
            inveTable.search();
        }
    
    }
    
    //--Si se da click al botón mostrar Captura
    $("#btn-mostrar").click(function() {
        showCart();
        /*$(".textAre").show();
        var btnMostrar = $("this");
        $(".filtro-consulta #claveMat").val("");
        $(".filtro-consulta #descMat").val("");
        if ($(this).attr("data_control") == "0") {
            $("#btn-mostrar").text("Mostrar Inventario");
            $(this).attr("data_control", "1");
            
            inveTable.reindex(); //Actualiza la tabla con los actuales valores
            //--Filtra los resultados de la tabla
            //console.log("prueba");
            inveTable.filter();
            inveTable.search();
            inveTable.filter(function(item) {
                if (item.values().cant > 0) {
                    return true;
                } else {
                    return false;
                }
            });
            //console.log($(".list tr").length);
            if ($(".list tr").length == 0) {
                $(".textAre").hide();
                $("#inveTable tbody").append("<tr><td colspan='5'>Ninguna cantidad capturada!</td></tr>");
            }
            else{
               // console.log("el tamaño de los productos son ");
               // console.log( $(".list tr").find("td:eq(Precio)").text()); 
              // document.getElementById("Tabla1").rows[0].cells[0].innerHTML
              //console.log(document.getElementsByTagName("tr")[1].innerHTML);

              //var els = document.getElementsByClassName("X");

                //for (var i = 1; i < $(".list tr").length; i++) {
                    var table = document.getElementById("inveTable");
                    var cells = table.getElementsByTagName("tr");
                    var total=0;
                    var totalP=0;
                    var totalV=0;
                    var totalD=0;

                    for (var i = 1; i < cells.length; i++) {
                        var resulta="";
                            var url = cells[i].innerHTML;

                            var frg = url.split('precio">');
                            var num= url.split('<td class="cant hidden">');
                            var peso=url.split('<td class="peso" hidden="true">');
                            var volumen=url.split('<td class="volumen" hidden="true">');
                            var dist = url.split('<td class="distribucion" hidden="true">');
                            
                            var frg2= frg[1];
                            var num2= num[1];
                            var peso2=peso[1];
                            var volumen2=volumen[1];
                            var dist1 = dist[1];


                            var url2 =frg2;
                            var url3=num2;
                            var peso3=peso2;
                            var volumen3=volumen2;
                            var dist2 = dist1;


                            var frg3 = url2.split("<");
                            var num3=url3.split("<");
                            var peso4=peso3.split("<");
                            var volumen4=volumen3.split("<");
                            var dist3= dist2.split("<");

                            var cantidad= frg3[0];
                            var numProd= num3[0];
                            var peso5=peso4[0];
                            var volumen5=volumen4[0];
                            var dist4 = dist3[0];

                            for(var j=0; j<cantidad.length;j++){
                                if(cantidad.charAt(j)!=','){                           
                                  // alert("el caracter  es  :  " + cantidad.charAt(j));
                                  /*El precio del producto por si en determinado caso llegar a tener una coma****** 
                                    resulta=resulta.concat(cantidad.charAt(j));
                                }
                                else{
                                    resulta=resulta;
                                }
                            }
                            /*el número total de productos******
                            var total2= parseInt(numProd);
                            /*El total del peso******
                             totalP=totalP+ (total2*(parseInt(peso5)));
                             totalV=totalV+ (total2*(parseInt(volumen5)));
                             totalD=totalD+ (total2/(parseInt(dist4)));
                             /*El total del volumen ******
                           //  alert("el total del peso es : " + totalP)
                             //el iva que se le aplica al producto
                             total=total+(parseInt(resulta)*total2);
                             //los dos decimales que se le aplican a la cifra
                             total=round((total*1.16),2);

                    }
                    var totalf= total+"0";
                    totalf=comasMiles(totalf);
                    
                    $("#inveTable tbody")
                    .append("<tr style='font-size:20px; font-weight:bold; text-align:left;'>"+
                                "<td></td>"+
                                "<td></td>"+
                                "<td></td>"+
                                "<td colspan='6'><br> Importe: " +  totalf + " <br> El peso total es : " + totalP +  " el volumén total es : " + totalV + " <br> El Importe no incluye envío</td>"+
                            "</tr>"+
                            "<tr style='font-size:20px; font-weight:bold; text-align:left;'>"+
                                "<td></td>"+
                                "<td></td>"+
                                "<td></td>"+
                                "<td colspan='6'><br> Cajas: " + totalD +"</td>"+
                            "</tr>"
                            
                            );

                }
          
        } else {
            $("#btn-mostrar").text("Mostrar Captura");
            $(this).attr("data_control", "0");
            $(".textAre").hide();
            inveTable.filter(); // Remove all filters
            inveTable.search();
        }*/
    });
    
    //--Muestra todos los materiales de la tabla
    /*$("#btn-mostrarTodo").click(function() {
        inveTable.search();
    });*/
    
    //--Genera una recepción modelo con las cantidades capturadas
    $("#btn-modPed").click(function() {
        console.log("el valor del email es ");
        var email = $("#email").val();
        console.log(email);
        console.log('Actualizando archivo de Conversiones...');

        var ordComp = $("#ordComp").val();
        if (email && validateEmail(email) && ordComp) {
            var nomEvento = $(".info-evento .nomEvento").text();
            var prods = [];
            var idx = 0;
            var cap = false;
            var cant = 0;
            //Captura de conversion
            $.ajax({
                type: 'post',
                url: 'php/setConversions.php',
                data: {
                    'increment': 1,
                },
                //dataType: "json",
                success: function(data) {
                    //$("#content").html(data);
                    console.log('Conversion Guardada');
                }
            });
            //end Captura

            inveTable.reindex();
            var items = inveTable.items;
            for (var x in items) {
                cant = parseInt(items[x].values().cant);
                if (!isNaN(cant) && cant > 0) {
                    prods.push({
                        "cve_art"   : items[x].values().cve_art,
                        "cant"      : items[x].values().cant,
                        "costo_prom": items[x].values().costo_prom,
                        "precio"    : items[x].values().precio        
                     });
                     cap = true;
                }
            }
            if (cap) {
                var observaciones=$(".textAre").val();                
                $.post("php/ped_mail.php",{ prods, observaciones}).done(function(data) {    
                    if (data == "Message sent!") {
                        alert("Pedido enviado!");
                        window.location.href = window.location.href;
						} 
					else 
						{
                        alert("No se pudo envíar el pedido!");
                        window.location.href = window.location.href;    
                    }
                });
            } else {
                alert("Debes capturar al menos una cantidad para poder enviar el Pedido");
            }
        } else {
            alert("Debes capturar el correo y la orden de compra!");
        }
        
    });
	
});

function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

 //--Obtiene el texto de resultado de un evento
function getResultText(salidas, entradas) {
    if (salidas) {
        var resultado = salidas - entradas;
        var textResult = "Correcto ";
        if (resultado < 0) { textResult = "Sobran "; resultado = Math.abs(resultado); }
        else if (resultado > 0) { textResult = "Faltan "; }
        if (resultado != 0) {
            return textResult + resultado;
        } else {
            return textResult;
        }
    } else {
        return "- -";
    }
}

function round(number, precision) {
    var shift = function (number, precision, reverseShift) {
        if (reverseShift) {
            precision = -precision;
        }
        var numArray = ("" + number).split("e");
        return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
    };
    return shift(Math.round(shift(number, precision, false)), precision, true);
}
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}