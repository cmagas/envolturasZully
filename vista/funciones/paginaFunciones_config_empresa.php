<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    


    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];

       // varDump($_POST);

    switch($funcion)
    {
        case 1:
                llenarComboMunicipios();
        break;
        case 2:
                obtenerDatosEmpresa();
        break;
        case 3:
                obtenerMunicipio();
        break;

        
        
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

    function obtenerDatosEmpresa()
    {
       global $con;

       $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $valores= array();

        $consulta="SELECT * FROM 4000_config_empresa WHERE cod_unidad='".$cod_unidad."' and situacion='1'";
        $res=$con->obtenerPrimeraFila($consulta);
        if($res)
        {
            $valores['existe']=1;
            $valores['cod_unidad']=$res[3];
            $valores['tipoEmpresa']=$res[4];
            $valores['nombre']=$res[5];
            $valores['rfc']=$res[8];
            $valores['telefono']=$res[9];
            $valores['email']=$res[10];
            $valores['estado']=$res[11];
            $valores['municipio']=$res[12];
            $valores['calle']=$res[13];
            $valores['numero']=$res[14];
            $valores['colonia']=$res[15];
            $valores['codPostal']=$res[16];
            $valores['localidad']=$res[17];
            $valores['rutaImagen']=$res[18];
            $valores['idEmpresa']=$res[0];
        }
        else{
            $valores['existe']=0;
            $valores['cod_unidad']='';
            $valores['tipoEmpresa']=-1;
            $valores['nombre']='';
            $valores['rfc']='';
            $valores['telefono']='';
            $valores['email']='';
            $valores['estado']=-1;
            $valores['municipio']=-1;
            $valores['calle']='';
            $valores['numero']='';
            $valores['colonia']='';
            $valores['codPostal']='';
            $valores['localidad']='';
            $valores['rutaImagen']="fotos/empresa/no_imagen.png";
            $valores['idEmpresa']=-1;
        }

        $valores= json_encode($valores);
        echo $valores;


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