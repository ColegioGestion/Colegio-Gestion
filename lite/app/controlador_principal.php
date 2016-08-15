<?php
defined('PASOINDEX') or exit;
class contprinc {
//Comprobar si la sesion se a abierto
    function comprobarsesion() {
	    IF (isset($_SESSION['usuario']))  {
	        return true;	
	    }ELSE{
	        return false;	
	    } 
     }     
     function crearurlinterna($c, $a, $get) {
	     return 'index.php?'.NOMBREGETCONTROLLER.'='.$c.'&'.NOMBREGETACTION.'='.$a.''.$get.'';
     }
     function redireccioninterna($c, $a) {
	     header('Location: '.contprinc::crearurlinterna($c, $a).'');
     }
     function crearenlaceinterno($nombre, $c, $a, $get) {
	     return fmw::crearenlace("$nombre", contprinc::crearurlinterna($c, $a, $get));
     }
     function crearenlaceinternojs($nombre, $alerta, $c, $a, $get) {
     	return '<a href="#" onClick="confirma(\''.contprinc::crearurlinterna($c, $a, $get).'\', \''.$alerta.'\'); return false;">'.$nombre.'</a>';
     }
     function obtenerget($get) {
     	return fmw::limpiartexto($_GET[$get]);
     }
}

