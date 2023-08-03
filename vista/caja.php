<link href="css/caja.css" rel="stylesheet">
<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/caja.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CAJA</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Caja</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- MAIN CONTENT-->
<div class="content">
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-md-6">
                <!-- INPUT CHECK DE EFECTIVO EXACTO -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="chkCotizacion">
                    <label class="form-check-label" for="chkCotizacion">
                        &nbsp; &nbsp; &nbsp;Solicitar Cotización
                    </label>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <!-- INPUT PARA INGRESO DEL CODIGO DE BARRAS O DESCRIPCION DEL PRODUCTO -->
                    <div class="col-md-12 mb-2">
                        <div class="form-group mb-2">

                            <label class="col-form-label" for="iptCodigoVenta">
                                <i class="fas fa-barcode fs-6"></i>
                                <span class="small">Productos</span>
                            </label>

                            <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                                name="iptCodigoVenta"
                                placeholder="Ingrese el código de barras o el nombre del producto">
                        </div>
                    </div>

                    <!-- ETIQUETA QUE MUESTRA LA SUMA TOTAL DE LOS PRODUCTOS AGREGADOS AL LISTADO -->
                    <div class="col-md-6 mb-3">
                        <h3>Total Venta: $ <span id="totalVenta">0.00</span></h3>
                    </div>


                    <!-- BOTONES PARA VACIAR LISTADO Y COMPLETAR LA VENTA -->
                    <div class="col-md-6 text-right">
                        <button class="btn btn-success ocultoBtn" id="btnEmitirCotizacion">
                            <i class="fas fa-address-book"></i> Cotización
                        </button>
                        <button class="btn btn-primary" id="btnIniciarVenta">
                            <i class="fas fa-shopping-cart"></i> Realizar Venta
                        </button>
                        <button class="btn btn-danger" id="btnVaciarListado">
                            <i class="far fa-trash-alt"></i> Vaciar Listado
                        </button>
                    </div>

                    <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                    <div class="col-md-12">
                        <table id="lstProductosVenta" class="display nowrap table-striped w-100 shadow ">
                            <thead class="bg-info text-left fs-6">
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo</th>
                                    <th>Id Categoria</th>
                                    <th>Categoria</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
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
            </div>

            <div class="col-md-3">
                <div class="card shadow">
                    <h5 class="card-header bg-primary text-white text-center m-0">
                        Total Venta: $ <span id="totalVentaRegistrar">0.00</span>
                    </h5>
                    <div class="card-body p-2 m-3">

                        <!-- SELECCIONAR TIPO DE DOCUMENTO -->
                        <div class="form-group mb-2">
                            <label class="col-form-label" for="selCategoriaReg">
                                <i class="fas fa-file-alt fs-6"></i>
                                <span class="small">Documento </span><span class="text-danger">*</span>
                            </label>

                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                id="selDocumentoVenta" disabled>
                                <option value="0">Seleccione Documento</option>
                                <option value="1" selected="true">Ticket</option>
                                <option value="2">Factura</option>
                                <option value="3">Boleta</option>
                            </select>

                            <span id="validate_categoria" class="text-danger small fst-italic" style="display:none">
                                Debe Seleccione documento
                            </span>
                        </div>

                        <!-- SELECCIONAR TIPO DE PAGO -->
                        <div class="form-group mb-2">

                            <label class="col-form-label" for="selCategoriaReg">
                                <i class="fas fa-money-bill-alt fs-6"></i>
                                <span class="small">Tipo Pago </span><span class="text-danger">*</span>
                            </label>

                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                id="selTipoPago" disabled>
                                <option value="0">Seleccione Tipo Pago</option>
                                <option value="1" selected="true">Efectivo</option>
                                <option value="2">Tarjeta</option>
                                <option value="3">Mixto</option>
                            </select>

                            <span id="validate_categoria" class="text-danger small fst-italic" style="display:none">
                                Debe Ingresar tipo de pago
                            </span>
                        </div>

                        <!-- SERIE Y NRO DE BOLETA -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="iptNroSerie">Serie</label>
                                    <input type="text" min="0" name="iptEfectivo" id="iptNroSerie"
                                        class="form-control form-control-sm" placeholder="nro Serie" disabled>
                                </div>

                                <div class="col-md-8">
                                    <label for="iptNroVenta">Nro Venta</label>
                                    <input type="text" min="0" name="iptEfectivo" id="iptNroVenta"
                                        class="form-control form-control-sm" placeholder="Nro Venta" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- INPUT DE EFECTIVO ENTREGADO -->
                        <div class="form-group">
                            <label for="iptEfectivoRecibido">Efectivo recibido</label>
                            <input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido"
                                class="form-control form-control-sm" placeholder="Cantidad de efectivo recibida">
                        </div>

                        <!-- INPUT CHECK DE EFECTIVO EXACTO -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="chkEfectivoExacto">
                            <label class="form-check-label" for="chkEfectivoExacto">
                                &nbsp; &nbsp; &nbsp;Efectivo Exacto
                            </label>
                        </div>

                        <!-- MOSTRAR MONTO EFECTIVO ENTREGADO Y EL VUELTO -->
                        <div class="row mt-2">
                            <div class="col-12 m-2">
                                <h6 class="text-start fw-bold">Monto Efectivo: $ <span
                                        id="EfectivoEntregado">0.00</span></h6>
                            </div>

                            <div class="col-12 m-1">
                                <h5 class="text-start text-danger fw-bold">Cambio: $ <span id="Vuelto">0.00</span>
                                </h5>
                            </div>
                        </div>

                        <!-- MOSTRAR EL SUBTOTAL, IGV Y TOTAL DE LA VENTA -->
                        <div class="row">
                            <div class="col-md-7">
                                <span>SUBTOTAL</span>
                            </div>
                            <div class="col-md-5 text-right">
                                $ <span class="" id="boleta_subtotal">0.00</span>
                            </div>

                            <div class="col-md-7">
                                <span>IVA (16%)</span>
                            </div>
                            <div class="col-md-5 text-right">
                                $ <span class="" id="boleta_igv">0.00</span>
                            </div>

                            <div class="col-md-7 mb-2">
                                <span>TOTAL</span>
                            </div>
                            <div class="col-md-5 text-right">
                                $ <span class="" id="boleta_total">0.00</span>
                            </div>
                        </div>

                    </div><!-- ./ CARD BODY -->

                </div><!-- ./ CARD -->
            </div>

        </div>
    </div>
    <!--/. container-fluid -->
</div>
<!-- /.content -->




<script>
$(document).ready(function() {

    /* ======================================================================================
    TRAER EL NRO DE BOLETA
    ======================================================================================*/
    CargarNroBoleta();

    /* ======================================================================================
        INICIALIZAR LA TABLA DE VENTAS
    ======================================================================================*/
    inicializarTablaProductos();

    /* ======================================================================================
        TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ======================================================================================*/
    listadoProducto();








})
</script>