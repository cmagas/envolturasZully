<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/impuestos.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE IMPUESTOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catalogo Impuestos</li>
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
                <table id="tbl_impuestos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Nombre del Impuesto</th>
                            <th>Valor (%)</th>
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
<div class="modal" id="modal_registro_impuesto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR IMPUESTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-8 div_etiqueta">
                    <label for="txt_impuesto">
                        <span class="small">Nombre del impuesto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_impuesto" placeholder="Nombre">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_valor">
                        <span class="small">% Valor</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_valor">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_impuesto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_impuesto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR IMPUESTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-8 div_etiqueta">
                    <label for="txt_impuesto_modifi">
                        <span class="small">Nombre del impuesto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_impuesto_modifi" placeholder="Nombre">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_valor_modifi">
                        <span class="small">% Valor</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_valor_modifi">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion_modifi">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modifi" maxlength="150"
                        placeholder="Maximo 150 caracteres"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                    <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="txtIdImpuesto" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_impuesto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    listarImpuestos();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})
</script>