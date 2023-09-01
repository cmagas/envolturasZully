<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">
<link href="css/rep_generales.css" rel="stylesheet">

<script type="text/javascript" src="js/admon_reportes.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">REPORTES GENERALES ADMINISTRATIVOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Reportes</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<div class="content">
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

        <div class="row">

            <h2>SELECIONE EL REPORTE A OBTENER</h2>
                <form action="" class="formulario">
                    <div class="radio">
                        <input type="radio" name="reporteRad" id="rep1">
                        <label for="rep1">Reporte 1</label>

                        <input type="radio" name="reporteRad" id="rep2">
                        <label for="rep2">Reporte 2</label>

                        <input type="radio" name="reporteRad" id="rep3">
                        <label for="rep3">Reporte 3</label>

                    </div>
                </form>
            </div>

        </div>
    </div>


</div>

<script>
$(document).ready(function() {

    /* ======================================================================================
        INICIALIZAR LA TABLA DE VENTAS
    ======================================================================================*/
    inicializarTablaVentas();


});
</script>