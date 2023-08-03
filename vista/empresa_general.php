<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");

    

?>
<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/empresa_general.js"></script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CONTROL DE EMPRESAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Empresas</li>
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
                <table id="tbl_empresas" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Empresa</th>
                            <th>Teléfono</th>
                            <th>Email</th>
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
                <h5 class="modal-title">REGISTRAR EMPRESA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoEmpresa">
                        <span class="small">Tipo de Empresa</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoEmpresa" name="cmb_tipoEmpresa"
                        style="width: 100%;" onchange="tipoEmpresa(this.value)">
                        <option value="-1">Seleccione el Tipo de Empresa</option>
                        <?php
                            $Consulta="SELECT valor,nombreElemento FROM 1_catalogoVarios WHERE tipoElemento='3' ORDER BY idElemento";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_nombre">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre" name="txt_nombre"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apPaterno">
                        <span class="small">Apellido Paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno" name="txt_apPaterno"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apMaterno">
                        <span class="small">Apellido Materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno" name="txt_apMaterno"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc" name="txt_rfc"
                        style="text-transform:uppercase;">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_telefono">
                        <span class="small">Teléfono (10 dig)</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono" name="txt_telefono"
                        style="text-transform:uppercase;">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_email">
                        <span class="small">E-mail</span><span class="text-danger"> *</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email" name="txt_email"
                        style="text-transform:uppercase;">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado" name="cmb_estado"
                        style="width: 100%;" onchange="obtenerMunicipiosPorEstado(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                            $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>

                <!--Columna Municipio-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio" name="txt_municipio" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el Municipio</option>
                    </select>
                </div>

                <!--Columna Calle-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle" name="txt_calle" maxlength="100"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Numero-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" maxlength="10"
                        style="text-transform:uppercase;">
                </div>

                <!--Columna Colonia-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia" name="txt_colonia" maxlength="100"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Codigo Postal-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal" name="txt_codPostal" maxlength="10">
                </div>

                <!--Columna Localidad-->
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad" name="txt_Localidad" maxlength="200"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_empresas()">Guardar</button>
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
                <h5 class="modal-title">MODIFICAR DATOS DE EMPRESA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoEmpresa_modificar">
                        <span class="small">Tipo de Empresa</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoEmpresa_modificar"
                        name="cmb_tipoEmpresa_modificar" style="width: 100%;" onchange="tipoEmpresa2(this.value)">
                        <option value="-1">Seleccione el Tipo de Empresa</option>
                        <?php
                            $Consulta="SELECT valor,nombreElemento FROM 1_catalogoVarios WHERE tipoElemento='3' ORDER BY idElemento";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_nombre_modificar">
                        <span class="small">Nombre o Razón Social</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modificar" name="txt_nombre_modificar"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apPaterno_modificar">
                        <span class="small">Apellido Paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno_modificar" name="txt_apPaterno_modificar"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apMaterno_modificar">
                        <span class="small">Apellido Materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno_modificar" name="txt_apMaterno_modificar"
                        style="text-transform:uppercase;" disabled>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc_modificar">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc_modificar" name="txt_rfc_modificar"
                        style="text-transform:uppercase;">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_telefono_modificar">
                        <span class="small">Teléfono (10 dig)</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono_modificar" name="txt_telefono_modificar"
                        style="text-transform:uppercase;">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_email_modificar">
                        <span class="small">E-mail</span><span class="text-danger"> *</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modificar" name="txt_email_modificar"
                        style="text-transform:uppercase;">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado_modificar">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado_modificar" name="cmb_estado_modificar"
                        style="width: 100%;" onchange="obtenerMunicipiosPorEstadoModi(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                            $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>

                <!--Columna Municipio-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio_modificar">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio_modificar" name="txt_municipio_modificar" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el Municipio</option>
                    </select>
                </div>

                <!--Columna Calle-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle_modificar">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle_modificar" name="txt_calle_modificar" maxlength="100"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Numero-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero_modificar">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero_modificar" name="txt_numero_modificar" maxlength="10"
                        style="text-transform:uppercase;">
                </div>

                <!--Columna Colonia-->
                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia_modificar">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia_modificar" name="txt_colonia_modificar" maxlength="100"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

                <!--Columna Codigo Postal-->
                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal_modificar">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal_modificar" name="txt_codPostal_modificar" maxlength="10">
                </div>

                <!--Columna Localidad-->
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad_modificar">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad_modificar" name="txt_Localidad_modificar" maxlength="200"
                        placeholder="Maximo 100 caract." style="text-transform:uppercase;">
                </div>

                <div class="col-lg-6 div_etiqueta">
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
                    <input type="text" id="txtIdEmpresa" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_empresas()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    listarEmpresasGeneral();

    $('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
        limpiarCamposModalRegistro();
    })
});
</script>