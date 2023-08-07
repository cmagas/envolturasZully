var table;

function listarEmpresasGeneral() {
    table = $("#tbl_empresas").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Empresa',
                className: 'addNewRecord',
                action: function (e, dt, node, config) {
                    abrirModuloRegistro();
                }
            },
            'excel', 'pdf', 'print', 'pageLength'
        ],
        ordering: false,
        bLengthChange: true,
        searching: { regex: true },
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        pageLength: 10,
        destroy: true,
        async: false,
        processing: true,
        ajax: {
            url: "funciones/paginaFunciones_empresas.php",
            type: "POST",
            data: {
                funcion: "1"
            }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreCompleto" },
            { data: "telefono" },
            { data: "email" },
            {
                data: "situacion",
                render: function (data, type, row) {
                    if (data == "1") {
                        return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                        return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                },
            },
            { data: "" }
        ],
        responsive: {
            detalls: {
                type: 'column'
            }
        },
        columnDefs: [
            {
                width: "5%",
                targets: 0,
                orderable: false,
                className: 'control'
            },
            {
                width: "5%",
                targets: 1,
                className: "text-center",
            },
            {
                width: "40%",
                targets:2
            },
            {
                width: "10%",
                className: "text-center",
                targets:3
            },
            {
                width: "20%",
                className: "text-center",
                targets:4
            },
            {
                width: "10%",
                className: "text-center",
                targets:5
            },
            {
                width: "10%",
                targets: 6,
                orderable: false,
                render: function (data, type, meta) {
                    return "<center>" +
                        "<span title='Modificar' class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-pencil-alt fs-5'></i>" +
                        "</span>" +
                        "</center>"
                }
            }
        ],

        language: idioma_espanol,
        select: true,

    });

}

$("#tbl_empresas").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_registro").modal("show");
    
    $("#txtIdEmpresa").val(data.id);
    $("#cmb_tipoEmpresa_modificar").val(data.tipoEmpresa);
    $("#txt_nombre_modificar").val(data.nombre);
    $("#txt_apPaterno_modificar").val(data.apPaterno);
    $("#txt_apMaterno_modificar").val(data.apMaterno);
    $("#txt_rfc_modificar").val(data.rfc);
    $("#txt_telefono_modificar").val(data.telefono);
    $("#txt_email_modificar").val(data.email);
    $("#cmb_estado_modificar").val(data.estado);
    $("#txt_municipio_modificar").val(data.municipio);
    $("#txt_calle_modificar").val(data.calle);
    $("#txt_numero_modificar").val(data.numero);
    $("#txt_colonia_modificar").val(data.colonia);
    $("#txt_codPostal_modificar").val(data.codPostal);
    $("#txt_Localidad_modificar").val(data.localidad);
    $("#txt_Situacion").val(data.situacion);
     

    obtenerMunicipio(data.municipio);
    
});

function abrirModuloRegistro() {
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_empresas() {
    var tipoEmpresa = $("#cmb_tipoEmpresa").val();
    var nombre = $("#txt_nombre").val();
    var apPaterno = $("#txt_apPaterno").val();
    var apMaterno = $("#txt_apMaterno").val();
    var rfc = $("#txt_rfc").val();
    var telefono = $("#txt_telefono").val();
    var email = $("#txt_email").val();
    var estado = $("#cmb_estado").val();
    var municipio = $("#txt_municipio").val();
    var calle = $("#txt_calle").val();
    var numero = $("#txt_numero").val();
    var colonia = $("#txt_colonia").val();
    var codPostal = $("#txt_codPostal").val();
    var localidad = $("#txt_Localidad").val();

    //console.log("tipo Empresa "+tipoEmpresa);

    if (tipoEmpresa == -1) {
        return Swal.fire("Mensaje De Advertencia", "Debe seleccionar el Tipo de Empresa", "warning");
    }

    if (tipoEmpresa == 1) {
        if (nombre.length == 0 || apPaterno.length == 0 || apMaterno.length == 0) {
            return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
        }
    } else {
        if (nombre.length == 0) {
            return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
        }
    }

    if (telefono.length == 0 || email.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
    }

    var cadObj = '{"tipoEmpresa":"'+tipoEmpresa+'","nombre":"'+nombre+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","rfc":"'+rfc+'","telefono":"'+telefono+'","email":"'+email+'","estado":"'+estado+'","municipio":"'+municipio+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+localidad+'"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split('|');
        if (arrResp[0] == '1') {
            $("#modal_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Empresa registrada correctamente',
                showConfirmButton: false,
                timer: 1500
              }); 
            listarEmpresasGeneral();
            limpiarCamposModalRegistro();
        }
        else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_empresas.php', funcAjax, 'POST', 'funcion=3&cadObj=' + cadObj, true)

}

function modificar_empresas()
{
    var idEmpresa = $("#txtIdEmpresa").val();
    var tipoEmpresa = $("#cmb_tipoEmpresa_modificar").val();
    var nombre = $("#txt_nombre_modificar").val();
    var apPaterno = $("#txt_apPaterno_modificar").val();
    var apMaterno = $("#txt_apMaterno_modificar").val();
    var rfc = $("#txt_rfc_modificar").val();
    var telefono = $("#txt_telefono_modificar").val();
    var email = $("#txt_email_modificar").val();
    var estado = $("#cmb_estado_modificar").val();
    var municipio = $("#txt_municipio_modificar").val();
    var calle = $("#txt_calle_modificar").val();
    var numero = $("#txt_numero_modificar").val();
    var colonia = $("#txt_colonia_modificar").val();
    var codPostal = $("#txt_codPostal_modificar").val();
    var localidad = $("#txt_Localidad_modificar").val();
    var situacion = $("#txt_Situacion").val();

    //console.log("tipo Empresa "+tipoEmpresa);

    if (tipoEmpresa == -1) {
        return Swal.fire("Mensaje De Advertencia", "Debe seleccionar el Tipo de Empresa", "warning");
    }

    if (tipoEmpresa == 1) {
        if (nombre.length == 0 || apPaterno.length == 0 || apMaterno.length == 0) {
            return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
        }
    } else {
        if (nombre.length == 0) {
            return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
        }
    }

    if (telefono.length == 0 || email.length == 0 || situacion==-1) {
        return Swal.fire("Mensaje De Advertencia", "Los datos Marcados con * son obligatorios", "warning");
    }

    var cadObj = '{"tipoEmpresa":"'+tipoEmpresa+'","nombre":"'+nombre+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","rfc":"'+rfc+'","telefono":"'+telefono+'","email":"'+email+'","estado":"'+estado+'","municipio":"'+municipio+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+localidad+'","idEmpresa":"'+idEmpresa+'","situacion":"'+situacion+'"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split('|');
        if (arrResp[0] == '1') {
            $("#modal_modificar_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Empresa modificada correctamente',
                showConfirmButton: false,
                timer: 1500
              }); 
            listarEmpresasGeneral();
        }
        else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_empresas.php', funcAjax, 'POST', 'funcion=5&cadObj=' + cadObj, true)    
}

function tipoEmpresa(value) {
    switch (value) {
        case '-1':
            $("#txt_nombre").prop('disabled', true); 
            $("#txt_apPaterno").prop('disabled', true);
            $("#txt_apMaterno").prop('disabled', true);
        break
        case '1':
            $("#txt_nombre").show();
            $("#txt_nombre").prop('disabled', false); 
            $("#txt_apPaterno").prop('disabled', false);
            $("#txt_apMaterno").prop('disabled', false);

        break
        case '2':
            $("#txt_nombre").prop('disabled', false); 
            $("#txt_apPaterno").prop('disabled', true);
            $("#txt_apMaterno").prop('disabled', true);
        break
    }
}

function tipoEmpresa2(value) {
    switch (value) {
        case '-1':
            $("#txt_nombre_modificar").prop('disabled', true); 
            $("#txt_apPaterno_modificar").prop('disabled', true);
            $("#txt_apMaterno_modificar").prop('disabled', true);
        break
        case '1':
            $("#txt_nombre_modificar").show();
            $("#txt_nombre_modificar").prop('disabled', false); 
            $("#txt_apPaterno_modificar").prop('disabled', false);
            $("#txt_apMaterno_modificar").prop('disabled', false);

        break
        case '2':
            $("#txt_nombre_modificar").prop('disabled', false); 
            $("#txt_apPaterno_modificar").prop('disabled', true);
            $("#txt_apMaterno_modificar").prop('disabled', true);
        break
    }
}

function obtenerMunicipiosPorEstado(value) {
    cveEstado = value;
    var params = { cveEstado: cveEstado, funcion: 2 };

    $.post("funciones/paginaFunciones_empresas.php", params, function (data) {
        $("#txt_municipio").html(data);
    });
}

function obtenerMunicipiosPorEstadoModi(value) {
    cveEstado = value;
    var params = { cveEstado: cveEstado, funcion: 2 };

    $.post("funciones/paginaFunciones_empresas.php", params, function (data) {
        $("#txt_municipio_modificar").html(data);
    });
}

function limpiarCamposModalRegistro() {
    $("#cmb_tipoEmpresa").val(-1);
    $("#txt_nombre").val('');
    $("#txt_apPaterno").val('');
    $("#txt_apMaterno").val('');
    $("#txt_rfc").val('');
    $("#txt_telefono").val('');
    $("#txt_email").val('');
    $("#cmb_estado").val(-1);
    $("#txt_municipio").val(-1);
    $("#txt_calle").val('');
    $("#txt_numero").val('');
    $("#txt_colonia").val('');
    $("#txt_codPostal").val('');
    $("#txt_Localidad").val('');

}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:4};
  $.post("funciones/paginaFunciones_empresas.php", params, function(data){
    $("#txt_municipio_modificar").html(data);
  });    
}