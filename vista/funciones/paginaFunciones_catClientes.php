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
                obtenerListadoCliente();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                registrarNuevoCliente();
        break;
        case 4:
                llenarComboMunicipios();
        break;
        case 5:
                obtenerMunicipio();
        break;
        case 6:
                guardarModificacionClientes();
        break;
    }

    function obtenerListadoCliente()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4018_clientes WHERE cod_unidad='".$cod_unidad."' ORDER BY idCliente";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           //$nombreCliente=obtenerNombreClienteProveedor($fila[0],'1');
           $nombreEstado=obtenerNombreEstado($fila[6]);

            $o='{"":"","id":"'.$fila[0].'","tipoEmpresa":"'.$fila[4].'","nombre":"'.$fila[5].'","estado":"'.$fila[6].'","nomEstado":"'.$nombreEstado.'",
            "municipio":"'.$fila[7].'","calle":"'.$fila[8].'","numero":"'.$fila[9].'","colonia":"'.$fila[10].'","codPostal":"'.$fila[11].'",
            "localidad":"'.$fila[12].'","telefono":"'.$fila[13].'","email":"'.$fila[14].'","rfc":"'.$fila[15].'","situacion":"'.$fila[16].'"}';
			
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

    function registrarNuevoCliente()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $tipoEmpresa=$obj->tipoEmpresa;
        $rfc=$obj->rfc;
        $nombreCliente=$obj->razonSocial;
        $email=$obj->email;
        $telefono=$obj->telefono;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
 
         $tipoOperacion="Registrar nuevo Cliente: ".$nombreCliente;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4018_clientes(idResponsable,fechaCreacion,cod_unidad,tipoEmpresa,nombre,estado,
                municipio,calle,numero,colonia,codPostal,localidad,telefono,email,rfc,situacion)VALUES('".$idUsuarioSesion."',
                '".$fechaActual."','".$cod_unidad."','".$tipoEmpresa."','".$nombreCliente."','".$estado."',
                '".$municipio."','".$calle."','".$numero."','".$colonia."','".$codPostal."','".$localidad."',
                '".$telefono."','".$email."','".$rfc."','1')";
        
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

    function guardarModificacionClientes()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idCliente=$obj->idCliente;
        $tipoEmpresa=$obj->tipoEmpresa;
        $rfc=$obj->rfc;
        $nombre=$obj->razonSocial;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Cliente: ".$idCliente;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4018_clientes SET tipoEmpresa='".$tipoEmpresa."',nombre='".$nombre."',estado='".$estado."',
                municipio='".$municipio."',calle='".$calle."',numero='".$numero."',colonia='".$colonia."',codPostal='".$codPostal."',
                localidad='".$localidad."',telefono='".$telefono."',email='".$email."',rfc='".$rfc."',situacion='".$situacion."'
                WHERE idCliente='".$idCliente."'";
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