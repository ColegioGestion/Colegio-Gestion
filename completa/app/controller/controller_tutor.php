<?php
defined('PASOINDEX') or exit;
class tutor {
	function miclase() {
		vistprinc::montarlayout("tutor_miclase");
	}
	function guardarnuevoalumno() {
		$alumno = fmw::limpiarpost($_POST);
		if (fmw::comprobarinputobligatorios(array("apellidos", "nombre"))) {
			modelprinc::querysql('INSERT INTO '.TABLAALUMNOS.' (apellido, nombre, telefono, curso) VALUES (\''.$alumno[1].'\', \''.$alumno[2].'\', \''.$alumno[3].'\', \''.$alumno[0].'\')');
			vistprinc::mostrarnotificacion("Alumno Guardado Correctamente.");
		}ELSE{
			vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
		}
	}
}