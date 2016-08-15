<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: Borrar pregunta</h3></div>
<table>
<tr><td>
      <center><h3>Atención</h3></center>
</td></tr>
<tr><td>
      <p>Seguro de que desea borrar la pregunta, al borrarla se eliminaran todos los resultados asociadas a ella.</p>
</td></tr>
<tr><td>
       <center>'.contprinc::crearenlaceinterno("Borrar esta pregunta", "encuestas", "borrarpregunta", '&id='.$_GET["id"].'').'</center>
</td></tr>
</table>
';