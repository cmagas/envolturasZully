<?php

    session_start();
	include_once("conexionBD.php"); 
	
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
		}
	}	

    switch($funcion)
	{
        case 1:
            	autenticarUsuario();
        break;
		case 2:
				cerrarSesion();
		break;
    }

    function autenticarUsuario()
	{
		global $con;
		
		$l=$_POST["l"];
		$p=$_POST["p"];
		
		//$consulta="SELECT * FROM 1000_usuarios WHERE usu_nombre='".cv($l)."' AND usu_contrasena='".cv($p)."' AND situacion in(1,3)";
		//$fila=$con->obtenerPrimeraFila($consulta);

		$consulta="SELECT * FROM 1000_usuarios u,1004_perfiles p,1005_perfilModulo pm, 1006_modulos m 
						WHERE u.idPerfilUsuario=p.idPerfil AND pm.idPerfil=u.idPerfilUsuario AND m.idModulo=pm.idModulo 
						AND pm.vista_inicio='1' AND u.usu_nombre='".cv($l)."' AND u.usu_contrasena='".cv($p)."'";
		$fila=$con->obtenerPrimeraFila($consulta);

		if($fila)
		{
			$codInstitucion=obtener_cod_institucion($fila[10]);

			$_SESSION["idUsr"]=$fila[0];
			$_SESSION["idEmpresa"]=$fila[10];
			$_SESSION["idPerfilUsuario"]=$fila[11];
			$_SESSION["idPerfilModulo"]=$fila[19];
			$_SESSION["idModulo"]=$fila[21];
			$_SESSION["vista"]=$fila[29];
			$_SESSION["usuarioNombre"]=$fila[7];
			$_SESSION["usuarioApellido"]=$fila[8]." ".$fila[9];
			$_SESSION["cod_unidad"]=$codInstitucion;

			echo "1|1";
		}
		else{
			$_SESSION["idUsr"]="-1";
			$_SESSION["idEmpresa"]="-1";
			$_SESSION["idPerfilUsuario"]="-1";
			$_SESSION["idPerfilModulo"]="-1";
			$_SESSION["idModulo"]="-1";

			echo "1|0";
		}

	}

	function cerrarSesion()
	{
		session_destroy(); 
	}
?>