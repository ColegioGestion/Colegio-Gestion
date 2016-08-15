<?php
$idusuario = fmw::limpiartexto($_GET["id"]);
$contenido = '
<center>
<div id="tituloseccion"><h3>SECRETARIA: VER USUARIO</h3></div>
<h2>Usuario: '.usuario::obtenerdatousuario("usuario", $idusuario).'</h2>
<h3>Datos Personales</h3>
<table border="1">
<tr>
  <td>Nombre:</td>
  <td>'.usuario::obtenerdatousuario("nombre", $idusuario).'</td>
</tr>
<tr>
  <td>Usuario:</td>
  <td>'.usuario::obtenerdatousuario("usuario", $idusuario).'</td>
</tr>
<tr>
  <td>Email:</td>
  <td>'.usuario::obtenerdatousuario("email", $idusuario).'</td>
</tr>
<tr>
  <td>Roll:</td>
  <td>'.constant("usuario".usuario::obtenerdatousuario("tipo", $idusuario)).'</td>
</tr>
</table>
<h3>Cambiar contraseña</h3>
<table>
'.fmw::iniciarformulario("cambiarcontraseña", "post", contprinc::crearurlinterna("secretaria", "cambiarcontrasena")).'
'.fmw::aniadirinput("hidden", "usuario", $idusuario).'
<tr>
  <td>Nueva contraseña:</td>		
</tr>
<tr>
  <td>'.fmw::aniadirinput("text", "contraseña", "", "20").'</td>		
</tr>
<tr>
  <td>'.fmw::aniadirinput("submit").'</td>		
</tr>
'.fmw::cerrarformulario().'
</table>
<h3>Borrar usuario</h3>
'.contprinc::crearenlaceinternojs("Pulse aqui para eliminar el usuario", "¿Seguro de que desea borrar el usuario?", "secretaria", "eliminarusuario", '&id='.$idusuario.'').'
</center>
';