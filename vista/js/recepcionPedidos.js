var table;
var items = [];
var valorProducto="";

function listarPedidos() {
    table = $("#tbl_pedidos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Pedido',
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
          url: "funciones/paginaFunciones_pedidoRecepcion.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nomPersonal" },
            { data: "fechaRecepcion" },
            { data: "total" },
            { data: "totalPiezas" },
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
                    width: "40%",
                    targets:2
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "10%",
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
                    className: "text-center",
                    targets:5
                },
                {
                    width: "10%",
                    targets:7,
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

function inicializarTablaProductos()
{
    table = $('#lstProductosPedido').DataTable({
        "columns": [
            { "data": "id" },
            { "data": "codigo_producto" },
            { "data": "descripcion_producto" },
            { "data": "cantidad" },
            { "data": "acciones" },
            { "data": "costoProd" },
            { "data": "totalProd" },
        ],
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: 5,
                visible: false
            },
            {
                targets: 5,
                visible: false
            }

        ],
        "order": [
            [0, 'desc']
        ],
        scrollY: '100px',
        scrollCollapse: true,
        paging: false,

        language: idioma_espanol,
    });
}

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function listadoProducto()
{
    $.ajax({
        async: false,
        url:   "funciones/paginaFunciones_pedidoRecepcion.php",
        method: "POST",
        data: {
            funcion: 2
        },
        dataType: 'json',
        success: function(respuesta){

            for(let i = 0; i < respuesta.length; i++){

                items.push(respuesta[i]['descripcion_producto'])
            }
            
           $("#iptCodigoVenta").autocomplete({

                source: items,
                select: function(event, ui){

                    valorProducto=ui.item.value;

                    $("#iptCantidad").val("1")
                    $("#iptCantidad").focus();

                    //obtenerUltimoCosto(valorProducto);
                }
            })
        } 
    })
}




/* ======================================================================================
    EVENTO PARA AGREGAR PRODUCTO AL GRID
=========================================================================================*/
$("#btnAgregarProducto").on('click', function() {
    agregarProductoTable();
})

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    vaciarListado();
    limpiarInputs();
})

/* ======================================================================================
    EVENTO PARA VACIAR EL CARRITO DE COMPRAS
=========================================================================================*/
$("#btnVaciarListado").on('click', function() {
    vaciarListado();
})

/* ======================================================================================
    EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
======================================================================================*/
$('#lstProductosPedido tbody').on('click', '.btnEliminarproducto', function() {
    table.row($(this).parents('tr')).remove().draw();

}); 


function agregarProductoTable()
{
    var valorProducto=valorProducto;
    var totalProd=0.00;

    var idPersonal = $("#cmb_Personal").val();
    var fechaAjuste = $("#txt_fechaAjuste").val();

    var producto=$("#iptCodigoVenta").val();
    var cantidad= $("#iptCantidad").val();

    if(producto=="") // || cantidad<0 || cantidad.length==0 ||  costoU<0 || costoU.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Debe selecccionar un Producto","warning");
    }

    if(cantidad<=0 || cantidad=="")
    {
        return Swal.fire("Mensaje De Advertencia","Debe Ingresar una Cantidad correcta","warning");
    }

    $.ajax({
        url: "funciones/paginaFunciones_pedidoRecepcion.php",
        method: "POST",
        data: {
            'funcion': 3, //BUSCAR PRODUCTOS POR SU CODIGO DE BARRAS
            'codigo_producto': producto
        },
        dataType: 'json',
        success: function(respuesta){
            if(respuesta)
            {
               totalProd=cantidad*respuesta['costoProd'];

                if(respuesta['aplica_peso'] == 1){
                    
                    table.row.add({
                        'id':respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': cantidad + ' Kg(s)',
                        'acciones': "<center>" +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                    "</center>",
                        'costoProd': respuesta['costoProd'],
                        'totalProd': '$ '+totalProd
                    }).draw();
                    limpiarProductos()
                }else{
                    
                    table.row.add({
                        'id':respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': cantidad + ' Und(s)',
                        'acciones': "<center>" +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                    "</center>",
                        'costoProd': respuesta['costoProd'],
                        'totalProd': '$ '+totalProd
                    }).draw();
                    limpiarProductos()
                }
                //recalcularTotales();

            }else{
                return Swal.fire(" El producto no existe ","error");

                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();
            }
        }

    });

    
}

function registrar_pedidos()
{
    var count = 0;
    var aux='';
    var arrProductos='';
    var cantidad=0;
    var totales=0.00;
    var costoP=0.00;

    var idPersonal=$("#cmb_Personal").val();
    var fechaRecepcion=$("#txt_fechaAjuste").val();
        
    if(idPersonal==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Debe seleccionar al Personal","warning");
    }
    
    table.rows().eq(0).each(function(index) {
        count = count + 1;
    });

   
    if (count > 0)
    {
        
        table.rows().eq(0).each(function(index)
        {
            var row = table.row(index);

            var data = row.data();

            var aplicaPeso = data['aplica_peso'];
            costoP = data['costoProd'];

            if(aplicaPeso==1)
            {
                cantidad=data['cantidad'].replace("Kg(s)","");
            }else{
                cantidad=data['cantidad'].replace("Und(s)","");
            }

            totales=cantidad*costoP;
            

            aux='{"id":"'+data['id']+'","codigo_producto":"'+data['codigo_producto']+'","descripcion_producto":"'+data['descripcion_producto']
                +'","cantidad":"'+cantidad+'","costoP":"'+costoP+'","totales":"'+totales+'"}';
            
             //console.log("aux "+aux);   
            if(arrProductos=='')
            {
                arrProductos=aux;
            }
            else
            {
                arrProductos+=','+aux
            }
            
        });

        var cadObj='{"idPersonal":"'+idPersonal+'","fechaRecepcion":"'+fechaRecepcion+'","arrProductos":['+arrProductos+']}';
        
        $.ajax({
            url: "funciones/paginaFunciones_pedidoRecepcion.php",
            method: "POST",
            data: {
                'funcion': 4,
                'cadObj': cadObj
            },
            dataType:'json',
            success: function(respuesta) {
               
                if(parseInt(respuesta['existe']) == 1)
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pedido Registrado',
                        showConfirmButton: false,
                        timer: 1500
                    }) 
                    $("#modal_registro").modal('hide');
                    listarPedidos();
                    vaciarListado();
                    limpiarProductos();
                    limpiarInputs();
                    
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'No se pudo registrar el Pedido',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
        
    }
    else{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'No hay productos en el listado.',
            showConfirmButton: false,
            timer: 1500
          });
    }

    $("#iptCodigoVenta").focus();


}

/*===================================================================*/
    //FUNCION PARA LIMPIAR TOTALMENTE EL CARRITO DE VENTAS
/*===================================================================*/
function vaciarListado() {
    table.clear().draw();
    limpiarProductos();
}

function limpiarInputs()
{
    $("#cmb_Personal").val(-1);
    $("#iptCodigoVenta").val('');
    $("#iptCantidad").val('');
 
}

function limpiarProductos()
{
    $("#iptCodigoVenta").val('');
    $("#iptCantidad").val('');
    //table.clear().draw();
}