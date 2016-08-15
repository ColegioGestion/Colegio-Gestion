<?php
defined('PASOINDEX') or exit;
class modelprinc {
//funcion inicial en la que establecemos que se use utf8 en las comunicaciones entre bd
	function __construct() {
		modelprinc::querysql("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	}
//funcion para conectar bd	
    function conectarbd() {
          $conexion = mysql_connect(SERVIDORSQL, USUARIOSQL, PASSWORDSQL);
          if (mysql_select_db(BASEDATOSSQL, $conexion)) {
             return $conexion;
          }  
    }
//funcion para querry sql
    function querysql($query) {
		  return mysql_query($query, modelprinc::conectarbd()); 
	} 
//funcion para borrar un registro
    function borrarregistro($tabla, $id) {
    	return modelprinc::querysql('DELETE FROM '.$tabla.' WHERE id='.$id.'');
    }
//funcion para obtener un registro a partir de un query
    function obtenerregistrosql($query) {
    	$row = mysql_fetch_array(modelprinc::querysql($query));
    	return $row[0];
    }
//funcion para crear desplegable a partir de query
    function desplegableapartirdequery($query, $nombre) {
    	$result = modelprinc::querysql($query);
    	$select = '<select name="'.$nombre.'">';
    	while ($row=mysql_fetch_array($result))
    	{
    		$select .= '<option name="'.$row[0].'">'.$row[0];echo '</option>';
    	}
    	$select .= "</select>";
    	return $select;
    }
    //funcion para saber si existe un registro
    function comprobarregistro($tabla, $id) {
    	$data = mysql_num_rows(modelprinc::querysql('SELECT id FROM '.$tabla.' WHERE id='.$id.''));
    	IF ($data != "") {
    		return true;
    	}ELSE{
    		return false;
    	}
    }
    //funcion contar registros a partir de query
    function contarregistrosquery($query) {
    	return mysql_num_rows(modelprinc::querysql($query));
    }
    //funcion para montar tabla con los datos de una tabla sql
    function montartablasql($tablasql, $columnas, $where, $enlace) {
    	$tabla = '<table class="tablaquery" style="width:70%">';
    	if ($where) {
    		$wheree = 'WHERE '.$where.'';
    	}
    	$query=modelprinc::querysql('SELECT id, '.fmw::hacerlistaarray($columnas).' FROM '.$tablasql.' '.$wheree.'');
    	$id = mysql_fetch_row(modelprinc::querysql('SELECT id FROM '.$tablasql.' '.$wheree.''));
    	$numerocolumnas=count($columnas)+1;
    	$tabla .= "<tr>";
    	//bucle para crear la primera fila con los nombres de las columnas
    	for ($i=0;$i<$numerocolumnas-1;$i++) {
    		$tabla .= '<th>'.constant("NOMBRE-$columnas[$i]").'</th>';
    	}
    	$tabla .= "</tr>";
    	//bucle para obtener cada fila
    	while($row=mysql_fetch_row($query)) {
    	if ($color == 1) {
		    $tabla .= '<tr bgcolor="#BDBDBD">';
		    $color = 2;
		}ELSE{
			$tabla .= '<tr>';
			$color = 1;
		}
    		$i=1;
    		//bucle para añadirle valor a cada columna
    		while ($i<$numerocolumnas) {
    		   if ($enlace[$i] != "") {
    				$tabla .= '<td>'.fmw::crearenlace($row[$i],''.$enlace[$i].''.$row[0].'').'</td>';
    		    }ELSE{
    				$tabla .= "<td>$row[$i]</td>";
    			  }
    			$i++;
    		}
    		$tabla .= "</tr>";	
    	}
    	$tabla .= "</table>";
    	if (!$color) {
    		$tabla .= 'No hay ningun registro.</br>';
    	}
    	return $tabla;
    }
    //funcion para añadir datos al log en base de datos
    function aniadirlog($descripcion, $tipo="error") {
    	if (GUARDARLOG) {
    	if (!$_SESSION["identificador"]) {
    		$usuario = "anonymous";
    	}ELSE{
    		$usuario = $_SESSION["identificador"];
    	}
    	modelprinc::querysql('INSERT INTO '.TABLALOG.' (tipo, usuario, controller, action, descripcion, fecha) VALUES (\''.$tipo.'\',\''.$usuario.'\',\''.$_GET[NOMBREGETCONTROLLER].'\',\''.$_GET[NOMBREGETACTION].'\',\''.$descripcion.'\', \''.date("Y-m-d H:i:s").'\')');
        }
    }
    function obtenerdato($tabla, $dato, $id) {
    	return modelprinc::obtenerregistrosql('SELECT '.$dato.' FROM '.$tabla.' WHERE id='.$id.'');
    }
}

