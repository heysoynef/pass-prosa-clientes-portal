$(() => {
    $('.btnRenvCorr').click(function (e) {
      e.preventDefault();
      var id = $('#idCompra').val();
      $('#mensaje').empty();
  
      var num = /^\d+$/;
      if (num.test(id)) {
        $.post('../php/consultDatos.php', { id }).done(function (dat) {
          var data = JSON.parse(dat);
          if (data.status === 'error') {
            $('#mensaje').append('No hay registro con ese ID ' + id);
          } else {
            var datosFiscales = data.datosFiscales;
            var datosEnvio = data.datosEnvio;
            var prods = data.prods;
            var datosAdicionales = data.datosAdicionales;
            var flete = data.flete;
            var cliente = data.cliente;
  
            var datos = {
              prods: prods,
              datosFiscales: datosFiscales,
              datosEnvio: datosEnvio,
              flete: flete,
              datosAdicionales: datosAdicionales,
              cliente: cliente
            };
            $.post('../php/reenviarCorreo.php', { datos }).done(function (dats) {
              // window.location.href='php/gracias.php';
            });
          }
        });
      } else {
          $('#mensaje').append('Ingrese un id valido ');
      }
    });
  });
  