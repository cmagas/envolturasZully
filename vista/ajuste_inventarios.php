<?php
session_start();
include("conexionBD.php");

$fechaActual=date("Y-m-d");


?>
<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/ajusteInventarios.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">AJUSTE AL INVENTARIO</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Ajuste Inventario</li>
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
                <table id="tbl_ajusteInventarios" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Tipo de Ajuste</th>
                            <th>Fecha</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR AJUSTE AL INVENTARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <!--TIPO AJUSTE-->
                    <div class="col-lg-6 div_etiqueta">
                        <label for="txt_tipoAjuste">
                            <span class="small">Tipo de Ajuste</span><span class="text-danger"> *</span>
                        </label>
                        <select name="" id="txt_tipoAjuste" style="width: 100%;" class="form-control">
                            <option value=" -1">Seleccionar...</option>
                            <option value="1">Ajuste de Entrada</option>
                            <option value="2">Ajuste de Salida</option>
                            <option value="4">Salida por Merma</option>
                        </select>
                    </div>

                    <!--FECHA AJUSTE-->
                    <div class="col-lg-6 div_etiqueta">
                        <label for="txt_fechaAjuste">
                            <span class="small">Fecha Ajuste</span><span class="text-danger"> *</span>
                        </label>
                        <input type="date" class="form-control" id="txt_fechaAjuste" value="<?php echo $fechaActual;?>"
                            disabled>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-md-9 ">
                        <div class="form-group mb-2">
                            <label class="col-form-label" for="iptCodigoVenta">
                                <i class="fas fa-barcode fs-6"></i>
                                <span class="small">Producto</span><span class="text-danger"> *</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                                placeholder="Ingrese el código o el nombre del producto">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="col-form-label" for="iptCantidad">
                                <span class="small">Cantidad</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" id="iptCantidad"
                                placeholder="Ingrese la Cantidad">
                        </div>
                    </div>
                </div>

                <div class="row  mt-5">
                    <!-- BOTONES PARA VACIAR LISTADO Y COMPLETAR EL AJUSTE -->
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" id="btnAgregarProducto">
                            <i class="fas fa-shopping-cart"></i> Agregar Producto
                        </button>
                        <button class="btn btn-danger" id="btnVaciarListado">
                            <i class="far fa-trash-alt"></i> Vaciar Listado
                        </button>
                    </div>

                    <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                    <div class="col-md-12 mt-3">
                        <table id="lstProductosAjuste" class="display nowrap table-striped w-100 shadow">
                            <thead class="bg-info text-left fs-6">
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="small text-left fs-6">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_ajuste()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        listarCategorias();

        inicializarTablaAjuste();

        /* ======================================================================================
        TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
        ======================================================================================*/
        listadoProductoAjuste();
    });
</script>