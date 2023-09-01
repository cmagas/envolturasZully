var table, ventas_desde, ventas_hasta;

function inicializarTablaVentas()
{
    $('#ventas_desde, #ventas_hasta').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })

    //Pone la fecha inicial principio de mes actual
    $("#ventas_desde").val(moment().startOf('month').format('DD/MM/YYYY'));
    //Pone la fecha actual
    $("#ventas_hasta").val(moment().format('DD/MM/YYYY'));
}