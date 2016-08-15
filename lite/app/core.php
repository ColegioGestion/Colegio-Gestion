<?php
defined('PASOINDEX') or exit;
if (!isset($_SESSION)) {
  session_start();
}
//comprobamos si el sistema esta instalado
if (!file_exists("config/configuracion.php")) {
   header ("Location: install.php");
   die;
}
//configuracion general
        header('Content-Type: text/html; charset=utf-8');
        putenv('TZ=Europe/Madrid');
        date_default_timezone_set('Europe/Madrid');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");
//requerimos las constantes
        require_once 'app/constantes.php';
//requerimos el archivo de configuracion
        require_once DIRECTORIOCONFIG.'/configuracion.php';
//requerimos el framework
        require_once DIRECTORIOFRAMEWORK.'/framework.php';
        new fmw;
//requerimos los controladores principales
        //clase: modelprinc
        require_once DIRECTORIOAPP.'/modelo_principal.php';
        new modelprinc();
        //clase: contprinc
		require_once DIRECTORIOAPP.'/controlador_principal.php';
		new contprinc();
		//clase: vistprinc
		require_once DIRECTORIOAPP.'/vista_principal.php';
		new vistprinc();
//requerimos todos los modelos
        foreach(glob(DIRECTORIOMODEL.'/*.php') as $file){
	          require_once $file;
        }
//requerimos todos los controladores
        foreach(glob(DIRECTORIOCONTROLLER.'/*.php') as $file){
	          require_once $file;
        }
//ocultamos errores segun estado de la web
if (ESTADOSITIO == "1") {
	 error_reporting(0);
}elseif (ESTADOSITIO == "2"){
	echo "SITIO EN CONSTRUCCIÓN";
	error_reporting(E_ERROR | E_PARSE);
}else{
	error_reporting(0);
	vistprinc::montarlayout("notificacion", "LA WEB ESTA CERRADA ACTUALMENTE. VUELVA A INTENTARLO MAS TARDE.");
	exit;
}
//Comprobamos que los get no esten vacios y en caso que si rellenarlos
$controlador = $_GET[NOMBREGETCONTROLLER];
$action      = $_GET[NOMBREGETACTION];
$encuesta    = $_GET["enc"];
	IF (!$controlador) {
		$controlador = "index";
	}
	IF (!$action) {
		$action = "inicio";
	}
//iniciamos controlador y accion secundario
    if ($controlador == "direccion" && !usuario::comprobarsisoy(5)) {
      contprinc::redireccioninterna("index", "inicio");
    }ELSEif ($controlador == "jefatura" && (!usuario::comprobarsisoy(5) && !usuario::comprobarsisoy(4)) && $action != "verparte") {
      contprinc::redireccioninterna("index", "inicio");
    }ELSEif ($controlador == "secretaria" && (!usuario::comprobarsisoy(5) && !usuario::comprobarsisoy(4) && !usuario::comprobarsisoy(3))) {
      contprinc::redireccioninterna("index", "inicio");
    }ELSEif ($controlador == "docente" && (!usuario::comprobarsisoy(5) && !usuario::comprobarsisoy(4) && !usuario::comprobarsisoy(3) && !usuario::comprobarsisoy(2) && !usuario::comprobarsisoy(1))) {
      contprinc::redireccioninterna("index", "inicio");
    }ELSEif ($controlador == "conserjeria" && (!usuario::comprobarsisoy(5) && !usuario::comprobarsisoy(4) && !usuario::comprobarsisoy(3) && !usuario::comprobarsisoy(1))) {
      contprinc::redireccioninterna("index", "inicio");
    }ELSE{
    	$controlador = new $controlador;
    	$controlador->$action();
    	}
