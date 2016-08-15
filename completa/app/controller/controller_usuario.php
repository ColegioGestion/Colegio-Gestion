<?php
defined('PASOINDEX') or exit;
class usuario {
	//funcion para obtener dato de un usuario
	function obtenerdatousuario($dato,$usuario,$tipo="id") {
		if ($usuario == "") {
		$usuario = $_SESSION["identificador"];
		}
		$row = mysql_fetch_array(modelprinc::querysql('SELECT '.$dato.' FROM '.TABLAUSUARIOS.' WHERE '.$tipo.'=\''.$usuario.'\''));
		return $row[0];
	}
	function comprobarsisoy($roll) {
			if (usuario::obtenerdatousuario("tipo", $_SESSION["identificador"]) == $roll) {
				return true;
			}ELSE{
				return false;
			}
	}
}