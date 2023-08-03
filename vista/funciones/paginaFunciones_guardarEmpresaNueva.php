<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["iptImagen"]["type"]))
    {
        session_start();
        include_once("conexionBD.php");

        varDump($_POST);

        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaAct=date("Y-m-d");

        $subNombre=date("Ymdhis");
        $ruta="";
        
        $idEmpresa=$_POST['txtIdEmpresa'];
        $tipoEmpresa=$_POST['cmb_tipoEmpresa'];
        $nombre=$_POST['txt_nombre'];
        $rfc=$_POST['txt_rfc'];
        $telefono=$_POST['txt_telefono'];
        $email=$_POST['txt_email'];
        $cveEstado=$_POST['cmb_estado'];
        $cveMunicipio=$_POST['txt_municipio'];
        $calle=$_POST['txt_calle'];
        $numero=$_POST['txt_numero'];
        $colonia=$_POST['txt_colonia'];
        $codPostal=$_POST['txt_codPostal'];
        $localidad=$_POST['txt_Localidad'];
        $nombreFoto=$_FILES['iptImagen']['name'];
        $rutaImagen=$_POST['txtRutaImagen'];

        if($idEmpresa!=-1)
        {
            $consultaDatos="DELETE FROM 4000_config_empresa WHERE idEmpresa='".$idEmpresa."'";
            $con->ejecutarConsulta($consultaDatos);

            if($rutaImagen!='')
            {
                unlink($rutaImagen);
            }
        }



        $tipoOperacion="Registrar Empresa: ".$nombre;

        if($nombre!="")
        {
            $dir="fotos/empresa/";

            $x=0;
            $consulta[$x]="begin";
            $x++;

            if($nombreFoto!="")
            {
                $nombreArchivo=$_FILES['iptImagen']['name'];
                $extension= obtenerExtensionFichero($_FILES['iptImagen']['name']);

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                if(($_FILES["iptImagen"]["type"] == "image/jpg") || ($_FILES["iptImagen"]["type"] == "image/png") || ($_FILES["iptImagen"]["type"] == "image/gif") || ($_FILES["iptImagen"]["type"] == "image/jpeg"))
                {
                    $nombreArchivo=$_FILES['iptImagen']['name'];
                    $file_tmp_name=$_FILES['iptImagen']['tmp_name'];
                    $nombreArchivoFin="img_".$subNombre.".".$extension;

                    $ruta=$dir.$nombreArchivoFin;

                    //echo "$file_tmp_name ".$file_tmp_name." ruta ".$ruta;

                    copy($file_tmp_name, "../".$ruta);

                }else{
                    echo "2";
                }
            }else{
                $ruta="fotos/empresa/no_imagen.png";
            }

            $consulta[$x]="INSERT INTO 4000_config_empresa(idResponsable,fechaCreacion,cod_unidad,tipoEmpresa,Nombre,rfc,telefono,email,
                        estado,municipio,calle,numero,colonia,cod_postal,localidad,ruta_imagen)VALUES('".$idUsuarioSesion."','".$fechaAct."',
                        '".$cod_unidad."','".$tipoEmpresa."','".$nombre."','".$rfc."','".$telefono."','".$email."','".$cveEstado."',
                        '".$cveMunicipio."','".$calle."','".$numero."','".$colonia."','".$codPostal."','".$localidad."','".$ruta."')";
            $x++;

            $consulta[$x]="commit";
            $x++;
            
        /*
            if($con->ejecutarBloque($consulta))
            {
                guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
                echo "1";
                
            }else{
                if($nombreFoto!="")
                {  
                    unlink($ruta);
                }
                echo "2";
            } 
            */
        }else{
            echo "0";
        }

    }

    function obtenerExtensionFichero($str)
    {
        return end(explode(".", $str));
    }


?>