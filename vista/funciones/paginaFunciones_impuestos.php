<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");

    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoPermisos();
        break;
        case 2:
                registrarImpuesto();
        break;
        case 3:
                modificarImpuestos();
        break;
        
    }

    function obtenerListadoPermisos()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4002_impuesto ORDER BY idImpuesto";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           

            $o='{"":"","id":"'.$fila[0].'","nombreImpuesto":"'.$fila[3].'","valor":"'.$fila[4].'","descripcion":"'.$fila[5].'","situacion":"'.$fila[6].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarImpuesto()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombreImpuesto=$obj->nombreImpuesto;
        $valor=$obj->valor;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nuevo Impuesto: ".$nombreImpuesto;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4002_impuesto(idResponsable,fechaCreacion,nombreImpuesto,valor,descripcion,situacion)VALUES('".$idUsuarioSesion."',
        '".$fechaActual."','".$nombreImpuesto."','".$valor."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function modificarImpuestos()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idImpuesto=$obj->idImpuesto;
        $nombreImpuesto=$obj->nombreImpuesto;
        $valor=$obj->valor;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Impuesto: ".$idImpuesto." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4002_impuesto SET nombreImpuesto='".$nombreImpuesto."',valor='".$valor."',descripcion='".$descripcion."',situacion='".$situacion."' WHERE idImpuesto='".$idImpuesto."'";
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