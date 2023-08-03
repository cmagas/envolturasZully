<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");
    //include_once("cajaPos/funcionesProductos.php");


    $idUsuario=$_SESSION['idUsr'];

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
                verificaStockProducto();
        break;
        case 3:
                obtenerProductoCodigo();
        break;
        case 5:
                obtenerFoliosBoleta();
        break;
        case 6:
                guardarVentaCaja();
        break;
        case 7:
                guardarCotizacion();
        break;
        case 8:
                obtenerVentaPeriodo();
        break;
        case 9:
                obtenerCotizacionPeriodo();
        break;
    }

    function obtenerListadoProductos()
    {
        global $con;

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT CONCAT(p.idProducto,'~ [',codigo_producto,'] ~',p.descripcion_producto,' ~ Precio May $',p.precioMayoreo ) AS descripcion_producto,
                    codigo_producto as codigo,p.idProducto FROM 3001_cat_productos p,4001_categorias c WHERE p.idCategoria=c.id_categoria AND p.situacion='1' ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
            $existencia=obtenerExistenciaProducto($fila[2]);
            $cadena=$fila[0]." Existencia: ".$existencia;
            //$o='{"descripcion_producto":"'.$fila[0].'"}';
            $o='{"descripcion_producto":"'.$cadena.'"}';

            if($arrRegistro=="")
                $arrRegistro=$o;
            else
                $arrRegistro.=",".$o;
        }

        echo '['.$arrRegistro.']';
    }
    
    function verificaStockProducto()
    {
        global $con;

        $codigoProducto=-1;
        $cantidad=0;
        $valor=0;
        $idProducto=-1;

        if(isset($_POST["idProducto"]))
            $codigoProducto=$_POST["idProducto"];

        if(isset($_POST["cantidad_a_comprar"]))
            $cantidad=$_POST["cantidad_a_comprar"];

        if(isset($_POST["idProducto"]))
            $idProducto=$_POST["idProducto"];

        $existencia=obtenerExistenciaProducto($idProducto);

        //echo "Cantidad ".$cantidad."Existencia ".$existencia;

        if($existencia > $cantidad)
        {
            $valor=1;
        }
        
        $o='{"existe":"'.$valor.'"}';

        echo $o;

        /*
        $consulta="SELECT COUNT(*) AS existe FROM 3001_cat_productos p WHERE p.codigo_producto='".$codigoProducto."' 
                    AND p.stock_producto>'".$cantidad."'";
        $res=$con->obtenerValor($consulta);
        */
    }

    function obtenerProductoCodigo()
    {
        global $con;
        $codigoProducto="";
        $valorImpuesto=0;
        $idProducto=-1;

        $o='{"contiene":"0"}';

        if(isset($_POST["codigo_producto"]))
            $codigoProducto=$_POST["codigo_producto"];
        

        $valor=explode("~",$codigoProducto);

        $codigo=$valor[0];
    
            $consulta="SELECT * FROM 3001_cat_productos WHERE idProducto='".$codigo."'";
            $resp=$con->obtenerPrimeraFila($consulta);

            if($resp)
            {
                $idProducto=$resp[0];
                $idCategoria=$resp[4];

                $existencia=obtenerExistenciaProducto($idProducto);

                if($existencia>0)
                {
                    $consulCate="SELECT * FROM 4001_categorias WHERE id_categoria='".$idCategoria."'";
                    $resCat=$con->obtenerPrimeraFila($consulCate);
            
                    $precioVenta=cambiarFormatoMoneda($resp[10],2);
                    $aplicaPeso=$resCat[6];
                    $tipoImpuesto=$resp[6];
                    if($tipoImpuesto==4)
                    {
                        $valorImpuesto=cambiarFormatoMoneda($resp[9]-($resp[9]/1.16),2);
                    }
            
                    $o='{"contiene":"1","id":"'.$resp[0].'","codigo_producto":"'.$resp[4].'","id_categoria":"'.$resp[5].'",
                        "nombre_categoria":"'.$resCat[4].'","descripcion_producto":"'.$resp[7].'","cantidad":"1",
                        "precio_venta_producto":"'.$precioVenta.'","total":"'.$precioVenta.'","precio_menudeo":"'.$resp[9].'",
                    "acciones":"","aplica_peso":"'.$aplicaPeso.'","idImpuesto":"'.$tipoImpuesto.'","valorImpuesto":"'.$valorImpuesto.'"}';
                }
                
            }
    
       echo $o;
    }

    function obtenerFoliosBoleta()
    {
        global $con;

        $idEmpresa=$_SESSION['idEmpresa'];
        $anio=date('Y');

        $consulta="SELECT * FROM 4003_folio WHERE idEmpresa='".$idEmpresa."' AND ciclo='".$anio."'";
        $res=$con->obtenerPrimeraFila($consulta);


        if($res)
        {
            $serie=$res[3];
            $resFolio=$res[4]+1;

            switch(strlen($resFolio))
            {
                case 1:
                        $folio='0000000'.$resFolio;
                break;
                case '2':
                        $folio='000000'.$resFolio;
                break;
                case '3':
                        $folio='00000'.$resFolio;
                break;
                case '4':
                    $folio='0000'.$resFolio;
                break;
                case '5':
                    $folio='000'.$resFolio;
                break;  
                case '6':
                    $folio='00'.$resFolio;
                break;  
                case '7':
                    $folio='0'.$resFolio;
                break;
                case '8':
                    $folio=$resFolio;
                break;            
            }
        }
        else{
                $folio="00000001";
                $serie="T-".$anio;

                $consulta="INSERT INTO 4003_folio(idEmpresa,ciclo,serie_boleta,nro_correlativo_venta)VALUES('".$idEmpresa."',
                            '".$anio."','".$serie."','".$folio."')";
                $res=$con->ejecutarConsulta($consulta);
        }

        

        $o='{"serie_boleta":"'.$serie.'","nro_venta":"'.$folio.'"}';

        echo $o;

    }

    function guardarVentaCaja()
    {
        global $con;

        $idUsuario=$_SESSION['idUsr'];
        $idEmpresa=$_SESSION['idEmpresa'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $anio=date('Y');

        $fechaActual=date("Y-m-d");
        $ivaProducto=0;

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $nro_boleta=$obj->nro_boleta;
        $total_venta=$obj->total_venta;
        $subTotal = $obj->subtotal;
        $ivaTotal = $obj->ivaTotal;
        $descripcion="Venta realizada con Nro Boleta: ".$nro_boleta;

        //$numeroFolioNuevo=obtenerFolioBoletaNuevo($nro_boleta);

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4004_venta_cabecera(idResponsable,cod_unidad,fecha_venta,nro_boleta,descripcion,subtotal,iva,total_venta,formaPago,
                totalFfectivo,totalTarjeta,numTarjeta)VALUES('".$idUsuario."','".$cod_unidad."','".$fechaActual."','".$nro_boleta."','".$descripcion."',
                '".$subTotal."','".$ivaTotal."','".$total_venta."','1','0','0','0')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        $consulta[$x]="UPDATE 4003_folio SET nro_correlativo_venta='".$nro_boleta."' WHERE idEmpresa='".$idEmpresa."' AND ciclo='".$anio."'";
        $x++;
        
        foreach($obj->arrProductos as $p)
	    {
            $codigo_producto=$p->codigo_producto;
            $cantidad=$p->cantidad;
            $total=$p->total;
            $ivaP=$p->valorImpuesto;
            $precioVenta=$p->precio_venta_producto;
            $idProducto=$p->idProducto;

            if($ivaP>0)
            {
                $ivaProducto=$cantidad*$ivaP;
            }

            $consulta[$x]="INSERT INTO 4005_venta_detalle(idVenta,nro_boleta,codigo_producto,cantidad,precioVenta,iva,total_venta,idProducto)VALUES(@idRegistro,
            '".$nro_boleta."','".$codigo_producto."','".$cantidad."','".$precioVenta."','".$ivaProducto."','".$total."','".$idProducto."')";
            $x++;

            $consulta[$x]="INSERT INTO 4006_inventario(idResponsable,fechaCreacion,cod_unidad,idTipoMovimiento,valorMovimiento,idProducto,
                        cantidad,idtablaRef,idRegistroRef)VALUES('".$idUsuario."','".$fechaActual."','".$cod_unidad."','5','-1','".$idProducto."',
                        '".$cantidad."','4004',@idRegistro)";
            $x++;

        }
        
        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            $consultaId="select @idRegistro";
             $resA=$con->obtenerValor($consultaId);

            echo "1|".$resA;
        }
        
    }

    function guardarCotizacion()
    {
        global $con;

        $idUsuario=$_SESSION['idUsr'];
        $idEmpresa=$_SESSION['idEmpresa'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $anio=date('Y');

        $fechaActual=date("Y-m-d");
        $ivaProducto=0;

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        //$nro_boleta=$obj->nro_boleta;
        $total_cotizacion=$obj->total_venta;
        $subTotal = $obj->subtotal;
        $ivaTotal = $obj->ivaTotal;
        //$descripcion="Guardar Cotizacion: ".$nro_boleta;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 5001_cotizacion_cabecera(idResponsable,fechaCreacion,cod_unidad,descripcion,subtotal,iva,total,situacion)VALUES('".$idUsuario."',
                    '".$fechaActual."','".$cod_unidad."','','".$subTotal."','".$ivaTotal."','".$total_cotizacion."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
	    $x++;

        $idReferencia="@idRegistro";
        
        foreach($obj->arrProductos as $p)
	    {
            $codigo_producto=$p->codigo_producto;
            $cantidad=$p->cantidad;
            $total=$p->total;
            $ivaP=$p->valorImpuesto;
            $precioVenta=$p->precio_venta_producto;
            $idProducto=$p->idProducto;

            if($ivaP>0)
            {
                $ivaProducto=$cantidad*$ivaP;
            }

            $consulta[$x]="INSERT INTO 5002_cotizacion_detalle(idCotizacion,codigo_producto,cantidad,precioVenta,iva,total,idProducto)VALUES(@idRegistro,
            '".$codigo_producto."','".$cantidad."','".$precioVenta."','".$ivaProducto."','".$total."','".$idProducto."')";
            $x++;

        }
        
        $consulta[$x]="commit";
        $x++;
        if($con->ejecutarBloque($consulta))
        {
            echo "1|".$idReferencia;
        }
    }

    function obtenerVentaPeriodo()
    {
        global $con;
        $ventas="";

        $idUsuario=$_SESSION['idUsr'];
        $idEmpresa=$_SESSION['idEmpresa'];
        $cod_unidad=$_SESSION['cod_unidad'];


        $fechaDesde=date("Y-m-d");
        $fechaHasta=date("Y-m-d");

        if(isset($_POST["fechaDesde"]))
            $fechaDesde=$_POST["fechaDesde"];

        if(isset($_POST["fechaHasta"]))
            $fechaHasta=$_POST["fechaHasta"];

        $consulta="SELECT id_boleta,nro_boleta,fecha_venta,total_venta FROM 4004_venta_cabecera 
            WHERE fecha_venta BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' AND situacion='1'
            AND cod_unidad='".$cod_unidad."' ORDER BY fecha_venta,id_boleta";
        $resp=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($resp))
	    {
            $text="Boleta Nro: ".$fila[1]." - Total venta: $".$fila[3];

            $consulDetalle="SELECT vd.idDetalleVenta,vd.idProducto,vd.codigo_producto,vd.cantidad,vd.total_venta,p.idCategoria,
                        c.nombre_categoria,c.aplica_peso,p.descripcion_producto FROM 4005_venta_detalle vd,3001_cat_productos p,
                        4001_categorias c WHERE vd.idProducto=p.idProducto AND p.idCategoria=c.id_categoria 
                        AND vd.idVenta='".$fila[0]."' ORDER BY vd.idDetalleVenta";
            $resDetalle=$con->obtenerFilas($consulDetalle);

            while($row=mysql_fetch_row($resDetalle))
	        {
                if($row[7]==1)
                {
                    $cantidad=$row[3]." Kg(s)";
                }
                else{
                    $cantidad=$row[3]." Und(s)";
                }

                $totalVenta="$ ".$row[4];
                $fechaVenta=cambiarFormatoFecha($fila[2]);

                $o='{"id":"","nro_boleta":"'.$text.'","codigo_producto":"'.$row[2].'","nombre_categoria":"'.$row[6].'"
                    ,"descripcion_producto":"'.$row[8].'","cantidad":"'.$cantidad.'","total_venta":"'.$totalVenta.'"
                    ,"fecha_venta":"'.$fechaVenta.'"}';

                if($ventas=="")
                    $ventas=$o;
                else
                    $ventas.=",".$o;

            }
        }

        echo '{"data":['.$ventas.']}';

    }

    function obtenerCotizacionPeriodo()
    {
        global $con;
        $ventas="";
        $x=0;

        $idUsuario=$_SESSION['idUsr'];
        $idEmpresa=$_SESSION['idEmpresa'];
        $cod_unidad=$_SESSION['cod_unidad'];


        $fechaDesde=date("Y-m-d");
        $fechaHasta=date("Y-m-d");

        if(isset($_POST["fechaDesde"]))
            $fechaDesde=$_POST["fechaDesde"];

        if(isset($_POST["fechaHasta"]))
            $fechaHasta=$_POST["fechaHasta"];

        $consulta="SELECT idCotizacion,fechaCreacion,subtotal,iva,total FROM 5001_cotizacion_cabecera 
                    WHERE fechaCreacion BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' 
                    AND cod_unidad='".$cod_unidad."' AND situacion='1' ORDER BY fechaCreacion,idCotizacion";
        $resp=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($resp))
	    {
            $text="Cotización Nro: ".$fila[0]."-Total Cotización: $".$fila[4];

            $consulDetalle="SELECT dc.idDetalleCotizacion,dc.codigo_producto,dc.cantidad,dc.precioVenta,dc.iva,dc.total,
                        p.idCategoria,c.nombre_categoria,c.aplica_peso,p.descripcion_producto,dc.idProducto FROM 5002_cotizacion_detalle dc,
                        3001_cat_productos p,4001_categorias c WHERE dc.idProducto=p.idProducto AND p.idCategoria=c.id_categoria 
                        AND dc.idCotizacion='".$fila[0]."' ORDER BY idDetalleCotizacion";
            $resDetalle=$con->obtenerFilas($consulDetalle);

            while($row=mysql_fetch_row($resDetalle))
		    {
                if($row[8]==1)
                {
                    $cantidad=$row[2]." Kg(s)";
                }
                else{
                    $cantidad=$row[2]." Und(s)";
                }

                $totalVenta="$ ".$row[5];
                $fechaVenta=cambiarFormatoFecha($fila[1]);

                $o='{"id":"'.$row[10].'","nro_boleta":"'.$text.'","codigo_producto":"'.$row[1].'","nombre_categoria":"'.$row[7].'"
                    ,"descripcion_producto":"'.$row[9].'","cantidad":"'.$cantidad.'","total_venta":"'.$totalVenta.'"
                    ,"fecha_venta":"'.$fechaVenta.'"}';

                if($ventas=="")
                    $ventas=$o;
                else
                    $ventas.=",".$o;
            }

           
        }
        echo '{"data":['.$ventas.']}';
    }
    

?>