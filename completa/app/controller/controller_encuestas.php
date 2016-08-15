<?php
defined('PASOINDEX') or exit;
class encuestas {
	/*
	 * Responder Encuesta
	 * */
	function responderencuesta() {
		$idencuesta = fmw::limpiartexto($_GET["id"]);
		$fechaactual = date("Y-m-d");
		$datoslanzamiento = modeloencuestas::querylanzamientos($idencuesta);
		while ($fechas = mysql_fetch_row($datoslanzamiento)) {
			if (fmw::compararfechas($fechas[0], $fechaactual, "<") && fmw::compararfechas($fechas[1], $fechaactual, ">")) {
				 vistprinc::montarlayout("encuestas_responderencuesta");
			}ELSE{
	    	vistprinc::mostrarnotificacion("La encuesta esta fuera de plazo.");
	        }
		}
     }
		
	function generarencuesta($encuesta) {
		$encuesta = fmw::limpiartexto($encuesta);
		$return = fmw::iniciarformulario("encuesta","POST",'index.php?c=encuestas&a=guardarresultadoencuesta&id='.$encuesta.'');
		$return .= '<table id="encuesta" style="width:60%; border: 4px solid '.modeloencuestas::obtenerdatoencuesta($encuesta, "color").'">';
		$return .= '<tr><th><h2>Encuesta: '.modeloencuestas::obtenerdatoencuesta($encuesta, "nombre").'</th></tr></h2>';
		$arraypreguntas = modeloencuestas::obteneridpreguntas($encuesta);
		while ($row = mysql_fetch_row($arraypreguntas))
		{
		$return .= '<tr><td>'.encuestas::generarcasilleropregunta($row[0], $encuesta).'</td></tr>';
		}
		if (modeloencuestas::obtenerdatoencuesta($encuesta, "anonima") == "0") {
			$anonima = 'La encuesta no es ANONIMA. Su usuario sera guardado junto el resultado de la encuesta.';
		}ELSE{
			$anonima = 'La encuesta es ANONIMA. No se vinculara su usuario con el resultado de la encuesta.';
		}
		$return .= '<tr><td><center>•Los campos marcados con un <FONT COLOR="red">*</FONT> son obligatorios.</center></tr></td>
		<tr><td><center>•<b>Atención:</b> '.$anonima.'</center></tr></td>            
		<tr><td><center>'.fmw::aniadirinput("submit").'</center></tr></td></table>';
		$return .= fmw::cerrarformulario();
		return $return;
		}
	function generarcasilleropregunta($idpregunta, $encuesta) {
		$idpregunta = fmw::limpiartexto($idpregunta);
		$idencuesta = fmw::limpiartexto($idencuesta);
		$arraypregunta = modeloencuestas::obtenerarraypreguntas($idpregunta);
		if ($arraypregunta[5] == "required") {
			$asterisco = '<FONT COLOR="red">*</FONT>';
		}
	    $pregunta = '
	                 <center>
                     <table id="tablabordenegro" style="width:50%; background-color: '.modeloencuestas::obtenerdatoencuesta($encuesta, "color").'">
                     <tr>
                         <td><h3>'.$arraypregunta[2].''.$asterisco.'</h3></td>
                     </tr>
                     <tr>
                         <td>'.$arraypregunta[3].'</td>		
                     </tr>
                     <tr>
                          <td>'.encuestas::generarpregunta($idpregunta).'</td>		
                     </tr>
                     </table>
                     </center>
	                 ';
		return $pregunta;
	}
	function generarpregunta($idpregunta) {
		$idpregunta = fmw::limpiartexto($idpregunta);
		$datosprincipales = mysql_fetch_row(modeloencuestas::querypreguntas($idpregunta));
		$values = mysql_fetch_row(modeloencuestas::queryidpreguntasvalues($idpregunta));
		//preguntas de texto
		IF ($datosprincipales[2] == "text" || $datosprincipales[2] == "email") {
			return fmw::aniadirinput($datosprincipales[2], $idpregunta, $values[1], "", $datosprincipales[3]);
		}
		//preguntas de select
		ELSEIF ($datosprincipales[2] == "sino") {
			return fmw::aniadirinput("select", $idpregunta, array("si" => "Si", "no" => "No"), $values[1], $datosprincipales[3]);
		}ELSEIF ($datosprincipales[2] == "verdaderofalso") {
			return fmw::aniadirinput("select", $idpregunta, array("verdadero" => "Verdadero", "falso" => "Falso"), $values[1], $datosprincipales[3]);
		}
		//preguntas de fecha hora
		ELSEIF ($datosprincipales[2] == "date" || $datosprincipales[2] == "time") {
			return fmw::aniadirinput($datosprincipales[2], $idpregunta, "", $values[1], $datosprincipales[3]);
		}
		//preguntas de select
	    ELSEIF ($datosprincipales[2] == "select") {
	    	$query = modelprinc::querysql('SELECT id, value FROM '.TABLAPREGUNTASVALUES.' WHERE idpregunta='.$idpregunta.''); 
	    	$return = fmw::aniadirinput("select2", $idpregunta, "abrir");
	    	while ($values = mysql_fetch_row($query)) {
	    		if ($values[0] == $datosprincipales[4]) {
	    	        $return .= fmw::aniadirinput("option", $values[1], $values[1]);
	    		}ELSE{
	    			$return .= fmw::aniadirinput("option", $values[1], $values[1]);
	    		}
	    	}
	    	$return .= fmw::aniadirinput("select2", $idpregunta, "cerrar");
	    	return $return;
	    } 
	}
    function guardarresultadoencuesta() {
    	$resultados = fmw::limpiarpost($_POST);
    	$idencuesta = fmw::limpiartexto($_GET["id"]);
    	$idlanzamiento = modeloencuestas::obteneridlanzamiento($idencuesta);
    	IF (modelprinc::comprobarregistro(TABLAENCUESTAS, $idencuesta)) {
    		 $numerorespuestas = mysql_num_rows(modelprinc::querysql('SELECT id FROM '.TABLARESULTADOSDATOS.' WHERE (idlanzamiento=\''.$idlanzamiento.'\')AND(usuario=\''.$_SESSION["identificador"].'\')'));
             IF ((modeloencuestas::obtenerdatoencuesta($idencuesta, "repetible") == "0" && $numerorespuestas == "0")||(modeloencuestas::obtenerdatoencuesta($idencuesta, "repetible") == "1")) {
      	        $preguntasobligatorias = modeloencuestas::querypreguntasobligatorias($idencuesta);
    			while ($row = mysql_fetch_row($preguntasobligatorias)){
    				if (!$_POST["$row[0]"]) {
    					vistprinc::mostrarnotificacion("No has respondido una pregunta obligatoria.");
    					exit();
    				}
    			}
    			$querypreguntas = modelprinc::querysql('SELECT id, tipo FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta=\''.$idencuesta.'\')');
    			$i=0;
    			while ($tipopregunta = mysql_fetch_row($querypreguntas)) {
    				if ($tipopregunta[1] == "select")  {
    					if (mysql_num_rows(modelprinc::querysql('SELECT id FROM '.TABLAPREGUNTASVALUES.' WHERE (idpregunta=\''.$tipopregunta[0].'\')AND(value=\''.$resultados[$i].'\')')) == "0") {
    						$error = 1;
    					}
    				}
    				$i++;
    			}
    				
    			//guardamos el resultado de la encuesta
    			if (!$error) {
    				$fechahora = date("Y-m-d H:i:s");
    				modelprinc::querysql('INSERT INTO '.TABLARESULTADOSDATOS.' (idlanzamiento, fechahora, ip, useragent, usuario) VALUES (\''.$idlanzamiento.'\',\''.$fechahora.'\',\''.$_SERVER['REMOTE_ADDR'].'\',\''.$_SERVER['HTTP_USER_AGENT'].'\',\''.$_SESSION['identificador'].'\')');
    				$idrespuesta = mysql_insert_id();
    				$idpreguntas = modeloencuestas::queryidpreguntas(fmw::limpiartexto($_GET["id"]));
    				$myPost = array_values($_POST);
    				$i = 0;
    				while ($preguntas = mysql_fetch_row($idpreguntas)) {
    					modelprinc::querysql('INSERT INTO '.TABLARESULTADOSRESPUESTAS.' (idresultado,idpregunta,respuesta) VALUES (\''.$idrespuesta.'\',\''.$preguntas[0].'\',\''.$myPost[$i].'\')');
    					$i++;
    				}
    				vistprinc::mostrarnotificacion("Se a enviado los resultados correctamente.");
    			}ELSE{
    				modelprinc::aniadirlog(ERROR_intentartrucarformulario);
    				contprinc::redireccioninterna("index","inicio");
    			}
    		}ELSE{
    			vistprinc::mostrarnotificacion("Esta encuesta no se puede realizar mas de dos veces.");
    		}
    	}ELSE{
    		contprinc::redireccioninterna("index","inicio");
    	}
   }
   /*
    * Administración
    * */
   function listaencuestas() {
   	vistprinc::montarlayout("encuestas_listaencuestas");
   }
   function nuevaencuesta() {
   	vistprinc::montarlayout("encuestas_nuevaencuesta");
   }
   function configurarencuesta() {
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, fmw::limpiartexto($_GET["id"]))) {
   		vistprinc::montarlayout("encuestas_configurarencuesta");
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function configurarpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["id"]);
   	$idencuestapregunta = modeloencuestas::obtenerdatopregunta($idpregunta, "idencuesta");
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestapregunta)) {
   		if (modeloencuestas::obtenerinfolanzamiento($idencuestapregunta) != "Activa") {
   			vistprinc::montarlayout("encuestas_configurarpregunta");
   		}ELSE{
   			vistprinc::mostrarnotificacion("
   					Mientras que la encuesta esta lanzada las preguntas no pueden ser modificadas.
   					");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function nuevapregunta() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	$arraytipopreguntas = array("text", "select");
   	IF (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuesta) && in_array($_POST["tipo"], $arraytipopreguntas)) {
   		if (modeloencuestas::obtenerinfolanzamiento($idencuesta) != "Activa") {
   			vistprinc::montarlayout("encuestas_nuevapregunta");
   		}ELSE{
   			vistprinc::mostrarnotificacion("
   					Mientras que la encuesta esta lanzada no se pueden crear preguntas.
   					");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function copiarpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["idpregunta"]);
   	$idencuestapregunta = modeloencuestas::obtenerdatopregunta($idpregunta, "idencuesta");
   	if (modeloencuestas::obtenerinfolanzamiento($idencuestapregunta) != "Activa") {
   		vistprinc::montarlayout("encuestas_nuevapregunta");
   	}ELSE{
   		vistprinc::mostrarnotificacion("
   				Mientras que la encuesta esta lanzada no se pueden crear preguntas.
   				");
   	}
   }
   function verresultados() {
   	$idlanzamiento = fmw::limpiartexto($_GET["id"]);
   	$idencuestalanzamiento = modelprinc::obtenerdato(TABLALANZAMIENTOS, "idencuesta", $idlanzamiento);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestalanzamiento)) {
   		vistprinc::montarlayout("encuestas_verresultados");
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function confirmacioneliminarencuesta() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuesta)) {
   		$estado = modeloencuestas::obtenerinfolanzamiento($idencuesta);
   		if ($estado == "Activa") {
   			vistprinc::mostrarnotificacion("
   					<h3>Atención</h3>
   					<p>Mientras que la encuesta este activa, la encuesta no podra ser eliminada. Espere a que el lanzamiento se acabe para proceder a su eliminación.</p>
   					");
   		}else{
   			vistprinc::montarlayout("encuestas_confirmacioneliminarencuesta");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function confirmacioneliminarpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["id"]);
   	$idencuestapregunta = modeloencuestas::obtenerdatopregunta($idpregunta, "idencuesta");
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestapregunta)) {
   		if (modeloencuestas::obtenerinfolanzamiento($idencuestapregunta) == "Activa") {
   			vistprinc::mostrarnotificacion("
   					<h3>Atención</h3>
   					<p>Mientras que la encuesta este activa, la pregunta no podra ser eliminada. Espere a que el lanzamiento se acabe para proceder a su eliminación.</p>
   					");
   		}else{
   			vistprinc::montarlayout("encuestas_confirmacioneliminarpregunta");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   //operaciones
   function desprogramarlanzamiento() {
   	$idlanzamiento = fmw::limpiartexto($_GET["id"]);
   	$idencuestalanzamiento = modelprinc::obtenerdato(TABLALANZAMIENTOS, "idencuesta", $idlanzamiento);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestalanzamiento)) {
   		modelprinc::borrarregistro(TABLALANZAMIENTOS, $idlanzamiento);
   		vistprinc::mostrarnotificacion("Se a desprogramado correctamente.");
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function borrarencuesta() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuesta)) {
   		$queryidlanzamiento = modeloencuestas::querylanzamientos($idencuesta);
   		while ($idlanzamiento = mysql_fetch_row($queryidlanzamiento)) {
   			$queryidresultadosdatos = modelprinc::querysql('SELECT id FROM '.TABLARESULTADOSDATOS.' WHERE (idlanzamiento='.$idlanzamiento[2].')');
   			while ($idresultadosdatos = mysql_fetch_row($queryidresultadosdatos)) {
   				$queryidresultadosrespuestas = modeloencuestas::queryidrespuestas($idresultadosdatos[0]);
   				while ($idresultadosrespuestas = mysql_fetch_row($queryidresultadosrespuestas)) {
   					modelprinc::borrarregistro(TABLARESULTADOSRESPUESTAS, $idresultadosrespuestas[0]);
   				}
   				modelprinc::borrarregistro(TABLARESULTADOSDATOS, $idresultadosdatos[0]);
   			}
   		}
   		$querypreguntas = modeloencuestas::queryidpreguntas($idencuesta);
   		while ($idpreguntas = mysql_fetch_row($querypreguntas)) {
   			$querypreguntasvalues = modeloencuestas::queryidpreguntasvalues($idpreguntas[0]);
   			while ($idpreguntas = mysql_fetch_row($querypreguntasvalues)) {
   				modelprinc::borrarregistro(TABLAPREGUNTASVALUES, $idpreguntas[0]);
   			}
   		}
   		modelprinc::borrarregistro(TABLAENCUESTAS, $_GET["id"]);
   		modelprinc::querysql('DELETE FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta='.$idencuesta.')');
   		modelprinc::querysql('DELETE FROM '.TABLAPREGUNTASDATOS.' WHERE (idencuesta='.$idencuesta.')');
   		vistprinc::mostrarnotificacion("Borrado correctamente", "-2");
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function borrarpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["id"]);
   	$idencuestapregunta = modelprinc::obtenerdato(TABLAPREGUNTASDATOS, "idencuesta", $idpregunta);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestapregunta)) {
   		modelprinc::borrarregistro(TABLAPREGUNTASDATOS, fmw::limpiartexto($_GET["id"]));
   		modelprinc::querysql('DELETE FROM '.TABLAPREGUNTASVALUES.' WHERE (idpregunta='.$idpregunta.')');
   		modelprinc::querysql('DELETE FROM '.TABLARESULTADOSRESPUESTAS.' WHERE (idpregunta='.$idpregunta.')');
   		vistprinc::mostrarnotificacion("Borrado correctamente", "-2");
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function guardarnuevapregunta() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	$pregunta = fmw::limpiarpost($_POST);
   	if ($_GET["id"] == $_POST["id"]) {
   		if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuesta)) {
   			if (fmw::comprobarinputobligatorios(array("pregunta", "obligatorio"))) {
   				if (($_POST["tipo"] == "select" && $_POST["value1"] != "")||($_POST["tipo"] != "select")) {
   					//comprobamos si hay dos opciones iguales
   					$arrayopciones = array();
   					for ($i=1;$i<"6";$i++) {
   						if ($_POST["value".$i]) {
   							array_push($arrayopciones, $_POST["value".$i]);
   						}
   					}
   					$arrayopciones = array_count_values($arrayopciones);
   					if (!in_array("2", $arrayopciones) && !in_array("3", $arrayopciones) && !in_array("4", $arrayopciones) && !in_array("5", $arrayopciones)) {
   						$orden = modeloencuestas::obtenernumeroorden(fmw::limpiartexto($_GET["id"]))+1;
   						modeloencuestas::guardardatosnuevapregunta('\''.fmw::limpiartexto($_GET["id"]).'\',\''.$pregunta[1].'\',\''.$pregunta[2].'\',\''.$pregunta[4].'\',\''.$pregunta[3].'\',\''.$orden.'\'');
   						$idpregunta = mysql_insert_id();
   						//bucle para guardar los values de la pregunta
   						for ($i=5;$i<"10";$i++) {
   							if ($pregunta[$i] != "") {
   								modeloencuestas::guardarvaluesnuevapregunta($idpregunta, $pregunta[$i]);
   							}
   						}
   						vistprinc::mostrarnotificacion("Se ha añadido correctamente.", "-2");
   					}ELSE{
   						vistprinc::mostrarnotificacion("No puede haber dos opciones iguales.", "-2");
   					}
   				}ELSE{
   					vistprinc::mostrarnotificacion("Como minimo debe tener una opción la lista desplegable.", "-2");
   				}
   			}ELSE{
   				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
   			}
   		}ELSE{
   			modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   			contprinc::redireccioninterna("index", "inicio");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_intentartrucarformulario);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function guardarnuevaencuesta() {
   	if ($_GET["id"] == $_POST["id"]) {
   		if (fmw::comprobarinputobligatorios(array("nombre", "color", "usuariominimo", "anonima", "repetible"))) {
   			if ($_POST["usuariominimo"] <= 5 && $_POST["repetible"] <= 2 && $_POST["anonima"] <= 2) {
   			$encuesta = fmw::limpiarpost($_POST);
   			//obtenemos el id para la respuesta aleatorio o generamos otro si el id ya existe
   			while (modeloencuestas::obtenerdatoencuesta($idaleatorio, "id") == $idaleatorio) {
   				$idaleatorio = rand();
   			}
   			modeloencuestas::guardarnuevaencuesta('\''.$idaleatorio.'\',\''.$_SESSION["identificador"].'\',\''.$encuesta[1].'\',\''.$encuesta[2].'\',\''.$encuesta[3].'\', \''.$encuesta[4].'\', \''.$encuesta[5].'\'');
   			vistprinc::mostrarnotificacion("Se ha añadido correctamente.", contprinc::crearurlinterna("encuestas", "listaencuestas"));
   			}ELSE{
   				modelprinc::aniadirlog(ERROR_intentartrucarformulario);
   				contprinc::redireccioninterna("index", "inicio");
   			}
   			}ELSE{
   			vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_intentartrucarformulario);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function actualizarpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["id"]);
   	$pregunta = fmw::limpiarpost($_POST);
   	if ($_GET["id"] == $_POST["id"]) {
   		$idencuestapregunta = modeloencuestas::obtenerdatopregunta($idpregunta, "idencuesta");
   		if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuestapregunta)) {
   			if (fmw::comprobarinputobligatorios(array("pregunta", "obligatorio"))) {
   				if ($pregunta[4] == "select" && $pregunta[5] == "" && $pregunta[6] == "" && $pregunta[7] == "" && $pregunta[8] == "" && $pregunta[9] == "") {
   					vistprinc::mostrarnotificacion("Debe introducir al menos una opcion.", "-2");
   				}ELSE{
   					//guardamos los resultados
   					modelprinc::querysql('UPDATE '.TABLAPREGUNTASDATOS.' SET pregunta=\''.$pregunta[1].'\', observaciones=\''.$pregunta[2].'\', tipo=\''.$pregunta[4].'\', obligatorio=\''.$pregunta[3].'\' WHERE id=\''.$idpregunta.'\'');
   					modelprinc::querysql('DELETE FROM '.TABLAPREGUNTASVALUES.' WHERE (idpregunta='.$pregunta[0].')');
   					for ($i=5;$i<"10";$i++) {
   						if ($pregunta[$i] != "") {
   							modeloencuestas::guardarvaluesnuevapregunta($idpregunta, $pregunta[$i]);
   						}
   					}
   					vistprinc::mostrarnotificacion("Se ha modificado correctamente.", "-2");
   				}
   			}ELSE{
   				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.", "-2");
   			}
   		}ELSE{
   			modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   			contprinc::redireccioninterna("index", "inicio");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_intentartrucarformulario);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function actualizarencuesta() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	if ($_GET["id"] == $_POST["id"]) {
   		if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $idencuesta)) {
   			if (fmw::comprobarinputobligatorios(array("nombre", "color", "usuariominimo", "repetible"))) {
   				$encuesta = fmw::limpiarpost($_POST);
   				modeloencuestas::actualizarencuesta($encuesta[0], $encuesta[1], $encuesta[3], $encuesta[4], $encuesta[2]);
   				vistprinc::mostrarnotificacion("Se ha modificado correctamente.");
   				}ELSE{
   				vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
   			}
   		}ELSE{
   			modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		    contprinc::redireccioninterna("index", "inicio");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function cambiarordenpregunta() {
   	$idpregunta = fmw::limpiartexto($_GET["id"]);
   	$datospregunta = mysql_fetch_row(modelprinc::querysql('SELECT idencuesta, orden FROM '.TABLAPREGUNTASDATOS.' WHERE id='.$idpregunta.''));
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $datospregunta[0])) {
   		if ($_GET["tipo"] == "subir") {
   			$ordenplus = $datospregunta[1]-1;
   			modelprinc::querysql('UPDATE '.TABLAPREGUNTASDATOS.' SET orden=\''.$datospregunta[1].'\' WHERE (orden=\''.$ordenplus.'\')AND(idencuesta=\''.$datospregunta[0].'\')');
   			modelprinc::querysql('UPDATE '.TABLAPREGUNTASDATOS.' SET orden=\''.$ordenplus.'\' WHERE (id=\''.$idpregunta.'\')AND(idencuesta=\''.$datospregunta[0].'\')');
   			vistprinc::mostrarnotificacion("Reordenado correctamente");
   		}ELSE{
   			$ordenplus = $datospregunta[1]+1;
   			modelprinc::querysql('UPDATE '.TABLAPREGUNTASDATOS.' SET orden=\''.$datospregunta[1].'\' WHERE (orden=\''.$ordenplus.'\')AND(idencuesta=\''.$datospregunta[0].'\')');
   			modelprinc::querysql('UPDATE '.TABLAPREGUNTASDATOS.' SET orden=\''.$ordenplus.'\' WHERE (id=\''.$idpregunta.'\')AND(idencuesta=\''.$datospregunta[0].'\')');
   			vistprinc::mostrarnotificacion("Reordenado correctamente");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
   function programarlanzamiento() {
   	$idencuesta = fmw::limpiartexto($_GET["id"]);
   	$lanzamiento = fmw::limpiarpost($_POST);
   	if (modeloencuestas::comprobarsiesdueño(TABLAENCUESTAS, $_GET["id"])) {
   		if (fmw::comprobarinputobligatorios(array("fechainicio", "fechafin"))) {
   			if (fmw::comprobarfecha($lanzamiento[0]) && fmw::comprobarfecha($lanzamiento[1])) {
   				if (fmw::compararfechas($lanzamiento[0], $lanzamiento[1], "<")) {
   					if (fmw::compararfechas($lanzamiento[0], date("Y-m-d"), ">")) {
   						if (modelprinc::contarregistrosquery('SELECT * FROM '.TABLALANZAMIENTOS.' WHERE (idencuesta=\''.$idencuesta.'\')AND((fechainicio<=\''.$lanzamiento[0].'\')AND(fechafin>=\''.$lanzamiento[1].'\'))OR((fechainicio=\''.$lanzamiento[0].'\')AND(fechafin=\''.$lanzamiento[1].'\'))') == 0) {
   							if (mysql_num_rows(modeloencuestas::obteneridpreguntas($idencuesta)) != 0) {
   								//subimos a la bd
   								modelprinc::querysql('INSERT INTO '.TABLALANZAMIENTOS.' (idencuesta, fechainicio, fechafin) VALUES (\''.$idencuesta.'\',\''.$lanzamiento[0].'\',\''.$lanzamiento[1].'\')');
   								vistprinc::mostrarnotificacion("Se ha programado correctamente.");
   							}ELSE{
   								vistprinc::mostrarnotificacion("La encuesta no tiene preguntas.");
   							}
   						}ELSE{
   							vistprinc::mostrarnotificacion("Ya hay un lanzamiento programado entre esas fechas.");
   						}
   					}ELSE{
   						vistprinc::mostrarnotificacion("No se puede programar un lanzamiento con  una fecha de inicio ya pasada.");
   					}
   				}ELSE{
   					vistprinc::mostrarnotificacion("La fecha de fin debe ser mayor que la de inicio.");
   				}
   			}ELSE{
   				vistprinc::mostrarnotificacion("La fechas no son correctas.");
   			}
   		}ELSE{
   			vistprinc::mostrarnotificacion("No has introducido un campo obligatorio.");
   		}
   	}ELSE{
   		modelprinc::aniadirlog(ERROR_entrarsinpermiso);
   		contprinc::redireccioninterna("index", "inicio");
   	}
   }
}