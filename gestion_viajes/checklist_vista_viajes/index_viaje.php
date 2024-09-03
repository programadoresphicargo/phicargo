<?php
if (isset($_GET['id_viaje'])) {
    $titulo = $_GET['id_viaje'];
    $id_viaje = $_GET['id_viaje'];
    require_once('../../includes2/head2.php');
    require_once('contenido_viaje.php');
    require_once('../../includes2/footer.php');
    require_once('funciones2.php');
} else {
    $titulo = $_POST['id_viaje'];
    $id_viaje = $_POST['id_viaje'];
    require_once('contenido_viaje.php');
    require_once('funciones2.php');
}
