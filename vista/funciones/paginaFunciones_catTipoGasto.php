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
                obtenerListadoTipoGasto();
        break;
        case 2:
                registrarNuevaTipoGasto();
        break;
        case 3:
                guardarModificacionTipoGasto();
        break;
        
    }

    function obtenerListadoTipoGasto()
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

        $consulta="SELECT * FROM 4021_cat_tipoGasto$sql ORDER BY idTipoGasto  ";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","nomTipoGasto":"'.$fila[4].'","descripcion":"'.$fila[5].'","situacion":"'.$fila[6].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevaTipoGasto()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombreTipo=$obj->nombreTipo;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nuevo Tipo de Gasto: ".$nombreTipo;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4021_cat_tipoGasto(idResponsable,fechaCreacion,cod_unidad,nombreTipo,descripcion,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$nombreTipo."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionTipoGasto()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idTipoGasto=$obj->idTipoGasto;
        $nomTipoGasto=$obj->nomTipoGasto;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Tipo de Gasto: ".$idTipoGasto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4021_cat_tipoGasto SET nombreTipo='".$nomTipoGasto."',descripcion='".$descripcion."',situacion='".$situacion."' 
                    WHERE idTipoGasto='".$idTipoGasto."'";
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