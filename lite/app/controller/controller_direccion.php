<?php
defined('PASOINDEX') or exit;
class direccion {
    function verestadisticas() {
			vistprinc::montarlayout("direccion_verestadisticas");
	}
	function verlog() {
			vistprinc::montarlayout("direccion_verlog");
	}
	function noticias() {
			vistprinc::montarlayout("direccion_noticias");
	}
	function eventos() {
			vistprinc::montarlayout("direccion_eventos");
	}
	//operaciones
	function vaciarlog() {
			modelodireccion::limpiarlog();
			vistprinc::mostrarnotificacion("Borrado correctamente");
	}
	function nuevanoticia() {
		$noticia = fmw::limpiarpost($_POST);
			if (fmw::comprobarinputobligatorios(array("fecha", "noticia"))) {
               modelprinc::querysql('INSERT INTO '.TABLANOTICIAS.' (fechadespliegue, noticia) VALUES (\''.$noticia[0].'\', \''.$noticia[1].'\')');
               vistprinc::mostrarnotificacion("Noticia publicada correctamente");
			}ELSE{
				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
			   }
	}
	function borrarnoticia() {
		$noticia = fmw::limpiarpost($_POST);
			if ($_GET["id"]) {
				modelprinc::querysql('DELETE FROM '.TABLANOTICIAS.' WHERE id='.contprinc::obtenerget("id").'');
				vistprinc::mostrarnotificacion("Noticia borrada Correctamente");
			}ELSE{
				modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			    contprinc::redireccioninterna("index", "inicio");
			}	
	}
	function nuevoevento() {
		$evento = fmw::limpiarpost($_POST);
			if (fmw::comprobarinputobligatorios(array("fecha", "hora", "evento", "descripcion", "roll"))
				AND (fmw::comprobarfecha($evento[0])) AND ($evento[4] <= "5") AND ($evento[4] >= "1")) {
				if (fmw::compararfechas($evento[0], date("Y-m-d"), ">")) {
				   modelprinc::querysql('INSERT INTO '.TABLAEVENTOS.' (tipo, fecha, hora, evento, observaciones, rollminimo) VALUES (\'1\', \''.$evento[0].'\', \''.$evento[1].'\', \''.$evento[2].'\', \''.$evento[3].'\', \''.$evento[4].'\')');
				   vistprinc::mostrarnotificacion("Evento publicado correctamente");
				 }ELSE{
				   vistprinc::mostrarnotificacion("La fecha del evento debe ser posterior a la actual.");
				 }
			}ELSE{
				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
			}
	}
	function borrarevento() {
		$evento = fmw::limpiarpost($_POST);
			if ($_GET["id"]) {
				modelprinc::querysql('DELETE FROM '.TABLAEVENTOS.' WHERE id='.contprinc::obtenerget("id").'');
				vistprinc::mostrarnotificacion("Evento Desprogramado correctamente");
			}ELSE{
				modelprinc::aniadirlog(ERROR_intentartrucarformulario);
				contprinc::redireccioninterna("index", "inicio");
			}
	}
}