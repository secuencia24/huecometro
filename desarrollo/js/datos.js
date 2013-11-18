$(document).on('ready', initdatos);
var q, pavimento, inversion, allFields, tips;

/**
 * se activa para inicializar el documento
 */
function initdatos() {
    q = {};
    q.ke = _ucode;
    q.lu = _ulcod;
    q.ti = _utval;
    pavimento = $("#hcmtr_pavimentado");
    inversion = $("#hcmtr_inversion");
    allFields = $([]).add(pavimento).add(inversion);
    tips = $(".validateTips");

    $('#dynamictable').dataTable({
        "sPaginationType": "full_numbers"
    });

    UTIL.applyDatepicker('hcmtr_fecha');
    $("#creardatos").button().click(function() {
        q.id = 0;
        $("#dialog-form").dialog("open");
    });

    $("#dialog-form").dialog({
        autoOpen: false, height: 400, width: 450, modal: true,
        buttons: {
            "Guardar": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");
                if (bValid) {
                    DATOS.savedata();
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

var DATOS = {
    deletedata: function(id) {
        var continuar = confirm('Va a eliminar información de forma irreversible.\n¿Desea continuar?');
        if (continuar) {
            q.op = 'datadelete';
            q.id = id;
            UTIL.callAjaxRqst(q, this.deletedatahandler);
        }
    },
    deletedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            window.location = 'datos.php';
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    editdata: function(id) {
        q.op = 'dataget';
        q.id = id;
        UTIL.callAjaxRqst(q, this.editdatahandler);
    },
    editdatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            var res = data.output.response[0];
            $('#hcmtr_pavimentado').val(res.hcmtr_pavimentado);
            $('#hcmtr_inversion').val(res.hcmtr_inversion);
            $('#hcmtr_fecha').val(res.hcmtr_fecha);
            $("#dialog-form").dialog("open");
        } else {
            alert('Error: ' + data.output.response.content);
        }
    },
    savedata: function() {
        q.op = 'datasave';
        q.hcmtr_pavimentado = $('#hcmtr_pavimentado').val();
        q.hcmtr_inversion = $('#hcmtr_inversion').val();
        q.hcmtr_fecha = $('#hcmtr_fecha').val();
        UTIL.callAjaxRqst(q, this.savedatahandler);
    },
    savedatahandler: function(data) {
        UTIL.cursorNormal();
        if (data.output.valid) {
            updateTips('Información guardada correctamente');
            window.location = 'datos.php';
        } else {
            updateTips('Error: ' + data.output.response.content);
        }
    }
}
