var table;
var tablaCompra;
var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
var itemProducto = 1;
var editor;
var valorProducto="";

function listarCompras()
{
    table = $("#tbl_compras").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Registrar Compra',
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
          url: "funciones/paginaFunciones_compras.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "fechaCompra" },
            { data: "nomProveedor" },
            { data: "total" },  
            { data: "formaPago" },   
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
                    width: "10%",
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
                    width: "15%",
                    className: "text-center",
                    targets:5
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:6
                },
                {
                    width: "10%",
                    targets:7,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                    "<span class='btnImprimir text-primary px-1' style='cursor:pointer;' title='Imprimir'>" +
                                        "<i class='fas fa-book fs-5'></i>"+
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
    tablaCompra = $('#lstProductosCompra').DataTable({
        "columns": [
            { "data": "id" },
            { "data": "codigo_producto" },
            { "data": "descripcion_producto" },
            { "data": "cantidad" },
            { "data": "precio_compra_producto" },
            { "data": "total" },
            { "data": "acciones" },
            { "data": "aplica_peso" },
            { "data": "valorImpuesto" }
        ],
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: 7,
                visible: false
            },
            {
                targets: 8,
                visible: true
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
    $("#modal_registro_compras").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_compras").modal("show");
}


$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    vaciarListado();
})

/* ======================================================================================
    EVENTO PARA VACIAR EL CARRITO DE COMPRAS
=========================================================================================*/
$("#btnVaciarListado").on('click', function() {
    vaciarListado();
})

/* ======================================================================================
    EVENTO PARA AGREGAR PRODUCTO AL GRID
=========================================================================================*/
$("#btnAgregarProducto").on('click', function() {
    agregarProductoTable();
})

/* ======================================================================================
    EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
======================================================================================*/
$('#lstProductosCompra tbody').on('click', '.btnEliminarproducto', function() {
    tablaCompra.row($(this).parents('tr')).remove().draw();
    recalcularTotales();
}); 

/* ======================================================================================
    IMPRIMIR COMPRA
======================================================================================*/
$("#tbl_compras").on("click", ".btnImprimir", function (){
    
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    var idCompra=data.id;

   imprimirCompra(idCompra);

    
    
});

function listadoProducto()
{
    
    $.ajax({
        async: false,
        url:   "funciones/paginaFunciones_compras.php",
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

                    obtenerUltimoCosto(valorProducto);
                }
            })
        } 
    })
}

/*===================================================================*/
    //FUNCION PARA CARGAR PRODUCTOS EN EL DATATABLE
/*===================================================================*/
function cargarProductos(producto = "") {
    
    if (producto != "") {
        var codigo_producto = producto;
        
    } else {
        var codigo_producto = $("#iptCodigoVenta").val();
    }

    var producto_repetido = 0;

    //console.log("codigo_producto "+codigo_producto);
   
    /*===================================================================*/
    // AUMENTAMOS LA CANTIDAD SI EL PRODUCTO YA EXISTE EN EL LISTADO
    /*===================================================================*/

    tablaCompra.rows().eq(0).each(function(index) {
        var row = tablaCompra.row(index);
        var data = row.data();

        //console.log("data "+data);

        //console.log("Primer codigo "+data['id']+" segundo codigo "+data['codigo_producto']);

        if (parseInt(codigo_producto) == data['codigo_producto']) {
            
            producto_repetido = 1;
 
            $.ajax({
                    async: false,
                    url: "funciones/paginaFunciones_compras.php",
                    method: "POST",
                    data: {
                        'funcion': 2, //BUSCAR PRODUCTO POR SU CODIGO D BARRAS
                        'codigo_producto': data['codigo_producto'],
                        'cantidad_a_comprar': data['cantidad'],
                        //'idProducto' : data['id']
                    },
                    dataType: 'json',
                    success: function(respuesta) {

                         if (parseInt(respuesta['existe']) == 0) {

                            return Swal.fire(" El producto " + data['descripcion_producto'] + " ya no tiene stock","error");

                            $("#iptCodigoVenta").val("");
                            $("#iptCodigoVenta").focus();

                        } else {

                            // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
                            tablaCompra.cell(index, 5).data(parseFloat(data['cantidad']) + 1 + ' Und(s)').draw();

                            // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
                            NuevoPrecio = (parseInt(data['cantidad']) * data['precio_compra_producto'].replace("$ ", "")).toFixed(2);
                            NuevoPrecio = "$ " + NuevoPrecio;
                            tablaCompra.cell(index, 7).data(NuevoPrecio).draw();

                            nuevoImpuesto = (parseInt(data['cantidad']) * data['valorImpuesto'].replace("$ ", "")).toFixed(2);
                            nuevoImpuesto = "$ " + nuevoImpuesto;
                            tablaCompra.cell(index, 12).data(nuevoImpuesto).draw();


                            // RECALCULAMOS TOTALES
                            recalcularTotales();
                        }
                    }
                });
        }
    });

    if(producto_repetido == 1){
        return;   
    } 

    $.ajax({
        url: "funciones/paginaFunciones_compras.php",
        method: "POST",
        data: {
            'funcion': 3, //BUSCAR PRODUCTOS POR SU CODIGO DE BARRAS
            'codigo_producto': codigo_producto,
        },
        dataType: 'json',
        success: function(respuesta) {
            //console.log("respues linea 452 "+respuesta);
            /*===================================================================*/
            //SI LA RESPUESTA ES VERDADERO, TRAE ALGUN DATO
            /*===================================================================*/
            if (respuesta) {

                var TotalVenta = 0.00;
                //console.log(respuesta['aplica_peso']);

                if (respuesta['aplica_peso'] == 1) {
                
                    tablaCompra.row.add({
                        //'id': itemProducto,
                        'id': respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Kg(s)',
                        'precio_compra_producto': respuesta['precio_compra_producto'],
                        'total' : respuesta['total'],
                        'acciones': "<center>" +
                                        "<span class='btnIngresarPeso text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                                        "<i class='fas fa-balance-scale fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>" +
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'valorImpuesto':respuesta['valorImpuesto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                } else {

                    tablaCompra.row.add({
                         'id': respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Und(s)',
                        'precio_compra_producto': respuesta['precio_compra_producto'],
                        'total' : respuesta['total'],
                        'acciones': "<center>" +
                                        "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                                        "<i class='fas fa-cart-plus fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                                        "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                                        "</span> " +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'valorImpuesto':respuesta['valorImpuesto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                }

                //  Recalculamos el total de la venta
                recalcularTotales();

            /*===================================================================*/
            //SI LA RESPUESTA ES FALSO, NO TRAE ALGUN DATO
            /*===================================================================*/
            } else {
                
                return Swal.fire(" El producto no existe","error");

                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();
            }

        }
    }); 

}

/*===================================================================*/
    //FUNCION PARA LIMPIAR TOTALMENTE EL CARRITO DE VENTAS
/*===================================================================*/
function vaciarListado() {
    tablaCompra.clear().draw();
    LimpiarInputs();
}

function LimpiarInputs()
{
    $("#txt_fechaCompra").val('');
    $("#txt_folioCompra").val('');
    $("#cmb_proveedor").val(-1);

    $("#iptCodigoVenta").val('');
    $("#iptCantidad").val('');
    $("#iptCostoU").val('');

    $("#totalVenta").html("0.00");
}


function obtenerUltimoCosto(valorProducto)
{
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_compras.php",
        method: "POST",
        data: {
            'funcion': 4,
            'codigo_producto': valorProducto
        },
        dataType: 'json',
        success: function(respuesta) {

            $("#iptCostoU").val(respuesta['valor']);

        }
    });
}

function agregarProductoTable()
{
    var valorProducto=valorProducto;
    var producto=$("#iptCodigoVenta").val();
    var cantidad= $("#iptCantidad").val();
    var costoU= $("#iptCostoU").val();

    var costoUnitario = parseFloat(costoU).toFixed(2);
    var totalCompra = parseFloat(cantidad*costoU).toFixed(2);

    //console.log("producto "+producto);

    if(producto=="") // || cantidad<0 || cantidad.length==0 ||  costoU<0 || costoU.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Debe selecccionar un Producto","warning");
    }

    if(cantidad<=0 || cantidad=="")
    {
        return Swal.fire("Mensaje De Advertencia","Debe Ingresar una Cantidad correcta","warning");
    }

    if(costoU<=0 || costoU=="")
    {
        return Swal.fire("Mensaje De Advertencia","Debe Ingresar el Costo","warning");
    }

    $.ajax({
        url: "funciones/paginaFunciones_compras.php",
        method: "POST",
        data: {
            'funcion': 3, //BUSCAR PRODUCTOS POR SU CODIGO DE BARRAS
            'codigo_producto': producto
        },
        dataType: 'json',
        success: function(respuesta){
            if(respuesta)
            {
                var TotalVenta=0.00;
                var ivaProducto=0.00;

                if(respuesta['idImpuesto']==4)
                {
                    ivaProducto=parseFloat(costoU-(costoU/1.16)).toFixed(2);
                }
                
                if(respuesta['aplica_peso'] == 1){

                    tablaCompra.row.add({
                        'id':respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': cantidad + ' Kg(s)',
                        'precio_compra_producto': '$ '+ costoUnitario,
                        'total' : '$ '+ totalCompra,
                        'acciones': "<center>" +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'valorImpuesto':ivaProducto
                    }).draw();
                    limpiarProductos()
                }else{
                    tablaCompra.row.add({
                        'id':respuesta['id'],
                        'codigo_producto': respuesta['codigo_producto'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': cantidad + ' Und(s)',
                        'precio_compra_producto': '$ '+ costoUnitario,
                        'total' : '$ '+ totalCompra,
                        'acciones': "<center>" +
                                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                                        "<i class='fas fa-trash fs-5'> </i> " +
                                        "</span>"+
                                    "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'valorImpuesto':ivaProducto
                    }).draw();
                    limpiarProductos()
                }
                recalcularTotales();

            }else{
                return Swal.fire(" El producto no existe ","error");

                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();
            }
        }

    });

    
}

function limpiarProductos()
{
    $("#iptCodigoVenta").val('');
    $("#iptCantidad").val('');
    $("#iptCostoU").val('');
}

function registrar_compra()
{
    var count = 0;
    var aux='';
    var arrProductos='';
    var cantidad=0;

    var fechaCompra=$("#txt_fechaCompra").val();
    var folioCompra=$("#txt_folioCompra").val();
    var idProveedor=$("#cmb_proveedor").val();
    var totalVenta = $("#totalVenta").html();
    var tipoCompra = $("#cmb_tipoCompra").val();

    
    if(fechaCompra=="" || folioCompra.length==0 || idProveedor==-1 || tipoCompra==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos Fecha compra, Folio y Proveedor son obligatorios","warning");
    }
    
    
    tablaCompra.rows().eq(0).each(function(index) {
        count = count + 1;
    });

   
    if (count > 0)
    {
        
        tablaCompra.rows().eq(0).each(function(index)
        {
            var row = tablaCompra.row(index);

            var data = row.data();

            var aplicaPeso=data['aplica_peso'];

            if(aplicaPeso==1)
            {
                cantidad=data['cantidad'].replace("Kg(s)","");
            }else{
                cantidad=data['cantidad'].replace("Und(s)","");
            }

            aux='{"id":"'+data['id']+'","codigo_producto":"'+data['codigo_producto']+'","descripcion_producto":"'+data['descripcion_producto']
                +'","cantidad":"'+cantidad+'","precio_compra_producto":"'+data['precio_compra_producto'].replace("$ ","")
                +'","total":"'+data['total'].replace("$ ","")+'","iva":"'+data['valorImpuesto'].replace("$ ","")+'"}';
            
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

        var cadObj='{"fechaCompra":"'+fechaCompra+'","folioCompra":"'+folioCompra+'","idProveedor":"'+idProveedor+'","totalCompra":"'+parseFloat(totalVenta)+'","tipoCompra":"'+tipoCompra+'","arrProductos":['+arrProductos+']}';
        
        $.ajax({
            url: "funciones/paginaFunciones_compras.php",
            method: "POST",
            data: {
                'funcion': 5,
                'cadObj': cadObj
            },
            dataType:'json',
            success: function(respuesta) {
               
                if(parseInt(respuesta['existe']) == 1)
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Compra Registrada',
                        showConfirmButton: false,
                        timer: 1500
                    }) 
                    vaciarListado();
                    limpiarProductos();
                    
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'No se pudo registrar la Compra',
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
    //FUNCION PARA RECALCULAR LOS TOTALES DE VENTA
/*===================================================================*/
function recalcularTotales()
{
    var TotalVenta = 0.00;
    var totalIVA = 0.00;
    var cantidad=0;

    tablaCompra.rows().eq(0).each(function(index) {

        var row = tablaCompra.row(index);
        var data = row.data();
        
        TotalVenta = parseFloat(TotalVenta) + parseFloat(data['total'].replace("$ ", ""));
        
    });

    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));

    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();
    
}

function imprimirCompra(idCompra)
{
    var arrParam='folio='+idCompra;

    enviarParametrosPagina('reportes/compra.php',arrParam);
}










