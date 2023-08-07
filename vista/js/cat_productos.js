var table;
function listarProductos() {
    table = $("#tbl_productos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Producto',
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
          url: "funciones/paginaFunciones_catProductos.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "codigoProducto" },
            { data: "producto" },   
            { data: "categoria" },
            { data: "precioMenudeo" },
            { data: "precioMayoreo" },
            { data: "precioProduccion" },
            { data: "stock_producto" },
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
                    targets:1,
                    className: "text-center",
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:2
                },
                {
                    width: "35%",
                    targets:3
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:4
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:5
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:6
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:7
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:8
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:9
                },
                {
                    width: "10%",
                    targets:10,
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

$("#tbl_productos").on("click", ".btEditarProducto", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_producto").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_producto").modal("show");
    
    //console.log("data.precioCompra "+data.precioCompra+" data.precioProduccion "+data.precioProduccion);

    var precioCompra = parseInt(data.precioCompra.replace("$ ",""));
    var precioMayoreo = parseInt(data.precioMayoreo.replace("$ ",""));
    var precioMenudeo = parseInt(data.precioMenudeo.replace("$ ",""));
    var precioProduccion = parseInt(data.precioProduccion.replace("$ ",""));

    //console.log("Nuevo precioCompra "+precioCompra+" precioProduccion "+precioProduccion);
    
     $("#txtIdProducto").val(data.id);
     $("#txt_nombre_modificar").val(data.producto);
     $("#txt_codigoBarra_modificar").val(data.codigoProducto);
     $("#txt_impuesto_modificar").val(data.idImpuesto);
     $("#txt_categoria_modificar").val(data.idCategoria);
     $("#txt_precioCompra_modificar").val(precioCompra);
     $("#txt_precioMayoreo_modificar").val(precioMayoreo);
     $("#txt_precioMenudeo_modificar").val(precioMenudeo);
     $("#txt_utilidad_modificar").val(data.utilidad);
     $("#txt_stockMaximo_modificar").val(data.stockMax);
     $("#txt_stockMinimo_modificar").val(data.stockMin);
     $("#txt_precioProduccion_modificar").val(precioProduccion);
     $("#txt_Situacion").val(data.situacion);
})

function abrirModuloRegistro()
{
    $("#modal_registro_producto").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_producto").modal("show");
}


/*==============================================
    FUNCION QUE PERMITE PREVISUALIZAR LA IMAGEN
 ===============================================*/
function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}

function registrar_producto()
{
    var frm = document.getElementById('form_subir');
    var data = new FormData(frm);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4){
            var msg = xhttp.responseText;
                switch(msg)
                {
                    case '0':
                        Swal.fire("Mensaje De Error","Los campos marcados con * sob obligatorios","error");
                    break;
                    case '1':
                            $('#modal_registro_producto').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto registrado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                              }); 
                            //$('#modal_registro_producto').trigger('reset');
                            listarProductos();
                    break;
                    case '2':
                            $('#modal_registro_producto').modal('hide');
                            limpiarCamposModalRegistro();
                            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
                            $('#modal_registro_producto').trigger('reset');
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFunciones_productoNuevo.php", true);
    xhttp.send(data); 
}

function modificar_producto()
{
    var idProducto = $("#txtIdProducto").val();
    var nombreProducto = $("#txt_nombre_modificar").val();
    var codigoProducto = $("#txt_codigoBarra_modificar").val();
    var impuesto = $("#txt_impuesto_modificar").val();
    var categoria = $("#txt_categoria_modificar").val();
    var precioCompra = $("#txt_precioCompra_modificar").val();
    var precioMayoreo = $("#txt_precioMayoreo_modificar").val();
    var precioMenudeo = $("#txt_precioMenudeo_modificar").val();
    var utilidad = $("#txt_utilidad_modificar").val();
    var stockMaximo = $("#txt_stockMaximo_modificar").val();
    var stockMinimo = $("#txt_stockMinimo_modificar").val();
    var precioProduccion = $("#txt_precioProduccion_modificar").val();

    //console.log("precioProduccion "+precioProduccion);

    var situacion = $("#txt_Situacion").val();

    if(nombreProducto.lenght==0 || codigoProducto.lenght==0 || impuesto==-1 || categoria==-1 || precioCompra.lenght==0 || precioMayoreo.lenght==0 || precioMenudeo.lenght==0 ||stockMaximo.lenght==0 || stockMinimo.lenght==0 || precioProduccion.lenght==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idProducto":"'+idProducto+'","nombreProducto":"'+nombreProducto+'","codigoProducto":"'+codigoProducto+'","impuesto":"'+impuesto
        +'","categoria":"'+categoria+'","precioCompra":"'+precioCompra+'","precioMayoreo":"'+precioMayoreo+'","precioMenudeo":"'+precioMenudeo
        +'","utilidad":"'+utilidad+'","stockMaximo":"'+stockMaximo+'","stockMinimo":"'+stockMinimo+'","precioProduccion":"'+precioProduccion
        +'","situacion":"'+situacion+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_producto").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto Modificado',
                showConfirmButton: false,
                timer: 1500
            }) 
            listarProductos();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_catProductos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}


$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL DIGITAR SOBRE LOS INPUT'S
/*===================================================================*/
$("#txt_precioCompra, #txt_precioMayoreo").keyup(function() {
    calcularUtilidadProducto(1);
})

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL CAMBIAR EL CONTENIDO (PERDER FOCUS)
/*===================================================================*/
$("#txt_precioCompra, #txt_precioMayoreo").change(function() {
    calcularUtilidadProducto(1);
});

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL DIGITAR SOBRE LOS INPUT'S
/*===================================================================*/
$("#txt_precioCompra_modificar, #txt_precioMayoreo_modificar").keyup(function() {
    //calcularUtilidadProducto(2);
});

/*===================================================================*/
//EVENTO PARA CALCULAR LA UTILIDAD AL CAMBIAR EL CONTENIDO (PERDER FOCUS)
/*===================================================================*/
$("#txt_precioCompra_modificar, #txt_precioMayoreo_modificar").change(function() {
    calcularUtilidadProducto(2);
});


function calcularUtilidadProducto(tipo)
{
    if(tipo==1)
    {
        var iptPrecioCompraReg = $("#txt_precioCompra").val();
        var iptPrecioVentaReg = $("#txt_precioMayoreo").val();
        /*
        if(iptPrecioCompraReg>iptPrecioVentaReg)
        {
            return Swal.fire("Mensaje De Advertencia","El precio de compra no puede ser mayor al Precio de Venta","warning");
        }
        */

        var Utilidad = iptPrecioVentaReg - iptPrecioCompraReg;
    
        $("#txt_utilidad").val(Utilidad.toFixed(2));
    }
    else{
        var iptPrecioCompraReg = $("#txt_precioCompra_modificar").val();
        var iptPrecioVentaReg = $("#txt_precioMayoreo_modificar").val();
    
        /*
        if(iptPrecioCompraReg>iptPrecioVentaReg)
        {
            return Swal.fire("Mensaje De Advertencia","El precio de compra no puede ser mayor al Precio de Venta","warning");
        }
        */

        var Utilidad = iptPrecioVentaReg - iptPrecioCompraReg;
    
        $("#txt_utilidad_modificar").val(Utilidad.toFixed(2));
    }
    
}

function limpiarCamposModalRegistro()
{
    $("#iptImagen").val('');
    $("#txt_nombre").val('');
    $("#txt_codigoBarra").val('');
    $("#txt_impuesto").val('-1');
    $("#txt_categoria").val('-1');
    $("#txt_precioCompra").val('0');
    $("#txt_precioMayoreo").val('0');
    $("#txt_precioMenudeo").val('0');
    $("#txt_utilidad").val('0');
    $("#txt_stockMaximo").val('0');
    $("#txt_stockMinimo").val('0');
    $("#txt_precioProducccion").val('0');
    $("#txt_existencia").val('0');
}