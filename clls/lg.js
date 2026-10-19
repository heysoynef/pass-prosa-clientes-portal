let loadingTimeout = null;

$("#btn-login").click(function () {
    var cmpUserName = $("#userName").val().trim();
    var cmpUserPsw  = $("#password").val().trim();

    // 1) Validaci��n previa: campos vac��os
    if (!cmpUserName || !cmpUserPsw) {
        Swal.fire({
            icon: "warning",
            title: "Faltan datos",
            text: "Por favor ingresa tu usuario y password.",
            confirmButtonColor: "rgb(45,90,72)",
            confirmButtonText: "De acuerdo",
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "ms/lg.php",
        dataType: "json",
        data: {
            userName: cmpUserName,
            userPsw: cmpUserPsw
        },
        beforeSend: function () {
            // 2) Mensaje inicial de espera
            Swal.fire({
                title: "Validando tus datos",
                text: "Por favor espera unos instantes.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Si la validaci��n tarda (ej. va a Firebird), cambiamos el mensaje
            loadingTimeout = setTimeout(() => {
                if (Swal.isLoading()) {
                    Swal.update({
                        title: "Estamos validando tus datos",
                        text: "Estamos consultando el sistema principal para cargar tu perfil. Esto puede tardar unos minutos. No cierres esta ventana.",
                        showConfirmButton: false 
                    });
                }
            }, 3500); // a los 3.5 segundos cambiamos el texto
        },
        success: function (data) {
            // Siempre limpiar timeout y cerrar el loader
            if (loadingTimeout) {
                clearTimeout(loadingTimeout);
                loadingTimeout = null;
            }
            Swal.close();

            console.log("Respuesta de login:", data);

            if (data && data.message === "usuarioBloqueado") {
                Swal.fire({
                    icon: "warning",
                    title: "Acceso no permitido",
                    text: "Este usuario no tiene acceso al portal de distribuidores.",
                    confirmButtonColor: "rgb(45,90,72)",
                    confirmButtonText: "Aceptar"
                });
            } else if (data && data.message === "usuarioAutenticado") {
                // 3A) Login correcto
                var status = data.status === "A" ? "ACTIVO" :
                             data.status === "S" ? "SUSPENDIDO" :
                             "MOROSO";

                $.post("sesiones/usersession_V1.0.php", {
                    set_userData: true,
                    userName: cmpUserName,
                    userPsw: cmpUserPsw,
                    clieNom: data.clieNom,
                    email: data.email,
                    facturacion: data.facturacion,
                    saldo: data.saldo,
                    limcred: data.limcred,
                    facts: data.facts,
                    status: status
                }).done(function () {
                    $.ajax({
                        type: "POST",
                        url: "ms/insertaAcceso.php",
                        success: function () {
                            // Si quieres, puedes mostrar un mini mensaje antes de redirigir
                            // Swal.fire({
                            //     icon: "success",
                            //     title: "�0�3Bienvenido!",
                            //     text: "Estamos preparando tu portal��",
                            //     showConfirmButton: false,
                            //     timer: 1000
                            // }).then(() => {
                            //     window.location.href = "https://portalclientes.prosanatural.com/";
                            // });

                            window.location.href = "./";
                        },
                        error: function () {
                            Swal.fire({
                                icon: "error",
                                title: "Ocurrio un problema",
                                text: "Tu sesi��n se valid��, pero no pudimos registrar el acceso. Intenta entrar de nuevo.",
                                confirmButtonColor: "rgb(45,90,72)"
                            });
                        }
                    });
                }).fail(function () {
                    Swal.fire({
                        icon: "error",
                        title: "Ocurrio un problema",
                        text: "No pudimos iniciar tu sesi��n. Por favor, intenta de nuevo.",
                        confirmButtonColor: "rgb(45,90,72)"
                    });
                });

            } else {
                // 3B) Usuario/contrase�0�9a incorrectos
                userIncorrecto(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (loadingTimeout) {
                clearTimeout(loadingTimeout);
                loadingTimeout = null;
            }
            Swal.close();

            console.error("Error en petici��n de login:", textStatus, errorThrown);
            Swal.fire({
                icon: "error",
                title: "No pudimos validar tus datos",
                text: "Hubo un problema al conectar con el servidor. Por favor, intenta nuevamente en unos minutos.",
                confirmButtonColor: "rgb(45,90,72)"
            });
        }
    });
});

// Mensaje para usuario/contrase�0�9a incorrectos
function userIncorrecto(data) {
    let msg = "Usuario o password incorrectos.";

    // Si m��s adelante distingues tipos de error desde PHP,
    // aqu�� podr��as personalizar el texto seg��n data.message.

    Swal.fire({
        icon: "warning",
        title: "No pudimos iniciar ",
        text: msg,
        confirmButtonColor: "rgb(45,90,72)",
        confirmButtonText: "Aceptar"
    });
}

// Recuperar credenciales (lo dejo como lo ten��as)
$("#getNewCredentialsBtn").click(function () {
    var serverResponse = new Array();
    $.ajax({
        type: "post",
        url: "./php/requireNewCredentials.php",
        data: {
            userNameRecCred: $("#cmpUsrRecCred").val(),
            userMailRecCred: $("#cmpMailRecCred").val()
        },
        success: function (data) {
            serverResponse = JSON.parse(data);
            console.log(serverResponse);
            if (serverResponse.message == "Message sent!") {
                toastr.success(
                    "En breve recibir��s respuesta a tu petici��n",
                    "Gracias",
                    { timeOut: 5000 }
                );
                $("#modalBodyContainer").replaceWith(
                    "<h3>Informaci��n enviada</h3></br><h5>Pulsa en Cerrar para salir de esta ventana</h5>"
                );
            } else {
                toastr.error(
                    "Reintenta nuevamente por favor...",
                    "ERROR",
                    { timeOut: 3000 }
                );
            }
        }
    });
});
