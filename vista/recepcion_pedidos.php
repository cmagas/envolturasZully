<?php
    session_start();
    include("conexionBD.php");

    $cod_unidad=$_SESSION['cod_unidad'];

    $fechaActual=date("Y-m-d");
?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/recepcionPedidos.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">RECEPCION DE PEDIDOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Recepción Pedidos</li>
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
                <table id="tbl_pedidos" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Nombre personal</th>
                            <th>Fecha</th>
                            <th>Total Pedido</th>
                            <th>Piezas</th>
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
                <h5 class="modal-title">REGISTRAR PEDIDO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <!--SELECCION DEL PERSONAL-->
                    <div class="col-lg-9 div_etiqueta">
                        <label for="cmb_Personal">
                            <span class="small">Nombre del Personal</span><span class="text-danger"> *</span>
                        </label>
                        <select class="js-example-basic-single form-control" id="cmb_Personal" style="width: 100%;">
                            <option value="-1">Seleccione el Personal</option>
                            <?php
                                $Consulta="SELECT idPersonal,nombre FROM 4014_cat_personal WHERE cod_unidad='".$cod_unidad."' AND situacion='1' ORDER BY nombre";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                        </select>
                    </div>

                    <!--FECHA AJUSTE-->
                    <div class="col-lg-3 div_etiqueta">
                        <label for="txt_fechaAjuste">
                            <span class="small">Fecha recepción</span><span class="text-danger"> *</span>
                        </label>
                        <input type="date" class="form-control" id="txt_fechaAjuste" value="<?php echo $fechaActual;?>">
                    </div>

                </div>

                <div class="row mt-3">

                    <!--SELECCION DE PRODUCTO-->
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

                    <!--INGRESAR CANTIDAD-->
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
                    <!-- ETIQUETA QUE MUESTRA LA SUMA TOTAL DE LOS PRODUCTOS AGREGADOS AL LISTADO -->
                    <div class="col-md-6">
                        <h4>Total Pedido: $ <span id="totalPedidos">0.00</span></h4>
                    </div>

                    <!-- BOTONES PARA VACIAR LISTADO Y COMPLETAR EL AJUSTE -->
                    <div class="col-md-6 text-right">
                        <button class="btn btn-primary" id="btnAgregarProducto">
                            <i class="fas fa-shopping-cart"></i> Agregar Producto
                        </button>
                        <button class="btn btn-danger" id="btnVaciarListado">
                            <i class="far fa-trash-alt"></i> Vaciar Listado
                        </button>
                    </div>

                    <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                    <div class="col-md-12 mt-3">
                        <table id="lstProductosPedido" class="display nowrap table-striped w-100 shadow">
                            <thead class="bg-info text-left fs-6">
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th class="text-center">Opciones</th>
                                    <th>costoProd</th>
                                    <th>totalProd</th>
                                </tr>
                            </thead>
                            <tbody class="small text-left fs-6">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_pedidos()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    listarPedidos();

     /* ======================================================================================
        INICIALIZAR LA TABLA DE VENTAS
    ======================================================================================*/
    inicializarTablaProductos();

    /* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ======================================================================================*/
    listadoProducto();

});
</script>