<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["iptImagen"]["type"]))
    {
        session_start();
        include_once("conexionBD.php");

        //varDump($_POST);

        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaAct=date("Y-m-d");

        $subNombre=date("Ymdhis");
        $ruta="";

        $nombreProducto=$_POST['txt_nombre'];
        $codigoBarra=$_POST['txt_codigoBarra'];
        $idImpuesto=$_POST['txt_impuesto'];
        $idCategoria=$_POST['txt_categoria'];
        $precioCompra=$_POST['txt_precioCompra'];
        $precioMayoreo=$_POST['txt_precioMayoreo'];
        $precioMenudeo=$_POST['txt_precioMenudeo'];
        $utilidad=$_POST['txt_utilidad'];
        $stockMaximo=$_POST['txt_stockMaximo'];
        $stockMinimo=$_POST['txt_stockMinimo'];
        $precioProduccion=$_POST['txt_precioProducccion'];
        $nombreFoto=$_FILES['iptImagen']['name'];

        $tipoOperacion="Registrar nuevo Producto: ".$nombreProducto;

        if($nombreProducto!="" && $codigoBarra!="" && $idImpuesto!="-1" && $idCategoria!="-1" && $precioCompra!="" && $precioMayoreo!="" && $precioMenudeo!="" && $stockMaximo!="" && $stockMinimo!="")
        { 

                $dir="fotos/productos/";

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
        
                            copy($file_tmp_name, "../".$ruta);
                    }else{
                        echo "2";
                    }
                }else{
                    $ruta="fotos/productos/default.png";
                }
        
                $consulta[$x]="INSERT INTO 3001_cat_productos(idResponsable,fechaCreacion,cod_unidad,codigo_producto,idCategoria,
                        idImpuesto,descripcion_producto,precioCompra,precioMenudeo,precioMayoreo,utilidad,stockMaximo,stockMinimo,
                        imagen_producto,precioProduccion,situacion)VALUES('".$idUsuarioSesion."','".$fechaAct."','".$cod_unidad."',
                        '".$codigoBarra."','".$idCategoria."','".$idImpuesto."','".$nombreProducto."','".$precioCompra."','".$precioMenudeo."',
                        '".$precioMayoreo."','".$utilidad."','".$stockMaximo."','".$stockMinimo."','".$ruta."','".$precioProduccion."','1')";
                $x++;
        
                $consulta[$x]="commit";
                $x++;
                
            
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
            
        }else{
            echo "0";
        }



    }


    function obtenerExtensionFichero($str)
    {
        return end(explode(".", $str));
    }

        
?>