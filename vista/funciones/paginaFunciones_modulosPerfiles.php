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
                obtenerDatosIniciales();
        break;
        case 2:
                obtenerDatosArbol();
        break;
        case 3:
                obtenerModulosPerfil();
        break;
        case 4:
                registrarPerfilModulos();
        break;
        case 5:
                obtenerDatosModulosIniciales();
        break;
        case 6:
                actualizarDatosArbolModulos();
        break;
        case 7:
                registrarNuevoModulo();
        break;
        case 8:
                obtenerDatosPerfilesUsuarios();
        break;
        case 9:
                modificarEstatusPerfilUsuario();
        break;
        case 10:
                guardarNuevoPerfilUsurio();
        break;
    }

    function obtenerDatosIniciales()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT idPerfil,nombrePerfil,situacion,DATE(fechaCreacion) AS fechaCreacion,fechaCreacion AS fecha_actualizacion,'' AS opciones 
        FROM 1004_perfiles ORDER BY idPerfil";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
        {
                $fecha1=cambiarFormatoFecha($fila[3]);

                $o='{"":"","idPerfil":"'.$fila[0].'","nombrePerfil":"'.$fila[1].'","situacion":"'.$fila[2].'","fechaCreacion":"'.$fecha1.'","fecha_actualizacion":"'.$fecha1.'","opciones":"'.$fila[5].'"}';
                
                if($arrRegistro=="")
                        $arrRegistro=$o;
                else
                        $arrRegistro.=",".$o;
        }

	    echo '{"data":['.$arrRegistro.']}';
 
    }

    function obtenerDatosArbol()
    {
        global $con;
        $arrRegistro="";

        $consulta="SELECT idModulo AS id,(CASE WHEN (idPadre is Null or idPadre=0) THEN '#' ELSE idPadre END) AS parent, 
        nombreModulo AS TEXT,vista FROM 1006_modulos ORDER BY orden";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
	    {
            //$o='{"id":"'.$fila[0].'","parent":"'.$fila[1].'","text":"'.$fila[2].'","vista":"'.$fila[3].'"}';
            $o='{"id":"'.$fila[0].'","parent":"'.$fila[1].'","text":"'.$fila[2].'","vista":"'.$fila[3].'"}';
			
                if($arrRegistro=="")
                        $arrRegistro=$o;
                else
                        $arrRegistro.=",".$o;
        }

        echo '['.$arrRegistro.']';
    }

    function obtenerModulosPerfil()
    {
        global $con;
        $arrRegistro="";

        $idPerfil=$_POST["id_perfil"];

        $consulta="SELECT m.idModulo,m.nombreModulo AS modulo,IFNULL(CASE WHEN (m.vista IS NULL OR m.vista='') THEN '0' ELSE ((SELECT '1' FROM 1005_perfilModulo pm 
        WHERE pm.idModulo=m.idModulo AND pm.idPerfil='".$idPerfil."')) END,0) AS sel FROM 1006_modulos m ORDER BY m.orden";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
	    {
            $o='{"id":"'.$fila[0].'","modulo":"'.$fila[1].'","sel":"'.$fila[2].'"}';
			
                if($arrRegistro=="")
                        $arrRegistro=$o;
                else
                        $arrRegistro.=",".$o;
        }
        
        //echo '['.$arrRegistro.']';
        echo '{"data":['.$arrRegistro.']}';
    }

    function registrarPerfilModulos()
    {
        global $con;

        $total_registro=0;

        $id_modulosSeleccionados=$_POST["id_modulosSeleccionados"];
        $id_Perfil=$_POST["id_Perfil"];
        $id_modulo_inicio=$_POST["id_modulo_inicio"];

        $x=0;
        $consulta[$x]="begin";
        $x++;

        if($id_Perfil==1)
        {
            $consulta[$x]="DELETE FROM 1005_perfilModulo WHERE idPerfil='".$id_Perfil."' AND idModulo !='6'";
            $x++;
        }
        else{
            $consulta[$x]="DELETE FROM 1005_perfilModulo WHERE idPerfil='".$id_Perfil."'";
            $x++;
        }

        foreach($id_modulosSeleccionados as $value)
        {
            if($id_Perfil==1 && $value==6)
            {
                $total_registro = $total_registro + 0;
            }else{
                if($value==$id_modulo_inicio){
                    $vista_inicio = 1;
                }else{
                    $vista_inicio = 0;
                }

                $consulta[$x]="INSERT INTO 1005_perfilModulo(idPerfil,idModulo,vista_inicio)VALUES('".$id_Perfil."',
                    '".$value."','".$vista_inicio."')";
                $x++;

                $total_registro= $total_registro+1;
            }
        }

        $consulta[$x]="commit";
	    $x++;

        if($con->ejecutarBloque($consulta))
        {
            echo $total_registro;
        }else{
            echo $total_registro=0;
        }  

    }

    function obtenerDatosModulosIniciales()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT m.idModulo,m.orden,m.nombreModulo,(SELECT nombreModulo FROM 1006_modulos mp WHERE mp.idModulo=m.idPadre) AS modulo_padre,vista,icon_menu,situacion
                    FROM 1006_modulos m WHERE situacion='1' ORDER BY m.orden";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"opciones":"","id":"'.$fila[0].'","orden":"'.$fila[1].'","modulo":"'.$fila[2].'","modulo_padre":"'.$fila[3].'","vista":"'.$fila[4].'","icon_menu":"'.$fila[5].'","situacion":"'.$fila[6].'"}';

            if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

        echo '{"data":['.$arrRegistro.']}';
 
    }

    function actualizarDatosArbolModulos()
    {
        global $con;
        $arrRegistro="";
        $total_registro=0;

        $modulos_ordenados=$_POST["modulos"];

        $x=0;
	    $consulta[$x]="begin";
	    $x++;

        foreach($modulos_ordenados as $modulos)
        {
            $array_item_modulo=explode(";",$modulos);
            $p_id=$array_item_modulo[0];
            $p_padre_id=$array_item_modulo[1];
            $p_orden=$array_item_modulo[2];

            $consulta[$x]="UPDATE 1006_modulos SET idPadre = REPLACE('".$p_padre_id."','#',0),orden='".$p_orden."' 
            WHERE idModulo='".$p_id."'";
            $x++;

            $total_registro= $total_registro+1;

        }

        $consulta[$x]="commit";
	    $x++;

        if($con->ejecutarBloque($consulta))
        {
            echo $total_registro;
        }else{
            echo $total_registro=0;
        }  
        
        
    }

    function registrarNuevoModulo()
    {
        global $con;
        $array_datos = "";
        $orden=0;
        $idUsuario=$_SESSION['idUsr'];
        $fechaCreacion=date("Y-m-d");

        //varDump($_POST["datos"]);

       parse_str($_POST["datos"],$array_datos);

       $nombreModulo=$array_datos["iptModulo"];
       $vistaModulo=$array_datos["iptVistaModulo"];
       $iconoModulo=$array_datos["iptIconoModulo"];

        $consul="SELECT MAX(orden) FROM 1006_modulos";
        $res=$con->obtenerValor($consul);

        $orden=$res + 1;

        $consulta="INSERT INTO 1006_modulos(idResponsable,fechaCreacion,nombreModulo,idPadre,vista,icon_menu,orden,situacion)VALUES('".$idUsuario."',
                '".$fechaCreacion."','".$nombreModulo."','0','".$vistaModulo."','".$iconoModulo."','".$orden."','1')";
        
        if($con->ejecutarConsulta($consulta))
        {
            echo "Se registro correctamente";
        }else{
            echo "Error al registrar";
        }
        
    }

    function obtenerDatosPerfilesUsuarios()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 1004_perfiles where situacion='1' ORDER BY idPerfil";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{

            $o='{"opciones":"","id":"'.$fila[0].'","perfil":"'.$fila[3].'","descripcion":"'.$fila[4].'","situacion":"'.$fila[5].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function modificarEstatusPerfilUsuario()
    {
        global $con;
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $idPerfil=$obj->idPerfil;
        $estado=$obj->estado;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1004_perfiles SET situacion='".$estado."' WHERE idPerfil='".$idPerfil."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            echo "1|";
        }else{
            echo "2|";
        } 
    }

    function guardarNuevoPerfilUsurio()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

        $nombrePerfil=$obj->nombrePerfil;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1004_perfiles(idResponsable,fechaCreacion,nombrePerfil)VALUES('".$idUsuarioSesion."','".$fechaActual."',
                '".$nombrePerfil."')";
        $x++;

        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            echo "1|";
        }else{
            echo "2|";
        }  
    }



?>