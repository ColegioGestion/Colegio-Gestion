<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: CONFIGURAR ENCUESTA</h3></div>
<h3>Elige una de las encuestas de la lista para proceder con su configuración.</h3>
<h3>'.contprinc::crearenlaceinterno("Nueva Encuesta", "encuestas", "nuevaencuesta").'</h3>
'.modelprinc::montartablasql(TABLAENCUESTAS, array("nombre"),'(administrador=\''.$_SESSION["identificador"].'\')', array("1" => contprinc::crearurlinterna("encuestas", "configurarencuesta", '&id='))).'
';