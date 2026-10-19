$(document).ready(function () {
su();

$("#gp").click(function () {
    window.location.href = "datos_envio.php" + "?w1=" + cc;
});
$(".shopping_cart_dropdown").append("Tu pedido está en proceso");
$("#logout").click(function() {
    $.post('../php/usersession_V1.0.php', { logout: true }).done(function(data) {
        var response = JSON.parse(data);
        console.log(response);
        if ((response.message == 'Sesion Finalizada')) {
            toastr.info('Gracias por tu visita hasta pronto', 'Cerrando Sesion', { timeOut: 5000 });
            window.location.href = "../acceso";
        } else {
            toastr.error(response.message, 'ERROR', { timeOut: 3000 });
        }
    });
});

function su(){
    var arr=decodeBase64(cc);
    var obj = JSON.parse(arr); 
    var pe=0;var vo=0;var pi=0;var ca=0;var su=0;var en=0;var im=0;var to=0;var en=0;
    for (var x in obj) {
        console.log("el peso es:" + obj[x]["pe"]);
        pe=pe+parseFloat(obj[x]["pe"]);
        vo=vo+parseFloat(obj[x]["vo"]);
        pi=pi+parseInt(obj[x]["np"]);
        ca=ca+parseFloat(obj[x]["ue"]);
        su=su+parseFloat(obj[x]["pr"])*parseInt(obj[x]["np"]);
        
    }
    
    $("#pt").val(comasMiles(round(pe,2)));
    $("#vct").val(comasMiles(round(vo,2)));
    $("#pi").val(comasMiles(round(pi,2)));
    $("#nc").val(comasMiles(round((pi/ca),2)));
    $("#su").val("$"+comasMiles(round(su,2)));

    if(pe > vo){
        en=Math.trunc((160+(100*(Math.trunc(pe/5))))*(1.16));
    }
    else{
        en=Math.trunc((160+(100*(Math.trunc(vo/5))))*(1.16));
    }
    im=(su+en)*0.16;
    to=im+su+en;
    $("#en").val("$"+comasMiles(round(en,2)));
    $("#im").val("$"+comasMiles(round(im,2)));
    $("#to").val("$"+comasMiles(round(to,2)));


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
            for (i; i < 10; i++) {
                if (i == 2) {
                    valordef = valordef + "," + valord.charAt(i);
                } else {
                    valordef = valordef + valord.charAt(i);
                }
            }
        }
        return valordef;
    }
}

   



});