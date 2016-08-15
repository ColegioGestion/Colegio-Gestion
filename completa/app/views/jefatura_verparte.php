<?php
$idalumno           = modelprinc::obtenerdato(TABLAPARTES, "alumno", $_GET["id"]);
$queryfirmatutor    = modelprinc::obtenerdato(TABLAPARTES, "firmatutor", $_GET["id"]);
$queryfirmajefatura = modelprinc::obtenerdato(TABLAPARTES, "firmajefatura", $_GET["id"]);
$profesorquelopone  = modelprinc::obtenerdato(TABLAPARTES, "docente", $_GET["id"]);
  if ($queryfirmatutor != 0) {
	  $firmatutor = 'Firmado por el TUTOR el dia '.fmw::darvueltafecha($queryfirmatutor).'';
  }ELSE{
  	if (modelprinc::obtenerdato(TABLATUTORIAS, "tutor", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $idalumno)) == $_SESSION["identificador"]) {
  	  $firmatutor = contprinc::crearenlaceinterno("Firmar ahora", "jefatura", "firmartutor", '&id='.$_GET["id"].'');
  	}ELSE{
	  $firmatutor = 'Sin firmar.';
  	}
  }
  if ($queryfirmajefatura != 0) {
	  $firmajefatura = 'Firmado por JEFATURA el dia '.fmw::darvueltafecha($queryfirmajefatura).'';
  }ELSE{
  	if (usuario::obtenerdatousuario("tipo", $_SESSION["identificador"]) == 4) {
  		$firmajefatura = contprinc::crearenlaceinterno("Firmar ahora", "jefatura", "firmarjefatura", '&id='.$_GET["id"].'');
  	}ELSE{
	  $firmajefatura = 'Sin firmar.';
  	}
  }
$contenido = '
<div id="tituloseccion"><h3>JEFATURA: VER PARTE</h3></div>
<table border="1">
<tr>
   <th>Fecha:</th>
   <td>'.fmw::darvueltafecha(modelprinc::obtenerdato(TABLAPARTES, "fecha", $_GET["id"])).'</td>
</tr>
<tr>
   <th>Profesor que lo pone:</th>
   <td>'.modelprinc::obtenerdato(TABLAUSUARIOS, "nombre", $profesorquelopone).'</td>
</tr>
<tr>
   <th>Alumno:</th>
   <td>'.modelprinc::obtenerdato(TABLAALUMNOS, "apellido", $idalumno).', '.modelprinc::obtenerdato(TABLAALUMNOS, "nombre", $idalumno).'</td>
</tr>
<tr>
   <th>Curso:</th>
   <td>'.modelprinc::obtenerdato(TABLATUTORIAS, "curso", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $idalumno)).'</td>
</tr>
<tr>
   <th>Tutor:</th>
   <td>'.modelprinc::obtenerdato(TABLAUSUARIOS, "nombre", modelprinc::obtenerdato(TABLATUTORIAS, "tutor", modelprinc::obtenerdato(TABLAALUMNOS, "curso", $idalumno))).'</td>
</tr>
<tr>
   <th>Tipo de Parte:</th>
   <td>'.constant("PARTE".modelprinc::obtenerdato(TABLAPARTES, "tipo", $_GET["id"])).'</td>
</tr>
<tr>
   <th>Descripción:</th>
   <td><textarea rows="11" cols="100" name="descripcion" disabled>'.modelprinc::obtenerdato(TABLAPARTES, "descripcion", $_GET["id"]).'</textarea></td>
</tr>
<tr>
   <th>Firma tutor:</th>
   <td>'.$firmatutor.'</td>
</tr>
<tr>
   <th>Firma jefe estudios:</th>
   <td>'.$firmajefatura.'</td>
</tr>
'.fmw::cerrarformulario().'
</table>
';