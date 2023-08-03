var table;
function listarCategorias() {
    table = $("#tbl_categorias").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Categoría',
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
          url: "funciones/paginaFunciones_categorias.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: ""},
            { data: "id" },
            { data: "nombreCategoria" },
            { data: "aplicaPeso", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "Si";
                    } else {
                    return "No";
                }
            },
            },
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

$("#tbl_categorias").on("click", ".btEditarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_registro").modal("show");
    
    $("#txtIdCategoria").val(data.id);
    $("#txt_nomCategoria_modificar").val(data.nombreCategoria);
    $("#txt_descripcion_modificar").val(data.descripcion);
    $("#txt_aplicaPeso_modificar").val(data.aplicaPeso);
    $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}


$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

function registrar_Categoria()
{
    var nomCategoria=$("#txt_nomCategoria").val();
    var descripcion=$("#txt_descripcion").val();
    var aplicaPeso=$("#txt_aplicaPeso").val();

    if(nomCategoria.length==0 || aplicaPeso==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"nomCategoria":"'+nomCategoria+'","descripcion":"'+descripcion+'","aplicaPeso":"'+aplicaPeso+'"}';

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
                title: 'Categoría registrada correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
            listarCategorias();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_categorias.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
    
}

function modificar_categorias()
{
    var idCategoria=$("#txtIdCategoria").val();
    var nomCategoria=$("#txt_nomCategoria_modificar").val();
    var descripcion=$("#txt_descripcion_modificar").val();
    var aplicaPeso=$("#txt_aplicaPeso_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(nomCategoria.length==0 || aplicaPeso==-1 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idCategoria":"'+idCategoria+'","nomCategoria":"'+nomCategoria+'","descripcion":"'+descripcion+'","aplicaPeso":"'+aplicaPeso+'","situacion":"'+situacion+'"}';

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
                title: 'Categoria modificada correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
            listarCategorias();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_categorias.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}

function limpiarCamposModalRegistro()
{
    $("#txt_nomCategoria").val('');
    $("#txt_descripcion").val('');
    $("#txt_aplicaPeso").val(-1);
}