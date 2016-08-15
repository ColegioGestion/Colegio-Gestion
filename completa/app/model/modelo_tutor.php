<?php
defined('PASOINDEX') or exit;
class modelotutor {
	function obtenermitutoria($id, $dato="curso") {
		return modelprinc::obtenerregistrosql('SELECT '.$dato.' FROM '.TABLATUTORIAS.' WHERE (tutor='.$id.')');
	} 
	function tablaalumnos() {
		$return = '<table border="1">
		'.fmw::iniciarformulario("nuevoalumno", "post", contprinc::crearurlinterna("tutor", "guardarnuevoalumno")).'
		<tr><td>ID</td><td>Apellidos</td><td>Nombre</td><td>Teléfono</td><td></td></tr>
		<tr><td>Nuevo Alumno:'.fmw::aniadirinput("hidden","clase",$_GET["clase"]).'</td><td>'.fmw::aniadirinput("text","apellidos").'</td><td>'.fmw::aniadirinput("text","nombre").'</td><td>'.fmw::aniadirinput("text","telefono").'</td><td>'.fmw::aniadirinput("submit").'</td>'.fmw::cerrarformulario().'</tr>
		';
		$query = modelprinc::querysql('SELECT * FROM '.TABLAALUMNOS.' WHERE (curso='.$_GET["clase"].') ORDER BY `apellido` ASC ');
		$i=1;
		while ($alumnos = mysql_fetch_row($query)) {
			$return .= '<tr><td>'.$i.'</td><td>'.$alumnos[2].'</td><td>'.$alumnos[1].'</td><td>'.$alumnos[3].'</td><td></td></tr>';
			$i++;
		}
		$return .= '</table>';
		return $return;
	}
	function listapartes() {
		$return = '<table border="1">
		<tr><td>ID</td><td>Alumno</td><td>Tipo</td><td>Ver parte</td><td>Estado</td></tr>
		';
		$tutor = modelprinc::obtenerdato(TABLATUTORIAS, "tutor", $_GET["clase"]);
		$query = modelprinc::querysql('SELECT id, alumno, tipo, firmatutor FROM '.TABLAPARTES.' WHERE (tutor='.$tutor.') ORDER BY id DESC ');
		while ($parte = mysql_fetch_row($query)) {
			if ($parte[3] == "0000-00-00") {
				$firma = "Sin firmar por el tutor";
			}
			$return .= '<tr><td>'.$parte[0].'</td><td>'.modelprinc::obtenerdato(TABLAALUMNOS, "apellido", $parte[1]).', '.modelprinc::obtenerdato(TABLAALUMNOS, "nombre", $parte[1]).'</td><td>'.constant("PARTE".$parte[2]).'</td><td>'.contprinc::crearenlaceinterno("Ver Parte", "jefatura", "verparte", '&id='.$parte[0].'').'</td><td>'.$firma.'</td></tr>';
			unset($firma);
		}
		$return .= '</table>';
		return $return;
	}
}