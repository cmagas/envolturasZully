<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");


    //$idUsuarioSesion=$_SESSION['idUsr'];
    //$cod_unidad=$_SESSION['cod_unidad'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoGastos();
        break;
        case 2:
                registrarNuevoGastos();
        break;
        case 3:
                guardarModificacionGastos();
        break;
        
    }

    function obtenerListadoGastos()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $sql="";

        if($cod_unidad!='00001')
        {
            $sql=" WHERE  cod_unidad='".$cod_unidad."'";
        }

        $consulta="SELECT * FROM 4022_control_Gastos$sql ORDER BY fechaGasto,idControl";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $fechaGastoVista=cambiarFormatoFecha($fila[4]);
            $nombreGasto=obtenerNombreGasto($fila[5]);
            $importeGasto=cambiarFormatoMoneda($fila[6]);

            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","fechaGastoVista":"'.$fechaGastoVista.'","fechaGasto":"'.$fila[4].'",
                "idTipoGasto":"'.$fila[5].'","nombreGasto":"'.$nombreGasto.'","importeVista":"'.$importeGasto.'","importe":"'.$fila[6].'","descripcion":"'.$fila[7].'",
                "situacion":"'.$fila[8].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevoGastos()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idTipoGasto=$obj->idTipoGasto;
        $fechaGasto=$obj->fechaGasto;
        $importe=$obj->importe;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nuevo Gasto: ".$idTipoGasto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4022_control_Gastos(idResponsable,fechaCreacion,cod_unidad,fechaGasto,idTipoGasto,importe,
        descripcion,situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$cod_unidad."','".$fechaGasto."','".$idTipoGasto."',
        '".$importe."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }  
    }

    function guardarModificacionGastos()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idGasto=$obj->idGasto;
        $idTipoGasto=$obj->idTipoGasto;
        $fechaGasto=$obj->fechaGasto;
        $importe=$obj->importe;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Gasto: ".$idGasto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4022_control_Gastos SET fechaGasto='".$fechaGasto."',idTipoGasto='".$idTipoGasto."',importe='".$importe."',
        descripcion='".$descripcion."',situacion='".$situacion."' WHERE idControl='".$idGasto."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }
    }

?>    