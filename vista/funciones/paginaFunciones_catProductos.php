<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoProductos();
        break;
        case 2:
                guardarModificacionProductos();
        break;

    }

    function obtenerListadoProductos()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $consulta="SELECT * FROM 3001_cat_productos WHERE cod_unidad='".$cod_unidad."' ORDER BY idProducto";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $nomCategoria=obtenerNombreCategoria($fila[5]);
           $precioCompra=formatearMoneda($fila[8]);
           $precioMenudeo=formatearMoneda($fila[9]);
           $precioMayoreo=formatearMoneda($fila[10]);
           $precioProduccion=formatearMoneda($fila[15]);

           $exist=obtenerExistenciaProducto($fila[0]);

            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","codigoProducto":"'.$fila[4].'","idCategoria":"'.$fila[5].'",
                "categoria":"'.$nomCategoria.'","idImpuesto":"'.$fila[6].'","producto":"'.$fila[7].'","precioCompra":"'.$precioCompra.'",
                "precioMenudeo":"'.$precioMenudeo.'","utilidad":"'.$fila[11].'","stockMax":"'.$fila[12].'","stockMin":"'.$fila[13].'",
                "stock_producto":"'.$exist.'","fechaCreacion":"'.$fila[2].'","precioMayoreo":"'.$precioMayoreo.'","fotoProducto":"'.$fila[14].'",
                "precioProduccion":"'.$precioProduccion.'","existencia":"'.$exist.'","idTipo":"'.$fila[16].'","idSubTipo":"'.$fila[17].'","situacion":"'.$fila[18].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function guardarModificacionProductos()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idProducto=$obj->idProducto;
        $producto=$obj->nombreProducto;
        //$codigoProducto=$obj->codigoProducto;
        $idImpuesto=$obj->impuesto;
        $idCategoria=$obj->categoria;
        $idTipoProducto=$obj->idTipo;
        $idSubTipoProducto=$obj->idSubTipo;
        $precioCompra=$obj->precioCompra;
        $precioMayoreo=$obj->precioMayoreo;
        $precioMenudeo=$obj->precioMenudeo;
        $utilidad=$obj->utilidad;
        $stockMaximo=$obj->stockMaximo;
        $stockMinimo=$obj->stockMinimo;
        $precioProduccion=$obj->precioProduccion;
        $situacion=$obj->situacion;

        $nomTipoProductoA=obtenerTipoProducto($idTipoProducto,'1');
        $nomSubTipoProductoA=obtenerTipoProducto($idSubTipoProducto,'2');

        $codigoProducto=$nomTipoProductoA."-".$nomSubTipoProductoA;
 
         $tipoOperacion="Realiza cambios a Producto: ".$idProducto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3001_cat_productos SET codigo_producto='".$codigoProducto."',idCategoria='".$idCategoria."',idImpuesto='".$idImpuesto."',
        descripcion_producto='".$producto."',precioCompra='".$precioCompra."',precioMenudeo='".$precioMenudeo."',precioMayoreo='".$precioMayoreo."',
        utilidad='".$utilidad."',stockMaximo='".$stockMaximo."',stockMinimo='".$stockMinimo."',precioProduccion='".$precioProduccion."',
        idTipo='".$idTipoProducto."',idSubTipo='".$idSubTipoProducto."',situacion='".$situacion."' WHERE idProducto='".$idProducto."'";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }         
    }

    function formatearMoneda($monto)
    {
        return '$ '.number_format($monto,2);
    }

    function obtenerTipoProducto($id,$tipo)
    {
        global $con;
        $valor="";

        switch($tipo)
        {
            case 1: //tipoProducto
                    $consulta="SELECT nombre_tipo FROM 3002_cat_tipoProducto WHERE idTipoProducto='".$id."'";
            break;
            case 2: //SubTipo
                    $consulta="SELECT nombre_subTipo FROM 3003_cat_subTipoProducto WHERE idSubTipoProducto='".$id."'";
            break;
        }

        $res=$con->obtenerValor($consulta);
        $valor=strtoupper($res);

        return $valor;

    }

?>    