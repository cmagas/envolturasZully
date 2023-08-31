var table, ventas_desde, ventas_hasta;
var groupColumn = 1; //Columna por el cual se va a grupar
var importeTotalVenta=0.00;

function inicializarTablaVentas()
{
    $('#ventas_desde, #ventas_hasta').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })

    //Pone la fecha inicial principio de mes actual
    $("#ventas_desde").val(moment().startOf('month').format('DD/MM/YYYY'));
    //Pone la fecha actual
    $("#ventas_hasta").val(moment().format('DD/MM/YYYY'));

    table = $('#lstVentas').DataTable({
        "columnDefs": [
            { visible: false, targets: [groupColumn,0] },
            {
                targets: [1,2,3,4,5,6,7],
                orderable: false
            }
        ],
        "order": [[ groupColumn, 'asc' ]],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'print', 'pageLength',
        ],
        ordering: true,
        orderCellsTop: true,
        fixedHeader: true,
        scrollX: false,
        lengthMenu: [0, 5, 10, 15, 20, 50],
        "pageLength": 15,
        ajax: {
            async: false,
            url: 'funciones/paginaFunciones_caja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'funcion': 8,
                'fechaDesde': ventas_desde,
                'fechaHasta' : ventas_hasta
            }
        },
        columns: [
            { data: "id"},
            { data: "nro_boleta"},
            { data: "codigo_producto"},
            { data: "nombre_categoria"},
            { data: "descripcion_producto"},
            { data: "cantidad"},
            { data: "total_venta"},
            { data: "fecha_venta"}
        ],
        drawCallback: function (settings) {
                
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {                
                 //console.log("🚀 ~ file: administrar_ventas.php ~ line 61 ~ group : ", group)               
                if ( last !== group ) {

                    const data = group.split("-");
                    var nroBoleta = data[0];
                    nroBoleta = nroBoleta.split(":")[1].trim();   
                    
                    var monto=data[1];
                    monto=monto.split(":")[1].trim();
                    var algo=parseFloat(monto.replace('$',''));

                    importeTotalVenta= parseFloat(importeTotalVenta)+ parseFloat(algo);

                    $(rows).eq(i).before(
                        
                        '<tr class="group">'+
                            '<td colspan="7" class="fs-6 fw-bold fst-italic bg-success text-white"> ' +
                            '<i nroBoleta = ' + nroBoleta + ' class="fas fa-print fs-6 text-warning mx-2 btnImprimirVenta fw-bold"  style="cursor:pointer;"></i> '+        
                            group +  
                            '</td>'+
                        '</tr>'
                        
                    );

                    last = group;
                }
            } );

            $("#totalVenta").html(importeTotalVenta.toFixed(2))
        },

        language: idioma_espanol
    });
}

/*========================================================
    EVENTO PARA FILTRAR VENTAS SEGUN RANGO DE FECHAS
========================================================*/
$("#btnFiltrar").on('click',function(){
    
    table.destroy();
    
    if($("#ventas_desde").val()==''){
        ventas_desde='01/01/1970';
    }else{
        ventas_desde= $("#ventas_desde").val();
    }

    if($("#ventas_hasta").val()==''){
        ventas_hasta='01/01/1970';
    }else{
        ventas_hasta= $("#ventas_hasta").val();
    }

    ventas_desde = ventas_desde.substr(6,4) + '-' + ventas_desde.substr(3,2) + '-' + ventas_desde.substr(0,2);
    ventas_hasta = ventas_hasta.substr(6,4) + '-' + ventas_hasta.substr(3,2) + '-' + ventas_hasta.substr(0,2);

    var groupColumn=1;

    table = $('#lstVentas').DataTable({

        "columnDefs": [
            { visible: false, targets: [groupColumn,0] },
            {
                targets: [2,3,4,5,6,7],
                orderable: false
            }
        ],
        "order": [[ groupColumn, 'asc' ]],
        dom: 'Bfrtip',
        buttons: [
            'excel', 'print', 'pageLength',

        ],
        lengthMenu: [0, 5, 10, 15, 20, 50],
        "pageLength": 15,
        ajax: {
            url: 'funciones/paginaFunciones_caja.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'funcion': 8,
                'fechaDesde': ventas_desde,
                'fechaHasta' : ventas_hasta
            }
        },
        columns: [
            { data: "id"},
            { data: "nro_boleta"},
            { data: "codigo_producto"},
            { data: "nombre_categoria"},
            { data: "descripcion_producto"},
            { data: "cantidad"},
            { data: "total_venta"},
            { data: "fecha_venta"}
        ],
        drawCallback: function (settings) {
                
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {                
                 //console.log("🚀 ~ file: administrar_ventas.php ~ line 61 ~ group : ", group)               
                if ( last !== group ) {

                    const data = group.split("-");
                    var nroBoleta = data[0];
                    nroBoleta = nroBoleta.split(":")[1].trim();   
                    
                    var monto=data[1];
                    monto=monto.split(":")[1].trim();
                    var algo=parseFloat(monto.replace('$',''));

                    importeTotalVenta= parseFloat(importeTotalVenta)+ parseFloat(algo);

                    $(rows).eq(i).before(
                        '<tr class="group">'+
                            '<td colspan="7" class="fs-6 fw-bold fst-italic bg-success text-white"> ' +
                            '<i nroBoleta = ' + nroBoleta + ' class="fas fa-print fs-6 text-warning mx-2 btnImprimirVenta fw-bold"  style="cursor:pointer;"></i> '+
                                    group +  
                            '</td>'+
                        '</tr>'
                    );

                    last = group;
                }
            } );

            $("#totalVenta").html(importeTotalVenta.toFixed(2))
        },
        language: idioma_espanol
    });

})

/*========================================================
    EVENTO PARA IMPRIMIR VENTA
========================================================*/
$('#lstVentas tbody').on('click','.btnImprimirVenta', function(){
    var data = table.row($(this).parents("tr")).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
      }
    var nroBoleta = $(this).attr("nroBoleta");

    reImprimirTicket(nroBoleta)

})




function reImprimirTicket(folio)
{
    var arrParam='folio='+folio;

    enviarParametrosPagina('reportes/ticket_venta.php',arrParam);
}