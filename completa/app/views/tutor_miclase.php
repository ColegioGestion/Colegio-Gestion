<?php
$contenido = '
<div id="tituloseccion"><center><h3>TUTORIA: MI CLASE</h3></div>
<h1>Clase: '.modelprinc::obtenerdato(TABLATUTORIAS, "curso", $_GET["clase"]).'</h1>
<h3>Alumnos</h3>
'.modelotutor::tablaalumnos().'
<h3>Partes puestos en el curso</h3>
'.modelotutor::listapartes().'
</center>
';