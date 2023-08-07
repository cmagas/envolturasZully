<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/cat_personal.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE PERSONAL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catalogo Personal</li>
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
                <table id="tbl_personal" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Nombre</th>
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
<div class="modal" id="modal_registro_personal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR PERSONAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-9 div_etiqueta">
                    <label for="txt_nombre">
                        <span class="small">Nombre del personal</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre" maxlength="150">
                </div>

                <div class="col-lg-3 div_etiqueta">
                    <label for="txt_telefono">
                        <span class="small">Teléfono (10 Dig)</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono" maxlength="10">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle" placeholder="Nombre" maxlength="150">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero" placeholder="Numero">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia" placeholder="Colonia" maxlength="150">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal" placeholder="Cod. Postal">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_localidad">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_localidad" placeholder="localidad" maxlength="150">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_personal()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_personal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR DATOS DE PERSONAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-9 div_etiqueta">
                    <label for="txt_nombre_modificar">
                        <span class="small">Nombre del personal</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modificar" placeholder="Nombre"
                        maxlength="150">
                </div>

                <div class="col-lg-3 div_etiqueta">
                    <label for="txt_telefono_modificar">
                        <span class="small">Teléfono (10 Dig)</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono_modificar" maxlength="10">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_calle_modificar">
                        <span class="small">Calle</span>
                    </label>
                    <input type="text" class="form-control" id="txt_calle_modificar" placeholder="Nombre"
                        maxlength="150">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_numero_modificar">
                        <span class="small">Número</span>
                    </label>
                    <input type="text" class="form-control" id="txt_numero_modificar" placeholder="Numero">
                </div>

                <div class="col-lg-10 div_etiqueta">
                    <label for="txt_colonia_modificar">
                        <span class="small">Colonia</span>
                    </label>
                    <input type="text" class="form-control" id="txt_colonia_modificar" placeholder="Colonia"
                        maxlength="150">
                </div>

                <div class="col-lg-2 div_etiqueta">
                    <label for="txt_codPostal_modificar">
                        <span class="small">Cod. Postal</span>
                    </label>
                    <input type="text" class="form-control" id="txt_codPostal_modificar" placeholder="Cod. Postal">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_localidad_modificar">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_localidad_modificar" placeholder="localidad"
                        maxlength="150">
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
                    <input type="text" id="txtIdPersonal" hidden>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_personal()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    listarPersonal();
});
</script>