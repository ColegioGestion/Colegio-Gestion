<?php
defined('PASOINDEX') or exit;
class modelojefatura {
   function listatutorias() {
   	   $return = '<table border="1">
   	   '.fmw::iniciarformulario("nuevatutoria", "post", contprinc::crearurlinterna("jefatura", "guardarnuevatutoria")).'
   	   <tr><td>ID</td><td>Curso</td><td>Tutor</td><td></td></tr>
   	   <tr><td>Nuevo Curso:</td><td>'.fmw::aniadirinput("text","curso").'</td><td>'.modelojefatura::desplegebleusuariosnotutoria().'</td><td>'.fmw::aniadirinput("submit").'</td>'.fmw::cerrarformulario().'</tr>
   	   ';
       $query = modelprinc::querysql('SELECT * FROM '.TABLATUTORIAS.'');
       $i=1;
       while ($tutorias = mysql_fetch_row($query)) {
       	  $return .= '<tr><td>'.$i.'</td><td>'.$tutorias[1].'</td><td>'.usuario::obtenerdatousuario("nombre", $tutorias[2]).'</td></tr>';
          $i++;
       }
       $return .= '</table>';
       return $return;
   }
   function desplegebleusuariosnotutoria() {
   	$return = fmw::aniadirinput("select2", "tutor", "abrir");
   	$query = modelprinc::querysql('SELECT id, nombre FROM '.TABLAUSUARIOS.' WHERE (tipo>="2")');
   	while($docentes = mysql_fetch_row($query)) {
   		if (!modelotutor::obtenermitutoria($docentes[0])) {
   	       $return .= fmw::aniadirinput("option", $docentes[0], $docentes[1]);
   		}
   	}
   	$return .= fmw::aniadirinput("select2", "tutor", "cerrar");
   	return $return;
   }
}
