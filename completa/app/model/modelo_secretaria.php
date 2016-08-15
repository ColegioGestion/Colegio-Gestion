<?php
defined('PASOINDEX') or exit;
class modelosecretaria {
	function guardarnuevousuario($datos) {
		return modelprinc::querysql('INSERT INTO '.TABLAUSUARIOS.' (nombre,tipo,usuario,contrasenia,email) VALUES ('.$datos.')');
	}
}