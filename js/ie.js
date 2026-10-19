$(document).ready(function () {

    $("#regfis").select2({
        placeholder: "Selecciona una Opción de Régimen Fiscal",
        allowClear: true
      });
      $("#catcomp").select2({
        placeholder: "Selecciona una Opción del Catálogo de Uso de CFDI",
        allowClear: true
      });
      $("#metopagcfdi").select2({
        placeholder: "Selecciona una Opción del Catálogo de Uso de CFDI",
        allowClear: true
      });
      $("#formpagcfdi").select2({
        placeholder: "Selecciona una Opción del Catálogo de Método de Pago",
        allowClear: true
      });
      $("#single").select2({
        placeholder: "Selecciona tu estado",
        allowClear: true
      });
    
      $("#single2").select2({
        placeholder: "Código postal, colonia y municipio o alcaldía",
        allowClear: true,
        "language": {
          "noResults": function() {
            return "No hay resultados disponibles, checa que hayas seleccionado el estado o revisa tu busqueda ";
          }
        },
        escapeMarkup: function(markup) {
          return markup;
        }
    
      });
      $("#single3").select2({
        placeholder: "Selecciona tu estado",
        allowClear: true
      });
    
      $("#single4").select2({
        placeholder: "Código postal, colonia y municipio o alcaldía",
        allowClear: true,
        "language": {
          "noResults": function() {
            return "No hay resultados disponibles, checa que hayas seleccionado el estado o revisa tu busqueda ";
          }
        },
        escapeMarkup: function(markup) {
          return markup;
        }
    
      });





    const temp = [{
        "id": 1,
        "name": "Aguascalientes",
        "abr": "AG"
      },
      {
        "id": 2,
        "name": "Baja California",
        "abr": "BC"
      },
      {
        "id": 3,
        "name": "Baja California Sur",
        "abr": "BS"
      },
      {
        "id": 4,
        "name": "Campeche",
        "abr": "CM"
      },
      {
        "id": 5,
        "name": "Coahuila",
        "abr": "CO"
      },
      {
        "id": 6,
        "name": "Colima",
        "abr": "CL"
      },
      {
        "id": 7,
        "name": "Chiapas",
        "abr": "CS"
      },
      {
        "id": 8,
        "name": "Chihuahua",
        "abr": "CH"
      },
      {
        "id": 9,
        "name": "Ciudad de México",
        "abr": "DF"
      },
      {
        "id": 10,
        "name": "Durango",
        "abr": "DG"
      },
      {
        "id": 11,
        "name": "Guanajuato",
        "abr": "GT"
      },
      {
        "id": 12,
        "name": "Guerrero",
        "abr": "GR"
      },
      {
        "id": 13,
        "name": "Hidalgo",
        "abr": "HG"
      },
      {
        "id": 14,
        "name": "Jalisco",
        "abr": "JA"
      },
      {
        "id": 15,
        "name": "Estado de México",
        "abr": "MX"
      },
      {
        "id": 16,
        "name": "Michoacán",
        "abr": "MI"
      },
      {
        "id": 17,
        "name": "Morelos",
        "abr": "MO"
      },
      {
        "id": 18,
        "name": "Nayarit",
        "abr": "NA"
      },
      {
        "id": 19,
        "name": "Nuevo León",
        "abr": "NL"
      },
      {
        "id": 20,
        "name": "Oaxaca",
        "abr": "OA"
      },
      {
        "id": 21,
        "name": "Puebla",
        "abr": "PU"
      },
      {
        "id": 22,
        "name": "Querétaro",
        "abr": "QT"
      },
      {
        "id": 23,
        "name": "Quintana Roo",
        "abr": "QR"
      },
      {
        "id": 24,
        "name": "San Luis Potosí",
        "abr": "SL"
      },
      {
        "id": 25,
        "name": "Sinaloa",
        "abr": "SI"
      },
      {
        "id": 26,
        "name": "Sonora",
        "abr": "SO"
      },
      {
        "id": 27,
        "name": "Tabasco",
        "abr": "TB"
      },
      {
        "id": 28,
        "name": "Tamaulipas",
        "abr": "TM"
      },
      {
        "id": 29,
        "name": "Tlaxcala",
        "abr": "TL"
      },
      {
        "id": 30,
        "name": "Veracruz",
        "abr": "VE"
      },
      {
        "id": 31,
        "name": "Yucatán",
        "abr": "YU"
      },
      {
        "id": 32,
        "name": "Zacatecas",
        "abr": "ZA"
      }
    ];
    var $select = $('.estados');

    //alert(options);
    $.each(temp, function(id, name) {
      $select.append('<option value="' + name.abr + ',' + name.name + '">' + name.name + '</option>');
    });

    $('.estados').on('change', function() {
      $(".loader").fadeIn("slow");
      // Obtener el valor de la variable 'edoSeleccionado'
      var edoSeleccionado = ($('.estados').val()).substr(0, 2);
      // Construir la ruta del archivo JavaScript basada en el valor de 'edoSeleccionado'
      var rutaArchivo = 'js/edos/' + edoSeleccionado + '.js';
        fetch(rutaArchivo)
          .then(response => response.text()) // Convertir la respuesta a texto
          .then(scriptText => {
          // Evaluar el texto del script para ejecutarlo
            eval(scriptText);

            // Después de que el script se haya ejecutado, puedes utilizar las variables definidas en él
            // console.log("el estado seleccionado es: " + edoSeleccionado);
            var edoSeleccionadojson = estadosss;
            var edoSeleccionadolongitud = edoSeleccionadojson.length;
            document.getElementById("single2").options.length = 0;
            var $select = $('.codigoscolonias');
            $select.append('<option value=' + "Escribe tu Código Postal por número o por el nombre de tu Colonia" + '>' + "Escribe tu Código Postal por número o por el nombre de tu Colonia" + '</option>');

            for (var i = 0; i < edoSeleccionadolongitud; i++) {
              $select.append('<option>' + estadosss[i].city + ',' + estadosss[i].zip + '</option>');
            }
            $(".loader").fadeOut("slow");


        })
        .catch(error => {
          // Manejar errores si el archivo no puede ser cargado o evaluado
        //   console.error('Error al cargar el archivo:', error);
        });


    });





    var $select2 = $('.estados2');

    //alert(options);
    $.each(temp, function(id, name) {
      $select2.append('<option value="' + name.abr + ',' + name.name + '">' + name.name + '</option>');
    });

    $('.estados2').on('change', function() {
      $(".loader").fadeIn("slow");
      var edoSeleccionado = ($('.estados2').val()).substr(0, 2);
      // Construir la ruta del archivo JavaScript basada en el valor de 'edoSeleccionado'
      var rutaArchivo = 'js/edos/' + edoSeleccionado + '.js';
        fetch(rutaArchivo)
          .then(response => response.text()) // Convertir la respuesta a texto
          .then(scriptText => {
          // Evaluar el texto del script para ejecutarlo
            eval(scriptText);
            // Después de que el script se haya ejecutado, puedes utilizar las variables definidas en él
            // console.log("el estado seleccionado es: " + edoSeleccionado);
            var edoSeleccionadojson = estadosss;
            var edoSeleccionadolongitud = edoSeleccionadojson.length;
            document.getElementById("single4").options.length = 0;
            var $select = $('.codigoscolonias2');
            $select.append('<option value=' + "Escribe tu Código Postal por número o por el nombre de tu Colonia" + '>' + "Escribe tu Código Postal por número o por el nombre de tu Colonia" + '</option>');
            for (var i = 0; i < edoSeleccionadolongitud; i++) {
              $select.append('<option>' + estadosss[i].city + ',' + estadosss[i].zip + '</option>');
            }
            $(".loader").fadeOut("slow");
        })
        .catch(error => {
          // Manejar errores si el archivo no puede ser cargado o evaluado
          // console.error('Error al cargar el archivo:', error);
        });
    });

  });