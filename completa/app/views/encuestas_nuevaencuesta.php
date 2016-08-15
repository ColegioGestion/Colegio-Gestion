<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: AÑADIR NUEVA ENCUESTA</h3></div>
<h3>Complete la información para crear la encuesta. Posteriormente se añadiran las preguntas. </h3>
'.fmw::iniciarformulario("nuevaencuesta", "post", contprinc::crearurlinterna("encuestas", "guardarnuevaencuesta")).'
'.fmw::aniadirinput("hidden","id", $_GET["id"]).'
              <table class="tablaconborde">
  <tr>
    <th>Nombre:</th>

  <td>'.fmw::aniadirinput("text","nombre", "", "required").'</td>		
  </tr>
  <tr>
    <th>Color de fondo:</th>
    <td>'.fmw::aniadirinput("color","color", "#5FC9BF").'</td>		
  </tr>
  <tr>
    <th>Anónima:</th>
   <td>'.fmw::aniadirinput("select","anonima", array(0 => "No", 1 => "Si"), "0", "required").'</td>		
  </tr>
    <tr>
    <th>Repetible:</th>
   <td>'.fmw::aniadirinput("select","repetible", array(0 => "No", 1 => "Si"), "0", "required").'</td>		
  </tr>
<tr>
    <th>Usuario mínimo para responder:</th>
   <td>'.fmw::aniadirinput("select","usuariominimo", array(4 => usuario4, 3 => usuario3, 2 => usuario2), "2", "required").'</td>		
  </tr>
</table>
'.fmw::aniadirinput("submit").'
'.fmw::cerrarformulario().'
';