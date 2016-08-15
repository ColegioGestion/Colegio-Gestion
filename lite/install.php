<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
require_once 'app/framework/framework.php';
echo '<center>
<h1>Instalación Colegio Gestión</h1>';
if (!file_exists("config/configuracion.php")) {
if ($_POST["form"] != 0) {
 if ($_POST["servidor"] != "" && $_POST["bd"] != "" && $_POST["usuariosql"] != ""
 		 && $_POST["contrasenasql"] != "" && $_POST["nombre"] != "" && $_POST["email"] != "" 
 		&& $_POST["usuario"] != "" && $_POST["contrasena"] != "" && $_POST["centroeducativo"] != "" 
 		&& $_POST["url"] != "") {
 	    //empezamos a configurar
 	    $datos = fmw::limpiarpost($_POST);
 	    $conexion = mysql_connect($datos[1], $datos[3], $datos[4]) or die('Error en la conexión a la base de datos. </br><input type="button" value="Volver atrás" onclick="history.back()" style="font-family: Verdana; font-size: 10 pt">');
 	    mysql_select_db($datos[2], $conexion);
 	    
 	    mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
 	    $file = fopen("config/configuracion.php","w+");
 	    fwrite($file, "<?php" . PHP_EOL);
 	    fwrite($file, "defined('PASOINDEX') or exit;" . PHP_EOL);
 	    fwrite($file, "" . PHP_EOL);
 	    fwrite($file, "//datos de conexion sql" . PHP_EOL);
 	    fwrite($file, "define('SERVIDORSQL', '$datos[1]');" . PHP_EOL);
 	    fwrite($file, "define('BASEDATOSSQL', '$datos[2]');" . PHP_EOL);
 	    fwrite($file, "define('USUARIOSQL', '$datos[3]');" . PHP_EOL);
 	    fwrite($file, "define('PASSWORDSQL', '$datos[4]');" . PHP_EOL);
 	    fwrite($file, "" . PHP_EOL);
 	    fwrite($file, "//Email webmaster" . PHP_EOL);
 	    fwrite($file, "define('EMAILWEBMASTER', '$datos[6]');" . PHP_EOL);
 	    fwrite($file, "" . PHP_EOL);
 	    fwrite($file, "//datos del sitio" . PHP_EOL);
 	    fwrite($file, "define('URLSITIO', '$datos[10]');" . PHP_EOL);
 	    fwrite($file, "" . PHP_EOL);
 	    fwrite($file, "//Estado sitio" . PHP_EOL);
 	    fwrite($file, "//1: Todas las funciones activas y no se muestran errores" . PHP_EOL);
 	    fwrite($file, "//2: Todas las funciones activas y se muestran todos los errores" . PHP_EOL);
 	    fwrite($file, "//3: Todas las funciones desactivadas y no se muestran errores" . PHP_EOL);
 	    fwrite($file, "define('ESTADOSITIO', '1');" . PHP_EOL);
 	    fwrite($file, "" . PHP_EOL);
 	    fwrite($file, "//guardar errores log" . PHP_EOL);
 	    fwrite($file, "define('GUARDARLOG', true);" . PHP_EOL);
 	    fclose($file);
mysql_query("CREATE TABLE IF NOT EXISTS `cg_centroeducativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_encuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `administrador` int(11) NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `usuariominimo` int(11) NOT NULL,
  `anonima` int(11) NOT NULL,
  `repetible` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `evento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8_unicode_ci NOT NULL,
  `rollminimo` int(11) NOT NULL,
  `hora` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_lanzamientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idencuesta` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechafin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noticia` text COLLATE utf8_unicode_ci NOT NULL,
  `fechadespliegue` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_preguntas_datosprincipales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idencuesta` int(11) NOT NULL,
  `pregunta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `obligatorio` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_preguntas_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpregunta` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_resultados_datosprincipales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idlanzamiento` int(11) NOT NULL,
  `fechahora` datetime NOT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `useragent` text COLLATE utf8_unicode_ci NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_resultados_respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idresultado` int(11) NOT NULL,
  `idpregunta` int(11) NOT NULL,
  `respuesta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_tutorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tutor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE IF NOT EXISTS `cg_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(1) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contrasenia` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
//eventos
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-10-12', 'Fiesta Nacional de España')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-11-01', 'Todos los Santos')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-06', 'Constitución Española')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-08', 'Inmaculada Concepción')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-26', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-27', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-28', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-29', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2016-12-30', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-01-02', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-01-03', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-01-04', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-01-05', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-01-06', 'Vacaciones Navidad')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-02-27', 'Semana Blanca')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-02-28', 'Semana Blanca')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-03-01', 'Semana Blanca')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-03-02', 'Semana Blanca')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-03-03', 'Semana Blanca')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-04-10', 'Semana Santa')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-04-11', 'Semana Santa')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-04-12', 'Semana Santa')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-04-13', 'Semana Santa')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-04-14', 'Semana Santa')");
mysql_query("INSERT INTO cg_eventos (tipo, fecha, evento) VALUES ('2', '2017-05-01', 'Fiesta del Trabajo')");
mysql_query("INSERT INTO cg_centroeducativo (nombre, value) VALUES ('nombre', '$datos[9]')");
$clave = md5($datos[7]);
mysql_query("INSERT INTO cg_usuarios (tipo, nombre, usuario, contrasenia, email) VALUES ('5', '$datos[5]', '$datos[8]', '$clave', '$datos[6]')");
echo '
El sistema se ha instalado correctamente. Ya puede iniciar sesion con el usuario de director desde la pagina de inicio y terminar de configurar el sistema añadiendo usuarios, tutorias...</br>
Recomendamos borrar el archivo install.php y colegiogestion.sql por medidas de seguridad.</br>
<a href="index.php">Iniciar Sesión</a>
';
 }ELSE{
 	echo 'Se a dejado algun campo vacio.</br>
 	   <input type="button" value="Volver atrás" onclick="history.back()" style="font-family: Verdana; font-size: 10 pt">
 	';
 }
	
	
}ELSE{
	echo '
<FORM action="install.php" method="POST">
<INPUT type="HIDDEN" name="form" value="1"><BR>
	<p>Servidor SQL</p>
    <LABEL>Servidor SQL: </LABEL>
              <INPUT type="text" name="servidor"><BR>
    <LABEL>Base de Datos SQL: </LABEL>
              <INPUT type="text" name="bd"><BR>
    <LABEL>Usuario SQL: </LABEL>
              <INPUT type="text" name="usuariosql"><BR>
    <LABEL>Contraseña SQL: </LABEL>
              <INPUT type="text" name="contrasenasql"><BR>
    <p>Datos Director</p>
    <LABEL>Nombre Director: </LABEL>
              <INPUT type="text" name="nombre"><BR>
    <LABEL>Email Director: </LABEL>
              <INPUT type="text" name="email"><BR>
    <LABEL>Usuario Director: </LABEL>
              <INPUT type="text" name="usuario"><BR>
    <LABEL>Contraseña Director: </LABEL>
              <INPUT type="text" name="contrasena"><BR>
    <p>Datos Centro Educativo</p>
    <LABEL>Nombre centro educativo: </LABEL>
              <INPUT type="text" name="centroeducativo"><BR>
              <p>Datos Servidor</p>
    <LABEL>URL de instalación del sistema (Ej: http://www.colegiogestion.com/colegiogestion/): </LABEL>
              <INPUT type="text" name="url"><BR>
    <INPUT type="submit" value="Enviar">
 </FORM>
</center>
	';
}
}ELSE{
	echo 'El sistema ya esta instalado.';
}
echo '</center>';
