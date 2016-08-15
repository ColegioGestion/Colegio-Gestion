<?php
defined('PASOINDEX') or exit;
class modelotutor {
	function obtenermitutoria($id, $dato="curso") {
		return modelprinc::obtenerregistrosql('SELECT '.$dato.' FROM '.TABLATUTORIAS.' WHERE (tutor='.$id.')');
	} 
}