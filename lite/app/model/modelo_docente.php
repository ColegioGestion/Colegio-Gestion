<?php
defined('PASOINDEX') or exit;
class modelodocente {
	function obtenerdatocentro($dato) {
		$row = mysql_fetch_array(modelprinc::querysql('SELECT value FROM '.TABLACENTRO.' WHERE nombre=\''.$dato.'\''));
		return $row[0];
	}
	function montarcalendariomensual() {
		$mes=date("m");
		$ano=date("Y");
		$calendario = "";
			$diaSemana=date("w",mktime(0,0,0,$mes,1,$ano))+7;
			$ultimoDiaMes=date("d",(mktime(0,0,0,$mes+1,1,$ano)-1));
			$last_cell=$diaSemana+$ultimoDiaMes;
			$calendario .= '<table id="calendario">
			<tr>
			<th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th>
			<th>Viernes</th><th>Sábado</th><th>Domingo</th>
			</tr>
			<tr>';
			for($i=1;$i<=42;$i++)
			{
			if($i==$diaSemana)
			{
			// determinamos en que dia empieza
			$day=1;
			}
			if($i<$diaSemana || $i>=$last_cell)
			{
				// celca vacia
					$calendario .= "<td>&nbsp;</td>";
				}else{
				// mostramos el dia
				$eventos = "";
					$queryeventos = modelprinc::querysql('SELECT * FROM '.TABLAEVENTOS.' WHERE (rollminimo<=\''.usuario::obtenerdatousuario("tipo", $_SESSION["identificador"]).'\')AND(fecha=\''.$ano.'-'.$mes.'-'.$day.'\')');
					while ($evento = mysql_fetch_row($queryeventos)) {
						if ($evento[1] == 2) {
							$nolectivo = 1;
						}
						$eventos .= '<b>'.constant("calendario".$evento[1]).'</b></br>'.$evento[3].'</br>';
					}
					if($i%7==0 || $i%7==6)
						$calendario .= "<td style='background:gray'><p><b>$day</b></td>";
					else
						if($nolectivo == 1)
						$calendario .= "<td style='background:gray'><p><b>$day</b></td>";
						else
					if($i%7==0)
					$calendario .= "<td><p style='color:red'><b>$day</b></td>";
					else
						if($day==date("j") && $mes==date("m") && $ano==date("Y"))
	
						$calendario .= "<td style='border: 1px solid blue; color:blue'><p><b>$day</b> $eventos</td>";
						else
							$calendario .= "<td><b>$day</b> </br>$eventos</td>";
								$day++;
								unset($nolectivo);
								unset($eventos);
				}
				// cuando llega al final de la semana, iniciamos una columna nueva
				if($i%7==0)
				{
					$calendario .= "</tr><tr>\n";
				}
			}
	
			$calendario .= '	</tr>
			</table>';
			return $calendario;
	}
	function proximoseventos() {
		$query = modelprinc::querysql('SELECT * FROM '.TABLAEVENTOS.' WHERE (rollminimo<=\''.usuario::obtenerdatousuario("tipo").'\')AND(fecha>=\''.date("Y").'-'.date("m").'-'.date("d").'\') ORDER BY fecha ASC  LIMIT 5');
		$tabla = '<table id="tablabordenegro2" style="width: 40%">';
		while($evento=mysql_fetch_row($query)) {
			$i=1;
			if ($evento[1] == 1) {
				$hora = 'Hora: '.$evento[6].'';
			}
			$tabla .= '<tr><td><h3>'.constant("calendario".$evento[1]).' Dia: '.fmw::darvueltafecha($evento[2]).' '.$hora.'</h3><h4>'.$evento[3].'</h4><p>'.$evento[4].'</p></td></tr>';
		    unset($hora);
		}
		if ($i != 1) {
			$tabla .= '<tr><td>No hay proximos eventos.</td></tr>';
		}
		$tabla .= "</table>";
		return $tabla;
	}
	function noticias() {
		$query = modelprinc::querysql('SELECT * FROM '.TABLANOTICIAS.' WHERE (fechadespliegue<=\''.date("Y-m-d").'\') ORDER BY `id` DESC');
		$tabla = '<table border="1" style="width:40%">
		<tr><th>Fecha de Publicación</th><th>Noticia</th></tr>
		';
		while($noticia=mysql_fetch_row($query)) {
			$i=1;
			$tabla .= '<tr><td>'.fmw::darvueltafecha($noticia[4]).'</td><td>'.$noticia[1].'</td></tr>';
		}
		$tabla .= "</table>";
	    if ($i == 1) {
			return $tabla;
		}ELSE{
			return '<table border="1"><tr><td>No hay noticias.</td></tr></table>';
		}
	}
	function mostrarnotificaciones() {
		$return = '';
		//notificaciones de encuestas pendientes
		$query = modelprinc::querysql('SELECT id, nombre FROM '.TABLAENCUESTAS.' WHERE (usuariominimo<='.usuario::obtenerdatousuario("tipo").')');
		while($quencuesta = mysql_fetch_row($query)) {
			        if (modeloencuestas::comprobarusuarioencuesta($quencuesta[0], $_SESSION["identificador"])) {
						$return .= '<div id="advertencia"><h3><b>Atención:</b> Tiene la encuesta: '.$quencuesta[1].' pendiente por responder. '.contprinc::crearenlaceinterno("Pulse aqui para responderla", "encuestas", "responderencuesta", '&id='.$quencuesta[0].'').'</h3></div>';
					}
			}
			return $return;
	}
	function mostrarlistaencuestas() {
		$return = '<table border="1">
		<tr><th>Nombre</th><th>Anonima</th><th>Estado</th></tr>
		';
		$query = modelprinc::querysql('SELECT * FROM '.TABLAENCUESTAS.' WHERE (usuariominimo<='.usuario::obtenerdatousuario("tipo").')');
		while ($datos = mysql_fetch_row($query)) {
			if (modelprinc::obtenerregistrosql('SELECT id FROM '.TABLALANZAMIENTOS.' WHERE idencuesta=\''.$datos[0].'\'') != "") {
			$i=1;
			if (!modeloencuestas::comprobarusuarioencuesta($datos[0], $_SESSION["identificador"]) && $datos[6] == "0") {
				$estado = "Respondida";
			}ELSE{
				$fechaactual = date("Y-m-d");
				$datoslanzamiento = modeloencuestas::querylanzamientos($datos[0]);
				while ($fechas = mysql_fetch_row($datoslanzamiento)) {
					if (fmw::compararfechas($fechas[0], $fechaactual, "<") && fmw::compararfechas($fechas[1], $fechaactual, ">")) {
				         $estado = contprinc::crearenlaceinterno("Responder Encuesta", "encuestas", "responderencuesta", '&id='.$datos[0].'');
					     }ELSE{
					     	$estado = "Fuera de Plazo";
					     }
				       }
					}
			$return .= '<tr><td>'.$datos[1].'</td><td>'.constant($datos[5]).'</td><td>'.$estado.'</td></tr>';
		    unset($estado);
			}
		}
		$return .= '</table>';
	    if ($i == 1) {
			return $return;
		}ELSE{
			return '<table border="1"><tr><td>No hay encuestas.</td></tr></table>';
		}
	}
	function desplegebletutorias() {
		$return = fmw::aniadirinput("select2", "curso", "abrir");
		$query = modelprinc::querysql('SELECT id, curso FROM '.TABLATUTORIAS.'');
		while($tutorias = mysql_fetch_row($query)) {
			    $i = 1;
				$return .= fmw::aniadirinput("option", $tutorias[0], $tutorias[1]);
		}
		$return .= fmw::aniadirinput("select2", "curso", "cerrar");
	    if ($i == 1) {
			return $return;
		}ELSE{
			return 'No hay tutorías en el sistema.';
		}
	}
}