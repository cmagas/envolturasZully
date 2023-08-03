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
                obtenerListadoCategoria();
        break;
        case 2:
                registrarNuevaCategoria();
        break;
        case 3:
                guardarModificacionCategoria();
        break;
        
    }

    function obtenerListadoCategoria()
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

        $consulta="SELECT * FROM 4001_categorias$sql ORDER BY id_categoria";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","nombreCategoria":"'.$fila[4].'","descripcion":"'.$fila[5].'","aplicaPeso":"'.$fila[6].'","situacion":"'.$fila[7].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevaCategoria()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nomCategoria=$obj->nomCategoria;
        $descripcion=$obj->descripcion;
        $aplicaPeso=$obj->aplicaPeso;
 
         $tipoOperacion="Registrar nueva Categoria: ".$nomCategoria;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4001_categorias(idResponsable,fechaCreacion,cod_unidad,nombre_categoria,descripcion,aplica_peso,
        situacion)VALUES('".$idUsuarioSesion."','".$fechaActual."','".$cod_unidad."','".$nomCategoria."','".$descripcion."','".$aplicaPeso."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionCategoria()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idCategoria=$obj->idCategoria;
        $nomCategoria=$obj->nomCategoria;
        $descripcion=$obj->descripcion;
        $aplicaPeso=$obj->aplicaPeso;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Categoria: ".$idCategoria;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4001_categorias SET nombre_categoria='".$nomCategoria."',descripcion='".$descripcion."',aplica_peso='".$aplicaPeso."',situacion='".$situacion."' WHERE id_categoria='".$idCategoria."'";
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