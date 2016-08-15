<?php
$contenido = '
<div id="tituloseccion"><h3>DOCENTE: PONER PARTE DISCIPLINARIO</h3></div>
<table border="1">
'.fmw::iniciarformulario("nuevoparte", "post", contprinc::crearurlinterna("docente", "guardarparte")).'
'.fmw::aniadirinput("hidden","alumno", $contenido1).'
<tr>
   <th>Alumno:</th>
   <td>'.modelprinc::obtenerdato(TABLAALUMNOS, "apellido", $contenido1).', '.modelprinc::obtenerdato(TABLAALUMNOS, "nombre", $contenido1).'</td>
</tr>
<tr>
   <th>Curso:</th>
   <td>'.modelprinc::obtenerdato(TABLATUTORIAS, "curso", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $contenido1)).'</td>
</tr>
<tr>
   <th>Tutor:</th>
   <td>'.modelprinc::obtenerdato(TABLAUSUARIOS, "nombre", modelprinc::obtenerdato(TABLATUTORIAS, "tutor", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $contenido1))).'</td>
</tr>
<tr>
   <th>Tipo de Parte:</th>
   <td>'.fmw::aniadirinput("select","tipo", array(1 => PARTE1, 2 => PARTE2, 3 => PARTE3)).'</td>
</tr>
<tr>
   <th>Descripción:</th>
   <td><textarea rows="11" cols="100" name="descripcion"></textarea></td>
</tr>
<tr>
   <th></th>
   <td>'.fmw::aniadirinput("submit").'</td>
</tr>
'.fmw::cerrarformulario().'
</table>
';