<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: VER RESULTADOS ENCUESTA</h3></div>
'.modeloencuestas::montartablaporcentajes($_GET["id"]).'
<h2>Lista con todos los resultados</h2>
'.modeloencuestas::montartablaresultados($_GET["id"]).'
';