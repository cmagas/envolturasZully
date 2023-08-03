var table;
function listarClientes() {
    table = $("#tbl_clientes").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Cliente',
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
          url: "funciones/paginaFunciones_catClientes.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombre" },
            { data: "localidad" },
            { data: "nomEstado" },   
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
                    width: "35%",
                    targets:2
                },
                {
                    width: "15%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "15%",
                    className: "text-center",
                    targets:4
                },
                {
                    width: "15%",
                    className: "text-center",
                    targets:5
                },
                {
                    width: "10%",
                    targets:6,
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

$("#tbl_clientes").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificacion_cliente").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificacion_cliente").modal("show");
    
    $("#txtIdCliente").val(data.id);
     $("#cmb_tipo_modificar").val(data.tipoEmpresa);
     $("#txt_rfc_modificar").val(data.rfc);
     $("#txt_razonSocial_modificar").val(data.nombre);
     $("#txt_email_modificar").val(data.email);
     $("#txt_telefono_modificar").val(data.telefono);
     $("#cmb_estado_modificar").val(data.estado);
     $("#txt_municipio_modificar").val(data.municipio);
     $("#txt_calle_modificar").val(data.calle);
     $("#txt_numero_modificar").val(data.numero);
     $("#txt_colonia_modificar").val(data.colonia);
     $("#txt_codPostal_modificar").val(data.codPostal);
     $("#txt_localidad_modificar").val(data.localidad);
     $("#txt_Situacion").val(data.situacion);

     obtenerMunicipio(data.municipio);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro_cliente").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_cliente").modal("show");
}

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFunciones_catClientes.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function registrar_cliente()
{
    var tipoEmpresa=$("#cmb_tipo").val();
    var rfc=$("#txt_rfc").val();
    var razonSocial=$("#txt_razonSocial").val();
    var email=$("#txt_email").val();
    var telefono=$("#txt_telefono").val();
    var estado=$("#cmb_estado").val();
    var municipio=$("#txt_municipio").val();
    var calle=$("#txt_calle").val();
    var numero=$("#txt_numero").val();
    var colonia=$("#txt_colonia").val();
    var codPostal=$("#txt_codPostal").val();
    var localidad=$("#txt_localidad").val();

    if(tipoEmpresa==-1 || razonSocial.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"tipoEmpresa":"'+tipoEmpresa+'","rfc":"'+rfc+'","razonSocial":"'+razonSocial+'","email":"'+email
            +'","telefono":"'+telefono+'","estado":"'+estado+'","municipio":"'+municipio+'","calle":"'+calle
            +'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+localidad+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_cliente").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Cliente registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              }); 
              listarClientes(); 
              limpiarCamposModalRegistro();          
        }
        else
        {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al registrar al Cliente',
                showConfirmButton: false,
                timer: 1500
              });
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catClientes.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
    
}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:5};
  $.post("funciones/paginaFunciones_catClientes.php", params, function(data){
    $("#txt_municipio_modificar").html(data);
  });    
}

function modificar_cliente()
{
    var idCliente=$("#txtIdCliente").val();
    var tipoEmpresa=$("#cmb_tipo_modificar").val();
    var rfc=$("#txt_rfc_modificar").val();
    var razonSocial=$("#txt_razonSocial_modificar").val();
    var email=$("#txt_email_modificar").val();
    var telefono=$("#txt_telefono_modificar").val();
    var estado=$("#cmb_estado_modificar").val();
    var municipio=$("#txt_municipio_modificar").val();
    var calle=$("#txt_calle_modificar").val();
    var numero=$("#txt_numero_modificar").val();
    var colonia=$("#txt_colonia_modificar").val();
    var codPostal=$("#txt_codPostal_modificar").val();
    var localidad=$("#txt_localidad_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(tipoEmpresa==-1 || razonSocial.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
    }

    var cadObj='{"idCliente":"'+idCliente+'","tipoEmpresa":"'+tipoEmpresa+'","rfc":"'+rfc+'","razonSocial":"'+razonSocial
            +'","email":"'+email+'","telefono":"'+telefono+'","estado":"'+estado+'","municipio":"'+municipio+'","calle":"'+calle
            +'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+localidad
            +'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificacion_cliente").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Cliente modificado correctamente',
                showConfirmButton: false,
                timer: 1500
                }); 
                listarClientes();           
        }
        else
        {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al guardar los cambios',
                showConfirmButton: false,
                timer: 1500
                });
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catClientes.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true)

    
}

function obtenerMunicipiosPorEstado2(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFunciones_catClientes.php", params, function(data){
       $("#txt_municipio_modificar").html(data);
    });            
}

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

function limpiarCamposModalRegistro()
{
    $("#cmb_tipo").val('-1');
    $("#txt_rfc").val('');
    $("#txt_razonSocial").val('');
    $("#txt_email").val('');
    $("#txt_telefono").val('');
    $("#cmb_estado").val('-1');
    $("#txt_municipio").val('-1');
    $("#txt_calle").val('');
    $("#txt_numero").val('');
    $("#txt_colonia").val('');
    $("#txt_codPostal").val('');
    $("#txt_localidad").val('');

}