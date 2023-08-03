<?php
    include("conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/cat_clientes.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE CLIENTES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Cat. Clientes</li>
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
                <table id="tbl_clientes" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Localidad</th>
                            <th>Estado</th>
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
<div class="modal" id="modal_registro_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="cmb_tipo">
                        <span class="small">Tipo de Cliente</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipo" style="width: 100%;">
                        <option value="-1">Seleccione el tipo</option>
                        <option value="1">Persona Física</option>
                        <option value="2">Persona Moral</option>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc" maxlength="12" placeholder="RFC">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_razonSocial">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_razonSocial" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email">
                        <span class="small">Correo electrónico</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_telefono">
                        <span class="small">Teléfono</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono" maxlength="10">
                </div>

                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Dirección</h3>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccionar Municipio</option>
                    </select>
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_localidad">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_localidad" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_cliente()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificacion_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR DATOS DE CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-4 div_etiqueta">
                    <label for="cmb_tipo_modificar">
                        <span class="small">Tipo de Cliente</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipo_modificar" style="width: 100%;">
                        <option value="-1">Seleccione el tipo</option>
                        <option value="1">Persona Física</option>
                        <option value="2">Persona Moral</option>
                    </select>
                </div>

                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc_modificar">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc_modificar" maxlength="12" placeholder="RFC">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_razonSocial_modificar">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_razonSocial_modificar" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email_modificar">
                        <span class="small">Correo electrónico</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modificar">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_telefono_modificar">
                        <span class="small">Teléfono</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono_modificar" maxlength="10">
                </div>

                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Dirección</h3>
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado_modificar">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado_modificar" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado2(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio_modificar">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio_modificar" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccionar Municipio</option>
                    </select>
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle_modificar">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle_modificar">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero_modificar">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero_modificar">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia_modificar">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia_modificar">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal_modificar">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal_modificar">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_localidad_modificar">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_localidad_modificar" maxlength="150"
                        placeholder="Maximo 150 caract.">
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
                    <input type="text" id="txtIdCliente" hidden>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_cliente()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    listarClientes();
});
</script>