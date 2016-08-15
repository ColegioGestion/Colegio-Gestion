<?php
$contenido = '
<div id="tituloseccion"><h3>SECRETARIA: LISTA USUARIOS</h3></div>
<tr><td>'.contprinc::crearenlaceinterno("Pulse aqui para crear un nuevo usuario", "secretaria", "crearusuario").'</td></tr>
'.modelprinc::montartablasql(TABLAUSUARIOS, array("nombre","usuario","email"), '', array("1" => contprinc::crearurlinterna("secretaria", "verusuario", '&id='))).'
';
