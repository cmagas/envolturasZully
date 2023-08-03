var table;
function listarImpuestos() {
    table = $("#tbl_impuestos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Impuesto',
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
          url: "funciones/paginaFunciones_impuestos.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombreImpuesto" },
            { data: "valor" },
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
                    width: "50%",
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
                    width: "10%",
                    targets:5,
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

$("#tbl_impuestos").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_impuesto").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_impuesto").modal("show");
    
     $("#txtIdImpuesto").val(data.id);
     $("#txt_impuesto_modifi").val(data.nombreImpuesto);
     $("#txt_valor_modifi").val(data.valor);
     $("#txt_descripcion_modifi").val(data.descripcion);
     $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro_impuesto").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_impuesto").modal("show");
}

function registrar_impuesto()
{
    var nombreImpuesto=$("#txt_impuesto").val();
    var valor=$("#txt_valor").val();
    var descripcion=$("#txt_descripcion").val();

    if(nombreImpuesto.length==0 || valor.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreImpuesto":"'+nombreImpuesto+'","valor":"'+valor+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_impuesto").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Impuesto registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
            listarImpuestos();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_impuestos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_impuesto()
{
    var idImpuesto=$("#txtIdImpuesto").val();
    var nombreImpuesto=$("#txt_impuesto_modifi").val();
    var valor=$("#txt_valor_modifi").val();
    var descripcion=$("#txt_descripcion_modifi").val();
    var situacion=$("#txt_Situacion").val();

    if(nombreImpuesto.length==0 || valor.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreImpuesto":"'+nombreImpuesto+'","valor":"'+valor+'","descripcion":"'+descripcion+'","idImpuesto":"'+idImpuesto+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_impuesto").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Impuesto modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
            listarImpuestos();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_impuestos.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true)

}

function limpiarCamposModalRegistro()
{
    $("#txt_impuesto").val('');
    $("#txt_valor").val('');
    $("#txt_descripcion").val('');
}