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
                obtenerListadoAjustes();
        break;
        case 2:
                obtenerListadoProductos();
        break;
        case 3:
                obtenerProductoCodigo();
        break;
        case 4:
                registrarAjuste();
        break;
        
    }

    function obtenerListadoAjustes()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4012_ajuste_cabecera WHERE cod_unidad='".$cod_unidad."' ORDER BY idAjuste";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $idTipoAjuste=$fila[4];

            switch($idTipoAjuste)
            {
                case 1:
                    $nomTipoAjuste="AJUSTE ENTRADA";
                break;
                case 2:
                    $nomTipoAjuste="AJUSTE SALIDA";
                break;
                case 4:
                    $nomTipoAjuste="AJUSTE SALIDA POR MERMA";
                break;
            }

            
            $fechaAjuste=cambiarFormatoFecha($fila[2]);


            $o='{"":"","id":"'.$fila[0].'","idTipoAjuste":"'. $idTipoAjuste.'","nomTipoAjuste":"'.$nomTipoAjuste.'","fechaAjuste":"'.$fechaAjuste.'","situacion":"'.$fila[5].'"}';
			
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
            
            $existencia=obtenerExistenciaProducto($fila[0]);

            $producto=$fila[0]."~ [".$fila[1]."] ".$fila[2]."~ Existencia: ".$existencia;

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
    
            $consulCate="SELECT * FROM 4001_categorias WHERE id_categoria='".$idCategoria."'";
            $resCat=$con->obtenerPrimeraFila($consulCate);
    
            $precioVenta=cambiarFormatoMoneda($resp[8],2);
            $aplicaPeso=$resCat[6];
    
            $o='{"id":"'.$resp[0].'","codigo_producto":"'.$resp[4].'","descripcion_producto":"'.$resp[7].'","aplica_peso":"'. $aplicaPeso.'","acciones":""}';

        echo $o;
        
    }

    function registrarAjuste()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];
        
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $tipoAjuste=$obj->tipoAjuste;


        switch($tipoAjuste)
        {
            case 1:
                $valorMovimiento='1';
            break;
            case 2:
                $valorMovimiento='-1';
            break;
            case 4:
                $valorMovimiento='1';
            break;
        }
        
        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4012_ajuste_cabecera(idResponsable,fechaCreacion,cod_unidad,tipoAjuste,situacion)VALUES('".$idUsuarioSesion."',
                '".$fechaActual."','".$cod_unidad."','".$tipoAjuste."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        foreach($obj->arrProductos as $p)
	    {
            $idProducto=$p->id;
            $codProducto=$p->codigo_producto;
            $producto=$p->descripcion_producto;
            $cantidad=$p->cantidad;

            $consulta[$x]="INSERT INTO 4013_ajuste_detalle(idAjuste,codigo_producto,cantidad,idProducto)VALUES(@idRegistro,'".$codProducto."',
                        '".$cantidad."','".$idProducto."')";
            $x++;

            $consulta[$x]="INSERT INTO 4006_inventario(idResponsable,fechaCreacion,cod_unidad,idTipoMovimiento,valorMovimiento,
                        idProducto,cantidad,idtablaRef,idRegistroRef)VALUES('".$idUsuarioSesion."','".$fechaActual."',
                        '".$cod_unidad."','".$tipoAjuste."','".$valorMovimiento."','".$idProducto."','".$cantidad."','4012',@idRegistro)";
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

?>    