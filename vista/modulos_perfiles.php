<?php
    include("conexionBD.php");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<link href="css/tablas.css" rel="stylesheet">

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">ADMINISTRAR MODULO Y PERFILES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Módulos</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!--Main Content-->
<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="tabs-asignar-modulos-perfil" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="content-perfiles-tab" data-toggle="pill" href="#content-perfiles" role="tab"
                    aria-controls="content-perfiles" aria-selected="false">Perfiles</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="content-modulos-tab" data-toggle="pill" href="#content-modulos" role="tab"
                    aria-controls="content-modulos" aria-selected="false">Modulos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" id="content-modulo-perfil-tab" data-toggle="pill"
                    href="#content-modulo-perfil" role="tab" aria-controls="content-modulo-perfil"
                    aria-selected="false">Asignar Modulo a Perfil</a>
            </li>
        </ul>

        <div class="tab-content" id="tabsContent-asignar-modulos-perfil">

            <!--Perfiles-->
            <div class="tab-pane mt-4 px-4" id="content-perfiles" role="tabpanel"
                aria-labelledby="content-perfiles-tab">
                <h4>Administrar Perfiles</h4>

                <div class="row">

                    <div class="col-md-8">
                        <div class="card card-info card-outline shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list"></i> Perfiles de Usuarios</h3>
                            </div>
                            <div class="card-body">

                                <table id="tblPerfilUsuario" class="display nowrap table-striped shadow rounded"
                                    style="width:100%">

                                    <thead class="bg-info text-left">
                                        <th>Estatus</th>
                                        <th class="text-center">Acciones</th>
                                        <th>id</th>
                                        <th>Nombre de Perfil</th>
                                    </thead>
                                    <tbody class="small text left">

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-gray shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Registro de Perfil</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" class="needs-validation-registro-perfil" novalidate
                                    id="frm_registro_perfil">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group mb-2">
                                                <label for="iptPerfil" class="col-form-label">
                                                    <i class="fas fa-laptop fs-6"></i>
                                                    <span class="small">Nombre del Perfil</span>
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="iptPerfil" id="iptPerfil" required>
                                                    <div class="invalid-feedback">Debe ingresar el Perfil</div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group m-0 mt-2">
                                                <button type="button" class="btn btn-success w-100"
                                                    id="btnRegistrarPerfilUsuario">Guardar Perfil</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--============================================================================================================================================
            CONTENIDO PARA MODULOS
            =============================================================================================================================================-->
            <div class="tab-pane mt-4 px-4" id="content-modulos" role="tabpanel"
                aria-labelledby="content-modulo-perfil-tab">
                <h4>Administrar Modulos</h4>
                <div class="row">

                    <!--LISTADO DE MODULOS -->
                    <div class="col-md-6">
                        <div class="card card-gray shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de Módulos</h3>
                            </div>

                            <div class="card-body">
                                <table id="tblModulos" class="display nowrap table-striped shadow rounded"
                                    style="width:100%">
                                    <thead class="bg-info text-left">
                                        <th>Estatus</th>
                                        <th class="text-center">Acciones</th>
                                        <th>id</th>
                                        <th>orden</th>
                                        <th>Módulo</th>
                                        <th>Módulo Padre</th>
                                        <th>Vista</th>
                                        <th>Icono</th>
                                    </thead>
                                    <tbody class="small text left">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--/. col-md-6 -->

                    <!--FORMULARIO PARA REGISTRO Y EDICION -->
                    <div class="col-md-3">
                        <div class="card card-gray shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Registro de Módulos</h3>
                            </div>

                            <div class="card-body">
                                <form method="post" class="needs-validation-registro-modulo" novalidate
                                    id="frm_registro_modulo">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">

                                                <label for="iptModulo" class="col-form-label">
                                                    <i class="fas fa-laptop fs-6"></i>
                                                    <span class="small">Módulo</span>
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="iptModulo" id="iptModulo" placeholder="Ingrese el módulo"
                                                        required>
                                                    <div class="invalid-feedback">Debe ingresar el módulo</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label for="iptVistaModulo" class="col-form-label">
                                                    <i class="fas fa-code text-white fs-6"></i>
                                                    <span class="small">Vista PHP</span>
                                                </label>
                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="iptVistaModulo" id="iptVistaModulo"
                                                        placeholder="Ingrese la vista del módulo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label for="iptIconoModulo" class="col-form-label">
                                                    <i class="far fa-circle fs-6 text-white"></i>
                                                    <span class="small">Icono</span>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group  m-0">
                                                    <input type="text" class="form-control form-control-sm" 
                                                        name="iptIconoModulo" id="iptIconoModulo" placeholder="<i class='far fa-circle'></i>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-info" id="spn_icono_modulo">
                                                            <i class="far fa-circle fs-6 text-white"></i>
                                                        </span>
                                                    </div>
                                                    <div class="invalid-feedback">Debe ingresar el ícono del módulo
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group m-0 mt-2">

                                                <button type="button" class="btn btn-success w-100"
                                                    id="btnRegistrarModulo">Guardar Módulo</button>

                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!--/. col-md-3 -->

                    <!--ARBOL DE MODULOS PARA REORGANIZAR -->
                    <div class="col-md-3">
                        <div class="card card-gray shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Organizar Módulos</h3>
                            </div>

                            <div class="card-body">
                                <div class="">
                                    <div>Modulos del Sistema</div>
                                    <div class="" id="arbolModulos"></div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <button id="btnReordenarModulos" class="btn btn-success mt-3"
                                                style="width: 47%;">Organizar Módulos</button>

                                            <button id="btnReiniciar" class="btn btn-warning mt-3 "
                                                style="width: 47%;">Estado Inicial</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/. col-md-3 -->

                </div>
                <!--/.row -->

            </div><!-- /#content-modulos -->

            <!--Modulo - Perfiles-->
            <div class="tab-pane in active mt-4 px-4" id="content-modulo-perfil" role="tabpanel"
                aria-labelledby="content-modulo-perfil-tab">
                <h4>Módulos Perfiles</h4>

                <div class="row">

                    <div class="col-md-8">
                        <div class="card card-info card-outline shadow">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de Perfiles</h3>
                            </div>

                            <div class="card-body">
                                <table id="tbl_perfiles_asignar"
                                    class="display nowrap table table-striped w-100 shadow rounded">
                                    <thead class="bg-info text-left">
                                        <th></th>
                                        <th>id Perfil</th>
                                        <th>Perfil</th>
                                        <th>Estado</th>
                                        <th>F. Creación</th>
                                        <th class="text-center">Opciones</th>
                                    </thead>
                                    <tbody class="small text left">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-info card-outline shadow" style="display:none" id="card-modulos">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-laptop"></i> Módulos del Sistema</h3>
                            </div>

                            <div class="card-body" id="card-body-modulos">

                                <div class="row m-2">
                                    <div class="col-md-6">
                                        <button class="btn btn-success btn-small  m-0 p-0 w-100"
                                            id="marcar_modulos">Marcar todo</button>
                                    </div>

                                    <div class="col-md-6">
                                        <button class="btn btn-danger btn-small m-0 p-0 w-100"
                                            id="desmarcar_modulos">Desmarcar todo</button>
                                    </div>
                                </div>

                                <!-- AQUI SE CARGAN TODOS LOS MODULOS DEL SISTEMA -->
                                <div id="modulos" class="demo mt-4"></div>

                                <div class="row m-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Seleccione el modulo de inicio</label>
                                            <select class="custom-select" id="select_modulos">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-12">
                                        <button class="btn btn-success btn-small w-50 text-center"
                                            id="asignar_modulos">Asignar</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

<script>
/*====================================================================
            VARIABLES GLOBALES
        ======================================================================*/
var tbl_perfiles_asignar, tbl_modulos, modulos_usuario, modulos_sistema, tbl_perfiles;

$(document).ready(function() {

    /* ======================================================================
        FUNCIONES PARA LAS CARGAS INICIALES DE DATATABLES, ARBOL DE MODULOS
    ========================================================================= */
    cargarDataTables();
    ajustarHeadersDataTables($('#tblModulos'));
    iniciarArbolModulos();


    /* =============================================================
    VARIABLES PARA REGISTRAR EL PERFIL Y LOS MODULOS SELECCIOMADOS
    ============================================================= */
    var idPerfil = 0;
    var selectedElmsIds = [];

    /* ========================================================================
        EVENTO PARA SELECCIONAR UN PERFIL DEL DATATABLE Y MOSTRAR LOS MODULOS 
        ASIGNADOS EN EL ARBOL DE MODULOS
    ============================================================================ */
    $('#tbl_perfiles_asignar tbody').on('click', '.btnSeleccionarPerfil', function() {

        var data = tbl_perfiles_asignar.row($(this).parents('tr')).data();

        if ($(this).parents('tr').hasClass('selected')) {

            $(this).parents('tr').removeClass('selected');

            $('#modulos').jstree("deselect_all", false);

            $("#select_modulos option").remove();

            idPerfil = 0;

            $("#card-modulos").css("display", "none");

        } else {

            tbl_perfiles_asignar.$('tr.selected').removeClass('selected');

            $(this).parents('tr').addClass('selected');

            idPerfil = data["idPerfil"];

            $("#card-modulos").css("display", "block"); //MOSTRAMOS EL ARBOL DE MODULOS DEL SISTEMA

            $.ajax({
                async: false,
                url: "funciones/paginaFunciones_modulosPerfiles.php",
                method: 'POST',
                data: {
                    funcion: 3,
                    id_perfil: idPerfil
                },
                dataType: 'json',
                success: function(respuesta) {

                    modulos_usuario = respuesta;

                    seleccionarModulosPerfil(idPerfil);
                }
            });

        }
    })

    /* =============================================================
    EVENTO QUE SE DISPARA CADA VEZ QUE HAY UN CAMBIO EN EL ARBOL DE MODULOS
    ============================================================= */
    $("#modulos").on("changed.jstree", function(evt, data) {

        $("#select_modulos option").remove();

        var selectedElms = $('#modulos').jstree("get_selected", true);

        $.each(selectedElms, function() {

            for (let i = 0; i < modulos_sistema.length; i++) {

                if (modulos_sistema[i]["id"] == this.id && modulos_sistema[i]["vista"]) {

                    $('#select_modulos').append($('<option>', {
                        value: this.id,
                        text: this.text
                    }));
                }
            }
        })

        if ($("#select_modulos").has('option').length <= 0) {

            $('#select_modulos').append($('<option>', {
                value: 0,
                text: "--No hay modulos seleccionados--"
            }));
        }
    })

        /* =============================================================
        EVENTO PARA MARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        ============================================================= */
    $("#marcar_modulos").on('click', function() {
        $('#modulos').jstree('select_all');
    })

        /* =============================================================
        EVENTO PARA DESMARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        ============================================================= */

    $("#desmarcar_modulos").on('click', function() {

        $('#modulos').jstree("deselect_all", false);
        $("#select_modulos option").remove();

        $('#select_modulos').append($('<option>', {
            value: 0,
            text: "--No hay modulos seleccionados--"
        }));
    })

        /* =============================================================
        REGISTRO EN BASE DE DATOS DE LOS MODULOS ASOCIADOS AL PERFIL 
        ============================================================= */

    $("#asignar_modulos").on('click', function() {

        selectedElmsIds = []
        var selectedElms = $('#modulos').jstree("get_selected", true);

        $.each(selectedElms, function() {

            selectedElmsIds.push(this.id);

            if (this.parent != "#") {
                selectedElmsIds.push(this.parent);
            }

        });

        //quitamos valores duplicados
        let modulosSeleccionados = [...new Set(selectedElmsIds)];

        let modulo_inicio = $("#select_modulos").val();

        //console.log('modulosSeleccionados :',modulosSeleccionados,' idPerfil: ',idPerfil,'modulo_inicio :',modulo_inicio);

        if (idPerfil != 0 && modulosSeleccionados.length > 0) {
            registrarPerfilModulos(modulosSeleccionados, idPerfil, modulo_inicio);
        } else {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Debe seleccionar el perfil y módulos a registrar',
                showConfirmButton: false,
                timer: 3000
            })
        }
    })

    /* =============================================================
                   MANTENIMIENTO DE MODULOS
       ============================================================= */

    fnCargarArbolModulos();

    /* =============================================================
    REORGANIZAR MODULOS DEL SISTEMA
    ============================================================= */
    $("#btnReordenarModulos").on('click', function() {
        fnOrganizarModulos();
    })

        /* =============================================================
        REINICIALIZAR MODULOS DEL SISTEMA EN EL JSTREE
        ============================================================= */

    $("#btnReiniciar").on('click', function() {
        actualizarArbolModulos();
    })

    /*=============================================================
    VISTA PREVIA DEL ICONO DE LA VISTA
    ==============================================================*/
    $("#iptIconoModulo").change(function() {

        $("#spn_icono_modulo").html($("#iptIconoModulo").val())

        if ($("#iptIconoModulo").val().length === 0) {
            $("#spn_icono_modulo").html("<i class='far fa-circle fs-6 text-white'></i>")
        }
    })

    /*===================================================================*/
    //EVENTO QUE GUARDA LOS DATOS DEL MODULO
    /*===================================================================*/
    document.getElementById("btnRegistrarModulo").addEventListener("click", function() {
        fnRegistrarModulo();
    })

    /*=====================================================
        FUNCIONES ADMINISTRAR PERFILES USUARIOS
    =======================================================*/

    $("#tblPerfilUsuario").on("click", ".btnSeleccionarPerfilUsuario", function () {
        var data = tbl_perfiles.row($(this).parents("tr")).data();
  
        if (tbl_perfiles.row(this).child.isShown()) {
            var data = table.row(this).data();
        }

        alert("Seleccionar");

    });

    $("#tblPerfilUsuario").on("click", ".btnEliminarPerfilUsuario", function () {
        
        var data = tbl_perfiles.row($(this).parents("tr")).data();
  
        if (tbl_perfiles.row(this).child.isShown()) {
            var data = table.row(this).data();
        }

        Swal.fire({
            title: "¿Esta seguro de eliminar el Perfil?",
            text: "Una vez hecho esto el usuario no lo visualizará",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            }).then((result) => {
                if (result.value) {
                    modificarEstatusPerfil(data.id, "0");
                }
            });
        
    });

    document.getElementById("btnRegistrarPerfilUsuario").addEventListener("click", function() {
            fnRegistrarPerfilUsuario();
        })


}) //FIN DEL DOCUMENTO READY


function cargarDataTables() {
    tbl_perfiles_asignar = $("#tbl_perfiles_asignar").DataTable({
        ajax: {
            async: false,
            url: "funciones/paginaFunciones_modulosPerfiles.php",
            type: "POST",
            data: {
                funcion: "1"
            }
        },
        columns: [{
                data: ""
            },
            {
                data: "idPerfil"
            },
            {
                data: "nombrePerfil"
            },
            {
                data: "situacion",
                render: function(data, type, row) {
                    if (data == "1") {
                        return "ACTIVO";
                    } else {
                        return "INACTIVO";
                    }
                },
            },
            {
                data: "fechaCreacion"
            }
        ],
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: 5,
                orderable: false,
                render: function(data, type, full, meta) {
                    return "<center>" +
                        "<span class='btnSeleccionarPerfil text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar perfil'> " +
                        "<i class='fas fa-check fs-5'></i> " +
                        "</span> " +
                        "</center>";
                }
            }
        ],
        language: idioma_espanol,
        select: true
    });

    tbl_modulos = $('#tblModulos').DataTable({
        ajax: {
            async: false,
            url: 'funciones/paginaFunciones_modulosPerfiles.php',
            type: 'POST',
            data: {
                'funcion': 5
            }
        },
        columns: [
            {
                data: "situacion"
            },
            {
                data: "opciones"
            },
            {
                data: "id"
            },
            {
                data: "orden"
            },
            {
                data: "modulo"
            },
            {
                data: "modulo_padre"
            },
            {
                data: "vista"
            },
            {
                data: "icon_menu"
            },
        ],
        columnDefs: [
            {
                targets: 0,
                visible: false
            },
            {
            targets: 1,
            sortable: false,
            render: function(data, type, full, meta) {
                return "<center>" +
                    "<span class='fas fa-edit fs-6 btnSeleccionarModulo text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar Módulo'> " +
                    "</span> " +
                    "<span class='fas fa-trash fs-6 btnEliminarModulo text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Módulo'> " +
                    "</span>" +
                    "</center>";
            }
        }],
        scrollX: true,
        order: [
            [0, 'asc']
        ],
        lengthMenu: [0, 5, 10, 15, 20, 50],
        pageLength: 20,
        language: idioma_espanol,
    });

    tbl_perfiles = $('#tblPerfilUsuario').DataTable({
        ajax: {
            async: false,
            url: 'funciones/paginaFunciones_modulosPerfiles.php',
            type: 'POST',
            data: {
                'funcion': 8
            }
        },
        columns: [
            {
                data: "situacion"
            },
            {
                data: "opciones"
            },
            {
                data: "id"
            },
            {
                data: "perfil"
            }
        ],
        columnDefs: [
            {
                targets: 0,
                visible: false
            },
            {
                targets: 1,
                sortable: false,
                render: function(data, type, full, meta) {
                    return "<center>" +
                        "<span class='fas fa-edit fs-6 btnSeleccionarPerfilUsuario text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar Perfil'> " +
                        "</span> " +
                        "<span class='fas fa-trash fs-6 btnEliminarPerfilUsuario text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Perfil'> " +
                        "</span>" +
                        "</center>";
                }
            }
        ],
    });
}

function ajustarHeadersDataTables(element) {
    var observer = window.ResizeObserver ? new ResizeObserver(function(entries) {
        entries.forEach(function(entry) {
            $(entry.target).DataTable().columns.adjust();
        });
    }) : null;

    // Function to add a datatable to the ResizeObserver entries array
    resizeHandler = function($table) {
        if (observer)
            observer.observe($table[0]);
    };

    // Initiate additional resize handling on datatable
    resizeHandler(element);
}

function iniciarArbolModulos() {
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 2
        },
        dataType: 'json',
        success: function(respuesta) {

            modulos_sistema = respuesta;
            //console.log("respuesta linea 724 "+respuesta)

            // inline data demo
            $('#modulos').jstree({
                'core': {
                    "check_callback": true,
                    'data': respuesta
                },
                "checkbox": {
                    "keep_selected_style": false
                },
                "types": {
                    "default": {
                        "icon": "fas fa-laptop text-warning"
                    }
                },
                "plugins": ["wholerow", "checkbox", "types", "changed"]

            }).bind("loaded.jstree", function(event, data) {
                // you get two params - event & data - check the core docs for a detailed description
                $(this).jstree("open_all");
            });
        }
    })
}

function seleccionarModulosPerfil(pin_idPerfil) {
    $('#modulos').jstree('deselect_all');

    for (let i = 0; i < modulos_sistema.length; i++) {
        if (parseInt(modulos_sistema[i]['id']) == parseInt(modulos_usuario.data[i]['id']) && parseInt(
                modulos_usuario
                .data[i]['sel']) == 1) {

            $("#modulos").jstree("select_node", modulos_sistema[i]['id']);
        }
    }

    /*OCULTAMOS LA OPCION DE MODULOS Y PERFILES PARA EL PERFIL DE ROOT*/
    if (pin_idPerfil != 1) { //SOLO PERFIL ROOT
        $("#modulos").jstree(true).hide_node(6);
    } else {
        $('#modulos').jstree(true).show_all();
    }
}

function registrarPerfilModulos(modulosSeleccionados, idPerfil, idModulo_inicio) {
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 4,
            id_modulosSeleccionados: modulosSeleccionados,
            id_Perfil: idPerfil,
            id_modulo_inicio: idModulo_inicio
        },
        dataType: 'json',
        success: function(respuesta) {

            if (respuesta > 0) {

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Se registro correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })

                $("#select_modulos option").remove();
                $('#modulos').jstree("deselect_all", false);
                tbl_perfiles_asignar.ajax.reload();
                $("#card-modulos").css("display", "none");

            } else {

                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al registrar',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        }
    });
}

/* =============================================================
    FUNCIONES PARA EL MANTENIMIENTO DE PESTAÑA MODULOS
============================================================= */
function fnCargarArbolModulos() {
    var dataSource;

    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 2
        },
        dataType: 'json',
        success: function(respuesta) {
            dataSource = respuesta;
        }
    });

    /*
        $.jstree.defaults.core.check_callback:
        Determina lo que sucede cuando un usuario intenta modificar la estructura del árbol .
        Si se deja como false se impiden todas las operaciones como crear, renombrar, eliminar, 
        mover o copiar.
        Puede configurar esto en true para permitir todas las interacciones o usar una función 
        para tener un mejor control.

        el plugins "dnd", permite mover, bajar y subir los modulos
    */
    $('#arbolModulos').jstree({
        'core': {
            "check_callback": true,
            'data': dataSource
        },
        "types": {
            "default": {
                "icon": "fas fa-laptop"
            },
            "file": {
                "icon": "fas fa-laptop"
            }
        },
        "plugins": ["types", "dnd"]

    }).bind("loaded.jstree", function(event, data) {
        // you get two params - event & data - check the core docs for a detailed description
        $('#arbolModulos').jstree("open_all");
    });
}

function actualizarArbolModulos() {
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 2
        },
        dataType: 'json',
        success: function(respuesta) {
            $('#arbolModulos').jstree(true).settings.core.data = respuesta;
            $('#arbolModulos').jstree(true).refresh();
        }
    });
}

function fnOrganizarModulos() {
    var array_modulos = [];

    var reg_id, reg_padre_id, reg_orden;

    var v = $("#arbolModulos").jstree(true).get_json('#', {
        'flat': true
    });

    //console.log("🚀 ~ file: modulos_perfiles.php ~ line 1074 ~ fnOrganizarModulos ~ v", v)

    for (i = 0; i < v.length; i++) {

        var z = v[i];
        //console.log("🚀 ~ file: modulos_perfiles.php ~ line 871 ~ fnOrganizarModulos ~ z", z)

        //asignamos el id, el padre Id y el nombre del modulo
        reg_id = z["id"];
        reg_padre_id = z["parent"];
        reg_orden = i;

        array_modulos[i] = reg_id + ';' + reg_padre_id + ';' + reg_orden;

    }

    /*REGISTRAMOS LOS MODULOS CON EL NUEVO ORDENAMIENTO */
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 6,
            modulos: array_modulos
        },
        dataType: 'json',
        success: function(respuesta) {

            if (respuesta > 0) {

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Se registró correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })

                tbl_modulos.ajax.reload();

                //recargamos arbol de modulos - MANTENIMIENTO MODULOS ASIGNADOS A PERFILES                                
                actualizarArbolModulosPerfiles();

            } else {

                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al registrar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    });
}

function actualizarArbolModulosPerfiles() {
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_modulosPerfiles.php",
        method: 'POST',
        data: {
            funcion: 1
        },
        dataType: 'json',
        success: function(respuesta) {
            modulos_sistema = respuesta;

            //console.log(modulos_sistema);

            $('#modulos').jstree(true).settings.core.data = respuesta;
            $('#modulos').jstree(true).refresh();
        }
    });

}

function fnRegistrarModulo() {
    var forms = document.getElementsByClassName('needs-validation-registro-modulo');

    var validation = Array.prototype.filter.call(forms, function(form) {

        if (form.checkValidity() === true) {

            //console.log("Listo para registrar el producto");

            Swal.fire({
                title: 'Está seguro de registrar el Modulo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo registrarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {

                if (result.isConfirmed) {

                    $("#iptIconoModulo").val($('#spn_icono_modulo i').attr('class'));

                    $.ajax({
                        async: false,
                        url: "funciones/paginaFunciones_modulosPerfiles.php",
                        method: 'POST',
                        data: {
                            funcion: 7,
                            datos: $('#frm_registro_modulo').serialize()
                        },
                        //dataType: 'json',
                        success: function(respuesta) {

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: respuesta,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            tbl_modulos.ajax.reload();

                            //recargamos arbol de modulos - MANTENIMIENTO MODULOS
                            actualizarArbolModulos();

                            //recargamos arbol de modulos - MANTENIMIENTO MODULOS ASIGNADOS A PERFILES                                
                            actualizarArbolModulosPerfiles();

                            $("#iptModulo").val("");
                            $("#iptVistaModulo").val("");
                            $("#iptIconoModulo").val("");

                            $(".needs-validation-registro-modulo").removeClass(
                                "was-validated");
                        }

                    })

                }
            });

        }

        form.classList.add('was-validated');
    })
}

function modificarEstatusPerfil(id,estado)
{
    var mensaje = "";
    var idPerfil = id;

    if (estado == "0") {
        mensaje = "Eliminado";
    } else {
        mensaje = "Activo";
    }

    var cadObj = '{"idPerfil":"' + idPerfil + '","estado":"' + estado + '"}';

    function funcAjax() {
        var resp = peticion_http.responseText;
        arrResp = resp.split("|");
        if (arrResp[0] == "1") {
            //cargarDataTables();
            tbl_perfiles.ajax.reload();
            Swal.fire(
                "Mensaje De Confirmacion",
                "El Perfil se ha " + mensaje + " con exito",
                "success"
            );
        } else {
        Swal.fire(
            "Mensaje De Error",
            "Lo sentimos, no se pudo modificar el registro",
            "error"
        );
        }
    }
    obtenerDatosWeb("funciones/paginaFunciones_modulosPerfiles.php",funcAjax,"POST","funcion=9&cadObj=" + cadObj,true);
}

function fnRegistrarPerfilUsuario()
{
    var perfil= $("#iptPerfil").val();

    if(perfil.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Todos los campos son obligatorios","warning");
    }

    var cadObj='{"nombrePerfil":"'+perfil+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            Swal.fire("Mensaje De Confirmacion","Datos correctamente, Perfil Registrado","success") 
            tbl_perfiles.ajax.reload();
            limpiarCamposPerfil();
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_modulosPerfiles.php',funcAjax, 'POST','funcion=10&cadObj='+cadObj,true)  
}

function limpiarCamposPerfil()
{
    $("#iptPerfil").val("");
}

</script>