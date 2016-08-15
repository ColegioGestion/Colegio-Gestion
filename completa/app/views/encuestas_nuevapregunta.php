<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: AÑADIR NUEVA PREGUNTA</h3></div>
<h3>Nueva pregunta para la encuesta: '.modeloencuestas::obtenerdatoencuesta($_GET["id"], "nombre").'</h3>
'.fmw::iniciarformulario("pregunta", "post", contprinc::crearurlinterna("encuestas", "guardarnuevapregunta", '&id='.$_GET["id"].'')).'
'.fmw::aniadirinput("hidden","id", $_GET["id"]).'
<table>
  <tr>
    <td>Pregunta:</td>
    <td>'.fmw::aniadirinput("text","pregunta", modeloencuestas::obtenerdatopregunta($_GET["idpregunta"], "pregunta"), "required").'</td>		
  </tr>
  <tr>
    <td>Observaciones:</td>
    <td>'.fmw::aniadirinput("text","observaciones", modeloencuestas::obtenerdatopregunta($_GET["idpregunta"], "observaciones"), "").'</td>		
  </tr>
   <tr>
    <td>Tipo:</td>
    <td>'.fmw::aniadirinput("select","obligatorio", array("required" => "Obligatorio", "optativa" => "No obligatorio"), modeloencuestas::obtenerdatopregunta($_GET["idpregunta"], "obligatorio")).'</td>		
  </tr>
  <tr>
    <td>Valor por defecto:</td>
    <td>';
if ($_POST["tipo"]) {
	$tipo = $_POST["tipo"];
}ELSE{
	$tipo = modeloencuestas::obtenerdatopregunta($_GET["idpregunta"], "tipo");
}
$contenido .= fmw::aniadirinput("hidden","tipo", $tipo);
if ($tipo == "text") {
$contenido .= fmw::aniadirinput("text", "value1", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "1"));
}ELSEIF ($tipo == "select") {
$contenido .= 'Opción 1:'.fmw::aniadirinput("text","value1", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "1")).'</br>';
$contenido .= 'Opción 2:'.fmw::aniadirinput("text","value2", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "2")).'</br>';
$contenido .= 'Opción 3:'.fmw::aniadirinput("text","value3", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "3")).'</br>';
$contenido .= 'Opción 4:'.fmw::aniadirinput("text","value4", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "4")).'</br>';
$contenido .= 'Opción 5:'.fmw::aniadirinput("text","value5", modeloencuestas::obtenervaluepreguntas($_GET["idpregunta"], "5")).'</br>';
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