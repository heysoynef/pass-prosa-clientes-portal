$("#logout").click(function() {
        $.post("sesiones/usersession_V1.0.php", { logout: true }).done(function(data) {
            var response = JSON.parse(data);
            console.log(response);
            if ((response.message == 'Sesion Finalizada')) {
                toastr.info('Gracias por tu visita hasta pronto', 'Cerrando Sesion', { timeOut: 1000 });
                setTimeout(() => {//agregue
                    window.location.href = "acceso";                    
                }, 1500);
            } else {
                toastr.error(response.message, 'ERROR', { timeOut: 3000 });
            }
        });
});


$("#logoutMovil").click(function() {
    console.log("has dado clic");
  $.post("sesiones/usersession_V1.0.php", { logout: true }).done(function(data) {
            var response = JSON.parse(data);
            console.log(response);
            if ((response.message == 'Sesion Finalizada')) {
                toastr.info('Gracias por tu visita hasta pronto', 'Cerrando Sesion', { timeOut: 1000 });
                setTimeout(() => {//agregue
                    window.location.href = "acceso";                    
                }, 1500);
            } else {
                toastr.error(response.message, 'ERROR', { timeOut: 3000 });
            }
        });
});

