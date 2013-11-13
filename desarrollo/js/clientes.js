$(document).on('ready', initcliente);
var q, nombre, estado, allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initcliente() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    nombre = $("#nombre");
    estado = $("#estado");
    allFields = $([]).add(nombre).add(estado);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    UTIL.applyDatepicker('fechainicio');
    UTIL.applyDatepicker('fechafin');

    $("#crearcliente").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });

    $("#dialog-form").dialog({
        autoOpen: false, height: 740, width: 450, modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");
                bValid = bValid && checkLength(nombre, "nombre", 3, 30);

                if (bValid) {
                    CLIENTE.savedata();
                }
            },
            "Cancelar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            UTIL.clearForm('formcreate');
            updateTips('');
        }
    });
}

var CLIENTE = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'clidelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'clientes.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'cliget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#nombre').val(res.nombre);
            $('#estado').val(res.estado);
            $('#email').val(res.email);
            $('#url').val(res.url);
            $('#fechainicio').val(res.fechainicio);
            $('#fechafin').val(res.fechafin);
            $('#nit').val(res.nit);
            $('#telefono').val(res.telefono);
            $('#pais').val(res.pais);
            $('#departamento').val(res.departamento);
            $('#ciudad').val(res.ciudad);
            $('#direccion').val(res.direccion);
            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'clisave';
        q.nombre = $('#nombre').val();
        q.estado = $('#estado').val();
        q.email = $('#email').val();
        q.url = $('#url').val();
        q.fechainicio = $('#fechainicio').val();
        q.fechafin = $('#fechafin').val();
        q.nit = $('#nit').val();
        q.telefono = $('#telefono').val();
        q.pais = $('#pais').val();
        q.departamento = $('#departamento').val();
        q.ciudad = $('#ciudad').val();
        q.direccion = $('#direccion').val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'clientes.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}
