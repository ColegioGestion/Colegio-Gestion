<?php
$contenido = '
<div id="tituloseccion"><h3>DIRECCIÓN: VER LOG</h3></div>
'.modelprinc::montartablasql(TABLALOG, array("id","tipo","usuario","controller","action","descripcion","fecha")).'
'.contprinc::crearenlaceinterno("Vaciar log","admin","vaciarlog").'
';