var table;
var myTable


function obtenerDatosTarjetas()
{
    $.ajax({
        url: "funciones/paginaFunciones_dashboard.php",
        method: 'POST',
        data:{
            funcion: "1"
        },
        dataType: 'json',
        success: function(respuesta){
            //console.log("respuesta", respuesta);
            $("#totalVentaMes").html(respuesta['totalVentaMes']);

            $("#totalVentasDia").html(respuesta['totalVentaDia']);

            $("#totalAdeudo").html(respuesta['totalAdeudos']);

            $("#totalGastos").html(respuesta['importeTotalGastoMes']);
        }


    });
}

function listarPedidosVentas()
{
    table = $("#tbl_pedidos_ventas").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
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
          url: "funciones/paginaFunciones_dashboard.php",
          type: "POST",
          data:{
              funcion: "2"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nomCliente" },
            {data: "fechaPedido" },
            {data: "fechaEntrega" },
            {data: "importeTotal" },
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
                    //className:'control'
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
                    width: "15%",
                    className: "text-right",
                    targets:5
                },
                {
                    width: "15%",
                    targets:6,
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


