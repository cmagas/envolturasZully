<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerAdeudoPersonal();
        break;
        case 2:
                registrarPago();
        break;
        case 3:
                
        break;
        case 4:
                
        break;
        
    }

    function obtenerAdeudoPersonal()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4015_pedidos_cabecera WHERE cod_unidad='".$cod_unidad."' AND situacion='1' ORDER BY idPedido";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $totalAbono=cambiarFormatoMoneda(obtenerTotalAbonosPedido($fila[0]));
            $nombrePersonal=obtenerNombrePersonal($fila[4]);
            $totalAdeudo=cambiarFormatoMoneda($fila[6]);
            $fechaRecepcion=cambiarFormatoFecha($fila[5]);

            if($totalAdeudo>$totalAbono)
            {
                $situacion="CON ADEUDO";
            }else{
                $situacion="PAGADO";
            }

            $o='{"":"","id":"'.$fila[0].'","idPersonal":"'.$fila[4].'","nombrePersonal":"'.$nombrePersonal.'","fechaRecepcion":"'.$fechaRecepcion.'","totalAdeudo":"'.$totalAdeudo.'","totalAbono":"'.$totalAbono.'","situacion":"'.$situacion.'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarPago()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idPedido=$obj->idPedido;
        $fechaPago=$obj->fechaPago;
        $importe=$obj->importe;
 
         $tipoOperacion="Registrar nuevo Pago: ".$idPedido;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4017_abonosPedidosPersonal(idResponsable,fechaCreacion,cod_unidad,idPedido,importe,fechaPago)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$idPedido."','".$importe."','".$fechaPago."')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

?>    