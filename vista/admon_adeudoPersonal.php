<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/admon_pagosPersonal.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">ADMINISTRACION DE PAGOS PERSONAL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Pagos Personal</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!--DATOS-->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_pagosPersonal" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Nombre Personal</th>
                            <th>Fecha Entrega</th>
                            <th>Importe</th>
                            <th>Total Pago</th>
                            <th>Estatus</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_registrar_pago" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR PAGOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nombrePersonal">
                        <span class="small">Nombre Personal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombrePersonal" disabled>
                </div>

                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_folioPedido">
                        <span class="small">Pedido</span>
                    </label>
                    <input type="text" class="form-control" id="txt_folioPedido" disabled>
                </div>

                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_fechaPago">
                        <span class="small">Fecha Pago</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaPago">
                </div>

                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_importe">
                        <span class="small">Importe</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_importe">
                </div>
                
                <div class="col-lg-12">
                    <input type="text" id="txtIdPedido" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="guardar_pago()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    listarAdeudos();
});
</script>