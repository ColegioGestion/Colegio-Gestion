<?php
defined('PASOINDEX') or exit;

//datos de conexion sql
define("SERVIDORSQL", "localhost");
define("BASEDATOSSQL", "colegiogestion");
define("USUARIOSQL", "root");
define("PASSWORDSQL", "root");

//Email webmaster
define("EMAILWEBMASTER", "webmaster@localhost");
//datos del sitio
define("URLSITIO", "http://localhost/colegiogestion1.0/");

//Estado sitio
//1: Todas las funciones activas y no se muestran errores
//2: Todas las funciones activas y se muestran todos los errores
//3: Todas las funciones desactivadas y no se muestran errores
define("ESTADOSITIO", "2");

//guardar errores log
define("GUARDARLOG", true);

/*
 * Tipos de evento:
 * 1: Evento
 * 2: No lectivo
 * 
 * */