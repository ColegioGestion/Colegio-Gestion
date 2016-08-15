<?php
defined('PASOINDEX') or exit;
class modelologin {
//funcion para guardar los contactos en la base de datos	
    function comprobarsiexistecontacto($usuario, $contrasenia) {
    	if($row = mysql_fetch_row(modelprinc::querysql('SELECT contrasenia FROM '.TABLAUSUARIOS.' WHERE usuario=\''.$usuario.'\''))) {
    		if($row[0] == $contrasenia){
    			return true;
    		  }
    	  }
    }
}