<?php
$contenido = '
<div id="tituloseccion"><h3>DOCENTE: INICIO</h3></div>
<h2>Calendario '.fmw::obtenernombremes(date("n")).', '.date("Y").'</h2>
'.modelodocente::montarcalendariomensual().'
<h3>Proximos eventos</h3>
'.modelodocente::proximoseventos().'
<h3>Noticias:</h3>
'.modelodocente::noticias().'
';