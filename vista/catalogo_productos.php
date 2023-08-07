<?php
    include("conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/cat_productos.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE PRODUCTOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catalogo Productos</li>
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
                <table id="tbl_productos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Precio Men.</th>
                            <th>Precio May.</th>
                            <th>Precio Prod.</th>
                            <th>Exist.</th>
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
<div class="modal" id="modal_registro_producto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_subir" enctype="multipart/form-data">
                    <div class="row">

                        <!--Columna foto-->
                        <div class="col-12 div_etiqueta">
                            <div class="form-group mb-2">
                                <label for="iptImagen">
                                    <i class="fas fa-image fs-6"></i>
                                    <span class="small">Seleccione la Foto (.jpg, .png, .gif,
                                        .jpeg)</span>
                                </label>
                                <input type="file" class="form-control form-control-sm" id="iptImagen" name="iptImagen"
                                    accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 my-1">
                            <div style="width: 100%; height: 200px">
                                <img id="previewImg" src="fotos/no_imagen.png" class="border border-secondary"
                                    style="object-fit: cover; width: 100%; height: 100%;" alt="">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="row">

                                <!--Columna Nombre-->
                                <div class="col-lg-12 div_etiqueta">
                                    <label for="txt_nombre">
                                        <span class="small">Nombre del Producto</span><span class="text-danger">
                                            *</span>
                                    </label>
                                    <input type="text" class="form-control valor_texto" id="txt_nombre"
                                        name="txt_nombre">
                                </div>

                                <!--Columna Codigo Barra-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_codigoBarra">
                                        <span class="small">Codigo de Barra</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_codigoBarra" name="txt_codigoBarra"
                                        placeholder="Código del Producto">
                                </div>

                                <!--Columna Impuesto-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_impuesto">
                                        <span class="small">Impuesto</span><span class="text-danger"> *</span>
                                    </label>
                                    <select name="txt_impuesto" id="txt_impuesto" style="width: 100%;"
                                        class="form-control">
                                        <option value="-1">Seleccione el impuesto</option>
                                        <?php
                                            $Consulta="SELECT idImpuesto, CONCAT(nombreImpuesto,'[ ',valor,' ]') AS impuesto FROM 4002_impuesto WHERE situacion='1'";
                                            $con->generarOpcionesSelect($Consulta);
                                        ?>
                                    </select>
                                </div>

                                <!--Columna Categoria-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_categoria">
                                        <span class="small">Categoría</span><span class="text-danger"> *</span>
                                    </label>
                                    <select name="txt_categoria" id="txt_categoria" style="width: 100%;"
                                        class="form-control">
                                        <option value="-1">Seleccione la Categoría</option>
                                        <?php
                                            $Consulta="SELECT id_categoria,nombre_categoria FROM 4001_categorias WHERE situacion='1' ORDER BY nombre_categoria";
                                            $con->generarOpcionesSelect($Consulta);
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <!--Columna linea-->
                        <div class="col-lg-12">
                            <hr>
                        </div>

                        <div class="col-lg-4 div_etiqueta mt-3">
                            <label for="txt_precioCompra">
                                <span class="small">Precio de Compra</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioCompra"
                                name="txt_precioCompra" value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta mt-3">
                            <label for="txt_precioMayoreo">
                                <span class="small">Precio de Mayoreo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioMayoreo" name="txt_precioMayoreo"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta mt-3">
                            <label for="txt_precioMenudeo">
                                <span class="small">Precio de Menudeo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioMenudeo" name="txt_precioMenudeo"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_utilidad">
                                <span class="small">Utilidad vs Mayoreo</span>
                            </label>
                            <input type="text" class="form-control valor" id="txt_utilidad" name="txt_utilidad"
                                value="0" readonly>
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_stockMaximo">
                                <span class="small">Stock Máximo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_stockMaximo" name="txt_stockMaximo"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_stockMinimo">
                                <span class="small">Stock Mínimo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_stockMinimo" name="txt_stockMinimo"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_precioProducccion">
                                <span class="small">Precio producción</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioProducccion" name="txt_precioProducccion"
                                value="0">
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_producto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_producto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR DATOS DEL PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_subir" enctype="multipart/form-data">
                    <div class="row">

                        <!--Columna Nombre-->
                        <div class="col-lg-12 div_etiqueta">
                            <label for="txt_nombre_modificar">
                                <span class="small">Nombre del Producto</span><span class="text-danger">
                                    *</span>
                            </label>
                            <input type="text" class="form-control valor_texto" id="txt_nombre_modificar"
                                name="txt_nombre_modificar">
                        </div>

                        <!--Columna Codigo Barra-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_codigoBarra_modificar">
                                <span class="small">Codigo de Barra</span><span class="text-danger"> *</span>
                            </label>
                            <input type="text" class="form-control" id="txt_codigoBarra_modificar"
                                name="txt_codigoBarra_modificar" placeholder="Código del Producto">
                        </div>

                        <!--Columna Impuesto-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_impuesto_modificar">
                                <span class="small">Impuesto</span><span class="text-danger"> *</span>
                            </label>
                            <select name="txt_impuesto_modificar" id="txt_impuesto_modificar" style="width: 100%;"
                                class="form-control">
                                <option value="-1">Seleccione el impuesto</option>
                                <?php
                                    $Consulta="SELECT idImpuesto, CONCAT(nombreImpuesto,'[ ',valor,' ]') AS impuesto FROM 4002_impuesto WHERE situacion='1'";
                                    $con->generarOpcionesSelect($Consulta);
                                ?>
                            </select>
                        </div>

                        <!--Columna Categoria-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_categoria_modificar">
                                <span class="small">Categoría</span><span class="text-danger"> *</span>
                            </label>
                            <select name="txt_categoria_modificar" id="txt_categoria_modificar" style="width: 100%;"
                                class="form-control">
                                <option value="-1">Seleccione la Categoría</option>
                                <?php
                                    $Consulta="SELECT id_categoria,nombre_categoria FROM 4001_categorias WHERE situacion='1' ORDER BY nombre_categoria";
                                    $con->generarOpcionesSelect($Consulta);
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_precioCompra_modificar">
                                <span class="small">Precio de Compra</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioCompra_modificar"
                                name="txt_precioCompra_modificar" value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_precioMayoreo_modificar">
                                <span class="small">Precio Mayoreo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioMayoreo_modificar" name="txt_precioMayoreo_modificar"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_precioMenudeo_modificar">
                                <span class="small">Precio Menudeo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioMenudeo_modificar" name="txt_precioMenudeo_modificar"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_utilidad_modificar">
                                <span class="small">Utilidad</span>
                            </label>
                            <input type="text" class="form-control valor" id="txt_utilidad_modificar" name="txt_utilidad_modificar"
                                value="0" readonly>
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_stockMaximo_modificar">
                                <span class="small">Stock Máximo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_stockMaximo_modificar" name="txt_stockMaximo_modificar"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_stockMinimo_modificar">
                                <span class="small">Stock Mínimo</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_stockMinimo_modificar" name="txt_stockMinimo_modificar"
                                value="0">
                        </div>

                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_precioProduccion_modificar">
                                <span class="small">Precio producción</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control valor" id="txt_precioProduccion_modificar" name="txt_precioProduccion_modificar"
                                value="0">
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
                            <input type="text" id="txtIdProducto" hidden>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_producto()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>





<script>
$(document).ready(function() {
    listarProductos();
});
</script>