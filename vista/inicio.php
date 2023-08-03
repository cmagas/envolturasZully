<?php
    session_start();
    include_once("conexionBD.php");
    
    if(!isset($_SESSION['idUsr'])){
        header('Location: login.php');
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administración | Pos</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../Plantilla/plugins/fontawesome-free/css/all.min.css">

    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../Plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../Plantilla/dist/css/adminlte.min.css">

    <!-- Bootstrap 5 -->
    <link href="../Plantilla/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="../utilitario/jquery-ui/css/jquery-ui.css">

    <!--JSTREE CSS-->
    <link href="../utilitario/jstree/dist/themes/default-dark/style.min.css" rel="stylesheet">

    <!--DATA TABLES-->
    <link href="../utilitario/DataTablesNew/datatables.css" rel="stylesheet">
    <link rel="stylesheet" href="../utilitario/DataTablesNew/datatables.min.css">
    <link rel="stylesheet" href="../utilitario/DataTablesNew/Responsive-2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../utilitario/DataTablesNew/Buttons-1.6.1/css/buttons.dataTables.min.css">

    <!-- Estilos personales -->
    <link href="css/plantilla.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="../utilitario/sweetalert2/sweetalert2.js"></script>

</head>

<body class="old-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php
            include "modulos/navbar.php";
            include "modulos/aside.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php
                include $_SESSION["vista"];
            ?>
        </div>
        <!-- /.content-wrapper -->



        <?php
            include "modulos/footer.php";
        ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../Plantilla/plugins/jquery/jquery.min.js"></script>

    <!-- jQuery -->
    <script src="../utilitario/jquery-ui/js/jquery-ui.js"></script>

    <!-- InputMask -->
    <script src="../Plantilla/plugins/moment/moment.min.js"></script>
    <script src="../Plantilla/plugins/inputmask/jquery.inputmask.min.js"></script>

        
    <!-- Bootstrap -->
    <script src="../Plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Plantilla/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- overlayScrollbars -->
    <script src="../Plantilla/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- AdminLTE -->
    <script src="../Plantilla/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="../Plantilla/plugins/chart.js/Chart.min.js"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../Plantilla/dist/js/pages/dashboard3.js"></script>

     <!-- JSTREE JS -->
     <script src="../utilitario/jstree/dist/jstree.min.js"></script>

    <!-- DATA TABLE -->
    <script src="../utilitario/DataTablesNew/datatables.js"></script>

    <!-- SCRIPT SISTEMA-->
    <script src="../Scripts/funcionesAjax.js"></script>    

    

    <script>
        var idioma_espanol = {
            select: {
                rows: "%d fila seleccionada"
            },
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
            "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "<b>No se encontraron datos</b>",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

        function CargarContenido(pagina_php, contenedor) {
            $("." + contenedor).load(pagina_php);
        }
    </script>
</body>

</html>