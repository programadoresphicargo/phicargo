<?php
session_start();
$titulo = 'Maniobras';
require_once('getManiobra.php');
require_once('modal_iniciar.php');
require_once('modal_finalizar.php');
require_once('modal_asignar_mr.php');
require_once('modal_asignar_mi.php');
require_once('../status/modal_status.php');
require_once('contenido.php');
require_once('../funciones/funciones.php');
require_once('../correos/modal.php');
require_once('vista_archivos.php');
require_once('../correos/modal_registro.php');
