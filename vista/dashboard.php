<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/dashboard.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">TABLERO PRINCIPAL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Tablero Principal</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Información Box -->
        <div class="row">

            <!-- Card Total Ventas MENSUAL -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-archive"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Ventas del mes</span>
                        <span class="info-box-number" id="totalVentaMes">
                            $ 0.00
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Total Ventas DEL DIA-->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cart-plus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Ventas del Día</span>
                        <span class="info-box-number" id="totalVentasDia">$ 0.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Adeudo personal -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Adeudo Personal</span>
                        <span class="info-box-number" id="totalAdeudo">$ 0.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Adeudo personal -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-briefcase"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Gastos Mes</span>
                        <span class="info-box-number" id="totalGastos">$ 0.00</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <table id="tbl_pedidos_ventas" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Nombre Cliente</th>
                            <th>Fecha Pedido</th>
                            <th>Fecha Entrega</th>
                            <th>Importe Venta</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->








<script>
$(document).ready(function() {
    obtenerDatosTarjetas();
    listarPedidosVentas();
    setInterval(() => {
       obtenerDatosTarjetas();

    }, 10000);
});
</script>