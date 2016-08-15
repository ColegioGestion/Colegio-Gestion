<?php
defined('PASOINDEX') or exit;
class modelodireccion {
	function limpiarlog() {
		return modelprinc::querysql('truncate '.TABLALOG.'');
	}
	function tablanoticias() {
		$query = modelprinc::querysql('SELECT * FROM '.TABLANOTICIAS.' ORDER BY `id` DESC');
		$tabla = '
		'.fmw::iniciarformulario("nuevanoticia", "post", contprinc::crearurlinterna("direccion", "nuevanoticia")).'
		<table border="1" style="width:40%">
		<tr><th>ID</th><th>Fecha de Publicación</th><th>Noticia</th><th></th></tr>
		<tr><td>Nueva Noticia:</td><td>'.fmw::aniadirinput("date", "fecha").'</td><td>'.fmw::aniadirinput("text", "noticia").'</td><td>'.fmw::aniadirinput("submit").'</td></tr>
		';
		$i=0;
		while($noticia=mysql_fetch_row($query)) {
			$tabla .= '<tr><td>'.$noticia[0].'</td><td>'.fmw::darvueltafecha($noticia[4]).'</td><td>'.$noticia[1].'</td><td>'.contprinc::crearenlaceinternojs("Borrar", "¿Seguro que desea borrar la noticia?", "direccion", "borrarnoticia", '&id='.$noticia[0].'').'</td></tr>';
			$i++;
		}
		$tabla .= '</table>'.fmw::cerrarformulario().'';
		return $tabla;
	}
	function tablaeventos() {
			$query = modelprinc::querysql('SELECT * FROM '.TABLAEVENTOS.' WHERE (rollminimo<=\''.usuario::obtenerdatousuario("tipo", $_SESSION["identificador"]).'\')AND(fecha>=\''.date("Y").'-'.date("m").'-'.date("d").'\')');
			$tabla = '
			'.fmw::iniciarformulario("nuevoevento", "post", contprinc::crearurlinterna("direccion", "nuevoevento")).'
			<table border="1" style="width:50%">
			<tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Evento</th><th>Descripción</th><th>Rol mínimo</th></tr>
			<tr><td>Nuevo Evento:</td><td>'.fmw::aniadirinput("date", "fecha").'</td><td>'.fmw::aniadirinput("text", "hora").'</td><td>'.fmw::aniadirinput("text", "evento").'</td><td>'.fmw::aniadirinput("text", "descripcion").'</td><td>'.fmw::aniadirinput("select","roll", array(4 => usuario4, 3 => usuario3, 2 => usuario2)).'</td><td>'.fmw::aniadirinput("submit").'</td></tr>
			';
			while($evento=mysql_fetch_row($query)) {
				if ($evento[6] == "") {
					$hora = "Dia Completo";
				}ELSE{
					$hora = $evento[6];
				}
				$tabla .= '<tr><td>'.$evento[0].'</td><td>'.fmw::darvueltafecha($evento[2]).'</td><td>'.$hora.'</td><td>'.$evento[3].'</td><td>'.constant("calendario".$evento[1]).' • '.$evento[4].'</td><td>'.constant("usuario".$evento[5]).'</td><td>'.contprinc::crearenlaceinternojs("Borrar", "¿Seguro que desea desprogramar el evento?", "direccion", "borrarevento", '&id='.$evento[0].'').'</td></tr>';
			    unset($hora);
			}
			$tabla .= "</table>";
			return $tabla;
	}
}