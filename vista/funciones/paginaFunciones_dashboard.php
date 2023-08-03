<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    //$idUsuarioSesion=$_SESSION['idUsr'];
    //$cod_unidad=$_SESSION['cod_unidad'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerDatosIniciales();
        break;
        case 2:
                obtenerListadoPedidosVentas();
        break;
        case 3:
                
        break;
        
    }


    function obtenerDatosIniciales()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");
        $anio=date("Y");
        $mes=date("m");

        $totalVentaMes="$ 0.00";
        $totalVentaDia="$ 0.00";
        $totalAdeudos="$ 0.00";

        //echo "Año actual ".$anio."mes actual ".$mes;

        /*SE OBTIENE TOTAL VENTA DEL MES */
        $consultaTV="SELECT SUM(total_venta) FROM 4004_venta_cabecera WHERE cod_unidad='".$cod_unidad."' AND YEAR(fecha_venta)='".$anio."' 
                    AND MONTH(total_venta)='".$mes."'";
        $resTV=$con->obtenerValor($consultaTV);

        if($resTV)
        {
            $totalVentaMes=cambiarFormatoMoneda($resTV);
        }

         /*SE OBTIENE TOTAL VENTA DEL DIA */
        $consultaVentaDia="SELECT SUM(total_venta) FROM 4004_venta_cabecera WHERE cod_unidad='".$cod_unidad."' 
                    AND fecha_venta='".$fechaActual."'";
        $ventaDia=$con->obtenerValor($consultaVentaDia);

        if($ventaDia)
        {
            $totalVentaDia=cambiarFormatoMoneda($ventaDia);
        }

         /*SE OBTIENE TOTAL ADEUDO */
         $consultaAdeudo="SELECT SUM(totalPedido) FROM 4015_pedidos_cabecera WHERE cod_unidad='".$cod_unidad."' AND situacion='1'";
         $resAdeudo=$con->obtenerValor($consultaAdeudo);

         if($resAdeudo)
         {
            $consultaAbonos="SELECT SUM(importe) FROM 4017_abonosPedidosPersonal WHERE cod_unidad='".$cod_unidad."'";
            $resAbonos=$con->obtenerValor($consultaAbonos);

            $totalAdeudos=cambiarFormatoMoneda($resAdeudo-$resAbonos);
         }

         $o='{"totalVentaMes":"'.$totalVentaMes.'","totalVentaDia":"'.$totalVentaDia.'","totalAdeudos":"'.$totalAdeudos.'"}';

         echo $o;

    }

    function obtenerListadoPedidosVentas()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4019_pedidosVenta_cabecera WHERE cod_unidad='".$cod_unidad."' AND situacion='1' ORDER BY idPedidoVenta";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $nombreCliente=obtenerNombreClienteProveedor($fila[0],'1');
           $fechaPedido=cambiarFormatoFecha($fila[5]);
           $fechaEntrega=cambiarFormatoFecha($fila[6]);
           $importeTotal=cambiarFormatoMoneda($fila[7]);

            $o='{"":"","id":"'.$fila[0].'","idCliente":"'.$fila[4].'","nomCliente":"'.$nombreCliente.'","fechaPedido":"'.$fechaPedido.'","fechaEntrega":"'.$fechaEntrega.'","importeTotal":"'. $importeTotal.'","situacion":"'.$fila[8].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

?>    