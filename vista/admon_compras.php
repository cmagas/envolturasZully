<?php
    session_start();
    include("conexionBD.php");

    $cod_unidad=$_SESSION['cod_unidad'];
?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/compras.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">MODULO DE COMPRAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Compras</li>
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
                <table id="tbl_compras" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Fecha compra</th>
                            <th>Proveedor</th>
                            <th>Importe</th>
                            <th>Forma Pago</th>
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

<!--MODAL NUEVO COMPRA-->
<div class="modal" id="modal_registro_compras" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content contenidoModal">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR COMPRA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <!--FECHA COMPRA-->
                    <div class="col-lg-4 div_etiqueta">
                        <label for="txt_fechaCompra">
                            <span class="small">Fecha compra</span><span class="text-danger"> *</span>
                        </label>
                        <input type="date" class="form-control" id="txt_fechaCompra">
                    </div>

                    <!--FECHA COMPRA-->
                    <div class="col-lg-4 div_etiqueta">
                        <label for="txt_folioCompra">
                            <span class="small">Folio compra</span><span class="text-danger"> *</span>
                        </label>
                        <input type="text" class="form-control" id="txt_folioCompra">
                    </div>

                    <div class="col-lg-4 div_etiqueta">
                        <label for="cmb_tipoCompra">
                            <span class="small">Tipo de compra</span><span class="text-danger"> *</span>
                        </label>
                        <select class="js-example-basic-single form-control" id="cmb_tipoCompra" style="width: 100%;">
                            <option value="-1">Seleccione el Tipo</option>
                            <?php
                                $Consulta="SELECT idSituacion,concepto FROM 4011_estatusCompraVenta WHERE tipo='COMPRA'";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-12 div_etiqueta">
                        <label for="cmb_proveedor">
                            <span class="small">Proveedor</span><span class="text-danger"> *</span>
                        </label>
                        <select class="js-example-basic-single form-control" id="cmb_proveedor" style="width: 100%;">
                            <option value="-1">Seleccione el Proveedor</option>
                            <?php
                                $Consulta="SELECT idProveedor,IF(tipoEmpresa=2,nombre,CONCAT(nombre,' ',apPaterno,' ',apMaterno)) AS nombre FROM 4008_proveedores WHERE cod_unidad='".$cod_unidad."' ORDER BY nombre";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                        </select>
                    </div>

                </div>
                <!--FIN ROW-->

                <!--REGISTRO PRODUCTOS-->

                <div class="row mt-5 mb-3">
                    <div class="col-md-12 mb-2 mt-3">
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

                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="col-form-label" for="iptCostoU">
                                <span class="small">Precio compra</span><span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" id="iptCostoU"
                                placeholder="Ingrese el Precio">
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6 mb-3">
                        <h4>Total Compra: $ <span id="totalVenta">0.00</span></h4>
                    </div>

                    <!-- BOTONES PARA VACIAR LISTADO Y COMPLETAR LA COMPRA -->
                    <div class="col-md-6 text-right">
                        <button class="btn btn-primary" id="btnAgregarProducto">
                            <i class="fas fa-shopping-cart"></i> Agregar Producto
                        </button>
                        <button class="btn btn-danger" id="btnVaciarListado">
                            <i class="far fa-trash-alt"></i> Vaciar Listado
                        </button>
                    </div>
                </div>

                <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                <div class="col-md-12">
                    <table id="lstProductosCompra" class="display nowrap table-striped w-100 shadow">
                        <thead class="bg-info text-left fs-6">
                            <tr >
                                <th>Item</th>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Costo</th>
                                <th>Total</th>
                                <th class="text-center">Opciones</th>
                                <th>Aplica Peso</th>
                                <th>T. Impuesto</th>
                            </tr>
                        </thead>
                        <tbody class="small text-left fs-6">
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_compra()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>

        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    listarCompras();

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