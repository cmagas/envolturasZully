var table;
function listarAdeudos() {
    table = $("#tbl_pagosPersonal").DataTable({
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
          url: "funciones/paginaFunciones_pagosPersonal.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nombrePersonal" },
            { data: "fechaRecepcion" },
            { data: "totalAdeudo" },
            { data: "totalAbono" },
            { data: "situacion"},
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
                    targets:6
                },
                {
                    width: "10%",
                    targets:7,
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

$("#tbl_pagosPersonal").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_registrar_pago").modal({ backdrop: "static", keyboard: false });
    $("#modal_registrar_pago").modal("show");
    
    
    $("#txtIdPedido").val(data.id);
    $("#txt_nombrePersonal").val(data.nombrePersonal);
    $("#txt_folioPedido").val(data.id);
   
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function(){
    limpiarCamposModalRegistro();
})

function guardar_pago()
{
    var idPedido=$("#txtIdPedido").val();
    var fechaPago=$("#txt_fechaPago").val();
    var importe=$("#txt_importe").val();

    if(fechaPago.length==0 || importe.length==0 || importe<0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idPedido":"'+idPedido+'","fechaPago":"'+fechaPago+'","importe":"'+importe+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registrar_pago").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Pago registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });

            listarAdeudos();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al registrar el pago',
                showConfirmButton: false,
                timer: 1500
              });
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_pagosPersonal.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function limpiarCamposModalRegistro()
{
    $("#txt_fechaPago").val('');
    $("#txt_importe").val('');
}