<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    $idUsuarioSesion=$_SESSION['idUsr'];
    $idEmpresaSesion=$_SESSION['idEmpresa'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoEmpresas();
        break;
        case 2:
                llenarComboMunicipios();
        break;
        case 3:
                registrarNuevaEmpresa();
        break;
        case 4:
                obtenerDatosMunicipio();
        break;
        case 5:
                guardarCambiosEmpresa();
        break;
        
        
    }

    function obtenerListadoEmpresas()
    {
        global $con;
        $arrRegistro="";
        $nombreCompleto="";

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 1002_empresa ORDER BY idEmpresa";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            if($fila[4]==2)
            {
                $nombreCompleto=tm($fila[5]);
            }else{
                $nombreCompleto=tm($fila[5])." ".tm($fila[6])." ".tm($fila[7]);
            }
          

            $o='{"":"","id":"'.$fila[0].'","codInstitucion":"'.$fila[3].'","tipoEmpresa":"'.$fila[4].'","nombreCompleto":"'.$nombreCompleto.'",
                "nombre":"'.$fila[5].'","apPaterno":"'.$fila[6].'","apMaterno":"'.$fila[7].'","rfc":"'.$fila[8].'","telefono":"'.$fila[9].'",
                "email":"'.$fila[10].'","estado":"'.$fila[11].'","municipio":"'.$fila[12].'","calle":"'.$fila[13].'","numero":"'.$fila[14].'",
                "colonia":"'.$fila[15].'","codPostal":"'.$fila[16].'","localidad":"'.$fila[17].'","situacion":"'.$fila[18].'"}';
			
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

    function registrarNuevaEmpresa()
    {
        global $con;
        $codIdRegistro=-1;
        $codigo='00000';

        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        //varDump($cadOb);

        $obj="";

        $obj=json_decode($cadObj);
    
        $tipoEmpresa=$obj->tipoEmpresa;
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;

         $tipoOperacion="Registrar nueva Empresa: ".$nombre;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 1002_empresa(idResponsable,fechaCreacion,tipoEmpresa,Nombre,apPaterno,apMaterno,rfc,telefono,
                    email,estado,municipio,calle,numero,colonia,cod_postal,localidad,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$tipoEmpresa."','".$nombre."','".$apPaterno."','".$apMaterno."','".$rfc."','".$telefono."',
                    '".$email."','".$estado."','".$municipio."','".$calle."','".$numero."','".$colonia."','".$codPostal."',
                    '".$localidad."','1')";
        $x++;

        $consulta[$x]="set @idRegistro:=(select last_insert_id())";
        $x++;

        /*
        $num= obtenerUltimoID();

        switch(strlen($num))
        {
            case 1:
                    $codigo="0000".$num;
            break;
            case 2:
                    $codigo="000".$num;
            break;
            case 3:
                    $codigo="00".$num;
            break;
            case 4:
                    $codigo="0".$num;
            break;
            case 4:
                    $codigo=$num;
            break;
        }
        */

        $consulta[$x]="UPDATE 1002_empresa SET cod_institucion='".$codigo."' WHERE idEmpresa=@idRegistro";
        $x++;

        $consulta[$x]="commit";
        $x++;
       
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
        
    }

    function obtenerDatosMunicipio()
    {
        global $con;
        $cveMunicipio=$_POST['mpio'];

        $consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveMunicipio='".$cveMunicipio."'";
        $resultadoM=$con->obtenerPrimeraFila($consulta);
    
        $html="<option value='".$resultadoM[0]."'>".$resultadoM[1]."</option>";
    
        echo $html;
    }

    function guardarCambiosEmpresa()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $idEmpresaSesion=$_SESSION['idEmpresa'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idEmpresa=$obj->idEmpresa;
        $tipoEmpresa=$obj->tipoEmpresa;
        $nombre=$obj->nombre;
        $apPaterno=$obj->apPaterno;
        $apMaterno=$obj->apMaterno;
        $rfc=$obj->rfc;
        $telefono=$obj->telefono;
        $email=$obj->email;
        $estado=$obj->estado;
        $municipio=$obj->municipio;
        $calle=$obj->calle;
        $numero=$obj->numero;
        $colonia=$obj->colonia;
        $codPostal=$obj->codPostal;
        $localidad=$obj->localidad;
        $situacion=$obj->situacion;
 
         $tipoOperacion="Realiza cambios a Empresa: ".$idEmpresa;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 1002_empresa SET tipoEmpresa='".$tipoEmpresa."',Nombre='".$nombre."',apPaterno='".$apPaterno."',apMaterno='".$apMaterno."',
                rfc='".$rfc."',telefono='".$telefono."',email='".$email."',estado='".$estado."',municipio='".$municipio."',calle='".$calle."',
                numero='".$numero."',colonia='".$colonia."',cod_postal='".$codPostal."',localidad='".$localidad."',situacion='".$situacion."' 
                WHERE idEmpresa='".$idEmpresa."'
        ";
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