<?php
defined('PASOINDEX') or exit;
class jefatura {
	function listatutorias() {
		vistprinc::montarlayout("jefatura_listatutorias");
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