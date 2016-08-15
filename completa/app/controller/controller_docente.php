<?php
defined('PASOINDEX') or exit;
class docente {
	//opciones para usuario normal
	function inicio() {
		vistprinc::montarlayout("docente_index");
	}
	function listaencuestas() {
		vistprinc::montarlayout("docente_listaencuestas");
	}
	function elegiralumnoparte() {
		vistprinc::montarlayout("docente_elegiralumnoparte");
	}
	function ponerparte() {
		$alumno = fmw::limpiarpost($_POST);
		$idalumno = modelprinc::obtenerregistrosql('SELECT id FROM '.TABLAALUMNOS.' WHERE (apellido=\''.$alumno[0].'\')AND(nombre=\''.$alumno[1].'\')AND(curso=\''.$alumno[2].'\')');
		if ($idalumno != "") {
		    vistprinc::montarlayout("docente_ponerparte", $idalumno);
		}ELSE{
			vistprinc::mostrarnotificacion("No existe el alumno, no has introducido su nombre o su curso correctamente.");
		}
	}
	function guardarparte() {
			$parte = fmw::limpiarpost($_POST);
			$tutor = modelprinc::obtenerdato(TABLATUTORIAS, "tutor", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $parte[0]));
			if (fmw::comprobarinputobligatorios(array("alumno", "tipo", "descripcion"))) {
				if (modelprinc::comprobarregistro(TABLAALUMNOS, $parte[0])) {
				    modelprinc::querysql('INSERT INTO '.TABLAPARTES.' (alumno, docente, tipo, descripcion, fecha, tutor) VALUES (\''.$parte[0].'\', \''.$_SESSION["identificador"].'\', \''.$parte[1].'\', \''.str_replace(array("\\r","\\n","\\"), '', $parte[2]).'\',\''.date("Y-m-d").'\',\''.$tutor.'\')');
				    vistprinc::mostrarnotificacion("El parte se ha enviado a jefatura y a su tutor correctamente.", contprinc::crearurlinterna("docente", "inicio"));
				}ELSE{
					modelprinc::aniadirlog(ERROR_intentotrucarformulario);
					contprinc::redireccioninterna("index", "inicio");
				}
				}ELSE{
				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
			}
	}
	function obtenerañolectivo() {
	$anodosdigitos = date("y");
	$anoanterior = $ano-"1";
	$anoproximo = $ano+"1";
	$anodosdigitossiguiente = $anodosdigitos+"1";
	if (($mes == "7") || ($mes == "8")) {
		$anolectivo = "Vacaciones";
	}
	ELSE
	{
		if ($mes < "7") {
			$anolectivo = ''.$anoanterior.'/'.$anodosdigitos.'';
		}
		ELSE
		{
			$anolectivo = ''.$ano.'/'.$anodosdigitossiguiente.'';
		}
	  }
	return $anolectivo;
	}
}

