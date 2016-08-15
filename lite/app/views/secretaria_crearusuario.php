<?php
$contenido = '
<div id="tituloseccion"><h3>SECRETARIA: CREAR NUEVO USUARIO</h3></div>
<p>Rellene los campos y pulse Enviar para guardar el usuario.</p>
'.fmw::iniciarformulario("nuevousuario", "post", contprinc::crearurlinterna("secretaria", "guardarnuevousuario")).'
              <table class="tablaconborde">
  <tr>
    <th>Nombre:</th>

  <td>'.fmw::aniadirinput("text","nombre", "", "required").'</td>		
  </tr>
  <tr>
    <th>Tipo:</th>
   <td>'.fmw::aniadirinput("select","tipo", array(5 => usuario5, 4 => usuario4, 3 => usuario3, 2 => usuario2), "2", "required").'</td>		
  </tr>
 <tr>
    <th>Usuario:</th>

  <td>'.fmw::aniadirinput("text","usuario", "", "required").'</td>		
  </tr>
  <tr>
    <th>Contraseña:</th>

  <td>'.fmw::aniadirinput("password","password", "", "required").'</td>		
  </tr>
  <tr>
    <th>Email:</th>

  <td>'.fmw::aniadirinput("email","email", "", "required").'</td>		
  </tr>
  <tr>
</table>
'.fmw::aniadirinput("submit").'
'.fmw::cerrarformulario().'
';
