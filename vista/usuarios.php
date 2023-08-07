<?php
    include("conexionBD.php");
    $fecha=date("Y-m-d");
?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/usuarios.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE USUARIOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Catalogo de Usuarios</li>
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
                <table id="tbl_usuarios" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Perfil</th>
                            <th>Foto</th>
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
<div class="modal" id="modal_registro_usuarios" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Registrar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_subir" enctype="multipart/form-data">

                    <div class="row">
                        <!--Columna foto-->
                        <div class="col-12 div_etiqueta">
                            <div class="form-group mb-2">
                                <label for="iptImagen">
                                    <i class="fas fa-image fs-6"></i>
                                    <span class="small">Seleccione la Foto (.jpg, .png, .gif,
                                        .jpeg)</span>
                                </label>
                                <input type="file" class="form-control form-control-sm" id="iptImagen" name="iptImagen"
                                    accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 my-1">
                            <div style="width: 100%; height: 200px">
                                <img id="previewImg" src="fotos/no_imagen.png" class="border border-secondary"
                                    style="object-fit: cover; width: 100%; height: 100%;" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <!--Columna Nombre-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_nombre">
                                        <span class="small">Nombre</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_nombre" name="txt_nombre">
                                </div>
                                <!--Columna Apellido Paterno-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_apPaterno">
                                        <span class="small">Apellido paterno</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_apPaterno" name="txt_apPaterno">
                                </div>
                                <!--Columna Apellido Materno-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_apMaterno">
                                        <span class="small">Apellido materno</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_apMaterno" name="txt_apMaterno">
                                </div>
                                <!--Columna RFC-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_rfc">
                                        <span class="small">R.F.C.</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_rfc" name="txt_rfc" maxlength="13">
                                </div>
                                <!--Columna Genero-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_genero">
                                        <span class="small">Genero</span>
                                    </label>
                                    <select id="txt_genero" name="txt_genero" style="width: 100%;" class="form-control">
                                        <option value="-1">Seleccione</option>
                                        <option value="1">Femenino</option>
                                        <option value="2">Masculino</option>
                                    </select>
                                </div>
                                <!--Columna Telefono-->
                                <div class="col-lg-4 div_etiqueta">
                                    <label for="txt_telefono">
                                        <span class="small">Teléfono</span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_telefono" name="txt_telefono"
                                        maxlength="10" placeholder="10 digitos">
                                </div>
                                <!--Columna Email-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_email">
                                        <span class="small">Correo Electrónico</span><span class="text-danger"> *</span>
                                    </label>
                                    <input type="email" class="form-control" id="txt_email" name="txt_email"
                                        maxlength="150">
                                </div>
                                <!--Columna Fecha Nac-->
                                <div class="col-lg-6 div_etiqueta">
                                    <label for="txt_fechaNac">
                                        <span class="small">Fecha de Nacimiento</span>
                                    </label>
                                    <input type="date" class="form-control" id="txt_fechaNac" name="txt_fechaNac"
                                        max="<?php echo $fecha; ?>">
                                </div>
                            </div>
                        </div>

                        <!--Columna linea-->
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <!--Columna Cabecera Direccion-->
                        <div class="col-lg-12 datos_divisor">
                            <h3>Dirección</h3>
                        </div>
                        <!--Columna Estado-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="cmb_estado">
                                <span class="small">Estado</span>
                            </label>
                            <select class="js-example-basic-single form-control" id="cmb_estado" name="cmb_estado"
                                style="width: 100%;" onchange="obtenerMunicipiosPorEstado(this.value)">
                                <option value="-1">Seleccione el Estado</option>
                                <?php
                                $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                            </select>
                        </div>
                        <!--Columna Municipio-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="txt_municipio">
                                <span class="small">Municipio</span>
                            </label>
                            <select id="txt_municipio" name="txt_municipio" style="width: 100%;" class="form-control">
                                <option value="-1">Seleccione el Estado</option>
                            </select>
                        </div>
                        <!--Columna Localidad-->
                        <div class="col-lg-12 div_etiqueta">
                            <label for="txt_Localidad">
                                <span class="small">Localidad</span>
                            </label>
                            <input type="text" class="form-control" id="txt_Localidad" name="txt_Localidad"
                                maxlength="150" placeholder="Maximo 150 caract.">
                        </div>
                        <!--Columna Linea-->
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <!--Columna Cabecera Datos de Acceso-->
                        <div class="col-lg-12 datos_divisor">
                            <h3>Datos de Acceso</h3>
                        </div>
                        <!--Columna Usuario-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_usuario">
                                <span class="small">Usuario</span><span class="text-danger"> *</span>
                            </label>
                            <input type="text" class="form-control" id="txt_usuario" name="txt_usuario"
                                placeholder="Ingrese el Usuario">
                        </div>
                        <!--Columna Contraseña 1-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_cont1">
                                <span class="small">Contrase&ntilde;a</span><span class="text-danger"> *</span>
                            </label>
                            <input type="password" class="form-control" id="txt_cont1" name="txt_cont1"
                                placeholder="Ingrese su contrase&ntilde;a">
                        </div>
                        <!--Columna Contraseña 2-->
                        <div class="col-lg-4 div_etiqueta">
                            <label for="txt_cont2">
                                <span class="small">Repita la Contrase&ntilde;a</span><span class="text-danger">
                                    *</span>
                            </label>
                            <input type="password" class="form-control" id="txt_cont2" name="txt_cont2"
                                placeholder="Repita la contrase&ntilde;a">
                        </div>
                        <!--Columna Linea-->
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <!--Columna Cabecera perfil-->
                        <div class="col-lg-12 datos_divisor">
                            <h3>Perfil de Usuario</h3>
                        </div>
                        <!--Columna Asignar Perfil-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="cmb_Perfil">
                                <span class="small">Asignar Perfil</span><span class="text-danger"> *</span>
                            </label>
                            <select class="js-example-basic-single form-control" id="cmb_Perfil" name="cmb_Perfil"
                                style="width: 100%;">
                                <option value="-1">Seleccione el Perfil</option>
                                <?php
                                    $Consulta="SELECT idPerfil,nombrePerfil FROM 1004_perfiles WHERE idPerfil>'1' AND situacion='1'";
                                    $con->generarOpcionesSelect($Consulta);
                                ?>
                            </select>
                        </div>

                        <!--Columna Empresa-->
                        <div class="col-lg-6 div_etiqueta">
                            <label for="cmb_Empresa">
                                <span class="small">Asignar Empresa</span><span class="text-danger"> *</span>
                            </label>
                            <select class="js-example-basic-single form-control" id="cmb_Empresa" name="cmb_Empresa"
                                style="width: 100%;">
                                <option value="-1">Seleccione la Empresa</option>
                                <?php
                                    $Consulta="SELECT idEmpresa,IF(tipoEmpresa=2,Nombre,CONCAT(Nombre,' ',apPaterno,' ',apMaterno)) AS nombre FROM 1002_empresa WHERE situacion='1'";
                                    $con->generarOpcionesSelect($Consulta);
                                ?>
                            </select>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_usuario()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_usuarios" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">Modificar Datos del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_nombre_modifi">
                        <span class="small">Nombre</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_nombre_modifi" placeholder="Nombre">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apPaterno_modifi">
                        <span class="small">Apellido paterno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apPaterno_modifi" placeholder="Apellido Paterno">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_apMaterno_modifi">
                        <span class="small">Apellido materno</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_apMaterno_modifi">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_rfc_modifi">
                        <span class="small">R.F.C.</span>
                    </label>
                    <input type="text" class="form-control" id="txt_rfc_modifi" maxlength="13" placeholder="RFC">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_genero_modifi">
                        <span class="small">Genero</span>
                    </label>
                    <select id="txt_genero_modifi" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione el Genero</option>
                        <option value="1">Femenino</option>
                        <option value="2">Masculino</option>
                    </select>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_telefono_modifi">
                        <span class="small">Teléfono</span>
                    </label>
                    <input type="text" class="form-control" id="txt_telefono_modifi" maxlength="10"
                        placeholder="10 digitos">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_email_modifi">
                        <span class="small">Correo Electrónico</span><span class="text-danger"> *</span>
                    </label>
                    <input type="email" class="form-control" id="txt_email_modifi" maxlength="150" placeholder="Email">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaNac_modifi">
                        <span class="small">Fecha de Nacimiento</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaNac_modifi" max="<?php echo $fecha; ?>">
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Dirección</h3>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_estado_modifi">
                        <span class="small">Estado</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_estado_modifi" style="width: 100%;"
                        onchange="obtenerMunicipiosPorEstado2(this.value)">
                        <option value="-1">Seleccione el Estado</option>
                        <?php
                            $Consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_municipio_modifi">
                        <span class="small">Municipio</span>
                    </label>
                    <select id="txt_municipio_modifi" style="width: 100%;" class="form-control">

                    </select>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Localidad_modifi">
                        <span class="small">Localidad</span>
                    </label>
                    <input type="text" class="form-control" id="txt_Localidad_modifi" maxlength="150"
                        placeholder="Maximo 150 caract.">
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Datos de Acceso</h3>
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_usuario_modifi">
                        <span class="small">Usuario</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_usuario_modifi" placeholder="Ingrese el Usuario">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_cont1_modifi">
                        <span class="small">Contrase&ntilde;a</span><span class="text-danger"> *</span>
                    </label>
                    <input type="password" class="form-control" id="txt_cont1_modifi"
                        placeholder="Ingrese su contrase&ntilde;a">
                </div>
                <div class="col-lg-4 div_etiqueta">
                    <label for="txt_cont2_modifi">
                        <span class="small">Repita la Contrase&ntilde;a</span><span class="text-danger"> *</span>
                    </label>
                    <input type="password" class="form-control" id="txt_cont2_modifi"
                        placeholder="Repita la contrase&ntilde;a">
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 datos_divisor">
                    <h3>Permisos asignados</h3>
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_Perfil_modifi">
                        <span class="small">Asignar Perfil</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_Perfil_modifi" style="width: 100%;">
                        <option value="-1">Seleccione el Perfil</option>
                        <?php
                            $Consulta="SELECT idPerfil,nombrePerfil FROM 1004_perfiles WHERE idPerfil>'1' AND situacion='1'";
                            $con->generarOpcionesSelect($Consulta);
                        ?>
                    </select>
                </div>

                <!--Columna Empresa-->
                <div class="col-lg-6 div_etiqueta">
                    <label for="cmb_Empresa_modifi">
                        <span class="small">Asignar Empresa</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_Empresa_modifi"
                        name="cmb_Empresa_modifi" style="width: 100%;">
                        <option value="-1">Seleccione la Empresa</option>
                        <?php
                                    $Consulta="SELECT idEmpresa,IF(tipoEmpresa=2,Nombre,CONCAT(Nombre,' ',apPaterno,' ',apMaterno)) AS nombre FROM 1002_empresa WHERE situacion='1'";
                                    $con->generarOpcionesSelect($Consulta);
                                ?>
                    </select>
                </div>

                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <input type="text" id="txtIdUsuario" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_usuario()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function() {
    listarUsuarios();
});

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
});
</script>