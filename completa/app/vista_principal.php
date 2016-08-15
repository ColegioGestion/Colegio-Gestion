<?php
defined('PASOINDEX') or exit;
class vistprinc {
//funcion para montar layout
    function montarlayout($nombre, $contenido1) {
    echo '<html>
    '.vistprinc::montarhead().'
    <body>
	<div id="contenido">
    '.vistprinc::montarcabezera().'	
    '.vistprinc::montarmenuizquierda().'
    '.vistprinc::montarmenuderecha().'';
    if ($nombre) {
    	echo '<div id="cuerpo">'.modelodocente::mostrarnotificaciones().'<center>'.vistprinc::elegirsubvista($nombre, $contenido1).'</center></div>';
    }ELSE{
    	echo '<div id="cuerpo">'.modelodocente::mostrarnotificaciones().'<center>'.$contenido1.'</center></div>';
    }
    echo ''.vistprinc::montarpiepagina().'
	       </div>
	      </body>
	      </html>';
    }
//funcion para mostrar notificacion 
    function mostrarnotificacion($notificacion, $redireccion) {
    	if (!$redireccion) {
    		$redireccion = '<input type="button" value="VOLVER ATRÁS" onclick="history.go(-1)" />';
    	}elseif ($redireccion == "-2") {
    		$redireccion = '<input type="button" value="VOLVER ATRÁS" onclick="history.go(-2)" />';
    	}else{
    		$redireccion = fmw::crearenlace("Volver Atras", URLSITIO.$redireccion);
    	}
    	$layout = '
    	<div id="tituloseccion"><h3>ADMINISTRACIÓN: NOTIFICACIÓN</h3></div>
        <table id="tablabordenegro">
        <tr>
          <td>'.$notificacion.'</td>
        </tr>
        <tr>
          <td>'.$redireccion.'</td>
        </tr>
        </table>
    	';
    	return vistprinc::montarlayout("", $layout);
    }
//funcion para montar head
    function montarhead() {
    		return '
    		  <head>
    		  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	      <title>'.NOMBREPAGINA.'</title>
              '.vistprinc::elegircss("estilo").'
              <script type="text/javascript" src="'.DIRECTORIOJS.'/funciones.js"></script>
              </head>
    	      ';
    }  
//funcion para montar cabezera    
    function montarcabezera() {
    	$cabezera = '
    	<div id="cabezera">
        <center><h1>'.NOMBREPAGINA.'</h1>
        <h3>'.modelodocente::obtenerdatocentro("nombre").'</h3>

        </center></div>
    	';
    	return $cabezera;
    }
//funcion para montar menu izquierda
    function montarmenuizquierda() {
    	$roll = usuario::obtenerdatousuario("tipo", $_SESSION["identificador"]);
    	$tutoria = modelotutor::obtenermitutoria($_SESSION["identificador"]);
    	$tutoriaid = modelotutor::obtenermitutoria($_SESSION["identificador"], "id");
    	$menu = '<div id="menuizquierda"><table id="menuizquierda" class="tablaconborde">';
    	if (contprinc::comprobarsesion()) {
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Inicio", "index", "inicio").'</td></tr>';
    		$menu .= '<tr><th>Docente</th></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Encuestas", "docente", "listaencuestas").'</td></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Poner Parte Disciplinario", "docente", "elegiralumnoparte").'</td></tr>';
    	if ($tutoria) {
    		$menu .= '<tr><th>Tutoria '.$tutoria.'</th></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Mi Clase", "tutor", "miclase", '&clase='.$tutoriaid.'').'</td></tr>';
    	}
    	if ($roll == 5) {
    		$menu .= '<tr><th>Dirección</th></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Noticias", "direccion", "noticias").'</td></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Eventos", "direccion", "eventos").'</td></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Estadisticas", "direccion", "verestadisticas").'</td></tr>';
    		$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Ver log", "direccion", "verlog").'</td></tr>';
    		$menu .= '<tr><td>'.fmw::crearenlace("Manual del sistema", DIRECTORIOVIEWS."/CG_ManualAvanzado.pdf").'</td></tr>';
    	}
    	    if ($roll == 4 || $roll == 5) {
    	    	$menu .= '<tr><th>Jefatura</th></tr>';
    	    	$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Convivencia", "jefatura", "listapartes").'</td></tr>';
    	    	$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Tutorias y Tutores", "jefatura", "listatutorias").'</td></tr>';
    	    	$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Encuestas", "encuestas", "listaencuestas").'</td></tr>';
    	    }
    	    if ($roll == 3 || $roll == 4 || $roll == 5) {
    	    	$menu .= '<tr><th>Secretaria</th></tr>';
    	    	$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Lista Usuarios", "secretaria", "listausuarios").'</td></tr>';
    	    	$menu .= '<tr><td>'.contprinc::crearenlaceinterno("Crear Usuario", "secretaria", "crearusuario").'</td></tr>';
    	    }
    	}
        $menu .= '</table></div>';       
        return $menu;
        }
//funcion para montar menu
    function montarmenuderecha() {
    	IF (contprinc::comprobarsesion()) {
    		    return '<div id="menuderecha">
                <table id="menuderecha" class="tablaconborde">
                <tr><td><center><b>Bienvenido:</b></br> '.usuario::obtenerdatousuario("nombre", $_SESSION["identificador"]).'</br>'.constant("usuario".usuario::obtenerdatousuario("tipo", $_SESSION["identificador"])).'</br></center></td></tr>
                <tr><td>'.contprinc::crearenlaceinterno("Cerrar Sesión", "login", "cerrarsesion").'</td></tr>
                </table>
                </div>';
    	}ELSE{
    		    return '';
    	}
    }
//funcion para montar foother    
    function montarpiepagina() {
    	require_once ''.DIRECTORIOVIEWS.'/piepagina.php';
    	return $contenido;
    }
//funcion para elegir css    
    function elegircss($css) {
        return '<link rel="stylesheet" type="text/css" href="'.DIRECTORIOCSS.'/'.$css.'.css"/>';
    }
//funcion para elegir sub-vista
    function elegirsubvista($vista, $contenido1) {
    	require_once DIRECTORIOVIEWS.'/'.$vista.'.php';
    	return $contenido;
    }    
}