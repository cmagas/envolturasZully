var table;
function listarTipoGasto() {
    table = $("#tbl_tipoGasto").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Tipo',
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
          url: "funciones/paginaFunciones_catTipoGasto.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: ""},
            { data: "id" },
            { data: "nomTipoGasto" },
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
                    width: "70%",
                    targets:2
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "10%",
                    targets:4,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditarProducto text-primary px-1' style='cursor:pointer;'>" +
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

$("#tbl_tipoGasto").on("click", ".btEditarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_registro").modal("show");
    
    $("#txtIdTipoCategoria").val(data.id);
    $("#txt_nombreTipo_modificar").val(data.nomTipoGasto);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_TipoGasto()
{
    var nombreTipo=$("#txt_nombreTipo").val();
    var descripcion=$("#txt_descripcion").val();

    if(nombreTipo.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nombreTipo":"'+nombreTipo+'","descripcion":"'+descripcion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Tipo de Gasto registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
              listarTipoGasto();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catTipoGasto.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_TipoGasto()
{
    var idTipoGasto=$("#txtIdTipoCategoria").val();
    var nomTipoGasto=$("#txt_nombreTipo_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(nomTipoGasto.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idTipoGasto":"'+idTipoGasto+'","nomTipoGasto":"'+nomTipoGasto+'","descripcion":"'+descripcion+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Tipo de Gasto modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
              listarTipoGasto();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catTipoGasto.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function limpiarCamposModalRegistro()
{
    $("#txt_nombreTipo").val('');
    $("#txt_descripcion").val('');
}