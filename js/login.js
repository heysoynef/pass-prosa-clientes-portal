$.post("php/usersession.php", {get_userData: true}).done(function(data) {
    if (data) {
      
        var userData = JSON.parse(data);
        $.post("php/login_sae.php", {check: true, userName: userData.userName, userPsw: userData.userPsw})
            .done(function(data) {
            var check = JSON.parse(data);
            if (check.message == "false") {
              //  window.location.href = "../inventarioWeb/acceso";
              window.location.href = "acceso";

            } else {
                
               $("#userName").text(userData.userName);
                $("#clien").text(check.clieNom);
                $("#email").val(check.email);
            }
        });
    } else {
         //window.location.href = "../inventarioWeb/acceso";
         window.location.href = "acceso";
    }
});

$("#logout").click(function() {
    $.post("php/usersession.php", {logout: true}).done(function(data) {
       // window.location.href = "../inventarioWeb/acceso";
       window.location.href = "acceso";
    });
});

