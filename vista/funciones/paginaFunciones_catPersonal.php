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
                obtenerListadoPersonal();
        break;
        case 2:
                registrarPersonal();
        break;
        case 3:
                guardarCambiosPersonal();
        break;
        
    }

    function obtenerListadoPersonal()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4014_cat_personal WHERE cod_unidad='".$cod_unidad."' ORDER BY idPersonal";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"":"","id":"'.$fila[0].'","nombre":"'.$fila[4].'","telefono":"'.$fila[5].'","calle":"'.$fila[6].'",
                "numero":"'.$fila[7].'","colonia":"'.$fila[8].'","codPostal":"'.$fila[9].'","localidad":"'.$fila[10].'",
                "situacion":"'.$fila[11].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }
		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarPersonal()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombrePersonal=$obj->nombre;
        $telefono=$obj->telefono;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
 
         $tipoOperacion="Registrar nuevo Personal: ".$nombrePersonal;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4014_cat_personal(idResponsable,fechaCreacion,cod_unidad,nombre,telefono,
                calle,numero,colonia,codPostal,localidad,situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."',
                '".$cod_unidad."','".$nombrePersonal."','".$telefono."','".$calle."','".$numero."',
                '".$colonia."','".$codPostal."','".$localidad."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarCambiosPersonal()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idPersonal=$obj->idPersonal;
        $nombre=$obj->nombre;
        $telefono=$obj->telefono;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Personal: ".$idPersonal." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4014_cat_personal SET nombre='".$nombre."',telefono='".$telefono."',calle='".$calle."',numero='".$numero."',
                colonia='".$colonia."',codPostal='".$codPostal."',localidad='".$localidad."',situacion='".$situacion."' WHERE idPersonal='".$idPersonal."'";
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