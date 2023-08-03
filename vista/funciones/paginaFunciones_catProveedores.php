<?php
    session_start();
    include_once("conexionBD.php");


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoProveedores();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                registrarNuevoProveedor();
        break;
        case 5:
                obtenerMunicipio();
        break;
        case 6:
                guardarModificacionProveedor();
        break;
       
    }

    function obtenerListadoProveedores()
    {
        global $con;
        $arrRegistro="";

        $cod_unidad=$_SESSION['cod_unidad'];

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 4008_proveedores WHERE cod_unidad='".$cod_unidad."' ORDER BY idProveedor";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
           $nombreProveedor=obtenerNombreClienteProveedor($fila[0],'2');
           $nombreEstado=obtenerNombreEstado($fila[8]);

            $o='{"":"","id":"'.$fila[0].'","tipoEmpresa":"'.$fila[4].'","nombreProv":"'.$nombreProveedor.'","nombre":"'.$fila[5].'","apPaterno":"'.$fila[6].'",
            "apMaterno":"'.$fila[7].'","estado":"'.$fila[8].'","nomEstado":"'.$nombreEstado.'","municipio":"'.$fila[9].'","calle":"'.$fila[10].'",
            "numero":"'.$fila[11].'","colonia":"'.$fila[12].'","codPostal":"'.$fila[13].'","localidad":"'.$fila[14].'","telefono":"'.$fila[15].'","email":"'.$fila[16].'",
            "rfc":"'.$fila[18].'","situacion":"'.$fila[19].'"}';
			
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

    function registrarNuevoProveedor()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $tipoEmpresa=$obj->tipoEmpresa;
        $txt_rfc=$obj->txt_rfc;
        $razonSocial=$obj->razonSocial;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $email=$obj->email;
        $telefono=$obj->telefono;
 
         $tipoOperacion="Registrar nuevo Proveedor: ".$razonSocial;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4008_proveedores(idResponsable,fechaCreacion,cod_unidad,tipoEmpresa,nombre,apPaterno,apMaterno,
                        estado,municipio,calle,numero,colonia,codpostal,localidad,telefono,email,rfc,situacion)VALUES('".$idUsuarioSesion."',
                        '".$fechaActual."','".$cod_unidad."','".$tipoEmpresa."','".$razonSocial."','".$apPaterno."',
                        '".$apMaterno."','".$estado."','".$municipio."','".$calle."','".$numero."','".$colonia."','".$codPostal."',
                        '".$localidad."','".$telefono."','".$email."','".$txt_rfc."','1')";
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

    function guardarModificacionProveedor()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idProveedor=$obj->idProveedor;
        $tipoEmpresa=$obj->tipoEmpresa;
        $rfc=$obj->txt_rfc;
        $nombre=$obj->razonSocial;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Proveedor: ".$idProveedor;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4008_proveedores SET tipoEmpresa='".$tipoEmpresa."',nombre='".$nombre."',apPaterno='".$apPaterno."',
        apMaterno='".$apMaterno."',estado='".$estado."',municipio='".$municipio."',calle='".$calle."',numero='".$numero."',
        colonia='".$colonia."',codPostal='".$codPostal."',localidad='".$localidad."',telefono='".$telefono."',email='".$email."',
        rfc='".$rfc."',situacion='".$situacion."' WHERE idProveedor='".$idProveedor."'";
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