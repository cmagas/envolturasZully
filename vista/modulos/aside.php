<?php
   //session_start();
    include_once("conexionBD.php");

    $consulta="SELECT m.idModulo,m.nombreModulo,m.icon_menu,m.vista,mp.vista_inicio 
        FROM 1006_modulos m,1005_perfilModulo mp, 1000_usuarios u
        WHERE m.idModulo=mp.idModulo AND mp.idPerfil=u.idPerfilUsuario AND u.idUsuario='".$_SESSION['idUsr']."' 
        AND (m.idPadre IS NULL or m.idPadre = 0) ORDER BY m.orden ";
    $menuUsuario=$con->obtenerFilas($consulta);

   //var_dump($menuUsuario);
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio.php" class="brand-link">
        <img src="../images/principal/icono.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">SGTecno | Pos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="fotos/default.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <h6 class="text-warning"><?php echo $_SESSION["usuarioNombre"]. ' ' . $_SESSION["usuarioApellido"] ?>
                </h6>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

                <?php
                    while($value=mysql_fetch_row($menuUsuario))
                    {
                ?>
                <li class="nav-item">
                    <a style="cursor: pointer;" class="nav-link <?php if($value[4]==1)
                                { 
                                    echo 'active';
                                } ?>" <?php if(!empty($value[3])){?>
                        onclick="CargarContenido('<?php echo $value[3];?>','content-wrapper')" <?php
                                }
                                ?>>
                        <i class="nav-icon <?php echo $value[2];?>"></i>
                        <p>
                            <?php echo $value[1]?>
                            <?php if(empty($value[3])){?>
                            <i class="right fas fa-angle-left"></i>
                            <?php
                                    }
                                    ?>
                        </p>
                    </a>

                    <?php if(empty($value[3]))
                            {
                                $consulSub="SELECT idModulo,nombreModulo,icon_menu,vista FROM 1006_modulos WHERE idPadre='".$value[0]."' ORDER BY orden";
                                $resSub=$con->obtenerFilas($consulSub);
                            ?>
                    <ul class="nav nav-treeview">
                        <?php
                                        while($sub=mysql_fetch_row($resSub))
                                        {
                                    ?>
                        <li class="nav-item">
                            <a style="cursor: pointer;" class="nav-link"
                                onclick="CargarContenido('<?php echo $sub[3] ?>','content-wrapper')">
                                <i class="<?php echo $sub[2]; ?> nav-icon"></i>
                                <p><?php echo $sub[1]; ?></p>
                            </a>
                        </li>
                        <?php
                                        }
                                    ?>
                    </ul>

                    <?php
                            }
                    ?>

                </li>
                <?php
                    
                    }
                ?>

                <!--Cerrar Sesion-->
                <li class="nav-item">
                    <a href="#" onclick="cerrarSesionFin()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- jQuery -->
<script src="../Plantilla/plugins/jquery/jquery.min.js"></script>
<script src="../js/acceso.js.php"></script>
<script src="../js/funcionAjax2.js"></script>

<script>
    $(".nav-link").on('click', function() {
        $(".nav-link").removeClass('active');
        $(this).addClass('active');
    })
</script>