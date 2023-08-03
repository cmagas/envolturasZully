var table;
function listarProveedores() {
    table = $("#tbl_proveedor").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Proveedor',
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
          url: "funciones/paginaFunciones_catProveedores.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreProv" },
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
                    className: "text-center",
                    targets:2
                },
                {
                    width: "20%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "15%",
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

function abrirModuloRegistro()
{
    $("#modal_registro_Proveedor").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_Proveedor").modal("show");
}

$("#tbl_proveedor").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_Proveedor").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_Proveedor").modal("show");
    
    
    $("#txtIdProveedor").val(data.id);
     $("#cmb_tipo_modificar").val(data.tipoEmpresa);
     $("#txt_rfc_modificar").val(data.rfc);
     $("#txt_razonSocial_modificar").val(data.nombre);
     $("#txt_apPaterno_modificar").val(data.apPaterno);
     $("#txt_apMaterno_modificar").val(data.apMaterno);
     $("#cmb_estado_modificar").val(data.estado);
     $("#txt_municipio_modificar").val(data.municipio);
     $("#txt_calle_modificar").val(data.calle);
     $("#txt_numero_modificar").val(data.numero);
     $("#txt_colonia_modificar").val(data.colonia);
     $("#txt_cod_postal_modificar").val(data.codPostal);
     $("#txt_Localidad_modificar").val(data.localidad);
     $("#txt_email_modificar").val(data.email);
     $("#txt_telefono_modificar").val(data.telefono);
     $("#txt_Situacion").val(data.situacion);

     obtenerMunicipio(data.municipio);
    
});


$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

function tipoProveedor(value)
{
    switch(value)
    {
        case '-1':
                
                $("#txt_apPaterno").prop('disabled', true);
                $("#txt_apMaterno").prop('disabled', true);
        break
        case '1':
                $("#txt_apPaterno").prop('disabled', false);
                $("#txt_apMaterno").prop('disabled', false);

        break
        case '2':
                $("#txt_apPaterno").prop('disabled', true);
                $("#txt_apMaterno").prop('disabled', true);
        break
    }
}

function tipoProveedorModificado(value)
{
    switch(value)
    {
        case '-1':
                
                $("#txt_apPaterno_modificar").prop('disabled', true);
                $("#txt_apMaterno_modificar").prop('disabled', true);
        break
        case '1':
                $("#txt_apPaterno_modificar").prop('disabled', false);
                $("#txt_apMaterno_modificar").prop('disabled', false);

        break
        case '2':
                $("#txt_apPaterno_modificar").prop('disabled', true);
                $("#txt_apMaterno_modificar").prop('disabled', true);
        break
    }
}

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFunciones_catProveedores.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function registrar_proveedor()
{
    var tipoEmpresa=$("#cmb_tipo").val();
    var txt_rfc=$("#txt_rfc").val();
    var razonSocial=$("#txt_razonSocial").val();
    var apPaterno=$("#txt_apPaterno").val();
    var apMaterno=$("#txt_apMaterno").val();
    var calle=$("#txt_calle").val();
    var numero=$("#txt_numero").val();
    var colonia=$("#txt_colonia").val();
    var codPostal=$("#txt_cod_postal").val();
    var estado=$("#cmb_estado").val();
    var municipio=$("#txt_municipio").val();
    var localidad=$("#txt_Localidad").val();
    var email=$("#txt_email").val();
    var telefono=$("#txt_telefono").val();

    if(tipoEmpresa==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe seleccionar el tipo de Proveedor","warning");
    }
    else{
            if(tipoEmpresa==1)
            {
                if(razonSocial.length==0 || apPaterno.length==0 || apMaterno.length==0)
                {
                    return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
                }
                }
                else{
                if(razonSocial.length==0)
                {
                    return Swal.fire("Mensaje De Advertencia","El campo Razon social es obligatorio","warning");
                }
            }
        }
    
    var cadObj='{"tipoEmpresa":"'+tipoEmpresa+'","txt_rfc":"'+txt_rfc+'","razonSocial":"'+razonSocial+'","apPaterno":"'+apPaterno
                +'","apMaterno":"'+apMaterno+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal
                +'","localidad":"'+localidad+'","estado":"'+estado+'","municipio":"'+municipio+'","email":"'+email+'","telefono":"'+telefono+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_Proveedor").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Proveedor Registrado',
                showConfirmButton: false,
                timer: 1500
            }) 
            limpiarCamposModalRegistro();
            listarProveedores();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catProveedores.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function obtenerMunicipiosPorEstado2(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:2};

    $.post("funciones/paginaFunciones_catProveedores.php", params, function(data){
       $("#txt_municipio_modificar").html(data);
    });            
}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:5};
  $.post("funciones/paginaFunciones_catProveedores.php", params, function(data){
    $("#txt_municipio_modificar").html(data);
  });    
}

function modificar_proveedor()
{
    var idProveedor=$("#txtIdProveedor").val();
    var tipoEmpresa=$("#cmb_tipo_modificar").val();
    var txt_rfc=$("#txt_rfc_modificar").val();
    var razonSocial=$("#txt_razonSocial_modificar").val();
    var apPaterno=$("#txt_apPaterno_modificar").val();
    var apMaterno=$("#txt_apMaterno_modificar").val();
    var estado=$("#cmb_estado_modificar").val();
    var municipio=$("#txt_municipio_modificar").val();
    var calle= $("#txt_calle_modificar").val();
    var numero= $("#txt_numero_modificar").val();
    var colonia= $("#txt_colonia_modificar").val();
    var codPostal= $("#txt_cod_postal_modificar").val();
    var localidad=$("#txt_Localidad_modificar").val();
    var email=$("#txt_email_modificar").val();
    var telefono=$("#txt_telefono_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(tipoEmpresa==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe seleccionar el tipo de Proveedor","warning");
    }
    else{
        if(tipoEmpresa==1)
        {
            if(razonSocial.length==0 || apPaterno.length==0 || apMaterno.length==0)
            {
                return Swal.fire("Mensaje De Advertencia","Todos los campos marcados son obligatorios","warning");
            }
        }
        else{
            if(razonSocial.length==0)
            {
                return Swal.fire("Mensaje De Advertencia","El campo Razon social es obligatorio","warning");
            }
        }
    }

    if(situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe indicar la situación del Proveedor","warning");
    }

    var cadObj='{"idProveedor":"'+idProveedor+'","tipoEmpresa":"'+tipoEmpresa+'","txt_rfc":"'+txt_rfc+'","razonSocial":"'+razonSocial+'","apPaterno":"'+apPaterno+'","apMaterno":"'+apMaterno+'","estado":"'+estado+'","municipio":"'+municipio+'","calle":"'+calle+'","numero":"'+numero+'","colonia":"'+colonia+'","codPostal":"'+codPostal+'","localidad":"'+localidad+'","email":"'+email+'","telefono":"'+telefono+'","situacion":"'+situacion+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_Proveedor").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Proveedor Modificado',
                showConfirmButton: false,
                timer: 1500
            }) 
            listarProveedores();           
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catProveedores.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true) 

}

function limpiarCamposModalRegistro()
{
    $("#cmb_tipo").val('-1');
    $("#txt_rfc").val('');
    $("#txt_razonSocial").val('');
    $("#txt_apPaterno").val('');
    $("#txt_apMaterno").val('');
    $("#cmb_estado").val('-1');
    $("#txt_municipio").val('-1');
    $("#txt_calle").val('');
    $("#txt_numero").val('');
    $("#txt_colonia").val('');
    $("#txt_cod_postal").val('');
    $("#txt_Localidad").val('');
    $("#txt_email").val('');
    $("#txt_telefono").val('');
}