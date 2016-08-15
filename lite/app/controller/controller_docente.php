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

