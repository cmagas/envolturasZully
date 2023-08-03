<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGTeno | Pos</title>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Plantilla/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../Plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Plantilla/dist/css/adminlte.min.css">

    <!--SWEETALERT-->
    <script type="text/javascript" src="../utilitario/sweetalert2/sweetalert2.js"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../index.html">PRINCIPAL <br><b> ADMINISTRACION</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Datos del Usuario</p>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Usuario" id="txtUsuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="txtPasswd">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"
                            onclick="autentificar()">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../Plantilla/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../Plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../Plantilla/dist/js/adminlte.min.js"></script>

    <!--acceso login-->
    <script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
    <script type="text/javascript" src="../Scripts/base64.js"></script>
    
    <script src="../js/funcionAjax2.js"></script>
    <script src="../js/acceso.js.php"></script>
</body>

</html>