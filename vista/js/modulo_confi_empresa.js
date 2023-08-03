function cargarDatos()
{
    const btnGuardar = document.querySelector('.btn-guardar');
    const btnModificar = document.querySelector('.btn-modificar');

    $.ajax({
        async: false,
        url:"funciones/paginaFunciones_config_empresa.php",
        method:"POST",
        data:{
                'funcion': 2
        },
        dataType: 'json',
        success: function(respuesta){
            
            $("#cmb_tipoEmpresa").val(respuesta.tipoEmpresa);
            $("#txt_nombre").val(respuesta.nombre);
            $("#txt_rfc").val(respuesta.rfc);
            $("#txt_telefono").val(respuesta.telefono);
            $("#txt_email").val(respuesta.email);
            $("#cmb_estado").val(respuesta.estado);
            $("#txt_municipio").val(respuesta.municipio);
            $("#txt_calle").val(respuesta.calle);
            $("#txt_numero").val(respuesta.numero);
            $("#txt_colonia").val(respuesta.colonia);
            $("#txt_codPostal").val(respuesta.codPostal);
            $("#txt_Localidad").val(respuesta.localidad);

            $("#txtIdEmpresa").val(respuesta.idEmpresa);

            $("#txtRutaImagen").val(respuesta.rutaImagen);

            $("#previewImg").val(respuesta.rutaImagen);

            obtenerMunicipio(respuesta.municipio);

            if(respuesta.existe==1)
            {
                btnGuardar.classList.remove('activo');
                btnGuardar.classList.add('ocultar');

                btnModificar.classList.remove('ocultar');
                btnModificar.classList.add('activo');

            }else{

                btnGuardar.classList.remove('ocultar');
                btnGuardar.classList.add('activo');

                btnModificar.classList.remove('activo');
                btnModificar.classList.add('ocultar');
            }
            

        }



    });
}

/*==============================================
    FUNCION QUE PERMITE PREVISUALIZAR LA IMAGEN
 ===============================================*/
 function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}

function registrar_empresa()
{
    var frm = document.getElementById('form_subir');
    var data = new FormData(frm);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4){
            var msg = xhttp.responseText;
                switch(msg)
                {
                    case '0':
                        Swal.fire("Mensaje De Error","Los campos marcados con * son obligatorios","error");
                    break;
                    case '1':
                            Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Empresa registrada',
                                    showConfirmButton: false,
                                    timer: 1500
                            }) 
                            cargarDatos();
                    break;
                    case '2':
                            Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Lo sentimos, no se pudo completar el registro',
                                    showConfirmButton: false,
                                    timer: 1500
                            });
                    break;
                }
        }
    }
    xhttp.open("POST","funciones/paginaFunciones_guardarEmpresaNueva.php", true);
    xhttp.send(data); 
}

function obtenerMunicipiosPorEstado(value)
{
    cveEstado = value;
    var params={cveEstado: cveEstado,funcion:1};

    $.post("funciones/paginaFunciones_config_empresa.php", params, function(data){
      $("#txt_municipio").html(data);
    });            
}

function obtenerMunicipio(mpio)
{
  mpio = mpio;
  var params={mpio:mpio,funcion:3};
  $.post("funciones/paginaFunciones_config_empresa.php", params, function(data){
    $("#txt_municipio").html(data);
  });    
}

function modificar_empresa()
{

}