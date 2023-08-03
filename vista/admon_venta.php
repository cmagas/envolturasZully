<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/admon_venta.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">ADMINISTRACION DE VENTAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Admon. Ventas</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<div class="content pb-2">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h2 class="card-title">CRITERIOS DE BUSQUEDA</h2>
                        <div class="card-tools"><button class="btn btn-tool" type="button"
                                data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ventas desde:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask-alias="datetime"
                                            data-inputmask-inputformat="dd/mm/yyyy" id="ventas_desde">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ventas hasta:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="far fa-calendar-alt"></i></span></div>
                                        <input type="text" class="form-control" data-inputmask-alias="datetime"
                                            data-inputmask-inputformat="dd/mm/yyyy" id="ventas_hasta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex flex-row align-items-center justify-content-end">
                                <div class="form-group m-0">
                                    <a class="btn btn-primary" style="width:120px;" id="btnFiltrar">Buscar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <h4>Total venta: $ <span id="totalVenta">0.00</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="display nowrap table-striped w-100 shadow" id="lstVentas">
                    <thead class="bg-info">
                        <tr>
                            <th>id</th>
                            <th>Nro Boleta</th>
                            <th>Codigo</th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total Venta</th>
                            <th>Fecha Venta</th>
                        </tr>
                    </thead>
                    <tbody class="small"></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!--FIN Main content -->

<script>
    $(document).ready(function() {

        /* ======================================================================================
            INICIALIZAR LA TABLA DE VENTAS
        ======================================================================================*/
        inicializarTablaVentas();


    });
</script>