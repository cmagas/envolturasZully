<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
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
                    AND MONTH(fecha_venta)='".$mes."'";
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

         /*SE OBTIENE EL TOTAL DE GASTOS DEL MES*/

         $consultaPagosPersonalMes="SELECT SUM(importe) FROM 4017_abonosPedidosPersonal WHERE cod_unidad='".$cod_unidad."' 
         AND YEAR(fechaPago)='".$anio."' AND MONTH(fechaPago)='".$mes."'";
         $resPersonal=$con->obtenerValor($consultaPagosPersonalMes);

         $consultarGastosMes="SELECT SUM(importe) FROM 4022_control_Gastos WHERE cod_unidad='".$cod_unidad."' 
         AND YEAR(fechaGasto)='".$anio."' AND MONTH(fechaGasto)='".$mes."'";
         $resTotalGastos=$con->obtenerValor($consultarGastosMes);

         $importeTotalGastoMes=cambiarFormatoMoneda($resPersonal+$resTotalGastos);

         $saldoCaja= obtenerImporteCaja();

         $o='{"totalVentaMes":"'.$totalVentaMes.'","totalVentaDia":"'.$totalVentaDia.'","totalAdeudos":"'.$totalAdeudos.'","importeTotalGastoMes":"'. $importeTotalGastoMes.'","saldoCaja":"'.$saldoCaja.'"}';

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

    function obtenerImporteCaja()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $totalVentas=0;
        $totalPagoPersonal=0;
        $totalGastos = 0;
        $saldo=0;

         /*SE OBTIENE TOTAL VENTAS*/
        $consultaVentas="SELECT SUM(total_venta) FROM 4004_venta_cabecera WHERE cod_unidad='".$cod_unidad."'";
        $resVentas=$con->obtenerValor($consultaVentas); 
        
        if($resVentas)
        {
            $totalVentas=$resVentas;
        }

        /*SE OBTIENE EL TOTAL PAGO PERSONAL*/
        $consultaPagosPersonal="SELECT SUM(importe) FROM 4017_abonosPedidosPersonal WHERE cod_unidad='".$cod_unidad."'";
        $resPagoPersonal=$con->obtenerValor($consultaPagosPersonal);

        if($resPagoPersonal)
        {
            $totalPagoPersonal=$resPagoPersonal;
        }

        /*SE OBTIENE EL TOTAL GASTOS*/
        $consultarGastos="SELECT SUM(importe) FROM 4022_control_Gastos WHERE cod_unidad='".$cod_unidad."'";
        $resTotalG=$con->obtenerValor($consultarGastos);

        if($resTotalG)
        {
            $totalGastos=$resTotalG;
        }

        $saldo = cambiarFormatoMoneda($totalVentas-$totalPagoPersonal-$totalGastos);

        return $saldo;
    }

?>    