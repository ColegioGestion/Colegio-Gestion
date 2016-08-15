<?php
defined('PASOINDEX') or exit;
class login {
	function iniciarsesion() {
		$datosacceso = fmw::limpiarpost($_POST);
		IF (!contprinc::comprobarsesion()) 
			IF (!$datosacceso[0] || !$datosacceso[1]) {	
			vistprinc::mostrarnotificacion("No has introducido todos los campos");
			}ELSE{
				IF (modelologin::comprobarsiexistecontacto($datosacceso[0], md5($datosacceso[1]))) {
					$_SESSION['usuario'] = $datosacceso[0];
					$_SESSION['identificador'] = usuario::obtenerdatousuario("id",$datosacceso[0],"usuario");
                    contprinc::redireccioninterna("docente","inicio");
				}ELSE{
            vistprinc::mostrarnotificacion("<b>Usuario o contraseña incorrectos.</b></br> Si se le ha olvidado la contraseña acuda a secretaria para solicitar una nueva.");
				}
			} 
		}	
	function cerrarsesion() {
		session_destroy();
		contprinc::redireccioninterna("index","inicio");
	}
}