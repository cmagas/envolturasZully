var table;
function listarPersonal() {
    table = $("#tbl_personal").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Personal',
                className: 'addNewRecord',
                action: function ( e, dt, node, config ){
                    abrirModuloRegistro();
                }
            },
            'excel','pdf','print','pageLength'
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
          url: "funciones/paginaFunciones_catPersonal.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombre" },
            { data: "situacion", 
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
                detalls:{
                    type: 'column'
                }
        },
        columnDefs:[
                {
                    width: "5%",
                    targets:0,
                    orderable: false,
                    className:'control'
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:1
                },
                {
                    width: "65%",
                    targets:2
                },
                {
                    width: "15%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "10%",
                    targets:4,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                                "</center>"
                    }
                }
        ],
        language: idioma_espanol,
        select: true,
    });

}

$("#tbl_personal").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_personal").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_personal").modal("show");
    
     $("#txtIdPersonal").val(data.id);
     $("#txt_nombre_modificar").val(data.nombre);
     $("#txt_telefono_modificar").val(data.telefono);
     $("#txt_calle_modificar").val(data.calle);
     $("#txt_numero_modificar").val(data.numero);
     $("#txt_colonia_modificar").val(data.colonia);
     $("#txt_codPostal_modificar").val(data.codPostal);
     $("#txt_localidad_modificar").val(data.localidad);
     $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro_personal").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_personal").modal("show");
}

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

function registrar_personal()
{
    var nombre = $("#txt_nombre").val();
    var telefono = $("#txt_telefono").val();
    var calle=$("#txt_calle").val();
    var numero = $("#txt_numero").val();
    var colonia = $("#txt_colonia").val();
    var codPostal = $("#txt_codPostal").val();
    var localidad = $("#txt_localidad").val();

    if(nombre.length==0 || telefono.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombre":"'+nombre+'","telefono":"'+telefono+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia
            +'","codPostal":"'+codPostal+'","localidad":"'+localidad+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_personal").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Personal registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
            listarPersonal();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catPersonal.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
    
}


function limpiarCamposModalRegistro()
{
    $("#txt_nombre").val('');
    $("#txt_telefono").val('');
    $("#txt_calle").val('');
    $("#txt_nombre").val('');
    $("#txt_numero").val('');
    $("#txt_colonia").val('');
    $("#txt_codPostal").val('');
    $("#txt_localidad").val('');
}

function modificar_personal()
{
    var idPersonal=$("#txtIdPersonal").val();
    var nombre=$("#txt_nombre_modificar").val();
    var telefono=$("#txt_telefono_modificar").val();
    var calle=$("#txt_calle_modificar").val();
    var numero=$("#txt_numero_modificar").val();
    var colonia=$("#txt_colonia_modificar").val();
    var codPostal=$("#txt_codPostal_modificar").val();
    var localidad=$("#txt_localidad_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(nombre.length==0 || telefono.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idPersonal":"'+idPersonal+'","nombre":"'+nombre+'","telefono":"'+telefono+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia
        +'","codPostal":"'+codPostal+'","localidad":"'+localidad+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_personal").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Personal modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              }); 
            listarPersonal();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catPersonal.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true)

}