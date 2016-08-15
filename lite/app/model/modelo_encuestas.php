<?php
defined('PASOINDEX') or exit;
class modeloencuestas {
	function comprobarsiesdueño($tabla, $id) {
		$resultado = mysql_num_rows(modelprinc::querysql('SELECT id FROM '.$tabla.' WHERE (id='.$id.')AND(administrador='.$_SESSION["identificador"].')'));
		if ($resultado != 0) {
			return true;
		}
	}
   function obteneridpreguntas($encuesta, $select = "id") {
	return modelprinc::querysql('SELECT '.$select.' FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta='.$encuesta.') ORDER BY `orden` ASC');
   }
   function obtenerarraypreguntas($idpregunta) {
	return mysql_fetch_row(modelprinc::querysql('SELECT * FROM '.TABLAPREGUNTASDATOS.' WHERE (id='.$idpregunta.') ORDER BY `orden` ASC'));
   }
   function obtenerdatoencuesta($id, $dato) {
	return modelprinc::obtenerregistrosql('SELECT '.$dato.' FROM '.TABLAENCUESTAS.' WHERE id='.$id.'');
   }
   function querypreguntasobligatorias($id) {
	return modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta=\''.$id.'\')AND(obligatorio=\'required\')');
   }
   function obteneridrespuesta($idencuesta, $fechahora) {
   	return modelprinc::obtenerregistrosql('SELECT id FROM '.TABLARESULTADOSDATOS.' WHERE (idencuesta=\''.$idencuesta.'\')AND(fechahora=\''.$fechahora.'\')');
   }
   function querypreguntas($idpregunta) {
   	return modelprinc::querysql('SELECT pregunta, observaciones, tipo, obligatorio FROM '.TABLAPREGUNTASDATOS.' WHERE id='.$idpregunta.'');
   }
   function obteneridlanzamiento($idencuesta) {
   	return modelprinc::obtenerregistrosql('SELECT id FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta=\''.$idencuesta.'\')AND(fechainicio<=\''.date("Y-m-d").'\')AND(fechafin>=\''.date("Y-m-d").'\')');
   }
   //funciones para las encuestas
   function obtenerrepetibleencuesta($id) {
   	if (modelprinc::obtenerregistrosql('SELECT repetible FROM '.TABLAENCUESTAS.' WHERE id='.$id.'') == "0") {
   		return "No repetible";
   	}ELSE{
   		return "Repetible";
   	}
   }
   function guardarnuevaencuesta($datos) {
   	return modelprinc::querysql('INSERT INTO '.TABLAENCUESTAS.' (id,administrador,nombre,color,anonima,repetible,usuariominimo) VALUES ('.$datos.')');
   }
   function actualizarencuesta($id, $nombre, $usuariominimo, $color, $repetible) {
   	return modelprinc::querysql('UPDATE '.TABLAENCUESTAS.' SET nombre=\''.$nombre.'\', color=\''.$color.'\', usuariominimo=\''.$usuariominimo.'\', repetible=\''.$repetible.'\' WHERE id=\''.$id.'\'');
   }
   //funciones para las preguntas
   function obtenerdatopregunta($id, $dato) {
   	return modelprinc::obtenerregistrosql('SELECT '.$dato.' FROM '.TABLAPREGUNTASDATOS.' WHERE id='.$id.'');
   }
   function obtenernumeropreguntas($id) {
   	return mysql_num_rows(modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASDATOS.' WHERE idencuesta='.$id.''));
   }
   function obtenervaluepreguntas($id, $numero) {
   	$query = modelprinc::querysql('SELECT value FROM '.TABLAPREGUNTASVALUES.' WHERE idpregunta='.$id.'');
   	$i=1;
   	while ($array = mysql_fetch_row($query)) {
   		if ($i==$numero) {
   			return $array[0];
   		}
   		$i++;
   	}
   }
   function montartablapreguntas($id) {
   	$query=modelprinc::querysql('SELECT id, pregunta, observaciones, tipo, obligatorio FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta='.$id.') ORDER BY `orden` ASC');
   	if ($row[4] == "required") {
   		$obligatoria = "Obligatoria";
   	}ELSE{
   		$obligatoria = "No obligatoria";
   	}
   	//bucle para obtener cada fila
   	$i=1;
   	$numeropreguntas = mysql_num_rows($query);
   	if ($numeropreguntas == "") {
   		$tabla = "NO HAY NINGUNA PREGUNTA CREADA. </br>PULSE EL BOTON DE ABAJO PARA CREAR UNA NUEVA.";
   	}ELSE{
   		$tabla = '<table id="preguntasadmin" border="1">';
   	}
   	while($row=mysql_fetch_row($query)) {
   		$bajar = "";
   		if ($i != "1") {
   			$subir = '•'.contprinc::crearenlaceinterno("&uarr;", "encuestas", "cambiarordenpregunta", "&tipo=subir&id=".$row[0]);
   		}
   		if ($i != $numeropreguntas) {
   			$bajar = '•'.contprinc::crearenlaceinterno("&darr;", "encuestas", "cambiarordenpregunta", "&tipo=bajar&id=".$row[0]);
   		}
   		$tabla .= "<tr>";
   		$tabla .= '<td>'.encuestas::generarcasilleropregunta($row[0], $id).'
   		<center>'.contprinc::crearenlaceinterno("Modificar pregunta", "encuestas", "configurarpregunta", "&id=".$row[0]).'•'.contprinc::crearenlaceinterno("Eliminar pregunta", "encuestas", "confirmacioneliminarpregunta", "&id=".$row[0]).'•'.contprinc::crearenlaceinterno("Copiar pregunta", "encuestas", "copiarpregunta", "&idpregunta=".$row[0]."&id=".fmw::limpiartexto($_GET["id"])).''.$subir.''.$bajar.'</center>
   		</td>
   		';
   		$tabla .= "</tr>";
   		$i++;
   	}
   	$tabla .= "</table>";
   	return $tabla;
   }
   function obteneridvaluepreguntas($id, $numero) {
   	$query = modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASVALUES.' WHERE idpregunta='.$id.'');
   	$i=1;
   	while ($array = mysql_fetch_row($query)) {
   		if ($i==$numero) {
   			return $array[0];
   		}
   		$i++;
   	}
   }
   function obtenernumeroorden($idencuesta) {
   	return modelprinc::obtenerregistrosql('SELECT orden FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta='.$idencuesta.') ORDER BY `orden` DESC ');
   }
   function guardardatosnuevapregunta($values) {
   	return modelprinc::querysql('INSERT INTO '.TABLAPREGUNTASDATOS.' (idencuesta,pregunta,observaciones,tipo,obligatorio,orden) VALUES ('.$values.')');
   }
   function guardarvaluesnuevapregunta($idpregunta, $value) {
   	return modelprinc::querysql('INSERT INTO '.TABLAPREGUNTASVALUES.' (idpregunta, value) VALUES (\''.$idpregunta.'\',\''.$value.'\')');
   }
   function queryidpreguntas($idencuesta) {
   	return modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta='.$idencuesta.')');
   }
   function queryidpreguntasvalues($idpregunta) {
   	return modelprinc::querysql('SELECT id, value FROM '.TABLAPREGUNTASVALUES.' WHERE (idpregunta='.$idpregunta.')');;
   }
   //relacionadas con lanzamientos
   function montartablalanzamientos($id) {
   	$tabla = '<table class="tablaquery" style="width:70%">';
   	$query=modelprinc::querysql('SELECT fechainicio, fechafin, id FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta='.$id.')');
   	$tabla .= "<tr>";
   	$tabla .= '<th>ID</th><th>Fecha Inicio</th><th>Fecha fin</th><th>Estado</th>';
   	$tabla .= "</tr>";
   	//bucle para obtener cada fila
   	$i=1;
   	while($row=mysql_fetch_row($query)) {
   		$otrascolumnas = "";
   		$estado = "";
   		if ($color == 0) {
   			$tabla .= '<tr bgcolor="#BDBDBD">';
   			$color = 1;
   		}ELSE{
   			$tabla .= '<tr>';
   			$color = 0;
   		}
   		//definir estado lanzamiento
   		$estado = modeloencuestas::obtenerestadolanzamiento($row[2]);
   		//definir otras columnas
   		if ($estado != "Lanzamiento programado") {
   			$otrascolumnas = "<td>".contprinc::crearenlaceinterno("Ver resultados", "encuestas", "verresultados", "&id=$row[2]")."</td>";
   		}
   		if ($estado == "Lanzamiento programado") {
   			$otrascolumnas = "<td>".contprinc::crearenlaceinterno("Desprogramar Lanzamiento", "encuestas", "desprogramarlanzamiento", "&id=$row[2]")."</td>";
   		}
   		$tabla .= '<td>'.$i.'</td><td>'.fmw::darvueltafecha($row[0]).'</td><td>'.fmw::darvueltafecha($row[1]).'</td><td>'.$estado.'</td>'.$otrascolumnas.'';
   		$tabla .= "</tr>";
   		$i++;
   	}
   	$tabla .= '<tr>'.fmw::iniciarformulario("nuevolanzamiento", "post", contprinc::crearurlinterna("encuestas", "programarlanzamiento", '&id='.fmw::limpiartexto($_GET["id"]).'')).'<td>Programar</br> lanzamiento: </td><td>'.fmw::aniadirinput("date","fechainicio", "", "required").'</td><td>'.fmw::aniadirinput("date","fechafin", "", "required").'</td><td></td><td>'.fmw::aniadirinput("submit").'</td>'.fmw::cerrarformulario().'';
   	$tabla .= "</table>";
   	return $tabla;
   }
   function obtenerestadolanzamiento($idlanzamiento) {
   	$fechainicio=modelprinc::obtenerregistrosql('SELECT fechainicio FROM '.TABLALANZAMIENTOS.' WHERE (id='.$idlanzamiento.')');
   	$fechafin=modelprinc::obtenerregistrosql('SELECT fechafin FROM '.TABLALANZAMIENTOS.' WHERE (id='.$idlanzamiento.')');
   	if (fmw::compararfechas($fechainicio, date("Y-m-d"), "<") && fmw::compararfechas($fechafin, date("Y-m-d"), ">") || fmw::compararfechas($fechainicio, date("Y-m-d"), "=") || fmw::compararfechas($fechafin, date("Y-m-d"), "=")) {
   		return "Activa";
   	}elseif (fmw::compararfechas($fechafin, date("Y-m-d"), "<")) {
   		return "Acabada";
   	}elseif (fmw::compararfechas($fechainicio, date("Y-m-d"), ">")) {
   		return "Lanzamiento programado";
   	}
   }
   function querylanzamientos($idencuesta) {
   	return  modelprinc::querysql('SELECT fechainicio, fechafin, id FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta='.$idencuesta.')');
   }
   //relacionadas con los resultados
   function montartablaporcentajes($idlanzamiento) {
   	$idencuesta = modelprinc::obtenerregistrosql('SELECT idencuesta FROM '.TABLALANZAMIENTOS.' WHERE (id='.$idlanzamiento.')');
   	$querypreguntas = modelprinc::querysql('SELECT id, pregunta FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta=\''.$idencuesta.'\')AND(tipo=\'select\')');
   	$queryidresultados = modelprinc::querysql('SELECT id FROM '.TABLARESULTADOSDATOS.' WHERE (idlanzamiento=\''.$idlanzamiento.'\')');
   	$arrayidresultados = array();
   	while ($id = mysql_fetch_row($queryidresultados)) {
   		array_push($arrayidresultados, $id[0]);
   	}
   	$return = '<h2>Estadistica Avanzada</h3>
   	<table id="tablaporcentajes">';
   	while ($row = mysql_fetch_row($querypreguntas)) {
   		$numerorespuestas = 0;
   		$queryresultados = modelprinc::querysql('SELECT idresultado, respuesta FROM '.TABLARESULTADOSRESPUESTAS.' WHERE (idpregunta=\''.$row[0].'\')');
   		$arrayconlosresultados = array();
   		while ($resultados = mysql_fetch_row($queryresultados)) {
   			if (in_array($resultados[0], $arrayidresultados)) {
   				array_push($arrayconlosresultados, $resultados[1]);
   				$numerorespuestas++;
   			}
   		}
   		$numerodecadarespuesta = array_count_values($arrayconlosresultados);
   		$return .= '<tr><td>
   		<b>Pregunta: '.$row[1].'</h4></b></br>De las '.$numerorespuestas.' personas que han respondido, estas son las estadisticas:</br>
   		<center><table border="1">
   		<tr><td></td><td>Pregunta</td><td>Votos</td><td>Porcentaje</td></tr>
   		';
   		$query = modelprinc::querysql('SELECT id, value FROM '.TABLAPREGUNTASVALUES.' WHERE (idpregunta='.$row[0].')');
   		$i = 1;
   		while ($valuespregunta=mysql_fetch_row($query)) {
   			if (!$numerodecadarespuesta[$valuespregunta[1]]) {
   				$votos = "0";
   			}ELSE{
   				$votos = $numerodecadarespuesta[$valuespregunta[1]];
   			}
   			$return .= '<tr><td><b>Opcion '.$i.':</b></td><td>'.$valuespregunta[1].'</td><td>'.$votos.'</td><td>'.fmw::calcularporcentaje($numerorespuestas, $numerodecadarespuesta[$valuespregunta[1]], "2").'%</td></tr>';
   			$i++;
   		}
   		$return .= '</table></center></td></tr>';
   
   	}
   	$return .= '</table>';
   	if (mysql_num_rows($querypreguntas) != "0") {
   		return $return;
   	}
   }
   function montartablaresultados($idlanzamiento) {
   	$idencuesta = modelprinc::obtenerregistrosql('SELECT idencuesta FROM '.TABLALANZAMIENTOS.' WHERE (id='.$idlanzamiento.')');
   	$tabla = '<table class="tablaquery" style="width:80%">';
   	$numeropreguntas = modeloencuestas::obtenernumeropreguntas($idencuesta);
   	$arraypreguntas = modeloencuestas::obteneridpreguntas($idencuesta, "pregunta");
   	$idrespuesta = modeloencuestas::obteneridrespuesta($idencuesta, $fechahora);
   	//obtenemos el id de cada pregunta
   	$arrayidpreguntas = array();
   	$idpreguntas = modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta=\''.$idencuesta.'\')');
   	while ($preguntas = mysql_fetch_row($idpreguntas)) {
   		array_push($arrayidpreguntas, $preguntas[0]);
   	}
   	$tabla .= "<tr><th>Fecha</th>";
   	if (modeloencuestas::obtenerdatoencuesta($idencuesta, "anonima") == "0") {
   		$visible = 1;
   		$tabla .= "<th>Usuario</th>";
   	}
   	while ($row = mysql_fetch_row($arraypreguntas))
   	{
   		$preguntas++;
   		$tabla .= '<th>'.$row[0].'</th>';
   	}
   	$tabla .= "</tr><tr>";
   	$query = modelprinc::querysql('SELECT fechahora, id, usuario FROM '.TABLARESULTADOSDATOS.' WHERE (idlanzamiento=\''.$idlanzamiento.'\')');
   	$numerocolumnas=count($arrayidpreguntas);
   	while($row=mysql_fetch_row($query)) {
   		if ($color == 0) {
   			$tabla .= '<tr bgcolor="#BDBDBD">';
   			$color = 1;
   		}ELSE{
   			$tabla .= '<tr>';
   			$color = 0;
   		}
   		//bucle para añadirle valor a cada columna
   		$i=0;
   		$tabla .= '<td>'.fmw::darvueltafecha($row[0]).'</td>';
   		if ($visible == 1) {
   			$tabla .= '<td>'.usuario::obtenerdatousuario("usuario", $row[2]).'</td>';
   		}
   		while ($i<$numerocolumnas) {
   			$tabla .= '<td>'.modelprinc::obtenerregistrosql('SELECT respuesta FROM '.TABLARESULTADOSRESPUESTAS.' WHERE (idresultado='.$row[1].')AND(idpregunta='.$arrayidpreguntas[$i].')').'</td>';
   			$i++;
   		}
   	}
   	$tabla .= "</tr></table>";
   	return $tabla;
   }
   function queryidrespuestas($idresultado) {
   	return modelprinc::querysql('SELECT id FROM '.TABLARESULTADOSRESPUESTAS.' WHERE (idresultado='.$idresultado.')');
   }
   function obtenerinfolanzamiento($idencuesta) {
   	$datoslanzamiento = modeloencuestas::querylanzamientos($idencuesta);
   	while ($fechas = mysql_fetch_row($datoslanzamiento)) {
   		if (fmw::compararfechas($fechas[0], date("Y-m-d"), "<") && fmw::compararfechas($fechas[1], date("Y-m-d"), ">")) {
   			$idlanzamiento = $fechas[2];
   		}
   	}
   	return modeloencuestas::obtenerestadolanzamiento($idlanzamiento);
   }
   //comprobar si un usuario a respondido una encuesta
   function comprobarusuarioencuesta($encuesta, $usuario) {
   	$query2 = modelprinc::querysql('SELECT id FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta=\''.$encuesta.'\')AND(fechainicio<=\''.date("Y-m-d").'\')AND(fechafin>=\''.date("Y-m-d").'\')');
   	while($qulanzamientos = mysql_fetch_row($query2)) {
   		$query3 = mysql_fetch_row(modelprinc::querysql('SELECT id FROM '.TABLARESULTADOSDATOS.' WHERE (idlanzamiento=\''.$qulanzamientos[0].'\')AND(usuario=\''.$usuario.'\')'));
   		if ($query3[0] == "") {
   			$ok = 1;
   		}
   	}
   if ($ok == 1) {
   	return true;
   }else{
   	return false;
   }
   }
}