<?php 	
	mb_internal_encoding('UTF-8');
	include_once("cConexion.php");

	date_default_timezone_set('America/Mexico_City');

	//Investigacion 
	//Expendiente grupoLatisMigracion
	
	$con=new cConexion("localhost","root","sistemas07","bd_sgtecno_51envolturas",true);//tus datso
	
	

	$tipoServidor=2; //Linux, 2 Windows
	//---agenda
	
	$urlSitio="http://bpm.sommeil.mx//";
	//$baseDir=$_SERVER["DOCUMENT_ROOT"]."";
	$baseDir="localhost/latis";
	$urlRepositorioDocumentos=$baseDir;
	$directorioInstalacion=$baseDir;
	$guardarArchivosBD=false;
	$considerarDeprecated=false;
	$SO=$tipoServidor; //1 Linux; 2 Windows
	$desHabilitarImageSize=true;
	$habilitarEnvioCorreo=true;
	$mailAdministrador="proyectos@grupolatis.net";
	$nombreEmisorAdministrador="Latis Admon";
	$considerarFichaMedica=false;
	$incluirCabeceraISO=false;
	$codificarUTF8uEJ=false;
	$codificarUTF8uE=false;
	$decodificarUTF8uEJ=false;
	$considerarJustificacionFaltas=false;
	$considerarReporteConducta=false; 
	$considerarAlumnosAsociados=false;
	$externosOrganigrama=false;
	
	
	
	//log de sistema
	$logInicioSesion=true;
	$logFinSesion=true;
	$logSistemaAccesoPaginas=true;
	$logSistemaModificacionBD=false; //insert,delete,update
	$logSistemaConsultaBD=false; //select
	
	
	$paginaInicioLogin="../Login/index.php";
	$paginaCierreLogin="../index.php";
	
	
	
	
	
	
?>