<?php
defined('PASOINDEX') or exit;
class secretaria {
    function listausuarios() {
			vistprinc::montarlayout("secretaria_listausuarios");
	}
	function verusuario() {
		$idusuario = fmw::limpiartexto($_GET["id"]);
		if (modelprinc::comprobarregistro(TABLAUSUARIOS, $idusuario)) {
		   vistprinc::montarlayout("secretaria_verusuario");
		}ELSE{
		    modelprinc::aniadirlog(ERROR_intentartrucarformulario);
		    contprinc::redireccioninterna("index", "inicio");
		}
	}
	function crearusuario() {
			vistprinc::montarlayout("secretaria_crearusuario");
	}
	function eliminarusuario() {
		$idusuario = fmw::limpiartexto($_GET["id"]);
		if (modelprinc::comprobarregistro(TABLAUSUARIOS, $idusuario)) {
			modelprinc::borrarregistro(TABLAUSUARIOS, $idusuario);
			vistprinc::mostrarnotificacion("Borrado correctamente");
		}ELSE{
			modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			contprinc::redireccioninterna("index", "inicio");
		}
	}
	function cambiarcontrasena() {
		$contrasena = fmw::limpiarpost($_POST);
		if (modelprinc::comprobarregistro(TABLAUSUARIOS, $contrasena[0])) {
		    modelprinc::querysql('UPDATE '.TABLAUSUARIOS.' SET contrasenia=\''.md5($contrasena[1]).'\' WHERE (id=\''.$contrasena[0].'\')');			
			vistprinc::mostrarnotificacion("Contraseña cambiada correctamente.");
		}ELSE{
			modelprinc::aniadirlog(ERROR_intentartrucarformulario);
			contprinc::redireccioninterna("index", "inicio");
		}
	}
	function guardarnuevousuario() {
		if (fmw::comprobarinputobligatorios(array("nombre", "tipo", "usuario", "password", "email"))) {
			$usuario = fmw::limpiarpost($_POST);
			if (usuario::obtenerdatousuario("nombre", $usuario[2], "usuario") == "" || usuario::obtenerdatousuario("nombre", $usuario[4], "email") == "") {
				modelosecretaria::guardarnuevousuario('\''.$usuario[0].'\',\''.$usuario[1].'\',\''.$usuario[2].'\',\''.md5($usuario[3]).'\',\''.$usuario[4].'\'');
				vistprinc::mostrarnotificacion("Se ha añadido correctamente.", contprinc::crearurlinterna("secretaria", "listausuarios"));
			}ELSE{
				vistprinc::mostrarnotificacion("El usuario o email ya esta en uso.");
			}
		}ELSE{
			vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
		}
	}
}