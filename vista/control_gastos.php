<?php
    include("conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/control_gasto.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CONTROL DE GASTOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Control Gastos</li>
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
                <table id="tbl_controlGastos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Concepto Gasto </th>
                            <th>Fecha</th>
                            <th>Importe</th>
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
<div class="modal" id="modal_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR GASTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoGasto">
                        <span class="small">Tipo de Gasto</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoGasto" style="width: 100%;">
                        <option value="-1">Seleccione el Tipo</option>
                        <?php
                                $Consulta="SELECT idTipoGasto,nombreTipo FROM 4021_cat_tipoGasto WHERE situacion='1' ORDER BY nombreTipo";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaGasto">
                        <span class="small">Fecha del Gasto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaGasto">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_importe">
                        <span class="small">Importe</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_importe">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                        placeholder="Maximo 150 caracteres" style="text-transform:uppercase;"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_Gasto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR DATOS DE GASTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoGasto_modificar">
                        <span class="small">Tipo de Gasto</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoGasto_modificar" style="width: 100%;">
                        <option value="-1">Seleccione el Tipo</option>
                        <?php
                                $Consulta="SELECT idTipoGasto,nombreTipo FROM 4021_cat_tipoGasto WHERE situacion='1' ORDER BY nombreTipo";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaGasto_modificar">
                        <span class="small">Fecha del Gasto</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaGasto_modificar">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_importe_modificar">
                        <span class="small">Importe</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_importe_modificar">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion_modificar">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres" style="text-transform:uppercase;"></textarea>
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <input type="text" id="txtIdGasto" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_Gasto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        listarControlGastos();
    });
</script>