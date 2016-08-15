<?php
$contenido = '
<h3>Atención</h3>
<table>
<tr><td><h4>¿Seguro de que desea borrar la encuesta? Al borrar la encuesta se perderan:</h4></td></tr>
<tr><td>• Todas las <b>respuestas</b> obtenidas</td></tr>
<tr><td>• Todas las preguntas creadas</td></tr>
<tr><td>• Se desprogramaran todos los lanzamientos programados</td></tr>
<tr><td>'.contprinc::crearenlaceinterno("Borrar esta encuesta", "encuestas", "borrarencuesta", '&id='.$_GET["id"].'').'</td></tr>
</table>
';