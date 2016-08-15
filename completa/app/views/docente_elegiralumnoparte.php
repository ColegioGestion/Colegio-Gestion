<?php
$contenido = '
<div id="tituloseccion"><h3>DOCENTE: ELEGIR ALUMNO PARA PARTE DISCIPLINARIO</h3></div>
<p>Escriba el Apellidos y Nombre del Alumno</p>
'.fmw::iniciarformulario("nuevousuario", "post", contprinc::crearurlinterna("docente", "ponerparte")).'
  <table class="tablaconborde">
  <tr>
    <th>Apellidos:</th>

  <td>'.fmw::aniadirinput("text","apellidos", "", "required").'</td>		
  </tr>
   <tr>
    <th>Nombre:</th>

  <td>'.fmw::aniadirinput("text","nombre", "", "required").'</td>		
  </tr>
  <tr>
    <th>Curso:</th>

  <td>'.modelodocente::desplegebletutorias().'</td>		
  </tr>
</table>
'.fmw::aniadirinput("submit").'
'.fmw::cerrarformulario().'
';