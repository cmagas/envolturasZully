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

       // varDump($_POST);

    switch($funcion)
    {
        case 1:
                obtenerListadoUsuarios();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                guardarCambiosUsuario();
        break;
        case 4:
                obtenerMunicipio();
        break;
        
        
    }

    function obtenerListadoUsuarios()
    {
        global $con;
        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT u.idUsuario,u.usu_nombre,u.usu_contrasena,u.usu_sexo,u.nombre,u.apPaterno,u.apMaterno,u.idPerfilUsuario,u.situacion,
        u.idEmpresa,e.fechaNacimiento,e.rfc,e.telMovil,e.email,e.estado,e.municipio,e.localidad,e.fotoPerfil FROM 1000_usuarios u,1001_identifica e 
        WHERE u.idUsuario=e.idUsuario  AND u.situacion!='3' ORDER BY u.idUsuario";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $nombreCompleto=$fila[4]." ".$fila[5]." ".$fila[6];
            $nombrePerfil=obtenerNombrePerfilUsuario($fila[7]);
            $nombreEmpresa=obtenerNombreEmpresaGeneral($fila[9]);

            $o='{"":"","id":"'.$fila[0].'","nombreCompleto":"'.$nombreCompleto.'","genero":"'.$fila[3].'","nombre":"'.$fila[4].'",
                "apPaterno":"'.$fila[5].'","apMaterno":"'.$fila[6].'","fechaNac":"'.$fila[10].'","rfc":"'.$fila[11].'",
                "telmovil":"'.$fila[12].'","email":"'.$fila[13].'","estado":"'.$fila[14].'","municipio":"'.$fila[15].'",
                "localidad":"'.$fila[16].'","fotoPerfil":"'.$fila[17].'","usuario":"'.$fila[1].'","passw":"'.$fila[2].'",
                "situacion":"'.$fila[8].'","idPerfil":"'.$fila[7].'","nombrePerfil":"'.$nombrePerfil.'","idEmpresa":"'.$fila[9].'",
                "nombreEmpresa":"'.$nombreEmpresa.'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    } 

    function llenarComboMunicipios()
    {
        global $con;

        $cveEstado=$_POST['cveEstado'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado='".$cveEstado."' ORDER BY municipio";
        $resultadoM=$con->obtenerFilas($consulta);
    
        $html="<option value='-1'>Seleccionar Municipio</option>";
    
        while($rowM=mysql_fetch_row($resultadoM))
        {
            $html.= "<option value='".$rowM[0]."'>".$rowM[1]."</option>";
        }
        
        echo $html;
    }

    function guardarCambiosUsuario()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idUsuario=$obj->idUsuario;
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $genero=$obj->genero;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $localidad=$obj->localidad;
        $usuario=$obj->usuario;
        $pass1=$obj->password;
        $idPerfil=$obj->idPerfil;
        $fechaNac=$obj->fechaNac;
        $idEmpresa=$obj->idEmpresa;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Modifica datos de Usuario: ".$idUsuario;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1000_usuarios SET usu_nombre='".$usuario."',usu_contrasena='".$pass1."',usu_sexo='".$genero."',nombre='".$nombre."',
            apPaterno='".$apPaterno."',apMaterno='".$apMaterno."',idEmpresa='".$idEmpresa."',idPerfilUsuario='".$idPerfil."',situacion='".$situacion."' WHERE idUsuario='".$idUsuario."'";
        $x++;

        $consulta[$x]="UPDATE 1001_identifica SET fechaNacimiento='".$fechaNac."', rfc='".$rfc."',telMovil='".$telefono."',email='".$email."',
                estado='".$estado."',municipio='".$municipio."',localidad='".$localidad."' WHERE idUsuario='".$idUsuario."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        }  


    }
    
    function obtenerMunicipio()
    {
        global $con;
        $cveMunicipio=$_POST['mpio'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveMunicipio='".$cveMunicipio."'";
        $resultadoM=$con->obtenerPrimeraFila($consulta);
    
        $html="<option value='".$resultadoM[0]."'>".$resultadoM[1]."</option>";
    
        echo $html;
    }

    
    
    


    
    
?>    