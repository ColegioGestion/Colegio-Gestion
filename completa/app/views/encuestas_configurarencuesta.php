<?php
$contenido = '
<div id="tituloseccion"><h3>ADMINISTRACIÓN: Configurar encuesta</h3></div>
'.fmw::iniciarformulario("modificarencuesta", "post", contprinc::crearurlinterna("encuestas", "actualizarencuesta", '&id='.$_GET["id"].'')).'
'.fmw::aniadirinput("hidden","id", $_GET["id"]).'
<table class="tablaconborde" style="width:60%">
 <tr>
     <td></td>
     <td><h2>Datos principales</h2><p>Para modificar estos datos ve pulsando encima de ellos y modificas su valor. Por ultimo debe pulsar el boton de enviar.</p></td>
 </tr>
 <tr>
    <th>Nombre:</th>
    <td>'.fmw::aniadirinput("text","nombre", modeloencuestas::obtenerdatoencuesta($_GET["id"], "nombre"), "required", "", "", "30").'</td>		
  </tr>
     <tr>
    <th>Anónima:</th>
    <td>'.constant(modeloencuestas::obtenerdatoencuesta($_GET["id"], "anonima")).'</td>		
  </tr>
       <tr>
    <th>Repetible:</th>
    <td>'.fmw::aniadirinput("select","repetible", array(0 => "No", 1 => "Si"), modeloencuestas::obtenerdatoencuesta($_GET["id"], "repetible")).'</td>		
  </tr>
   <tr>
    <th>Usuario Mínimo:</th>
    <td>'.fmw::aniadirinput("select","usuariominimo", array(4 => usuario4, 3 => usuario3, 2 => usuario2), modeloencuestas::obtenerdatoencuesta($_GET["id"], "usuariominimo")).'</td>		
  </tr>
   <tr>
    <th>Color de fondo:</th>
    <td>'.fmw::aniadirinput("color","color", modeloencuestas::obtenerdatoencuesta($_GET["id"], "color")).'</td>		
  </tr>
  <tr>
    <td></td>
    <td>'.fmw::aniadirinput("submit").' o '.contprinc::crearenlaceinterno("Eliminar encuesta", "encuestas", "confirmacioneliminarencuesta", '&id='.$_GET["id"].'').'</td>
  </tr>
</table>
'.fmw::cerrarformulario().'
<h2>Lanzamientos:</h2>
'.modeloencuestas::montartablalanzamientos($_GET["id"]).'
<h2>Preguntas</h2>
'.modeloencuestas::montartablapreguntas($_GET["id"]).'
'.fmw::iniciarformulario("nuevapregunta", "post", contprinc::crearurlinterna("encuestas", "nuevapregunta", '&id='.$_GET["id"].'')).'
<table id="tablabordenegro">
                     <tr>
                         <th>Añadir nueva pregunta</th>
                     </tr>
                     <tr>
                         <td>Tipo: '.fmw::aniadirinput("select","tipo", array("text" => "Texto", "select" => "Lista Desplegable"), "", "required").'</td>		
                     </tr>
                     <tr>
                          <td>'.fmw::aniadirinput("submit", "Seguir configurando la pregunta").'</td>		
                     </tr>
                     </table>
';