<?php
    session_start();
    include_once("conexionBD.php");
    include_once("funcionesSistemaGeneral.php");

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoPedido();
        break;
        case 2:
                obtenerListadoProductos();
        break;
        case 3:
                obtenerProductoCodigo();
        break;
        case 4:
                registrarPedidos();
        break;
        
    }

    function obtenerListadoPedido()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4015_pedidos_cabecera WHERE cod_unidad='".$cod_unidad."' ORDER BY idPedido";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombrePersonal=obtenerNombrePersonal($fila[4]);
            $fechaRecepcion=cambiarFormatoFecha($fila[5]);
            $totalPedido=cambiarFormatoMoneda($fila[6]);
            $totalPiezas=totalProductosPiezas($fila[0]);

            $o='{"":"","id":"'.$fila[0].'","fechaRecepcion":"'.$fechaRecepcion.'","idPersonal":"'.$fila[4].'","nomPersonal":"'.$nombrePersonal.'","total":"'.$totalPedido.'","totalPiezas":"'.$totalPiezas.'","situacion":"'.$fila[7].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function obtenerListadoProductos()
    {
        global $con;

        $arrRegistro="";
        $existencia=0;

        $hoy=date("Y-m-d");

        $consulta="SELECT idProducto,codigo_producto,p.descripcion_producto FROM 3001_cat_productos p WHERE p.situacion='1'";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {

            $producto=$fila[0]."~ [".$fila[1]."] ".$fila[2];

            $o='{"descripcion_producto":"'.$producto.'"}';

            if($arrRegistro=="")
                $arrRegistro=$o;
            else
                $arrRegistro.=",".$o;
        }

        echo '['.$arrRegistro.']';
    }

    function obtenerProductoCodigo()
    {
        global $con;
        $codigoProducto="";
        $idProducto=-1;
        $costoProd=0;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $o="";

        if(isset($_POST["codigo_producto"]))
            $codigoProducto=$_POST["codigo_producto"];
        

        $valor=explode("~",$codigoProducto);

        $codigo=$valor[0];
    
            $consulta="SELECT * FROM 3001_cat_productos WHERE idProducto='".$codigo."'";
            $resp=$con->obtenerPrimeraFila($consulta);
    
            $idCategoria=$resp[5];
            $costoProd=$resp[15];
    
            $consulCate="SELECT * FROM 4001_categorias WHERE id_categoria='".$idCategoria."'";
            $resCat=$con->obtenerPrimeraFila($consulCate);
    
            $precioVenta=cambiarFormatoMoneda($resp[8],2);
            $aplicaPeso=$resCat[6];
    
            $o='{"id":"'.$resp[0].'","codigo_producto":"'.$resp[4].'","descripcion_producto":"'.$resp[7].'","aplica_peso":"'. $aplicaPeso.'","acciones":"","costoProd":"'.$costoProd.'"}';

        echo $o;
        
    }

    function registrarPedidos()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $sumaTotal=0;
        $tipoAjuste='8';
        $valorMovimiento='1';

        
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $idPersonal=$obj->idPersonal;
        $fechaRecepcion=$obj->fechaRecepcion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4015_pedidos_cabecera(idResponsable,fechaCreacion,cod_unidad,idPersonal,fechaRecepcion,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$idPersonal."','".$fechaRecepcion."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        foreach($obj->arrProductos as $p)
	    {
            $idProducto=$p->id;
            $codProducto=$p->codigo_producto;
            $producto=$p->descripcion_producto;
            $cantidad=$p->cantidad;
            $costo=$p->costoP;
            $total=$p->totales;

            $sumaTotal=$sumaTotal+$total;

            $consulta[$x]="INSERT INTO 4016_pedidos_detalle(idPedido,codigo_producto,cantidad,idProducto,costo,total)VALUES(@idRegistro,
                            '".$codProducto."','".$cantidad."','".$idProducto."','".$costo."','".$total."')";
            $x++;

            $consulta[$x]="UPDATE 4015_pedidos_cabecera SET totalPedido='".$sumaTotal."' WHERE idPedido=@idRegistro";
            $x++;

            $consulta[$x]="INSERT INTO 4006_inventario(idResponsable,fechaCreacion,cod_unidad,idTipoMovimiento,valorMovimiento,
                        idProducto,cantidad,idtablaRef,idRegistroRef)VALUES('".$idUsuarioSesion."','".$fechaActual."',
                        '".$cod_unidad."','".$tipoAjuste."','".$valorMovimiento."','".$idProducto."','".$cantidad."','4015',@idRegistro)";
            $x++;
        }

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            $o='{"existe":"1"}';
            echo $o;
        }
        else{
            $o='{"existe":"0"}';
            echo $o;
        }

    }

    function totalProductosPiezas($idPedido)
    {
        global $con;
        $valor=0;

        $consulta="SELECT SUM(cantidad) FROM 4016_pedidos_detalle WHERE idPedido='".$idPedido."'";
        $valor=$con->obtenerValor($consulta);

        return $valor;

    }

?>    