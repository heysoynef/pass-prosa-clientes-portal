/*
 *   Created By:     SDE. Alfredo Jimenez Miguel.
 *   Company:        PASS Consultores.
 *   Date:           Oct 2019--$('#buscadorModal input:search').val('');
 */
//region Main function by Document ready
$(document).ready(function() {
    var dir_imagenes = "../Imagenes/";
    var TotalesDePesoPartidas = new Array();
    var TotalesDeVolumenPartidas = new Array();
    var TotalesDeEmpaquesPartidas = new Array();
    var TotalesPreciosPromedio = new Array();
    //var TotalesCantidadesPartidas = new Array();
    //var TotalesCvesPartidas = new Array();
    var prods = new Array();


    var arrayPesos = new Array();
    var arrayVolums = new Array();
    var arrayEmpaques = new Array();
    var cantidadRec = 0;
    var result;
    var arreglosActualizados;
    //var mainData = new Array();
    //region Modal 
    //Images

    $('.prod_image').click(function(e) {
        var sourceimg = e.target.src;
        var modal = '<div class="modal" id="modal"><img src="' + sourceimg + '" class="modal__img"><div class="modal__boton" id="modal__boton">X</div></div>';
        $('body').append(modal);
        $('#modal__boton').click(function() {
            $('#modal').remove();
            modal = null;
        })
    });

    $("#btnAceptar").click(function() {
        var costoTotal = $('#cmpSubTotales').val();
        if($('#usuario').text()=='3981'){
            // alert(validarSubtotal(costoTotal));
             if (validarSubtotal(costoTotal)==true) {
                     $("#btnDatosEnvio").click();
             }
             else {
                 toastr.error("El Pedido debe de tener un importe mayor a 2000 pesos", 'ERROR', { timeOut: 3000 });
                 return;
             }
        }
        else{
            if (validarSubtotal(costoTotal)==true) {
                sendOrder();
            }
            else {
                toastr.error("El Pedido debe de tener un importe mayor a 2000 pesos", 'ERROR', { timeOut: 3000 });
                return;
            }
        }
       
    });
    
    $("#enviarInfoFiscalEnvio").click(function() {

        if($("#nombreFiscal").val()=='' || $("#rfcFiscal").val()=='' || $("#correoEFiscal").val()=='' || $("#telefonoFisical").val()=='' || $("#calleFiscal").val()=='' || $("#numIntFiscal").val()=='' || $("#single").val()=='' || $("#single").val()==null || $("#single2").val()==null || $("#single2").val()=='' || $("#single2").val()=='Escribe' || $("#single3").val()=='' || $("#single3").val()==null || $("#single4").val()=='' || $("#single4").val()==null || $("#single4").val()=='Escribe' || $("#calleenvio").val()=='' || $("#numIntenvio").val()=='' || $("#numExtenvio").val()=='' || $("#referenciaenvio").val()==''){
            toastr.error("Por favor llenar todos los campos de Datos Fiscales y los Datos de envío", 'ERROR', { timeOut: 10000 });
            return;
        }
        else{
            sendOrder2();
        }
    });

    $(document).keyup(function(e) {
        if (e.which == 27) {
            $('#modal').remove();
        }
    });
    //region Datables
    //Main Table
    $('#mainTable').DataTable({
        "language": {
            "decimal": ".",
            "thousands": ",",
            //"search": "Filtrar por:",
            "lengthMenu": "Mostrando _MENU_ resultados por página",
            "zeroRecords": "No hay registros por mostrar",
            "info": "Mostrando página _PAGE_ of _PAGES_",
            "infoEmpty": "No hay datos por Mostrar",
            "infoFiltered": "(Filtrando de _MAX_ total de registros)"
        },
        searching: false,
        pageLength: 10,
        responsive: true,
        "columns": [
            { "width": "10%" }, //cantidad
            { "width": "15%" }, //clave
            { "width": "30%" }, //descripcion
            { "width": "15%" }, //unidad
            { "width": "15%" }, //precio 
            { "width": "15%" }, //accion
            /*{ "width": "1%" }, //existencias
            { "width": "1%" }, //peso
            { "width": "1%" }, //volumen
            { "width": "1%" }, //factorEmpaque*/
        ]
    });
    const TABLE_0 = $('#mainTable').DataTable();

    //end Main table 

    //Products Table
    $('#productsTable').DataTable({
        "language": {
            "decimal": ".",
            "thousands": ",",
            "search": "Buscar:",
            "lengthMenu": "Mostrando _MENU_ resultados por página",
            "zeroRecords": "No hay registros por mostrar",
            "info": "Mostrando página _PAGE_ of _PAGES_",
            "infoEmpty": "No hay datos por Mostrar",
            "infoFiltered": "(Filtrando de _MAX_ total de registros)"
        },
        pageLength: 10,
        responsive: true,
        "columns": [
            { "width": "20%" }, //imagen producto
            { "width": "10%" }, //clave
            { "width": "25%" }, //descripcion
            { "width": "10%" }, //unidad
            { "width": "10%" }, //precio
            { "width": "10%" }, //existencias
            { "width": "10%" }, //cantidad
            { "width": "15%" }, //accion
            /*{ "width": "5%" }, //peso
            { "width": "5%" }, //volumen
            { "width": "5%" }, //factorEmpaque*/
        ]
    });
    const TABLE_1 = $('#productsTable').DataTable();
    //End Products Table

    //Edit Products Table
    $('#editProductsTable').DataTable({
        "language": {
            "decimal": ".",
            "thousands": ",",
            "search": "Buscar:",
            "lengthMenu": "Mostrando _MENU_ resultados por página",
            "zeroRecords": "No hay registros por mostrar",
            "info": "Mostrando página _PAGE_ of _PAGES_",
            "infoEmpty": "No hay datos por Mostrar",
            "infoFiltered": "(Filtrando de _MAX_ total de registros)"
        },
        pageLength: 10,
        responsive: true,
        "columns": [
            { "width": "15%" }, //imagen producto
            { "width": "10%" }, //clave
            { "width": "20%" }, //descripcion
            { "width": "10%" }, //unidad
            { "width": "10%" }, //precio
            { "width": "10%" }, //existencias
            { "width": "8%" }, //cantidad
            { "width": "17%" }, //accion
            /*{ "width": "5%" }, //peso
            { "width": "5%" }, //volumen
            { "width": "5%" }, //factorEmpaque*/
        ]
    });
    const TABLE_2 = $('#editProductsTable').DataTable();
    //end Edit Products Table

    //endregion

    //Rows Manager
    function registrosFilaHtmlProd(fila) {
        /*var table1 = $('#productsTable').DataTable();
        "<i class='far fa-eye' style='font-size:24px; color: blue; cursor: pointer;'></i> &nbsp;&nbsp;" +
        "<i class='far fa-edit' style='font-size:24px; color: orangered; cursor: pointer;'></i> &nbsp;&nbsp;" +
        mainData = fila;
        console.log(mainData);*/
        $.each(fila, function(i, item) {
            //console.log(item);
            if (item != false) {
                var rowNode = TABLE_1
                    .row.add({
                        reg: item,
                        0: "<img src='" + dir_imagenes + item.CVE_ART + ".jpg" + "' border='0' width='144' height='123'>",
                        1: item.CVE_ART,
                        2: item.DESCR,
                        3: item.UNI_ALT,
                        4: item.PRECIO,
                        5: item.A4,
                        6: '<input class="cantidad" type="number" id="' + item.CVE_ART + '" min="0">',
                        7: "<i class='addArtModal fas fa-check-double' style='font-size:24px; color: green; cursor: pointer;' " +
                            "id='btnAgregarArt' data-toggle='tooltip' data-placement='top' title='Agregar al Pedido'></i> &nbsp; &nbsp;" +
                            "<i class='removeArtModal fas fa-ban' style='font-size:24px; color: red; cursor: pointer;'" +
                            " id='btnCancelarArt' data-toggle='tooltip' data-placement='top' title='Eliminar de la lista'></i>",
                        8: item.PESO,
                        9: item.VOLUMEN,
                        10: item.UNI_EMP,
                        11: item.COSTO_PROM,
                    })
                    .draw()
                    .node();
                //PESO, VOLUMEN, UNI_EMP
            }
        });
        fila = null;
        item = null;
    }

    function deleteRecords(data) {
        //console.log(data);
        var actualWeight = Number(data[7]);
        console.log('Antes de Eliminar Articulo Peso:' + TotalesDePesoPartidas);
        console.log('Antes de Eliminar Articulo Volumen:' + TotalesDeVolumenPartidas);
        console.log('Antes de Eliminar Articulo Empaques:' + TotalesDeEmpaquesPartidas);
        console.log('Antes de Eliminar Articulo Precio Promedio:' + TotalesPreciosPromedio);

        for (var d = 0; d < TotalesDePesoPartidas.length; d++) {
            if (TotalesDePesoPartidas[d] == actualWeight) {
                if (TotalesDePesoPartidas.splice(d, 1) && TotalesDeVolumenPartidas.splice(d, 1) && TotalesDeEmpaquesPartidas.splice(d, 1) &&
                    TotalesPreciosPromedio.splice(d, 1)) {
                    arreglosActualizados = true;
                } else {
                    arreglosActualizados = false;
                }
                break;
            }
        }
        if (arreglosActualizados) {
            result = true;
        } else {
            result = false;
        }
        console.log('Despues Peso:' + TotalesDePesoPartidas);
        console.log('Despues Volumen:' + TotalesDeVolumenPartidas);
        console.log('Despues Empaques:' + TotalesDeEmpaquesPartidas);
        console.log('Despues Precios:' + TotalesPreciosPromedio);
        console.log('Resultado de la operacion: ****************');
        console.log('Borrado: ' + result);
        actualWeight = null;
        arreglosActualizados = null;
        return result;
    }

    function registrosFilaEditProducts(fila) {
        //console.log(fila);
        //TABLE_2.clear().draw();
        cantidadRec = fila[0];
        var cveRec = fila[1];
        var descRec = fila[2];
        var unidadesRec = fila[3];
        var precioRec = fila[4];
        var existRec = fila[6];
        var pesoRec = fila[7];
        var volumenRec = fila[8];
        var unidadEmpaqueRec = fila[9];
        var costoPromRec = fila[10];
        var rowNode = TABLE_2
            .row.add({
                reg: fila,
                0: "<img src='" + dir_imagenes + cveRec + ".jpg" + "' border='0' width='144' height='123'>",
                1: cveRec,
                2: descRec,
                3: unidadesRec,
                4: precioRec,
                5: existRec,
                6: '<input class="cantidad" type="number" id="' + cveRec + '" min="0" value="' + cantidadRec + '">',
                7: '<i class="saveEditArtModal fa fa-sync" style="font-size:24px; color: green; cursor: pointer;" id="btnEditAgregarArt" data-toggle="tooltip" data-placement="top" title="Actualizar datos del Articulo"></i>Actualizar' +
                    '<i class="cancelEditArtModal fas fa-reply" style="font-size:22px; color: orangered; cursor: pointer;" id="btnCancelEdit" data-toggle="tooltip" data-placement="top" title="Cancelar Edicion"></i>Regresar',
                8: pesoRec,
                9: volumenRec,
                10: unidadEmpaqueRec,
                11: costoPromRec,
            })
            .draw()
            .node();
        //data-toggle="modal" data-target="#editProductsModal" ---data-toggle="modal" data-target="#editProductsModal" cLASE DE BOTONES editProducts

        if (rowNode) {
            result = true;
        } else {
            result = false;
        }
        cantidadRec = null;
        cveRec = null;
        descRec = null;
        unidadesRec = null;
        precioRec = null;
        existRec = null;
        pesoRec = null;
        volumenRec = null;
        unidadEmpaqueRec = null;
        costoPromRec = null;
        return result;
    }

    function registrosFilaHtmlFact(datos) {
        /* var table0 = $('#mainTable').DataTable();
         var table1 = $('#productsTable').DataTable();*/
        var cve = datos.reg.CVE_ART;
        var unidad = datos.reg.UNI_ALT;
        var precio = datos.reg.PRECIO;
        var desc = datos.reg.DESCR;
        var cant = $('#' + cve).val();
        var existencias = datos.reg.A4;
        var peso = (cant * datos.reg.PESO);
        var volumen = (cant * datos.reg.VOLUMEN);
        var unidadEmpaque = (cant / datos.reg.UNI_EMP);
        var precio_promedio = (cant * datos.reg.COSTO_PROM);
        //$('#buscadorModal').remove();
        //console.log(item);
        if (cant != 0) {
            //TotalesCvesPartidas.push(cve);
            //TotalesCantidadesPartidas.push(cant);
            TotalesDePesoPartidas.push(peso);
            TotalesDeVolumenPartidas.push(volumen);
            TotalesDeEmpaquesPartidas.push(unidadEmpaque);
            TotalesPreciosPromedio.push(precio_promedio);

            /*mainData.push({
                "cve_art": datos.reg.CVE_ART,
                "descripcion": datos.reg.DESCR,
                "costo_prom": datos.reg.COSTO_PROM,
                "imagen": datos.reg.CVE_IMAGEN,
                "peso": datos.reg.PESO,
                "volumen": datos.reg.VOLUMEN,
                "precio": datos.reg.PRECIO,
                "unidades": datos.reg.UNI_ALT,
                "empaque": datos.reg.UNI_EMP,
                "cant": cant,
                'existencias': datos.reg.A4,
            });*/

            var rowNode = TABLE_0
                .row.add({
                    reg: datos,
                    0: cant,
                    1: cve,
                    2: desc,
                    3: unidad,
                    4: precio,
                    5: //"<i class='addArt fas fa-check-double' style='font-size:24px; color: green; cursor: pointer;' id='btnAgregarArt'></i> &nbsp; &nbsp;" +
                        "<i class='examinarArt far fa-eye' style='font-size:24px; color: blue; cursor: pointer;' data-toggle='tooltip' data-placement='top' title='Examinar Articulo'></i> &nbsp;&nbsp;" +
                        '<button data-toggle="modal" data-target="#editProductsModal" class="editProducts btn btn-xs">' +
                        "<i class=' far fa-edit' style='font-size:24px; color: orangered;' data-toggle='tooltip' data-placement='top' title='Editar Cantidad'></i>" +
                        '</button>' +
                        " &nbsp;&nbsp;" +
                        "<i class='borrarArt fas fa-ban' style='font-size:24px; color: red; cursor: pointer;' id='btnCancelarArt' data-toggle='tooltip' data-placement='top' title='Eliminar de la lista'></i>",
                    6: existencias,
                    7: peso,
                    8: volumen,
                    9: unidadEmpaque,
                    10: precio_promedio,
                })
                .draw()
                .node();
            result = true;
        } else {
            toastr.error('Por favor indica la cantidad de articulos deseados...', 'Cantidad.', { timeOut: 3000 });
            result = false;
        }

        cve = null;
        unidad = null;
        precio = null;
        desc = null;
        cant = null;
        existencias = null;
        peso = null;
        volumen = null;
        unidadEmpaque = null;
        precio_promedio = null;
        datos = null;
        return result;
    }
    //addEditRegistersToFilaHtmlFact
    function addEditRegistersToFilaHtmlFact(fila) {
        //console.log(fila);

        //Origen indica que el valor del concepto es aquel con el que se declara desde la consulta y por lo general son solo datos de referencia que no
        //cambiaran a lo largo del proceso del formulario, sin embargo son utilizado para obtener los resultados del pedido
        var imagenProductoOrigen = fila[0];
        var cveOrigen = fila[1];
        var descOrigen = fila[2];
        var unidadesOrigen = fila[3];
        var precioOrigen = Number(fila[4]);
        var existenciasOrigen = Number(fila[5]);

        //Al referirse a actual indica que el concepto ya es el resultado de la operacion de cantidad por el concepto original proveniente de la tabla de llamada       
        //Los datos cantidad actual y peso actual serviran  para ubicar el indice a borrar dentro de los arrays globales.
        var cntAct = Number(fila.reg[0]);
        var pesoActual = Number(fila[8]);

        var volumenActual = Number(fila[9]);
        var unidadesEmpaqueactual = Number(fila[10]);
        var precio_promedioActual = Number(fila[11]);
        /*console.log('*******************************************');
        console.log('Valores Actuales Cantidad: ' + fila.reg[0]);

        console.log('Cantidad: ' + cntAct);
        console.log('Precio: ' + precioOrigen);
        console.log('Volumen: ' + volumenActual);
        console.log('Cajas: ' + unidadesEmpaqueactual);

        console.log('Precio Promedio: ' + precio_promedioActual);*/
        var pesoOrigen = (pesoActual / cntAct);
        var volumenOrigen = (volumenActual / cntAct);
        var unidadesEmpaqueOrigen = (cntAct / unidadesEmpaqueactual);
        var precio_promedioOrigen = (precio_promedioActual / cntAct);

        /*console.log('Peso ORIGEN: ' + pesoOrigen);
        console.log('Volumen ORIGEN: ' + volumenOrigen);
        console.log('CAJAS ORIGEN: ' + unidadesEmpaqueOrigen);
        console.log('Precio promedio ORIGEN: ' + precio_promedioOrigen);*/

        //Updated datos resultado de la nueva cantidad por los conceptos
        /*estos valores no cambian en el tiempo y debido a que ya se obtuvieron como origen no es necesario operarlos, sino 
        usarlos para OPERAR
        var unitUpdated = fila[3];
        var precioUpdated = Number(fila[4]);
        var existUpdated = Number(fila[5]);
        console.log('*******************************************');
        console.log(fila);
        console.log('*******************************************');
        */
        var cantUpdated = $('#' + cveOrigen).val();
        var pesoUpdated = (cantUpdated * pesoOrigen);
        var volumenUpdated = (cantUpdated * volumenOrigen);
        var unidadEmpaqueUpdated = (cantUpdated / unidadesEmpaqueOrigen);
        var precio_promedioUpdated = (cantUpdated * precio_promedioOrigen);


        /*console.log('*******************************************');
        console.log('Cantidad ACTUALIZADA: ' + cantUpdated);
        console.log('*******************************************');
        console.log('Descargando producto de pedido.');
        console.log('Cantidad a descargar:' + cntAct);
        console.log('Peso a descargar:' + pesoActual);


        console.log('Peso a Actualizar: ' + pesoUpdated);
        console.log('Volumen a Actualizar: ' + volumenUpdated);
        console.log('Empaques a Actualizar: ' + unidadEmpaqueUpdated);
        console.log('Precios a Actualizar:' + precio_promedioUpdated);

        console.log('Imprimiendo Globales ANTES de descontar producto');
        console.log(TotalesDePesoPartidas);
        console.log(TotalesDeVolumenPartidas);
        console.log(TotalesDeEmpaquesPartidas);
        console.log(TotalesPreciosPromedio);
        console.log('*******************************************');

        console.log('Actualizando valores del producto');*/
        try {
            for (var d = 0; d < TotalesDePesoPartidas.length; d++) {
                if (TotalesDePesoPartidas[d] == pesoActual) {
                    //TotalesDePesoPartidas[d] = 0;
                    if (TotalesDePesoPartidas.splice(d, 1, pesoUpdated) && TotalesDeVolumenPartidas.splice(d, 1, volumenUpdated) &&
                        TotalesDeEmpaquesPartidas.splice(d, 1, unidadEmpaqueUpdated) && TotalesPreciosPromedio.splice(d, 1, precio_promedioUpdated)) {
                        arreglosActualizados = true;
                    } else {
                        arreglosActualizados = false;
                    }
                    break;
                }
            }
            /*console.log('Imprimiendo Globales despues de descontar producto');
            console.log(TotalesDePesoPartidas);
            console.log(TotalesDeVolumenPartidas);
            console.log(TotalesDeEmpaquesPartidas);
            console.log(TotalesPreciosPromedio);*/
            if (cantUpdated) {
                if (arreglosActualizados) {
                    //toastr.info('Actualizando datos en tabla Principal');
                    var rowNode = TABLE_0
                        .row.add({
                            reg: fila,
                            0: cantUpdated,
                            1: cveOrigen,
                            2: descOrigen,
                            3: unidadesOrigen,
                            4: precioOrigen,
                            5: //"<i class='addArt fas fa-check-double' style='font-size:24px; color: green; cursor: pointer;' id='btnAgregarArt'></i> &nbsp; &nbsp;" +
                                "<i class='examinarArt far fa-eye' style='font-size:24px; color: blue; cursor: pointer;' data-toggle='tooltip' data-placement='top' title='Examinar Articulo'></i> &nbsp;&nbsp;" +
                                '<button data-toggle="modal" data-target="#editProductsModal" class="editProducts btn btn-xs">' +
                                "<i class=' far fa-edit' style='font-size:24px; color: orangered;' data-toggle='tooltip' data-placement='top' title='Editar Cantidad'></i>" +
                                '</button>' +
                                " &nbsp;&nbsp;" +
                                "<i class='borrarArt fas fa-ban' style='font-size:24px; color: red; cursor: pointer;' id='btnCancelarArt' data-toggle='tooltip' data-placement='top' title='Eliminar de la lista'></i>",
                            6: existenciasOrigen,
                            7: pesoUpdated,
                            8: volumenUpdated,
                            9: unidadEmpaqueUpdated,
                            10: precio_promedioUpdated,
                        })
                        .draw()
                        .node();
                    cantidadRec = null;
                    result = true;
                } else {
                    result = false;
                }
            } else {
                toastr.error('Por favor indica la cantidad de articulos deseados...', 'Cantidad.', { timeOut: 3000 });
                result = false;
            }
        } catch (error) {
            console.log('Se capturo error en: ' + error);
            result = false;
        } finally {
            volumenActual = null;
            unidadesEmpaqueactual = null;
            precio_promedioActual = null;
            pesoOrigen = null;
            volumenOrigen = null;
            unidadesEmpaqueOrigen = null;
            precio_promedioOrigen = null;
            cantUpdated = null;
            pesoUpdated = null;
            volumenUpdated = null;
            unidadEmpaqueUpdated = null;
            precio_promedioUpdated = null;
            cantidadRec = null;
            arreglosActualizados = null;
            fila = null;
            return result;
        }
    }


    //verificar y corregir clase editProducts
    function cancelEditRegistersToFilaHtmlFact(datos) {
        //console.log(datos);
        var cve = datos[1];
        var cant = datos.reg[0];
        var desc = datos[2];
        var unidad = datos[3];
        var precio = datos[4];
        var existencias = datos[5];
        var peso = datos[8];
        var volumen = datos[9];
        var unidadEmpaque = datos[10];
        var precio_promedio = datos[11];

        var rowNode = TABLE_0
            .row.add({
                reg: datos,
                0: cant,
                1: cve,
                2: desc,
                3: unidad,
                4: precio,
                5: //"<i class='addArt fas fa-check-double' style='font-size:24px; color: green; cursor: pointer;' id='btnAgregarArt'></i> &nbsp; &nbsp;" +
                    "<i class='examinarArt far fa-eye' style='font-size:24px; color: blue; cursor: pointer;' data-toggle='tooltip' data-placement='top' title='Examinar Articulo'></i> &nbsp;&nbsp;" +
                    '<button data-toggle="modal" data-target="#editProductsModal" class="editProducts btn btn-xs">' +
                    "<i class=' far fa-edit' style='font-size:24px; color: orangered;' data-toggle='tooltip' data-placement='top' title='Editar Cantidad'></i>" +
                    '</button>' +
                    " &nbsp;&nbsp;" +
                    "<i class='borrarArt fas fa-ban' style='font-size:24px; color: red; cursor: pointer;' id='btnCancelarArt' data-toggle='tooltip' data-placement='top' title='Eliminar de la lista'></i>",
                6: existencias,
                7: peso,
                8: volumen,
                9: unidadEmpaque,
                10: precio_promedio,
            })
            .draw()
            .node();
        if (rowNode) {
            result = true;
        } else {
            result = false;
        }
        cant = null;
        cve = null;
        desc = null;
        unidad = null;
        precio = null;
        existencias = null;
        peso = null;
        volumen = null;
        unidadEmpaque = null;
        precio_promedio = null;
        datos = null;
        return result;
    }

    $('#mainTable tbody').on('click', '.examinarArt', function() {
        //var table0 = $('#mainTable').DataTable();
        row = TABLE_0.row($(this).parents('tr'));
        var dataC = row.data();
        //console.log(dataC);
        //toastr.success('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Mostrando Informacion del articulo: ' + dataC[2], { timeOut: 1000 });
        $('#cmpDescProd').val(dataC[2]);
        $("#prodImage").attr("src", dir_imagenes + dataC[1] + ".jpg");
        var modal = '<div class="modal" id="modal"><img src="' + dir_imagenes + dataC[1] + '.jpg" class="modal__img" alt="Imagen Articulo">' +
            '<div class="modal__boton" id="modal__boton">X</div></div>';
        $('body').append(modal);
        $('#modal__boton').click(function() {
            $('#modal').remove();
            modal = null;
        })
        row = null;
        dataC = null;
    });

    //region clear Order Prods ROW
    $('#mainTable tbody').on('click', '.borrarArt', function() {
        //var table0 = $('#mainTable').DataTable();
        row = TABLE_0.row($(this).parents('tr'));
        var dataDel = row.data();
        //toastr.warning('Borrando Articulo: ' + dataDel[2], "Mensaje");
        if (deleteRecords(dataDel)) {
            //toastr.success('Articulo Borrado');
            row.remove().draw();
            row = null;
            dataDel = null;
            getSubtotales();
        } else {
            toastr.error('NO se elimino el registro!!', 'Intentalo nuevamente!', { timeOut: 4000 });
            dataDel = null;
            row = null;
            return;
        }
    });

    //region clear Order Prods ROW
    $('#clearAllProducts').on('click', function() {
        //toastr.warning('Borrando Pedido...');
        clearMainView();
    });

    $('#mainTable tbody').on('click', '.editProducts', function() {
        //toastr.success('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i> Espera por favor...', 'Cargando datos...', { timeOut: 3000 });
        row = TABLE_0.row($(this).parents('tr'));
        var dataC1 = row.data();
        //console.log(dataC1.reg.precio_promedio);
        /*El siguiente ciclo Muestra el contenido necesario para poblar la tabla de edición, se incluye en el reultado los valores 
        adicionales no visibles en celdas de (se muestran los indices de los atributos):
        --PRECIO[8]-VOLUMEN[9]-(piezas por empaque)EMPAQUES[10]-- 
        La longitud del array de datos corresponde al numero de filas utilizado para
        la construcción de la tabla principal, es decir las columnas provenientes del modal (11)
        for (var i = 0; i < 11; i++) {
            console.log(dataC1.reg[i]);
        }
            
        for (var i = 0; i < 12; i++) {
            console.log(dataC[i]);
        }

        //console.log(dataC1.reg[1]);
        /*$.each(
            dataC1,
            function(item, value) {
                console.log('Campo: ' + item + '- Valor: ' + value);
            });*/
        //editData();
        //clearModalView();
        //toastr.info('Producto-' + dataC1[2], 'Editando.', { timeOut: 3000 });
        if (registrosFilaEditProducts(dataC1)) {
            row.remove().draw();
        } else {
            toastr.warning('Intentalo nuevamnente por favor.', 'Mensaje.', { timeOut: 3000 });
            TABLE_2.clear().draw();
            return;
        }
        row = null;
        dataC1 = null;
    });
    // region clear data form DataTables
    function clearMainView() {
        TABLE_0.clear().draw();
        $('#cmpPesoTotales').val("0");
        $('#cmpVolumenTotales').val("0");
        $('#cmpEmpaquesTotales').val("0");
        $('#cmpSubTotales').val("0");
        $('#cmpImpuestos').val("0");
        $('#cmpEnvio').val("0");
        $('#cmpCostoTotal').val("0");
        $('#cmpObservaciones').val("");
        $('#cmpOrdenCompra').val("");
        //*************Borrar arreglos */
        TotalesDePesoPartidas = new Array();
        TotalesDeVolumenPartidas = new Array();
        TotalesDeEmpaquesPartidas = new Array();
        TotalesPreciosPromedio = new Array();
        console.log('Comprobando Valores vacios: ' + TotalesDePesoPartidas);
        console.log('Comprobando Valores vacios: ' + TotalesDeVolumenPartidas);
        console.log('Comprobando Valores vacios: ' + TotalesDeEmpaquesPartidas);
        console.log('Comprobando Valores vacios: ' + TotalesPreciosPromedio);
    }

    function clearModalView() {
        TABLE_1.clear().draw();
    }

    $('#btnAddProducts').click(function() {
        //toastr.success('Cargando Productos');
        TABLE_1.clear().draw();
        //toastr.success('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i> Espera por favor...', 'Cargando Listado', { timeOut: 3000 });
        getArticles();
    });

    //endregion clear Order Prods Table

    function editData() {
        var data = row.data();
        //console.log('Cantidad: ' + data);
    }

    /*region Products Search it was deprectated by users evaluation
    $('#productsTable tfoot').on('click', '.searchArts', function() {;
        //$('#descDiv').append();
    });*/

    function getArticles() {
        $.ajax({
            type: 'get',
            url: '../php/inve_sae_V1.0.php',
            data: {
                funcion: 'buscarTodos',
            },
            success: function(data) {
                if ((data.errors)) {
                    toastr.error(JSON.stringify(data.errors));
                } else {
                    var filas = JSON.parse(data);
                    TABLE_1.clear().draw();
                    //console.log(filas);
                    registrosFilaHtmlProd(filas);
                }
            }
        });
    }
    //endregion Products Search

    //region Add Articles to Main Table
    $('#productsTable tbody').on('click', '.addArtModal', function() {
        /* var table0 = $('#mainTable').DataTable();
         var table1 = $('#productsTable').DataTable();*/
        row = TABLE_1.row($(this).parents('tr'));
        var dataC = row.data();
        if (registrosFilaHtmlFact(dataC)) {
            //toastr.warning('Cargando Articulo: ' + dataC.reg.DESCR, "Mensaje");
            row.remove().draw();
        } else {
            return;
        }
    });

    $('#editProductsTable tbody').on('click', '.saveEditArtModal', function() {
        /* var table0 = $('#mainTable').DataTable();
         var table1 = $('#productsTable').DataTable();*/
        row = TABLE_2.row($(this).parents('tr'));
        var dataC4 = row.data();
        //toastr.warning('Actualizando Articulo: ' + dataC4[2], "Mensaje");
        if (addEditRegistersToFilaHtmlFact(dataC4)) {
            row.remove().draw();
            getSubtotales();
            dataC4 = null;
        } else {
            alert('No se han actualizado los registros');
            //toastr.error('No se han actualizado los registros', 'ERROR', { timeOut: 3000 });
            return;
        }
    });

    $('#editProductsTable tbody').on('click', '.cancelEditArtModal', function() {
        row = TABLE_2.row($(this).parents('tr'));
        var dataC5 = row.data();
        //toastr.success('Recuperando Articulo: ' + dataC5[2], "Mensaje");
        if (cancelEditRegistersToFilaHtmlFact(dataC5)) {
            row.remove().draw();
            getSubtotales();
            dataC5 = null;
        } else {
            toastr.error('No se han recuperado los registros', 'ERROR', { timeOut: 5000 });
            return;
        }
        /* var table0 = $('#mainTable').DataTable();
         var table1 = $('#productsTable').DataTable();*/
        row = null;
        dataC5 = null;
    });


    $(".closeEditModal").click(function() {
        //toastr.success('Cancelando edicion');
        editCancel();
    });

    function editCancel() {
        row = TABLE_2.row(0);
        var dataC6 = row.data();
        console.log(dataC6);
        if (dataC6) {
            //toastr.success('Recuperando Articulo: ' + dataC6[2], "Mensaje");
            if (cancelEditRegistersToFilaHtmlFact(dataC6)) {
                row.remove().draw();
                getSubtotales();
            } else {
                toastr.error('No se han recuperado los registros', 'ERROR', { timeOut: 5000 });
                row = null;
                dataC6 = null;
                return;
            }
        } else {
            return;
        }

        /* var table0 = $('#mainTable').DataTable();
         var table1 = $('#productsTable').DataTable();*/
        row = null;
        dataC6 = null;
    }

    //endregion Add Articles to Main Table  

    //region remove Rows from Modal Products
    $('#productsTable tbody').on('click', '.removeArtModal', function() {
        //var table0 = $('#mainTable').DataTable();
        //toastr.success('Borrando Articulo');
        row = TABLE_1.row($(this).parents('tr')).remove().draw();
    });
    //endregion remove Rows from Modal Products

    //region Totalizers
    function getSubtotales() {
        //toastr.warning('Sumando Totales...');
        prods.length=0;
        var cantidades = TABLE_0.column(0).data();
        var clavesArt = TABLE_0.column(1).data();
        var descArt = TABLE_0.column(2).data();

        var precios = TABLE_0.column(4).data();
        /*var pesos = TABLE_0.column(7).data();
        var volums = TABLE_0.column(8).data();
        var empaques = TABLE_0.column(9).data();
        //7,8,9
                        6: existencias,
                7: peso,
                8: volumen,
                9: unidadEmpaque,
                10: precio_promedio,
        
        */

        //var arraySubTotalesCostosRow = new Array();
        var subtotalesCostos = 0;
        var sumPeso = 0;
        var sumVolums = 0;
        var sumEmpaques = 0;
        var factura = $('#facturar').val();
        var factorIVA = 0.16;
        var tasaAddIVA = 0;
        var totalMasIVA = 0;
        var totales = 0;
        /*
                for (var f = 0; f < cantidades.length; f++) {
                    sumPesoPorColumnas += (cantidades[f] * pesosPorColumnas[f]);
                    sumVolumsPorColumnas += (cantidades[f] * volumenPorColumnas[f])
                }
                console.log('*************************************************');
                console.log('Suma de Pesos por columnas: ' + sumPesoPorColumnas);
                console.log('Suma de Volumen por columnas: ' + sumVolumsPorColumnas);
                //console.log('Suma de Pesos por columnas: '+sumPesoPorColumnas);
                console.log('*************************************************');
                console.log('*************************************************');

                
                
                var subtotalAddDecimal = Number.parseFloat(subtot).toFixed(2);
                    
                $.each(cantidades, function(indice, cantidad) {
                    if (!cantidad.isNaN) {
                        arrayCantidades.push(cantidad);
                    }
                });

                $.each(precios, function(index, precio) {
                    arrayPrecios.push(index);
                });
                for (var k = 0; k < arraySubTotalesCostosRow.length; k++) {
                    console.log('Subtotales:' + [k] + '->' + arraySubTotalesCostosRow[k]);
                }
                    
                for (var b = 0; b < TotalesCvesPartidas.length; b++) {
                    console.log('Subtotales:' + [b] + '->' + TotalesCvesPartidas[b]);
                }

                for (var v = 0; v < TotalesCantidadesPartidas.length; v++) {
                    console.log('Cantidad de Partida:' + v + '-' + TotalesDePesoPartidas[v]);
                }
                    
                for (var z = 0; z < TotalesPreciosPromedio.length; z++) {
                    console.log('Precio Promedio por partida: ' + z + '-' + TotalesPreciosPromedio[z]);
                }
                */
        for (var j = 0; j < cantidades.length; j++) {
            //console.log('Clave de articulo partida: ' + j + '-' + clavesArt[j]);
            prods.push({
                "cve_art": clavesArt[j],
                "descArt" : descArt[j],
                "cant": cantidades[j],
                "costo_prom": TotalesPreciosPromedio[j],
                "precio": precios[j]
            });
        }

        

        for (var m = 0; m < TotalesDePesoPartidas.length; m++) {
            //console.log('Peso Partida:' + m + '-' + TotalesDePesoPartidas[m]);
            sumPeso += TotalesDePesoPartidas[m];
        }

        for (var n = 0; n < TotalesDeVolumenPartidas.length; n++) {
            //console.log('Volumen Partida:' + n + '-' + TotalesDeVolumenPartidas[n]);
            sumVolums += TotalesDeVolumenPartidas[n];
        }

        for (var q = 0; q < TotalesDeEmpaquesPartidas.length; q++) {
            //console.log('Numero de Empaques de partida' + q + '-' + TotalesDeEmpaquesPartidas[q]);
            sumEmpaques += TotalesDeEmpaquesPartidas[q];
        }

        for (var i = 0; i < cantidades.length; i++) {
            //console.log(cantidades[i]);
            subtotalesCostos += (cantidades[i] * precios[i]);
            //arraySubTotalesCostosRow.push(subtotalesCostos);
            //arrayTotalesRow.push = arrayCantidades[i] * arrayPrecios[i];
        }

        /*console.log('Total Peso:' + '->' + sumPeso);
        console.log('Total Volumen:' + '->' + sumVolums);
        console.log('Total Empaques:' + '->' + sumEmpaques);
        console.log('Subtotales Costo Globales: ' + subtotalesCostos);*/

        //cmpPesoTotales, cmpVolumenTotales, cmpEmpaquesTotales
        /*
        $('#cmpTotales').val(subtotalesCostos.toFixed(2));*/
        // Obtener la suma: $('#cmpTotales').val(TABLE_0.column(3).data().sum());
        /* $('#cmpPesoTotales').val((sumPeso));
         $('#cmpVolumenTotales').val(comasMiles(sumVolums));
         $('#cmpEmpaquesTotales').val(comasMiles(sumEmpaques));*/
        $('#cmpPesoTotales').val(sumPeso.toFixed(2));
        $('#cmpVolumenTotales').val(sumVolums.toFixed(2));
        $('#cmpEmpaquesTotales').val(sumEmpaques.toFixed(2));

        var pesoTotal = parseFloat($('#cmpPesoTotales').val());
        var volumenTotal = parseFloat($('#cmpVolumenTotales').val());

        if(pesoTotal > volumenTotal){
            envio=Math.trunc((200+(100*(Math.trunc(pesoTotal/5))))*(1.16));
        }
        else{
            envio=Math.trunc((200+(100*(Math.trunc(volumenTotal/5))))*(1.16));
        }


        if (factura == 'NO') {
            //console.log("Cambiando formato de resultado");
            //$('#cmpSubTotales').val(.toFixed(2)); new Intl.NumberFormat("en-IN").format(subtotalesCostos)

            $('#cmpCostoTotal').val(comasMiles(Number.parseFloat(subtotalesCostos).toFixed(2) + envio));
        } else {

          
            $('#cmpEnvio').val(envio);
            /*cmpSubTotales,
            cmpImpuestos, new Intl.NumberFormat("en-IN").format(number)
            cmpCostoTotal*/
            tasaAddIVA = (subtotalesCostos * factorIVA);
            totalMasIVA = (subtotalesCostos + tasaAddIVA);
            $('#cmpSubTotales').val(comasMiles(Number.parseFloat(subtotalesCostos).toFixed(2)));
            $('#cmpImpuestos').val(comasMiles(Number.parseFloat(tasaAddIVA).toFixed(2)));
            $('#cmpCostoTotal').val(comasMiles(Number.parseFloat(totalMasIVA + envio).toFixed(2)));
          // $('#cmpCostoTotal').val(comasMiles(envio));


        }
        sumPeso = 0;
        sumVolums = 0;
        sumEmpaques = 0;
        return prods;
    }

    /*$(".cancelEdit").click(function() {
        row = TABLE_2.row($(this).parents('tr'));
        var dataC3 = row.data();
        if (addEditRegistersToFilaHtmlFact(dataC3)) {
            toastr.warning('Cargando Articulo: ' + dataC3[2], "Mensaje");
            row.remove().draw();
        } else {
            return;
        }
        getSubtotales();
    });*/

    $(".modalDismiss").click(function() {
        TABLE_1.search("").draw();
        getSubtotales();
    });

    //endregion TotalizerS

    //--end Rows Manager 

    //endregion

    $("#validar").click(function() {
        toastr.warning("Pedido Agregado", "Guardando");
    });

    //region operational functions*/
    $("#buscadorCategoria").change(function() {
        var itemSelected = $('select[id=buscadorCategoria]').val();
        switch (itemSelected) {
            case "0":
                break;
            case "1":
                //toastr.info('Cosmeticos');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Cosméticos',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "2":
                //toastr.warning('Cuidado de la Piel');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Cuidado de la Piel',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            //console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "3":
                //toastr.success('Capsulas');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Cápsulas',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            //console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "4":
                //toastr.info('Suplementos Liquidos');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Suplementos Líquidos',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            //console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "5":
                //toastr.warning('Jarabes');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Jarabes',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            //console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "6":
                //toastr.success('Polvos');
                $.ajax({
                    type: 'post',
                    url: '../php/inve_sae_V1.0.php',
                    data: {
                        funcion: 'buscarPorCategoria',
                        criterio: 'Polvos',
                    },
                    success: function(data) {
                        //console.log(data);
                        if ((data.errors)) {
                            toastr.error(JSON.stringify(data.errors));
                        } else {
                            var filas = JSON.parse(data);
                            //console.log(filas);
                            TABLE_1.clear().draw();
                            //console.log(filas);
                            registrosFilaHtmlProd(filas);
                        }
                    }
                });
                break;
            case "7":
                getArticles();
                break;
        }
        //$('#valor2').val($(this).val());
    });

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

    var inveTable;
    $(".filtro-consulta input").val("");

    $("#cmpEmail").click(function() { $(this).select(); });
    $(".textAre").hide();
    //--Imprime todos los productos del inventario

    /*$(document).on('keyup', '.input-cant', function(e) {
        $(this).parents("tr").find(".cant").text($(this).val());

        var esIE = (document.all);
        var esNS = (document.layers);
        tecla = (esIE) ? event.keyCode : e.which;
        if (tecla == 13) {
            showCart();
            return false;
        }

    });

    $(document).on('onkeypress', ".input-cant"),
        function(e) {
            var esIE = (document.all);
            //var esNS = (document.layers);
            tecla = (esIE) ? event.keyCode : e.which;
            if (tecla == 13) {
                alert("Ud. ha presionado la tecla Enter");
                return false;
            }
        }*/

    //--Si se da click al botón mostrar Captura
    $("#btn-mostrar").click(function() {
        showCart();
    });

    //--Muestra todos los materiales de la tabla
    /*$("#btn-mostrarTodo").click(function() {
        inveTable.search();
    });*/


    //--Genera una recepción modelo con las cantidades capturadas
    function sendOrder() {
        //        console.log(" ");
        var costoTotal = $('#cmpSubTotales').val();
        var mail = $("#cmpEmail").val();
        var ordComp = $("#cmpOrdenCompra").val();
        //var ordComp = "A0001";
        var obs = $("#cmpObservaciones").val();

        //console.log('el valor del email es: ' + email);

        //console.log(validateInput(ordComp));
        // validando todos los campos: if (validateInput(mail) && validateInput(ordComp) && validateEmail(mail)) {
        // solo correo:
        //console.log(validateInput(costoTotal));
        //console.log(validateInput(mail));
        if (validateInput(costoTotal)) {
            if (validateInput(mail) && validateEmail(mail)) {
                toastr.info('Enviando Datos...');
                var idx = 0;
                var cap = false;
                var cant = 0;
                prods.push({
                    "email": mail,
                    "ordComp": ordComp,
                    "observaciones": obs
                });
                estadoFacturacion =($("#single").val()).split(',');
                fragmentoTexto =($("#single2").val()).split(',');
            
                estadoFacturacion2 =($("#single").val()).split(',');
                fragmentoTexto2 =($("#single4").val()).split(',');
                
                var datosFiscales=new Array($("#nombreFiscal").val(),$("#rfcFiscal").val(),$("#correoEFiscal").val(),$("#telefonoFisical").val(),$("#calleFiscal").val(),$("#numIntFiscal").val(),$("#numExtFiscal").val(),fragmentoTexto[0],fragmentoTexto[1],fragmentoTexto[2], estadoFacturacion[1]);   
                var datosEnvio=new Array($("#calleenvio").val(),$("#numIntenvio").val(),$("#numExtenvio").val(),fragmentoTexto2[0],fragmentoTexto2[1],fragmentoTexto2[2],estadoFacturacion2[1],$("#referenciaenvio").val());
                var flete= new Array($('#cmpEnvio').val(),$('#cmpSubTotales').val(),$('#cmpImpuestos').val(),$('#cmpCostoTotal').val());
                var datosAdicionales= new Array($('#cmpPesoTotales').val(),$('#cmpVolumenTotales').val(),$('#cmpEmpaquesTotales').val());

                var envio=$('#cmpEnvio').val();
               var subtotales=$('#cmpSubTotales').val();
               var impuestos=$('#cmpImpuestos').val();
               var ctotal=$('#cmpCostoTotal').val();
              // var flete= new Array($('#cmpEnvio').val(),  $('#cmpSubTotales').val(),     $('#cmpImpuestos').val(),$('#cmpCostoTotal').val());
               var flete= new Array(comasMiles(parseFloat(envio.replace(',','')).toFixed(2)) ,comasMiles(parseFloat(subtotales.replace(',','')).toFixed(2)),comasMiles(parseFloat(impuestos.replace(',','')).toFixed(2)),comasMiles(parseFloat(ctotal.replace(',','')).toFixed(2)));
               
                /*console.log('Correo: ' + mail);
                console.log('Orden de compra:' + ordComp);
                console.log('Datos completos:');
                console.log(prods);*/
                //Captura de conversion
                console.log('Actualizando archivo de Conversiones...');
                $.ajax({
                    type: 'post',
                    url: '../php/setConversions.php',
                    data: {
                        'increment': 1,
                    },
                    //dataType: "json",
                    success: function(data) {
                        //$("#content").html(data);
                        console.log('Conversion Guardada');
                    }
                });
                var datos = {
                    'prods':prods,
                    'datosFiscales':datosFiscales,
                    'datosEnvio':datosEnvio,
                    'flete':flete,
                    'datosAdicionales':datosAdicionales
                  }
                //end Captura
                if (prods) {
                    $.post("../php/ped_mail_V1.0.php", {datos}).done(function(data) {
                        //console.log(data);
                        var datos = JSON.parse(data);
                        console.log(datos.message);
                        if (datos.message == "Message sent!") {
                            toastr.success("Pedido enviado!", "Gracias por su Compra", { timeOut: 3000 });
                            clearMainView();
                            prods = new Array();
                            //window.location.href = window.location.href;
                        } else {
                            //alert("Correo en mantenimiento ")
                            console.log(datos.message);
                            toastr.warning("Pedido Pendiente!", 'Advertencia', { timeOut: 3000 });
                            clearMainView();
                            //window.location.href = window.location.href;
                        }
                    });
                } else {
                    toastr.warning("El Pedido tiene faltantes, verificalo e intenta nuevamente", 'Advertencia', { timeOut: 3000 });
                }
            } else {
                toastr.error("Debes capturar tu correo!", 'ERROR', { timeOut: 3000 });
                return;
            }
        } else {
            toastr.error("El Pedido debe de tener un importe mayor a 2000 pesos", 'ERROR', { timeOut: 3000 });
            return;
        }
    }



    //--Genera una recepción modelo con las cantidades capturadas
    function sendOrder2() {
        //        console.log(" ");
        var costoTotal = $('#cmpSubTotales').val();
        var mail = $("#cmpEmail").val();
        var ordComp = $("#cmpOrdenCompra").val();
        //var ordComp = "A0001";
        var obs = $("#cmpObservaciones").val();
        //var datosFiscales='';
        //var datosEnvio='';
        //console.log('el valor del email es: ' + email);

        //console.log(validateInput(ordComp));
        // validando todos los campos: if (validateInput(mail) && validateInput(ordComp) && validateEmail(mail)) {
        // solo correo:
        //console.log(validateInput(costoTotal));
        //console.log(validateInput(mail));
            if (validateInput(mail) && validateEmail(mail)) {
                toastr.info('Enviando Datos...');
                var idx = 0;
                var cap = false;
                var cant = 0;
                prods.push({
                    "email": mail,
                    "ordComp": ordComp,
                    "observaciones": obs
                });



               
        
//alert($("#nombreFiscal").val() + " " + $("#rfcFiscal").val()  + " " +  $("#correoEFiscal").val()   + " " +  $("#telefonoFisical").val()   + " " +  $("#calleFiscal").val()   + " " +  $("#numIntFiscal").val()   + " " +  $("#numExtFiscal").val()   + " " +  $("#cpFiscal").val()   + " " +  $("#coloniaFiscal").val()  + " " +   $("#maFiscal").val()   + " " +  $("#estadoFiscal").val() + ":armando");
               //var datosFiscales=new Array($("#nombreFiscal").val(),$("#rfcFiscal").val(),$("#correoEFiscal").val(),$("#telefonoFisical").val(),$("#calleFiscal").val(),$("#numIntFiscal").val(),$("#numExtFiscal").val(),$("#cpFiscal").val(),$("#coloniaFiscal").val(),$("#maFiscal").val(),$("#estadoFiscal").val());
      
                //var datosEnvio=new Array($("#calleenvio").val(),$("#numIntenvio").val(),$("#numExtenvio").val(),$("#cpenvio").val(),$("#coloniaenvio").val(),$("#maenvio").val(),$("#estadoenvio").val(),$("#paisenvio"),$("#referenciaenvio").val());

               // alert($("#calleenvio").val() + " " + $("#numIntenvio").val()  + " " +  $("#numExtenvio").val()   + " " +  $("#cpenvio").val()   + " " +  $("#coloniaenvio").val()   + " " +  $("#maenvio").val()   + " " +  $("#estadoenvio").val()   + " " +  $("#paisenvio").val()   + " " +  $("#referenciaenvio").val()   + ":armando2");
               estadoFacturacion =($("#single").val()).split(',');
               fragmentoTexto =($("#single2").val()).split(',');
           
               estadoFacturacion2 =($("#single").val()).split(',');
               fragmentoTexto2 =($("#single4").val()).split(',');

               var datosFiscales=new Array($("#nombreFiscal").val(),$("#rfcFiscal").val(),$("#correoEFiscal").val(),$("#telefonoFisical").val(),$("#calleFiscal").val(),$("#numIntFiscal").val(),$("#numExtFiscal").val(),fragmentoTexto[0],fragmentoTexto[1],fragmentoTexto[2], estadoFacturacion[1]);   
                var datosEnvio=new Array($("#calleenvio").val(),$("#numIntenvio").val(),$("#numExtenvio").val(),fragmentoTexto2[0],fragmentoTexto2[1],fragmentoTexto2[2],estadoFacturacion2[1],$("#referenciaenvio").val());
                var envio=$('#cmpEnvio').val();
                var subtotales=$('#cmpSubTotales').val();
                var impuestos=$('#cmpImpuestos').val();
                var ctotal=$('#cmpCostoTotal').val();
               // var flete= new Array($('#cmpEnvio').val(),  $('#cmpSubTotales').val(),     $('#cmpImpuestos').val(),$('#cmpCostoTotal').val());
               var flete= new Array(comasMiles(parseFloat(envio.replace(',','')).toFixed(2)) ,comasMiles(parseFloat(subtotales.replace(',','')).toFixed(2)),comasMiles(parseFloat(impuestos.replace(',','')).toFixed(2)),comasMiles(parseFloat(ctotal.replace(',','')).toFixed(2)));
               var datosAdicionales= new Array($('#cmpPesoTotales').val(),$('#cmpVolumenTotales').val(),$('#cmpEmpaquesTotales').val());

                /*console.log('Correo: ' + mail);
                console.log('Orden de compra:' + ordComp);
                console.log('Datos completos:');
                console.log(prods);*/
                //Captura de conversion
                console.log('Actualizando archivo de Conversiones...');
                $.ajax({
                    type: 'post',
                    url: '../php/setConversions.php',
                    data: {
                        'increment': 1,
                    },
                    //dataType: "json",
                    success: function(data) {
                        //$("#content").html(data);
                        console.log('Conversion Guardada');
                    }
                });
                var datos = {
                    'prods':prods,
                    'datosFiscales':datosFiscales,
                    'datosEnvio':datosEnvio,
                    'flete':flete,
                    'datosAdicionales':datosAdicionales
                  }
                //end Captura
                if (prods) {
                    $.post("../php/ped_mail_V1.0.php", {datos}).done(function(data) {
                        //console.log(data);
                        var datos = JSON.parse(data);
                        console.log(datos.message);
                        
                        if (datos.message == "Message sent!") {
                            toastr.success("Pedido enviado!", "Gracias por su Compra", { timeOut: 3000 });
                            clearMainView();
                            $('#buscadorModal2').hide();
                            prods = new Array();
                            window.location.href = window.location.href;
                        } else {
                            //alert("Correo en mantenimiento ")
                            console.log(datos.message);
                            toastr.warning("Pedido Pendiente!", 'Advertencia', { timeOut: 3000 });
                            clearMainView();
                            $('#buscadorModal2').hide();
                            window.location.href = window.location.href;
                        }
                    });
                } else {
                    toastr.warning("El Pedido tiene faltantes, verificalo e intenta nuevamente", 'Advertencia', { timeOut: 3000 });
                }
            } else {
                toastr.error("Debes capturar tu correo!", 'ERROR', { timeOut: 3000 });
                return;
            }
        
    }

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



    //endregion operational functions
});
// endregion Main function by Document ready

//--region external Functions
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

//Obtiene el texto de resultado de un evento
function getResultText(salidas, entradas) {
    if (salidas) {
        var resultado = salidas - entradas;
        var textResult = "Correcto ";
        if (resultado < 0) {
            textResult = "Sobran ";
            resultado = Math.abs(resultado);
        } else if (resultado > 0) { textResult = "Faltan "; }
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
    var shift = function(number, precision, reverseShift) {
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
    return emailReg.test($email);
}

function validarSubtotal(subtotal){
    var sub = subtotal.replace(',', '');
    var subt=parseFloat(sub);
    
    if (subt < 2000) {
        return false;
    } else {
        return true;
    }
}

function validateInput(input) {
    /*console.log('Valor del input:');
    console.log(input);*/
    if (input < 2000) {
        return false;
    } else {
        return true;
    }
}

//--endregion external Functions