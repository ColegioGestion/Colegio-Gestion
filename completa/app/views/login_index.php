<?php
$contenido = '
<div id="tituloseccion"><h3>INICIAR SESIÓN</h3></div>
<table>
'.fmw::iniciarformulario("iniciarsesion", "post", contprinc::crearurlinterna("login", "iniciarsesion")).'
<tr>
  <td>Usuario:</td>
  <td>'.fmw::aniadirinput("text", "usuario", "", "20").'</td>		
</tr>
<tr>
  <td>Contraseña:</td>
  <td>'.fmw::aniadirinput("password", "contrasenia", "", "12").'</td>		
</tr>
<tr>
  <td>'.fmw::aniadirinput("submit").'</td>		
</tr>
'.fmw::cerrarformulario().'
</table>
';
