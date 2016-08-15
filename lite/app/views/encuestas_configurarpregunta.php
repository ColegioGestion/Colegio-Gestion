<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: Configurar pregunta</h3></div>
'.fmw::iniciarformulario("pregunta", "post", contprinc::crearurlinterna("encuestas", "actualizarpregunta", '&id='.$_GET["id"].'')).'
'.fmw::aniadirinput("hidden","id", $_GET["id"]).'
<table>
  <tr>
    <td>Pregunta:</td>
    <td>'.fmw::aniadirinput("text","pregunta", modeloencuestas::obtenerdatopregunta($_GET["id"], "pregunta"), "required").'</td>		
  </tr>
  <tr>
    <td>Observaciones:</td>
    <td>'.fmw::aniadirinput("text","observaciones", modeloencuestas::obtenerdatopregunta($_GET["id"], "observaciones"), "").'</td>		
  </tr>
   <tr>
    <td>Tipo:</td>
    <td>'.fmw::aniadirinput("select","obligatorio", array("required" => "Obligatorio", "optativa" => "No obligatorio"), modeloencuestas::obtenerdatopregunta($_GET["id"], "obligatorio")).'</td>		
  </tr>
  <tr>
    <td>Valor por defecto:</td>
    <td>';
$tipo = modeloencuestas::obtenerdatopregunta($_GET["id"], "tipo");
$contenido .= fmw::aniadirinput("hidden","tipo", $tipo);
if ($tipo == "text") {
$contenido .= fmw::aniadirinput("text", "value1", modeloencuestas::obtenervaluepreguntas($_GET["id"], "1"));
}ELSEIF ($tipo == "select") {
$contenido .= 'Opción 1:'.fmw::aniadirinput("text","value1", modeloencuestas::obtenervaluepreguntas($_GET["id"], "1")).'</br>';
$contenido .= 'Opción 2:'.fmw::aniadirinput("text","value2", modeloencuestas::obtenervaluepreguntas($_GET["id"], "2")).'</br>';
$contenido .= 'Opción 3:'.fmw::aniadirinput("text","value3", modeloencuestas::obtenervaluepreguntas($_GET["id"], "3")).'</br>';
$contenido .= 'Opción 4:'.fmw::aniadirinput("text","value4", modeloencuestas::obtenervaluepreguntas($_GET["id"], "4")).'</br>';
$contenido .= 'Opción 5:'.fmw::aniadirinput("text","value5", modeloencuestas::obtenervaluepreguntas($_GET["id"], "5")).'</br>';
}
$contenido .= '</td>		
  </tr>
   <tr>
   <td></td>
    <td>'.fmw::aniadirinput("submit").'</td>		
  </tr>
</table>
'.fmw::cerrarformulario().'
';