<?php
session_start();
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();

$id_solicitud = $_POST['id_solicitud'];
$id_usuario = $_SESSION['userID'];
$x_usuario_creacion = $_SESSION['nombre'];
$x_ejecutivo = $_POST['x_ejecutivo'];
$id_cliente = $_POST['partner_id'];

$departure_address_id = $_POST['departure_address_id'];
$arrival_address_id = $_POST['arrival_address_id'];

$sequence_id = $_POST['sequence_id'];
switch ($sequence_id) {
    case 35;
        $store_id = 1;
        break;
    case 344;
        $store_id = 9;
        break;
    case 187;
        $store_id = 2;
        break;
}
$date_order = $_POST['date_order'];
$expected_date_delivery = $_POST['expected_date_delivery'];

$waybill_category = $_POST['waybill_category'];
$x_reference_owr = $_POST['x_reference_owr'];
$x_tipo_bel = $_POST['x_tipo_bel'];
$x_tipo2_bel = $_POST['x_tipo2_bel'];
$x_modo_bel = $_POST['x_modo_bel'];
$client_order_ref = $_POST['client_order_ref'];
$x_numero_cotizacion = $_POST['x_numero_cotizacion'];
$x_tarifa = $_POST['x_tarifa'];
$x_medida_bel = $_POST['x_medida_bel'];
$x_clase_bel = $_POST['x_clase_bel'];

$x_subcliente_bel = $_POST['x_subcliente_bel'];
$x_contacto_subcliente = $_POST['x_contacto_subcliente'];
$x_telefono_subcliente = $_POST['x_telefono_subcliente'];
$x_correo_subcliente = $_POST['x_correo_subcliente'];
$x_codigo_postal = $_POST['x_codigo_postal'];
$upload_point = $_POST['upload_point'];
$download_point = $_POST['download_point'];
$x_ruta_autorizada = $_POST['x_ruta_autorizada'];
$x_paradas_autorizadas = $_POST['x_paradas_autorizadas'];
$x_reference = $_POST['x_reference'];
$x_ejecutivo_viaje_bel = $_POST['x_ejecutivo_viaje_bel'];

$date_start = $_POST['date_start'];
$x_date_arrival_shed = $_POST['x_date_arrival_shed'];
$x_ruta_destino = $_POST['x_ruta_destino'];
$x_ruta_bel = $_POST['x_ruta_bel'];

$x_nombre_agencia =  $_POST['x_nombre_agencia'];
$x_telefono_aa = $_POST['x_telefono_aa'];
$x_email_aa =  $_POST['x_email_aa'];

$x_nombre_custodios =  $_POST['x_nombre_custodios'];
$x_empresa_custodia = $_POST['x_empresa_custodia'];
$x_datos_unidad =  $_POST['x_datos_unidad'];
$x_telefono_custodios =  $_POST['x_telefono_custodios'];

$x_seguro = isset($_POST['x_seguro']) && $_POST['x_seguro'] !== null ? true : false;
$x_barras_logisticas = isset($_POST['x_barras_logisticas']) && $_POST['x_barras_logisticas'] !== null ? true : false;
$x_almacenaje = isset($_POST['x_almacenaje']) && $_POST['x_almacenaje'] !== null ? true : false;
$x_desconsolidacion = isset($_POST['x_desconsolidacion']) && $_POST['x_desconsolidacion'] !== null ? true : false;
$x_pesaje = isset($_POST['x_pesaje']) && $_POST['x_pesaje'] !== null ? true : false;
$x_reparto = isset($_POST['x_reparto']) && $_POST['x_reparto'] !== null ? true : false;
$x_prueba_covid = isset($_POST['x_prueba_covid']) && $_POST['x_prueba_covid'] !== null ? true : false;
$x_maniobra_carga_descarga = isset($_POST['x_maniobra_carga_descarga']) && $_POST['x_maniobra_carga_descarga'] !== null ? true : false;
$x_fumigacion = isset($_POST['x_fumigacion']) && $_POST['x_fumigacion'] !== null ? true : false;
$x_resguardo = isset($_POST['x_resguardo']) && $_POST['x_resguardo'] !== null ? true : false;
$x_conexion_refrigerado = isset($_POST['x_conexion_refrigerado']) && $_POST['x_conexion_refrigerado'] !== null ? true : false;

$dangerous_cargo = isset($_POST['dangerous_cargo']) && $_POST['dangerous_cargo'] !== null ? true : false;

$x_custodia_bel =  $_POST['x_custodia_bel'];

#transporte internacional
$international_shipping = $_POST['international_shipping'];
$merchandice_country_origin_id = $_POST['merchandice_country_origin_id'];
$tipo_transporte_entrada_salida_id = $_POST['tipo_transporte_entrada_salida_id'];
$shipping_complement_type = $_POST['shipping_complement_type'];
$waybill_pedimento = $_POST['waybill_pedimento'];

$x_epp =  $_POST['x_epp'];
$x_especificaciones_especiales =  $_POST['x_especificaciones_especiales'];

$values = [
    'x_id_usuario_cliente' => $id_usuario,
    'x_usuario_creacion' => $x_usuario_creacion,

    'date_order' => $date_order,
    'expected_date_delivery' => $expected_date_delivery,

    #inicio
    'sequence_id' => $sequence_id,
    'store_id' => $store_id,
    'waybill_category' => $waybill_category,
    'x_reference_owr' => $x_reference_owr,
    'x_tipo_bel' => $x_tipo_bel,
    'x_tipo2_bel' => $x_tipo2_bel,
    'x_modo_bel' => $x_modo_bel,
    'dangerous_cargo' => $dangerous_cargo,
    'x_ejecutivo' => $x_ejecutivo,
    'client_order_ref' => $client_order_ref,
    'x_numero_cotizacion' => $x_numero_cotizacion,
    'x_tarifa' => $x_tarifa,
    'x_medida_bel' => $x_medida_bel,
    'x_clase_bel' => $x_clase_bel,

    #cliente
    'partner_id' => $id_cliente,
    'partner_invoice_id' => $id_cliente,
    'partner_order_id' => $id_cliente,
    'departure_address_id' => $departure_address_id,
    'arrival_address_id' => $arrival_address_id,

    #datos entrega o carga de mercancia
    'date_start' => $date_start,
    'x_date_arrival_shed' => $x_date_arrival_shed,
    'x_subcliente_bel' => $x_subcliente_bel,
    'x_contacto_subcliente' => $x_contacto_subcliente,
    'x_telefono_subcliente' => $x_telefono_subcliente,
    'x_correo_subcliente' => $x_correo_subcliente,
    'x_ruta_destino' => $x_ruta_destino,
    'upload_point' => $upload_point,
    'download_point' => $download_point,
    'x_codigo_postal' => $x_codigo_postal,
    'x_ruta_autorizada' => $x_ruta_autorizada,
    'x_paradas_autorizadas' => $x_paradas_autorizadas,
    'x_reference' => $x_reference,
    'x_ejecutivo_viaje_bel' => $x_ejecutivo_viaje_bel,
    'x_ruta_bel' => $x_ruta_bel,

    #transporte internacional
    'international_shipping' => $international_shipping,
    'merchandice_country_origin_id' => $merchandice_country_origin_id,
    'tipo_transporte_entrada_salida_id' => $tipo_transporte_entrada_salida_id,
    'shipping_complement_type' => $shipping_complement_type,
    'waybill_pedimento' => $waybill_pedimento,

    #agente aduanal
    'x_nombre_agencia' =>  $x_nombre_agencia,
    'x_telefono_aa' => $x_telefono_aa,
    'x_email_aa' =>  $x_email_aa,

    #custodia
    'x_custodia_bel' => $x_custodia_bel,
    'x_nombre_custodios' =>  $x_nombre_custodios,
    'x_empresa_custodia' =>  $x_empresa_custodia,
    'x_telefono_custodios' => $x_telefono_custodios,
    'x_datos_unidad' =>  $x_datos_unidad,

    #servicios adicionales
    'x_almacenaje' => $x_almacenaje,
    'x_barras_logisticas' => $x_barras_logisticas,
    'x_conexion_refrigerado' => $x_conexion_refrigerado,
    'x_desconsolidacion' => $x_desconsolidacion,
    'x_fumigacion' => $x_fumigacion,
    'x_maniobra_carga_descarga' => $x_maniobra_carga_descarga,
    'x_pesaje' => $x_pesaje,
    'x_prueba_covid' => $x_prueba_covid,
    'x_reparto' => $x_reparto,
    'x_resguardo' => $x_resguardo,
    'x_seguro' => $x_seguro,

    #notas
    'x_epp' =>  $x_epp,
    'x_especificaciones_especiales' =>  $x_especificaciones_especiales,

];

if ($id_solicitud != 0) {
    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', [intval($id_solicitud), $values]);
    if (is_array($partners) && array_key_exists('faultCode', $partners)) {
        $response = array(
            'accion' => 'write',
            'status' => 'error',
            'error' => $partners['faultCode'],
        );
        print_r($partners);
    } else {
        $response = array(
            'accion' => 'write',
            'status' => 'correcto',
            'respuesta' => $partners,
        );
    }
} else {
    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'create', [$values]);
    if (is_array($partners) && array_key_exists('faultCode', $partners)) {
        $response = array(
            'accion' => 'create',
            'status' => 'error',
            'error' => $partners['faultCode'],
        );
    } else {
        $response = array(
            'accion' => 'create',
            'status' => 'correcto',
            'respuesta' => $partners,
        );
    }
}

$json_response = json_encode($response);
echo $json_response;
