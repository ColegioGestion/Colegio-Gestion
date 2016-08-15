<?php
/******************************************************/
/* Framework 1.4 para Colegio Gestion    2016         */
/******************************************************/
class fmw {
	/*------------------------------------------------*/
	/*Conjunto de funciones relacionadas con texto*/
	/*------------------------------------------------*/
    //funcion para limpiar texto y evitar inyecciones sql
	function limpiartexto($texto) {
		return addslashes($texto);
	}
    //funcion para generar un enlace
    function crearenlace($nombre, $url) {
	    if (!$url) {
		  $url = $nombre;
	    } 
	    return '<a href="'.$url.'">'.$nombre.'</a>';
    }
 	/*------------------------------------------------*/
    /*Fin funciones relacionadas con texto*/
	/*Conjunto de funciones relacionadas con formulario*/
	/*------------------------------------------------*/
	//funcion para iniciar un formulario
	function iniciarformulario($nombre, $metodo, $url) {
		return '<FORM name="'.$nombre.'" action="'.$url.'" method="'.$metodo.'" accept-charset="UTF-8" autocomplete="off">';
	}
	//funcion para añadir un input
	function aniadirinput($tipo, $nombre, $value, $select, $obligatorio, $maxlength, $size, $min, $max) {
		if ($tipo == "submit") {
			IF (!$NOMBRE) {
				$NOMBRE = "ENVIAR";
			}
			return '<input type="submit" name="'.$nombre.'">';
		}ELSEIF ($tipo == "select") {
			$desplegable = '<select name="'.$nombre.'" '.$obligatorio.'>';
			for ($i=0;$i<count($value);$i++) {
				if ($i=="0") {
					$valuea = current($value);
				}
				if ($select == key($value)) {
					$desplegable .= '<option value="'.key($value).'" selected>'.$valuea.'</option>';
				}ELSE{
					$desplegable .= '<option value="'.key($value).'">'.$valuea.'</option>';
				}
				$valuea = next($value);
			}
			$desplegable .= '</select>';
			return $desplegable;
		}ELSEIF ($tipo == "select2") {
			IF ($value == "abrir") {
				return '<select name="'.$nombre.'" '.$obligatorio.'>';
			}ELSE{
				return '</select>';
			} 	
		}ELSEIF ($tipo == "option") {
			//selected
			    return '<option value="'.$nombre.'" '.$select.'>'.$value.'</option>';
		}ELSE{
				return '<input type="'.$tipo.'" name="'.$nombre.'" value="'.$value.'" maxlength="'.$maxlength.'" size="'.$size.'" '.$obligatorio.' min="'.$min.'" max="'.$max.'" class="input">';
		     }
		}
	//funcion para cerrar un formulario
	function cerrarformulario() {
		return '</form>';
	}
	//funcion para eliminar signos no permitidos de un post devolviendo un array limpio
	function limpiarpost($post) {
		$post = array_values($post);
		for($i=0; $i<count($post); $i++)
		{
		$array[$i] = fmw::limpiartexto($post[$i]);
		}
		return $array;
	}
	//funcion para ver si los input obligatorios estan en un post
	function comprobarinputobligatorios($input) {
		for ($i=0;$i<count($input);$i++) {
			if ($_POST[$input[$i]] == "") {
				$false = "1";
			}
		 }
		 if (!$false) {
		    return true;
		    }ELSE{
		    return false;
		    }
		}
	/*------------------------------------------------*/
    /*Fin funciones relacionadas con texto*/
	/*Conjunto de funciones relacionadas con arrays*/
	/*------------------------------------------------*/
	//funcion para imprimir array con siguiente formato: uno,dos,tres
	function hacerlistaarray($array) {
		for($i=0; $i<count($array); $i++)
		{
			if (!$resultado) {
				$resultado = $array[$i];
			}ELSE{
				$resultado .= ",$array[$i]";
			}
		}
		return $resultado;
	}
	//funcion lista con nombres array:
	function listanombresarray($array) {
		/*implode(",", $array)*/
		while ($nombre_array = current($array)) {
			if (!$resultado) {
				$resultado = key($array);
			}ELSE{
				$resultado .= ",key($array)";
			}
			next($array);
		}
		return $resultado;
	}
	/*------------------------------------------------*/
	/*Fin funciones relacionadas con arrays*/
	/*Conjunto de funciones relacionadas con date*/
	/*------------------------------------------------*/
	function compararfechas($fecha1, $fecha2, $comparacion) {
		$fechan1 = strtotime($fecha1);
		$fechan2 = strtotime($fecha2);
		IF ($comparacion == "<") {
			if ($fechan1<$fechan2 || $fechan1==$fechan2) {
				$true = "1";
			}
		}ELSEIF ($comparacion == ">") {
			if ($fechan1>$fechan2 || $fechan1==$fechan2) {
				$true = "1";
			}
		}
		if ($true) {
			return true;
		}ELSE{
			return false;
		}
	}
	//funcion comprobar fecha si es real formato: 2016-03-29
	function comprobarfecha($date) {
		 $fecha = explode("-", $date);
		 if (checkdate($fecha[1], $fecha[2], $fecha[0])) {
		 	return true;
		 }ELSE{
		 	return false;
		 }
	}
	function darvueltafecha($fechaalreves) {
		$date = date_create($fechaalreves);
		return date_format($date, 'd-m-Y');
	}
	function obtenernombredia($numero) {
		$array = array(1 => "Lunes", 2 => "Martes", 3 => "Miercoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sabado", 7 => "Domingo");
		return $array[$numero];
	}
	function obtenernombremes($numero) {
		$array = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
	    return $array[$numero];
	}
	//saber mes proximo o anterior
	function obtenermes($tipo) {
		if ($tipo == "+") {
			if (date("n") == "12") {
				return array(1, date("Y")+1);
			}ELSE{
				return array(date("n")+1, date("Y"));
			}
		}ELSE{
				if (date("n") == "1") {
					return array(12, date("Y")-1);
				}ELSE{
					return array(date("n")-1, date("Y"));
				}
	   }
	}
	/*------------------------------------------------*/
	/*Fin funciones relacionadas con date*/
	/*Inicio de funciones relacionadas con números*/
	/*------------------------------------------------*/
	function calcularporcentaje($total, $parte, $redondear = 2) {
		return round($parte / $total * 100, $redondear);
	}
	/*------------------------------------------------*/
	/*Fin funciones relacionadas con numeros*/
	/*Inicio de funciones encriptar*/
	/*------------------------------------------------*/
	function encrypt_decrypt($action, $string) {
		$output = false;
	
		$encrypt_method = "AES-256-CBC";
		
		$secret_key = contprinc::obtenerkey();
		$secret_iv = sha1(md5($secret_key));
	
		// hash
		$key = hash('sha256', $secret_key);
	
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
	
		if( $action == 'encriptar' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'desencriptar' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
	
		return $output;
	}
	/*------------------------------------------------*/
	/*Fin funciones encriptar*/
	/*Otras funciones*/
	/*------------------------------------------------*/
	function aleatorio($numerocaracteres=10) {
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cadena = ""; 
		for($i=0;$i<$numerocaracteres;$i++)
		{
			$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); 
		}
		return $cadena;
	}
}
