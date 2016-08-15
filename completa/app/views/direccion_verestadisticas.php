<?php
$contenido = '
<div id="tituloseccion"><h3>DIRECCIÓN: Estadisticas del sistema</h3></div>
<table border="1">
<th>Sistema:</th>
  <tr>
    <td>Número de registros en el log:</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLALOG.'').'</td>		
  </tr>
<th>Usuarios:</th>
  <tr>
    <td>Número docentes:</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLAUSUARIOS.'').'</td>		
  </tr>
   <tr>
    <td>Número alumnos:</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLAALUMNOS.'').'</td>		
  </tr>
<th>Encuestas:</th>
  <tr>
    <td>Número de encuestas existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLAENCUESTAS.'').'</td>		
  </tr>
  <tr>
    <td>Número de respuestas existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLARESULTADOSDATOS.'').'</td>		
  </tr>
  <th>Eventos:</th>
  <tr>
    <td>Número de eventos existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLAEVENTOS.'').'</td>		
  </tr>
    <th>Noticias:</th>
  <tr>
    <td>Número de noticias existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLANOTICIAS.'').'</td>		
  </tr>
      <th>Partes Disciplinarios:</th>
  <tr>
    <td>Número de partes existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLAPARTES.'').'</td>		
  </tr>
      <th>Tutorias:</th>
  <tr>
    <td>Número de tutorias existentes en el sistema</td>
    <td>'.modelprinc::contarregistrosquery('SELECT id FROM '.TABLATUTORIAS.'').'</td>		
  </tr>
</table>
';