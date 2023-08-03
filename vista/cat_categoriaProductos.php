<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/cat_categorias.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE CATEGORIA DE PRODUCTOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Cat. Categorias</li>
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
                <table id="tbl_categorias" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Nombre Categoria</th>
                            <th>Aplica peso</th>
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
                <h5 class="modal-title">REGISTRAR CATEGORIA DE PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nomCategoria">
                        <span class="small">Nombre de la Categoría</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nomCategoria" placeholder="Nombre Categoría"
                        style="text-transform:uppercase;">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion" maxlength="150"
                        placeholder="Maximo 150 caracteres" style="text-transform:uppercase;"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_aplicaPeso">
                        <span class="small">Aplica Peso</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_aplicaPeso" style="width: 100%;" class="form-control">
                            <option value=" -1">Seleccionar...</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_Categoria()">Guardar</button>
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
                <h5 class="modal-title">MODIFICAR CATEGORIA DE PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_nomCategoria_modificar">
                        <span class="small">Nombre de la Categoría</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nomCategoria_modificar"
                        placeholder="Nombre Categoría" style="text-transform:uppercase;">
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_descripcion_modificar">
                        <span class="small">Descripción</span>
                    </label>
                    <textarea class="form-control " rows="2" id="txt_descripcion_modificar" maxlength="150"
                        placeholder="Maximo 150 caracteres" style="text-transform:uppercase;"></textarea>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_aplicaPeso_modificar">
                        <span class="small">Aplica Peso</span><span class="text-danger"> *</span>
                    </label>
                    <select name="" id="txt_aplicaPeso_modificar" style="width: 100%;" class="form-control">
                            <option value="-1">Seleccionar...</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
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
                    <input type="text" id="txtIdCategoria" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_categorias()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>





<script>
$(document).ready(function() {
    listarCategorias();
});
</script>