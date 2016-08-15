<?php
defined('PASOINDEX') or exit;
//Constantes Principales
define("NOMBREPAGINA", "Colegio Gestión");

//nombre del key del get de la url donde ira localizado el nombre del controlador y la action
define("NOMBREGETCONTROLLER", "c");
define("NOMBREGETACTION", "a");

//Directorios de la web
define("DIRECTORIOAPP", "app");
define("DIRECTORIOCONFIG", "config");
define("DIRECTORIOFRAMEWORK", "app/framework");
define("DIRECTORIOCONTROLLER", "app/controller");
define("DIRECTORIOMODEL", "app/model");
define("DIRECTORIOVIEWS", "app/views");
define("DIRECTORIOCSS", "app/views/css");
define("DIRECTORIOJS", "app/views/javascript");

//Tablas SQL
define("TABLAUSUARIOS", "cg_usuarios");
define("TABLACENTRO", "cg_centroeducativo");
define("TABLAEVENTOS", "cg_eventos");
define("TABLANOTICIAS", "cg_noticias");
define("TABLATUTORIAS", "cg_tutorias");
define("TABLAALUMNOS", "cg_alumnos");
define("TABLAPARTES", "cg_partes");
/*Encuestas*/
define("TABLAENCUESTAS", "cg_encuestas");
define("TABLAPREGUNTASDATOS", "cg_preguntas_datosprincipales");
define("TABLAPREGUNTASVALUES", "cg_preguntas_values");
define("TABLARESULTADOSDATOS", "cg_resultados_datosprincipales");
define("TABLARESULTADOSRESPUESTAS", "cg_resultados_respuestas");
define("TABLALANZAMIENTOS", "cg_lanzamientos");
define("TABLALOG", "cg_log");

//Nombres de las columnas
define("NOMBRE-id", "Id");
define("NOMBRE-nombre", "NOMBRE");
define("NOMBRE-tipo", "Tipo");
define("NOMBRE-url", "Url pública");
define("NOMBRE-pregunta", "Pregunta");
define("NOMBRE-observaciones", "Observaciones");
define("NOMBRE-value", "Valor");
define("NOMBRE-obligatorio", "Obligatorio");
define("NOMBRE-usuario", "Usuario");
define("NOMBRE-email", "Correo Electrónico");
define("NOMBRE-controller", "Controller");
define("NOMBRE-action", "Action");
define("NOMBRE-descripcion", "Descripción");
define("NOMBRE-fecha", "Fecha");
define("NOMBRE-fechainicio", "Fecha Inicio");
define("NOMBRE-fechafin", "Fecha Fin");

//Tipos de usuario
define("usuario5", "Director");
define("usuario4", "Jefe de Estudios");
define("usuario3", "Secretario");
define("usuario2", "Profesor");

//tipos de envento
define("calendario1", "Evento");
define("calendario2", "No lectivo");

//tipos de parte
define("PARTE1", "Leve");
define("PARTE2", "Medio");
define("PARTE3", "Grave");

define(1, "Si");
define(0, "No");

//tipos de error
define("ERROR_entrarsinpermiso", "Intento entrar sin ser propietario");
define("ERROR_intentartrucarformulario", "Intento modificar id formulario");
define("ERROR_encuestanoexiste", "Intento entrar encuesta no existente");
define("ERROR_trucarget", "Intento modificar controller o action a partir del GET.");