<?php
defined('PASOINDEX') or exit;
class jefatura {
	function listatutorias() {
		vistprinc::montarlayout("jefatura_listatutorias");
	}
	function listapartes() {
		vistprinc::montarlayout("jefatura_listapartes");
	}
	function verparte() {
		$tutorparte = modelprinc::obtenerdato(TABLAPARTES, "tutor", fmw::limpiartexto($_GET["id"]));
		if (modelprinc::comprobarregistro(TABLAPARTES, fmw::limpiartexto($_GET["id"])) && (usuario::comprobarsisoy(5) || usuario::comprobarsisoy(4) || $tutorparte == $_SESSION["identificador"])) {
		    vistprinc::montarlayout("jefatura_verparte");
		}ELSE{
		    modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			contprinc::redireccioninterna("index","inicio");
		}
	}
	function firmartutor() {
		$idalumno = modelprinc::obtenerdato(TABLAPARTES, "alumno", fmw::limpiartexto($_GET["id"]));
		if (modelprinc::obtenerdato(TABLATUTORIAS, "tutor", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $idalumno)) == $_SESSION["identificador"]) {
		    modelprinc::querysql('UPDATE '.TABLAPARTES.' SET firmatutor = \''.date("Y-m-d").'\' WHERE  id = '.fmw::limpiartexto($_GET["id"]).'');
		    vistprinc::mostrarnotificacion("Firmado Correctamente.");
		}ELSE{
			modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			contprinc::redireccioninterna("index","inicio");
		}
	}
	function firmarjefatura() {
		if (usuario::comprobarsisoy(4)) {
			modelprinc::querysql('UPDATE '.TABLAPARTES.' SET firmajefatura = \''.date("Y-m-d").'\' WHERE  id = '.fmw::limpiartexto($_GET["id"]).'');
			vistprinc::mostrarnotificacion("Firmado Correctamente.");
		}ELSE{
			modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			contprinc::redireccioninterna("index","inicio");
		}
	}
	function guardarnuevatutoria() {
		$tutoria = fmw::limpiarpost($_POST);
		if (fmw::comprobarinputobligatorios(array("curso", "tutor"))) {
			modelprinc::querysql('INSERT INTO '.TABLATUTORIAS.' (curso, tutor) VALUES (\''.$tutoria[0].'\', \''.$tutoria[1].'\')');
			vistprinc::mostrarnotificacion("Tutoria Guardada Correctamente.");
		}ELSE{
			vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
		}
	} 
}