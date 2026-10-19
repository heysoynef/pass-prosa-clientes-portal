$(document).ready(function () {
  var cc ="";
  if (pedsValue === "") {
     cc = new Array();
  } else {
      cc = JSON.parse(pedsValue);
      let totals = calculateTotals();
      updateShoppingCartDropdown(totals.nt, totals.ntp);
      $("#prectot").text(comasMiles(totals.ntp.toFixed(2)));
  }

  var st = 0;
  var sp = 0;
  var sv = 0;
  var sc = 0;
  
  // Variables globales para guardar los datos obtenidos
  var todosData = null;  // Datos de la consulta "todos"
  var otrosData = null;  // Datos de la consulta "Otros"

  // Función para filtrar los datos de "todos" en el cliente
  function filterTodos(di, data) {
    switch(di) {
      case "sd":
        return data.filter(function(item) { 
          return item.CAMPLIB11 === null; 
        });
      case "Cosméticos":
        return data.filter(function(item) { 
          return item.CAMPLIB12 && item.CAMPLIB12.substring(0,4) === "Cosm" && item.CAMPLIB11 === null; 
        });
      case "Suplementos Líquidos":
        return data.filter(function(item) { 
          return item.CAMPLIB12 && item.CAMPLIB12.substring(0,3) === "Sup" && item.CAMPLIB11 === null; 
        });
      case "Cápsulas":
        return data.filter(function(item) { 
          if(item.CAMPLIB12 && item.CAMPLIB11 === null && item.CAMPLIB12.charAt(0) === "C") {
            var sub = item.CAMPLIB12.substring(0,3);
            return sub !== "Cos" && sub !== "Cui";
          }
          return false;
        });
      case "Cuidado de la Piel":
        return data.filter(function(item) { 
          return item.CAMPLIB12 === "Cuidado de la Piel" && item.CAMPLIB11 === null; 
        });
      case "Jarabes":
        return data.filter(function(item) { 
          return item.CAMPLIB12 === "Jarabes" && item.CAMPLIB11 === null; 
        });
      case "Polvos":
        return data.filter(function(item) { 
          return item.CAMPLIB12 === "Polvos" && item.CAMPLIB11 === null; 
        });
    //   case "promociones":
    //     return data.filter(function(item) { 
    //       return item.CAMPLIB12 === "promociones" && item.CAMPLIB11 === null; 
    //   });
      default:
        return data.filter(function(item) { 
          return item.CAMPLIB11 !== null; 
        });
    }
  }

  // Función it() adaptada:
  // • Si se solicita "Otros", se hace la consulta a is.php con di:"Otros"
  // • Para cualquier otra categoría, se consulta (únicamente una vez) "todos" y se filtra en el cliente
  function it(di) {
    if (di == undefined || di == "Todos los productos") di = "sd";

    if (di === "Otros") {
      $.post("ms/is.php", { g_e: true, di: "Otros" }).done(function (d) {
        if (d != "nr") {
          otrosData = JSON.parse(d);
          dEC(d, di);
        } else {
          var dtp = [];
          dtp.push([null, null, null, null, null, null]);
          tp(dtp);
        }
      });
    } else {
      if (todosData !== null) {
        var filtered = filterTodos(di, todosData);
        dEC(JSON.stringify(filtered), di);
      } else {
        $.post("ms/is.php", { g_e: true, di: "todos" }).done(function (d) {
          if (d != "nr") {
            todosData = JSON.parse(d);
            var filtered = filterTodos(di, todosData);
            dEC(JSON.stringify(filtered), di);
          } else {
            var dtp = [];
            dtp.push([null, null, null, null, null, null]);
            tp(dtp);
          }
        });
      }
    }
  }

  // Llamada inicial (se carga la categoría por defecto "sd" mediante la consulta de "todos")
  it("sd");

  $(".dataTables_length").css({ color: "white" });
  //$("#shopping_cart_dropdown").append("No tienes algún producto agregado");
  $("#gp").click(function () {
    prm();
  });
  $(".me").click(function () {
    $(".loader").fadeIn("slow");
    var val = $(this).attr("id");
    it(val);
    $(".loader").fadeOut("slow");
  });
  $("#tpr").change(function () {
    var val = $(this).val();
    it(val);
  });
  $(".gp").click(function () {
    dEC2();
  });
  facts();

  // --------------------- Resto del código ORIGINAL ---------------------
  function dEC(d, di) {
      var prodproh = 0;
      var prod = "";
      var dtp = [];
      var mediaqueryList = window.matchMedia("(max-width: 720px)");
      if (d != "nr") {
        var p = JSON.parse(d);
        for (var x in p) {
          prodproh++;
          if (
            p[x] != null &&
            p[x]["CVE_ART"] != undefined &&
            p[x]["CVE_ART"] != "12106"  &&
            p[x]["CVE_ART"] != "KIT-BE-08" &&
            p[x]["CVE_ART"] != "KIT-BE-09" &&
            p[x]["CVE_ART"] != "KIT-BE-07" 
          ) {
            prod = p[x]["DESCR"];
            if (p[x]["CVE_ART"] == 12100) {
              prod = "BEBIDA SABILA 1 LT. ";
            }
            if (p[x]["CVE_ART"] == 12102) {
              prod = "BEBIDA SAB,NOP Y CUACHALALATE 1LT.";
            }
            if (p[x]["CVE_ART"] == 12176) {
              prod = "BEBIDA SABILA Y NOPAL 1LT. ";
            }
  
            if (mediaqueryList.matches) {
              //productos para celular
              if (p[x]["EXIST"] > 50) {
                dtp.push([
                  "<div class='row' style='display: contents;'><div class='dvi' align='center'><img loading='lazy' src='Imagenes/" +
                    p[x]["CVE_ART"] +
                    ".jpg' border='0' width='50' height='42'></div><div class='dvi'><div class='cv' name='cc' id='ac" +
                    p[x]["CVE_ART"] +
                    "' data-value='" +
                    p[x]["CVE_ART"] +
                    "---" +
                    p[x]["DESCR"] +
                    "---" +
                    p[x]["PRECIO"] +
                    "---" +
                    p[x]["PESO"] +
                    "---" +
                    p[x]["VOLUMEN"] +
                    "---" +
                    p[x]["UNI_EMP"] +
                    "'></div>",
                  p[x]["CVE_ART"],
                  '<div class="row may">' +
                    prod +
                    '</div><input type="button" name="pr" class="pr" value="-" id="' +
                    p[x]["CVE_ART"] +
                    '"> <input class="prc" type="text" name="can" id="can' +
                    p[x]["CVE_ART"] +
                    '"> <input type="button" class="pr" name="pr" id="' +
                    p[x]["CVE_ART"] +
                    '" value="+">',
                  "<p>" +
                    round(p[x]["PRECIO"], 2) +
                    "</p>" +
                    "<p  id='pr" +
                    p[x]["CVE_ART"] +
                    "' data-value='" +
                    p[x]["PRECIO"] +
                    "' val='1212'></p>",
                ]);
              } else {
                dtp.push([
                  "<div class='row' style='display: contents;'><div class='dvi' align='center'><img loading='lazy' src='Imagenes/" +
                    p[x]["CVE_ART"] +
                    ".jpg' border='0' width='50' height='42'></div>",
                  p[x]["CVE_ART"],
                  '<div class="row may">' +
                    prod +
                    "</div>" +
                    '<label style="width:100%;color:#d83d19;text-align:center;font-weight:700;" for="exampleInputEmail1">AGOTADO</label>',
                  "<p>" + p[x]["PRECIO"] + "</p>",
                ]);
              }
              if ((di == "Cápsulas" || di == "sd") && prodproh == 9) {
                dtp.push([
                  "<div class='dvi' align='center'><img loading='lazy' src='Imagenes/10257.jpg' border='0' width='50' height='42'></div>",
                  "",
                  "",
                  "<div class='me carrprodproh' name='me' id='Otros'></div>",
                ]);
              }
            } else {
              //productos para computadora de escritorio
              if (p[x]["EXIST"] > 50) {
                dtp.push([
                  "<div class='dvi' align='center'><img loading='lazy' src='Imagenes/" +
                    p[x]["CVE_ART"] +
                    ".jpg' border='0' width='50' height='42'></div>",
                  p[x]["CVE_ART"],
                  prod,
                  round(p[x]["PRECIO"], 2),
                  '<input type="button" name="pr" class="pr" value="-" id="' +
                    p[x]["CVE_ART"] +
                    '"> <input class="prc" type="text" name="can" id="can' +
                    p[x]["CVE_ART"] +
                    '"> <input type="button" class="pr" name="pr" id="' +
                    p[x]["CVE_ART"] +
                    '" value="+">',
                  "<p id='pr" +
                    p[x]["CVE_ART"] +
                    "' data-value='" +
                    round(p[x]["PRECIO"], 2) +
                    "' val='1212'></p>",
                  "<div class='cv' name='cc' id='ac" +
                    p[x]["CVE_ART"] +
                    "' data-value='" +
                    p[x]["CVE_ART"] +
                    "---" +
                    p[x]["DESCR"] +
                    "---" +
                    round(p[x]["PRECIO"], 2) +
                    "---" +
                    p[x]["PESO"] +
                    "---" +
                    p[x]["VOLUMEN"] +
                    "---" +
                    p[x]["UNI_EMP"] +
                    "'></div>",
                ]);
              } else {
                dtp.push([
                  "<div class='dvi' align='center'><img loading='lazy' src='Imagenes/" +
                    p[x]["CVE_ART"] +
                    ".jpg' border='0' width='50' height='42'></div>",
                  p[x]["CVE_ART"],
                  prod,
                  round(p[x]["PRECIO"], 2),
                  '<label style="width:100%;color:#d83d19;text-align:center;font-weight:700;" for="exampleInputEmail1">SIN EXISTENCIAS</label>',
                  "",
                  "",
                ]);
              }
              if ((di == "Cápsulas" || di == "sd") && prodproh == 9) {
                dtp.push([
                  "<div class='dvi' align='center'><img loading='lazy' src='Imagenes/10257.jpg' border='0' width='50' height='42'></div>",
                  "",
                  "",
                  "",
                  "",
                  "",
                  "<div class='me carrprodproh' name='me' id='Otros'></div>",
                ]);
              }
            }
          }
        }
      } else {
        dtp.push([null, null, null, null, null, null, null]);
      }
      tp(dtp);
  }

  function tp(d) {
    var mediaqueryList = window.matchMedia("(max-width: 720px)");
    if (mediaqueryList.matches) {
      var tabla = $("#pdMov").DataTable({
        data: d,
        responsive: true,
        language: {
          decimal: ".",
          thousands: ",",
          lengthMenu: "Mostrando _MENU_ productos por página",
          zeroRecords:
            "No se encuentra disponible este producto o busca el producto por su descripción o sku",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No se encontraron resultados",
          search: "",
          searchPlaceholder: "Quiero encontrar",
          infoFiltered: "(Filtrando de _MAX_ total de registros)",
          paginate: {
            previous: "Anterior",
            next: "Siguiente",
          },
        },
        pageLength: 120,
        bDestroy: true,
        columns: [
          { title: "", className: "dt-body-right" },
          { title: "SKU", className: "dt-body-right" },
          { title: "PRODUCTO", className: "dt-body-right" },
          { title: "PRECIO", className: "dt-body-right" },
        ],
      });
    } else {
      var tabla = $("#pdEs").DataTable({
        data: d,
        language: {
          decimal: ".",
          thousands: ",",
          lengthMenu: "Mostrando _MENU_ productos por página",
          zeroRecords:
            "No se encuentra disponible este producto o busca el producto por su descripción o sku",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No se encontraron resultados",
          search: "",
          searchPlaceholder: "Quiero encontrar",
          infoFiltered: "(Filtrando de _MAX_ total de registros)",
          paginate: {
            previous: "Anterior",
            next: "Siguiente",
          },
        },
        pageLength: 120,
        bDestroy: true,
        columns: [
          { title: "", width: "5%" },
          { title: "SKU", width: "5%" },
          { title: "PRODUCTO", width: "40%" },
          { title: "PRECIO", width: "10%" },
          { title: "CANTIDAD", width: "25%" },
          { title: "TOTAL", width: "10%" },
          { title: "", width: "10%" },
        ],
      });
    }
    $("input[name='pr']").click(function () {
      var id = $(this).attr("id");
      var val = $(this).val();
      var can = $("#can" + id).val();
      var dvcv = $("#ac" + id).attr("data-value");
      dvcv = dvcv.split("---");
      $("#pr" + id).empty();
  
      if (can == "") {
        if (val == "+") {
          can = 1;
          $("#can" + id).val("1");
          $("#ac" + id)
            .addClass("cll")
            .removeClass("cv");
        } else {
          $("#can" + id).val("0");
          can = 0;
        }
      } else {
        if (val == "+") {
          can = parseFloat(can) + 1;
          $("#can" + id).val(can);
          if (can == 1)
            $("#ac" + id)
              .addClass("cll")
              .removeClass("cv");
        } else {
          if (can > 0) {
            can = parseFloat(can) - 1;
            $("#can" + id).val(can);
            if (can == 0)
              $("#ac" + id)
                .addClass("cv")
                .removeClass("cll");
          }
        }
      }
      ag(dvcv[0], dvcv[1], dvcv[2], dvcv[3], dvcv[4], dvcv[5], can);
      var pr = parseFloat($("#pr" + id).attr("data-value")) * parseFloat(can);
      $("#pr" + id).append(comasMiles(pr.toFixed(2)));
    });
  
    $("input[name='can']").keyup(function () {
      var val = parseFloat($(this).val());
      var id = $(this).attr("id");
      id = id.replace("can", "");
      $("#pr" + id).empty();
  
      if (val == "") {
      } else {
        if (isNaN(val) || val < 0) {
          $(this).val("");
          alert("Ingresa un valor válido");
          $("#ac" + id)
            .addClass("cv")
            .removeClass("cll");
          $("#pr" + id).append("");
          rm(id);
        } else {
          var dvcv = $("#ac" + id).attr("data-value");
  
          dvcv = dvcv.split("---");
          ag(dvcv[0], dvcv[1], dvcv[2], dvcv[3], dvcv[4], dvcv[5], val);
          var pr = parseFloat($("#pr" + id).attr("data-value")) * parseFloat(val);
          $("#pr" + id).append(comasMiles(pr.toFixed(2)));
          $("#ac" + id)
            .addClass("cll")
            .removeClass("cv");
        }
      }
    });
  
    if (window.matchMedia("(max-width: 720px)").matches) {
      $("select[name=pdMov_length]").val(10);
      $("select[name=pdMov_length]").change();
    } else {
      $("select[name=pdEs_length]").val(10);
      $("select[name=pdEs_length]").change();
    }
    $(".dataTables_length").css({ display: "none" });
    $(".me").click(function () {
      var val = $(this).attr("id");
      it(val);
    });
  }
  
  function updateShoppingCartDropdown(nt, ntp) {
      $(".shopping_cart_dropdown").empty();
      $(".texto-encima").empty();
  
      if (cc.length === 0) {
          $(".shopping_cart_dropdown").append("No tienes algún producto agregado");
      } else {
          $(".shopping_cart_dropdown").append('<div class="row" style="padding-bottom: 15px;"><button type="button" class="gpvp btn gp" style="font-family: Exo, sans-serif;width:100%;" data-toggle="modal" data-target=".bd-example-modal-xl">VER PEDIDO</button></div>');
          cc.forEach(item => {
              if (item["np"] > 0) {
                  $(".shopping_cart_dropdown").append(
                      '<div class="row" style="border-bottom: 0px solid white;margin-bottom:10px;">' +
                      '<div class="col-md-5"><img loading="lazy" style="width:100%;" src="Imagenes/' + item["cv"] + '.jpg"></div>' +
                      '<div class="col-md-7"><p style="font-size:12px;margin-bottom:0px;">' + item["de"] + '</p>' +
                      '<p style="font-size:20px;margin-bottom:0px;font-weight:100;">' + item["pr"] + '</p>' +
                      '<p style="font-size:12px;margin-bottom:0px;">Cantidad: ' + item["np"] + '</p></div></div>'
                  );
              }
          });
          $(".shopping_cart_dropdown").append('<div class="row" style="border-top: 2px solid rgb(35,112,45);"><p class="tot">TOTAL: $' + comasMiles(ntp.toFixed(2)) + "</p></div>");
          $(".shopping_cart_dropdown").append('<div class="row"><button type="button" style="width:100%;" class="btn cpE gp2" name="">Generar Pedido</button></div>');
          $(".gp2").click(function () {
              prm();
          });
          $(".gp").click(function () {
            dEC2();
          });
  
      }
      $(".texto-encima").append(comasMiles(round(nt, 2)));
  }
  
  function calculateTotals() {
      let nt = 0;
      let ntp = 0;
      cc.forEach(item => {
          nt += parseFloat(item["np"]);
          ntp += parseFloat(item["pr"]) * parseFloat(item["np"]);
      });
      return { nt, ntp };
  }
  
  function updateSession() {
      var w1 = JSON.stringify(cc);
      $.post("php/pedses.php", { peds: w1 }).done(function (data) {});
  }
  
  function addItemToCart(cv, de, pr, pe, vo, ue, np) {
      let itemExists = false;
      cc.forEach(item => {
          if (item["cv"] === cv) {
              item["np"] = np;
              itemExists = true;
          }
      });
      if (!itemExists) {
        cc.push({cv: cv, de: de, pr: parseFloat(pr).toFixed(2), vo: vo, pe: pe, ue: ue, np: np});
      }
      let totals = calculateTotals();
      updateSession();
      updateShoppingCartDropdown(totals.nt, totals.ntp);
      $("#prectot").text(comasMiles(totals.ntp.toFixed(2)));
  }
  
  function removeItemFromCart(cv) {
      cc = cc.filter(item => item["cv"] !== cv);
      let totals = calculateTotals();
      updateSession();
      updateShoppingCartDropdown(totals.nt, totals.ntp);
  }
  
  // Función para manejar el evento de agregar al carrito
  function ag(cv, de, pr, pe, vo, ue, np) {
      addItemToCart(cv, de, pr, pe, vo, ue, np);
      $(".am").click(function () {
          $(".gpvp").trigger("click");
      });
  }
  
  // Función para manejar el evento de remover del carrito
  function rm(cv) {
      removeItemFromCart(cv);
  }
  
  function prm() {
    var st = 0;
    var pe = 0;
    var vo = 0;
    var pi = 0;
    var ca = 0;
    var su = 0;
    var en = 0;
    var en2 = 0;
  
    for (var x in cc) {
      np = parseFloat(cc[x]["np"]);
      if (np > 0) {
        pr = parseFloat(cc[x]["pr"]);
        to = pr * np;
        st = st + to;
        pe = pe + parseFloat(cc[x]["pe"]) * np;
        vo = vo + parseFloat(cc[x]["vo"]) * np;
        pi = pi + parseFloat(cc[x]["np"]);
        ca = ca + np * (1 / parseFloat(cc[x]["ue"]));
        su = su + parseFloat(cc[x]["pr"]) * np;
      }
    }
    if (st < 2000) {
      alert("Tu pedido debe tener un Importe mínimo de compra de $2,000 MXN antes de impuestos");
    } else {
      if (id == 3981) {
        var w1 = JSON.stringify(cc);
        $.post("php/pedses.php", { peds: w1 }).done(function (data) {});
        if (navigator.userAgent.search("Firefox") >= 0) {
          window.open("datos_envio.php", "_blank");
          window.close();
        } else {
          window.open("datos_envio.php", "_self");
        }
      } else {
        var prods = cc;
        var datosFiscales = "";
        var datosEnvio = "";
  
        toastr.info("Procesando pedido...");
  
        prods.push({
          email: mail,
          ordComp: "",
          observaciones: "",
        });
  
        if (factus == "S") {
          en = 0;
          $(".enenvio").addClass("ocultar");
        } else {
          if (pe > vo) {
            en = Math.trunc(200 + 100 * Math.trunc(pe / 5));
          } else {
            en = Math.trunc(200 + 100 * Math.trunc(vo / 5));
          }
        }
  
        su = su;
        im = (en + su) * 0.16;
        to = su + en + im;
  
        pe = pe.toFixed(2);
        vo = vo.toFixed(2);
        ca = ca.toFixed(2);
        su = comasMiles(su.toFixed(2));
        en2 = en.toFixed(2);
        en = comasMiles(en.toFixed(2));
        im = comasMiles(im.toFixed(2));
        to = comasMiles(to.toFixed(2));
  
        var flete = new Array(en, su, im, to, en2);
        var datosAdicionales = new Array(pe, vo, ca);
  
        var datos = {
          prods: prods,
          datosFiscales: datosFiscales,
          datosEnvio: datosEnvio,
          flete: flete,
          datosAdicionales: datosAdicionales,
        };


        $.post("ms/insertDatosCompra.php", {datos}).done(function (data) {
          var p = JSON.parse(data);
        
          if (p.estatus.includes('Exito')) {
              $.post("php/ped_mail_V1.0.php", { datos }).done(function (data) {
                console.log("el mensaje es:" + data + ".");

                if (data.includes('Exito')) {
                  console.log("el mensaje es:" + data + ".");
                  window.location.href='gracias';
                }
              }); 
          }
      })
      }
    }
  }
  
  function cp(d) {
    var mediaqueryList = window.matchMedia("(max-width: 720px)");
  
    if (mediaqueryList.matches) {
      var tabla = $("#cp2").DataTable({
        data: d,
        deferRender: true,
        paginate: false,
        language: {
          decimal: ".",
          thousands: ",",
          lengthMenu: "Mostrando _MENU_ resultados por página",
          zeroRecords: "No hay productos agregados al pedido",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No se encontraron resultados",
          infoFiltered: "(Filtrando de _MAX_ total de registros)",
          paginate: {
            previous: "Anterior",
            next: "Siguiente",
          },
        },
        pageLength: 10,
        bDestroy: true,
        searching: false,
        columns: [
          { title: "", width: "10%" },
          { title: "SKU", width: "10%" },
          { title: "PRODUCTO", width: "70%" },
          { title: "PRECIO", width: "10%" },
        ],
      });
    } else {
      var tabla = $("#cp").DataTable({
        data: d,
        deferRender: true,
        paginate: false,
        language: {
          decimal: ".",
          thousands: ",",
          lengthMenu: "Mostrando _MENU_ resultados por página",
          zeroRecords: "No hay productos agregados al pedido",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No se encontraron resultados",
          infoFiltered: "(Filtrando de _MAX_ total de registros)",
          paginate: {
            previous: "Anterior",
            next: "Siguiente",
          },
        },
        pageLength: 10,
        bDestroy: true,
        searching: false,
        columns: [
          { title: "", className: "cb" },
          { title: "" },
          { title: "SKU" },
          { title: "PRODUCTO" },
          { title: "PRECIO" },
          { title: "CANTIDAD" },
          { title: "TOTAL" },
        ],
      });
    }
  
    /*CLIC AL BOTE DE BASURA */
    $("div[name='ec']").click(function () {
      var cp = $(this).attr("id");
      rm(cp);
      $("#can" + cp).val("");
      $("#pr" + cp).empty();
      dEC2();
    });
  
    $("input[name='pr2']").click(function () {
      var id = $(this).attr("id");
      var val = $(this).val();
      var can = $("#can2" + id).val();
      $("#pr" + id).empty();
      $("#pr2" + id).empty();
  
      if (val == "+") {
        can = parseFloat(can) + 1;
        $("#can2" + id).val(can);
        $("#can" + id).val(can);
      } else {
        if (can > 0) {
          can = parseFloat(can) - 1;
          $("#can2" + id).val(can);
          $("#can" + id).val(can);
        }
      }
  
      var pr = parseFloat($("#pr2" + id).attr("data-value")) * parseFloat(can);
      $("#pr" + id).append(comasMiles(pr.toFixed(2)));
      $("#pr2" + id).append(comasMiles(pr.toFixed(2)));
      ag(id, "", "", "", "", "", can);
      dEC2();
    });
  
    $("input[name='can2']").keyup(function () {
        var val = parseFloat($(this).val());
        var id = $(this).attr("id").replace("can2", "");
        $("#pr" + id).empty();
        $("#pr2" + id).empty();
    
        if (val === "" || isNaN(val) || val < 0) {
         
                val = 1;
                $(this).val(val);
                var dvcv = $("#ac" + id).attr("data-value");
                dvcv = dvcv.split("---");
                var pr = parseFloat(dvcv[4]) * val;
                $("#pr" + id).append(comasMiles(pr.toFixed(2)));
                $("#pr2" + id).append(comasMiles(pr.toFixed(2)));
    
                $("#can" + id).val(val);
    
                ag(id, "", "", "", "", "", val);
                dEC2();
    
        } else {
            var dvcv = $("#ac" + id).attr("data-value");
                dvcv = dvcv.split("---");
                var pr = parseFloat(dvcv[4]) * val;
                $("#pr" + id).append(comasMiles(pr.toFixed(2)));
                $("#pr2" + id).append(comasMiles(pr.toFixed(2)));
    
                $("#can" + id).val(val);
    
                ag(id, "", "", "", "", "", val);
                dEC2();
        }
    });
  }
  
  function dEC2() {
    var dtp = [];
    var cv;
    var np;
    var de;
    var pr;
    var to = 0;
    var st = 0;
    var im = 0;
    var pe = 0;
    var vo = 0;
    var pi = 0;
    var ca = 0;
    var en = 0;
    var su = 0;
    var mediaqueryList = window.matchMedia("(max-width: 720px)");
    for (var x in cc) {
      np = parseFloat(cc[x]["np"]);
      if (np > 0) {
        cv = cc[x]["cv"];
        de = cc[x]["de"];
        pr = parseFloat(cc[x]["pr"]);
        to = pr * np;
        st = st + to;
        pe = pe + np * parseFloat(cc[x]["pe"]);
        vo = vo + np * parseFloat(cc[x]["vo"]);
        pi = pi + parseFloat(cc[x]["np"]);
        ca = ca + np * (1 / parseFloat(cc[x]["ue"]));
        su = su + np * parseFloat(cc[x]["pr"]);
  
        if (mediaqueryList.matches) {
          dtp.push([
            "<img loading='lazy' src='Imagenes/" + cv + ".jpg' border='0' width='50' height='42'><div class='boba' name='ec' id='" + cv + "'></div>",
            cv,
            '<div class="row may">' + de + '</div><input type="button" name="pr2" class="pr" value="-" id="' + cv + '"> <input class="prc" type="text" name="can2" id="can2' + cv + '" value="' + np + '"> <input type="button" class="pr" name="pr2" id="' + cv + '" value="+">',
            "<p>" + pr + "</p><p id='pr2" + cv + "' data-value='" + pr + "'>" + comasMiles(to.toFixed(2)) + "</p>",
          ]);
        } else {
          dtp.push([
            "<div class='boba' name='ec' id='" + cv + "'></div>",
            "<div class='dvi' align='center'><img loading='lazy' src='Imagenes/" + cv + ".jpg' border='0' width='50' height='42'></div>",
            cv,
            de,
            pr,
            '<input type="button" name="pr2" class="pr" value="-" id="' + cv + '"> <input class="prc" type="text" name="can2" id="can2' + cv + '" value="' + np + '"> <input type="button" class="pr" name="pr2" id="' + cv + '" value="+">',
            "<p class='prc' id='pr2" + cv + "' data-value='" + pr + "'>" + comasMiles(to.toFixed(2)) + "</p>",
          ]);
        }
      }
    }
  
    $("#vct").empty();
    $("#pi").empty();
    $("#nc").empty();
    $("#pt").empty();
    $("#st").empty();
    $("#en").empty();
    $("#im").empty();
    $("#to").empty();
  
    $("#pt").append(comasMiles(pe.toFixed(2)));
    $("#vct").append(comasMiles(vo.toFixed(2)));
    $("#pi").append(comasMiles(pi.toFixed(2)));
    $("#nc").append(comasMiles(ca.toFixed(2)));
    if (factus == "S") {
      en = 0;
      $(".enenvio").addClass("ocultar");
    } else {
      if (pe > vo) {
        en = Math.trunc(200 + 100 * Math.trunc(pe / 5));
      } else {
        en = Math.trunc(200 + 100 * Math.trunc(vo / 5));
      }
    }
  
    st = st;
    im = (en + st) * 0.16;
    to = st + en + im;
    $("#en").append("<div style='float:left'>$</div>" + comasMiles(en.toFixed(2)));
    $("#st").append("<div style='float:left'>$</div>" + comasMiles(st.toFixed(2)));
    $("#im").append("<div style='float:left'>$</div>" + comasMiles(im.toFixed(2)));
    $("#to").append("<div style='float:left'>$</div>" + comasMiles(to.toFixed(2)));
  
    cp(dtp);
  }
  
  function itsf() {
    $.post("ms/is.php", { itsf: true, di: "sd" }).done(function (d) {
      var dtp = [];
      if (d != "0 results") {
        var p = JSON.parse(d);
        var importe = 0;
        for (var x in p) {
          if (p[x]["NO_FACTURA"] != null && p[x]["NO_FACTURA"] != undefined) {
            if (
              p[x]["IMP1"] != null &&
              p[x]["IMP2"] != undefined &&
              p[x]["IMP2"] != null &&
              p[x]["IMP2"] != undefined
            ) {
              importe = parseInt(p[x]["IMP1"]) - parseInt(p[x]["IMP2"]);
              if (importe > 0) {
                importe = parseFloat(p[x]["IMP1"]) - parseFloat(p[x]["IMP2"]);
              }
            } else {
              if (p[x]["IMP1"] == null || p[x]["IMP1"] == undefined) {
                importe = parseFloat(p[x]["IMP2"]);
              } else if (p[x]["IMP2"] == null || p[x]["IMP2"] == undefined) {
                importe = parseFloat(p[x]["IMP1"]);
              }
            }
            if (importe > 0) {
              dtp.push([
                p[x]["NO_FACTURA"],
                p[x]["FECHA_APLI"].slice(0, 10),
                p[x]["FECHA_VENC"].slice(0, 10),
                comasMiles(round(importe, 2)),
              ]);
            }
          }
        }
      } else {
        dtp.push([null, null, null, null, null]);
      }
      tpitsf(dtp);
    });
  }
  
  function tpitsf(d) {
    var tabla = $("#facts").DataTable({
      data: d,
      responsive: true,
      language: {
        decimal: ".",
        thousands: ",",
        lengthMenu: "Mostrando _MENU_ productos por página",
        zeroRecords: "No debes en este momento alguna factura",
        info: "Mostrando página _PAGE_ de _PAGES_",
        infoEmpty: "No debes en este momento alguna factura",
        search: "",
        searchPlaceholder: "Quiero encontrar",
        infoFiltered: "(Filtrando de _MAX_ total de registros)",
        paginate: {
          previous: "Anterior",
          next: "Siguiente",
        },
      },
      bDestroy: true,
      searching: false,
      columns: [
        { title: "Clave de Factura", className: "dt-body-right" },
        { title: "Fecha de Elaboración", className: "dt-body-right" },
        { title: "Fecha Limite de Pago", className: "dt-body-right" },
        { title: "Pago Pendiente", className: "text-right" },
      ],
    });
  
    $(".loader").fadeOut("slow");
  }
  
  function round(number, precision) {
    var shift = function (number, precision, reverseShift) {
      if (reverseShift) {
        precision = -precision;
      }
      var numArray = ("" + number).split("e");
      return +(
        numArray[0] +
        "e" +
        (numArray[1] ? +numArray[1] + precision : precision)
      );
    };
    return shift(Math.round(shift(number, precision, false)), precision, true);
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
      } else if (valor < 100000) {
        for (i; i < 10; i++) {
          if (i == 2) {
            valordef = valordef + "," + valord.charAt(i);
          } else {
            valordef = valordef + valord.charAt(i);
          }
        }
      } else if (valor < 1000000) {
        for (i; i < 11; i++) {
          if (i == 3) {
            valordef = valordef + "," + valord.charAt(i);
          } else {
            valordef = valordef + valord.charAt(i);
          }
        }
      } else if (valor < 10000000) {
        for (i; i < 12; i++) {
          if (i == 1) {
            valordef = valordef + "," + valord.charAt(i);
          } else if (i == 4) {
            valordef = valordef + "," + valord.charAt(i);
          } else {
            valordef = valordef + valord.charAt(i);
          }
        }
      } else if (valor < 100000000) {
        for (i; i < 13; i++) {
          if (i == 2) {
            valordef = valordef + "," + valord.charAt(i);
          } else if (i == 5) {
            valordef = valordef + "," + valord.charAt(i);
          } else {
            valordef = valordef + valord.charAt(i);
          }
        }
      }
      return valordef;
    }
  }
  
  function formatoF(texto) {
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, "$3/$2/$1");
  }
  
  function facts() {
    var factus=100000;
    if (factus != "S") {
      $(".facturasSaldo").addClass("ocultar");
      $(".loader").fadeOut("slow");
    } else {
      $("#saldopendienteIA").text(comasMiles(parseFloat(saldo).toFixed(2)));
      $("#creditoIA").text(comasMiles(parseFloat(limcred).toFixed(2)));
      if (factus != "0") {
        itsf();
      } else {
        var dtp = [];
        dtp.push([null, null, null, null]);
        tpitsf(dtp);
      }
    }
  }
});
