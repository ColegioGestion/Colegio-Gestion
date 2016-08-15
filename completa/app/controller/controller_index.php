<?php
defined('PASOINDEX') or exit;
class index {
	function inicio() {
		if (contprinc::comprobarsesion()) {
			contprinc::redireccioninterna("docente", "inicio");
		}ELSE{
			vistprinc::montarlayout("login_index");
		}
	}
}
