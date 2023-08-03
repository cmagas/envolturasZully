<?php
    session_start();
    include_once("conexionBD.php");
    include_once("funcionesSistemaGeneral.php");

    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoCompras();
        break;
        case 2:
                obtenerListadoProductos();
        break;
        case 3:
                obtenerProductoCodigo();
        break;
        case 4:
                obtenerUltimoCosto();
        break;
        case 5:
                registrarCompras();
        break;
       
    }

    function obtenerListadoCompras()
    {
        global $con;
        $arrRegistro="";

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4009_compras_cabecera WHERE cod_unidad='".$cod_unidad."' ORDER BY idCompra ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $fechaCompra=cambiarFormatoFecha($fila[2]);
            $nombreProveedor=obtenerNombreClienteProveedor($fila[4],'2');
            $nombreFormaPago=obtenerNombreTipoCompra($fila[8]);
            $importe=formatearMoneda($fila[7]);

            $o='{"":"","id":"'.$fila[0].'","fechaCompra":"'.$fechaCompra.'","idProveedor":"'.$fila[4].'","nomProveedor":"'.$nombreProveedor.'","subtotal":"'.$fila[5].'","iva":"'.$fila[6].'","total":"'.$importe.'","tipoCompra":"'.$fila[8].'","formaPago":"'.$nombreFormaPago.'","situacion":"'.$fila[9].'"}';
			
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

        $hoy=date("Y-m-d");

        $consulta="SELECT CONCAT(idProducto,'~ [',codigo_producto,'] ~',p.descripcion_producto,'~ Precio Compra $',p.precioCompra ) AS descripcion_producto,
                    codigo_producto as codigo FROM 3001_cat_productos p,4001_categorias c WHERE p.idCategoria=c.id_categoria 
                    and p.situacion='1'";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
            $o='{"descripcion_producto":"'.$fila[0].'"}';

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
        $valorImpuesto=0;
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
            $tipoImpuesto=$resp[6];
            if($tipoImpuesto==4)
            {
                $valorImpuesto=cambiarFormatoMoneda($resp[9]-($resp[9]/1.16),2);
            }
    
            $o='{"id":"'.$resp[0].'","codigo_producto":"'.$resp[4].'","id_categoria":"'.$resp[5].'","nombre_categoria":"'.$resCat[4].'",
            "descripcion_producto":"'.$resp[7].'","cantidad":"1","total":"'.$precioVenta.'",
            "acciones":"","aplica_peso":"'.$aplicaPeso.'","precio_compra_producto":"'.$resp[8].'","idImpuesto":"'.$tipoImpuesto.'",
            "valorImpuesto":"'.$valorImpuesto.'"}';

        echo $o;
        
    }

    function obtenerUltimoCosto()
    {
        global $con;

        $valor=0;
        $codigoProducto=-1;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        if(isset($_POST["codigo_producto"]))
        {
            $codigo=$_POST["codigo_producto"];

            $valor=explode("~",$codigo);

            $codigoProducto=$valor[0];
        }
            

        $consulta="SELECT costoUnitario FROM 4006_inventario WHERE idProducto='".$codigoProducto."' 
                AND cod_unidad='".$cod_unidad."' ORDER BY fechaCreacion DESC";
        $res=$con->obtenerPrimeraFila($consulta);

        if($res)
        {
            $valor=$res[0];
        }

        $o='{"valor":"'.$valor.'"}';

        echo $o;
    }

    function obtenerProductoCodigo2()
    {
        global $con;
        $codigoProducto="";
        $valorImpuesto=0;
        $idProducto=-1;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $o="";

        if(isset($_POST["codigo_producto"]))
            $codigoProducto=$_POST["codigo_producto"];
        

        $valor=explode("~",$codigoProducto);

        $codigo=$valor[0];
    
            $consulta="SELECT * FROM 3001_cat_productos WHERE codigo_producto='".$codigo."' AND cod_unidad='".$cod_unidad."'";
            $resp=$con->obtenerPrimeraFila($consulta);
    
            $idCategoria=$resp[5];
    
            $consulCate="SELECT * FROM 4001_categorias WHERE id_categoria='".$idCategoria."' AND cod_unidad='".$cod_unidad."'";
            $resCat=$con->obtenerPrimeraFila($consulCate);
    
            $precioVenta=cambiarFormatoMoneda($resp[8],2);
            $aplicaPeso=$resCat[6];
            $tipoImpuesto=$resp[6];
            if($tipoImpuesto==4)
            {
                $valorImpuesto=cambiarFormatoMoneda($resp[9]-($resp[9]/1.16),2);
            }
    
            $o='{"id":"'.$resp[0].'","codigo_producto":"'.$resp[4].'","id_categoria":"'.$resp[5].'","nombre_categoria":"'.$resCat[4].'",
            "descripcion_producto":"'.$resp[7].'","cantidad":"1","total":"'.$precioVenta.'",
            "acciones":"","aplica_peso":"'.$aplicaPeso.'","precio_compra_producto":"'.$resp[8].'","idImpuesto":"'.$tipoImpuesto.'",
            "valorImpuesto":"'.$valorImpuesto.'"}';
        

        echo $o;
        
    }

    function registrarCompras()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];
        $subTotal=0;
        $totalIVA=0;
        $sumaTotal=0;

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $fechaCompra=$obj->fechaCompra;
        $folioCompra=$obj->folioCompra;
        $idProveedor=$obj->idProveedor;
        $totalCompra=$obj->totalCompra;
        $tipoCompra=$obj->tipoCompra;
       
        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4009_compras_cabecera(idResponsable,fechaCreacion,cod_unidad,idProveedor,
                subtotal,iva,total,tipoCompra,situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$cod_unidad."',
                '".$idProveedor."','','','".$totalCompra."','".$tipoCompra."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        foreach($obj->arrProductos as $p)
	    {
            $idProducto=$p->id;
            $codProducto=$p->codigo_producto;
            $producto=$p->descripcion_producto;
            $cantidad=$p->cantidad;
            $costoU=$p->precio_compra_producto;
            $total=$p->total;
            $iva=$p->iva;

            $totalIVA=$totalIVA+($cantidad*$iva);
            $sumaTotal=$sumaTotal+$total;
            $subTotal=$sumaTotal-$totalIVA;

            $consulta[$x]="INSERT INTO 4010_compras_detalle(idCompras,codigo_producto,cantidad,costoU,iva,
                        total,idProducto)VALUES(@idRegistro,'".$codProducto."','".$cantidad."','".$costoU."',
                        '".$iva."','".$total."','".$idProducto."')";
            $x++;

            $consulta[$x]="INSERT INTO 4006_inventario(idResponsable,fechaCreacion,cod_unidad,idTipoMovimiento,valorMovimiento,
                        idProducto,cantidad,costoUnitario,idtablaRef,idRegistroRef)VALUES('".$idUsuarioSesion."','".$fechaActual."',
                        '".$cod_unidad."','3','1','".$idProducto."','".$cantidad."','".$costoU."','4009',@idRegistro)";
            $x++;
            
        }

        $consulta[$x]="UPDATE 4009_compras_cabecera SET subtotal='".$subTotal."',iva='".$totalIVA."' WHERE idCompra=@idRegistro";
        $x++;

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

    function formatearMoneda($monto)
    {
        return '$ '.number_format($monto,2);
    }


?>    