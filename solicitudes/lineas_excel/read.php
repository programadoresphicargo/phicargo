<?php

// Incluir el autoloader de Composer
require '../../vendor/autoload.php';
require '../../odoo/odoo-conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Obtener la ubicación temporal del archivo cargado
$archivo_temporal = $_FILES['archivo']['tmp_name'];

// Cargar el archivo de Excel desde la ubicación temporal
$spreadsheet = IOFactory::load($archivo_temporal);

// Seleccionar la primera hoja del libro de trabajo
$sheet = $spreadsheet->getActiveSheet();

// Definir un array para almacenar los errores
$errores = [];

// Iterar sobre las filas y columnas para leer los datos y realizar comprobaciones
foreach ($sheet->getRowIterator() as $row) {
    // Obtener el número de fila
    $fila = $row->getRowIndex();

    // Evitar realizar comprobaciones en la primera fila (encabezados)
    if ($fila === 1) {
        continue;
    }

    // Obtener los valores de las celdas de la fila
    $valores_fila = [];
    foreach ($row->getCellIterator() as $cell) {
        $valores_fila[] = $cell->getValue();
    }

    // Realizar comprobaciones por cada columna (cambia el índice según tus necesidades)
    // Aquí se muestra un ejemplo de comprobación para la columna A (índice 0)

    $valor_columna_B = $valores_fila[1];
    if (empty($valor_columna_B) || !is_numeric($valor_columna_B) || $valor_columna_B != (int)$valor_columna_B) {
        $errores[] = "Error en la fila $fila: El valor en la columna B debe ser un número entero y no puede ser nulo o vacío.";
    } else {
        $kwargs = ['fields' => ['id', 'code', 'name']];

        $partners =
            $models->execute_kw(
                $db,
                $uid,
                $password,
                'sat.producto',
                'search_read',
                array(array(array('code', '=', $valor_columna_B))),
                $kwargs
            );

        $json = json_encode($partners, true);
        $decoded_array = json_decode($json, true);
        if (!empty($decoded_array)) {
            foreach ($decoded_array as $item) {
                $clave_producto_sat = $item['id'];
            }
        } else {
            $errores[] = "Error en la fila $fila:, clave: $valor_columna_B invalida.";
        }
    }

    $valor_columna_C = $valores_fila[2];
    if (empty($valor_columna_C) || !is_numeric($valor_columna_C)) {
        $errores[] = "Error en la fila $fila: El valor en la columna C debe ser un número entero o decimal y no puede ser nulo o vacío.";
    }

    $valor_columna_D = $valores_fila[3];
    if (empty($valor_columna_D)) {
        $errores[] = "Error en la fila $fila: El valor en la columna D no puede estar vacío.";
    } elseif (strpos($valor_columna_D, ' ') !== false) {
        $errores[] = "Error en la fila $fila: El valor en la columna D no puede contener espacios en blanco.";
    } else {
        $kwargs = ['fields' => ['id', 'code', 'name']];

        $partners =
            $models->execute_kw(
                $db,
                $uid,
                $password,
                'sat.udm',
                'search_read',
                array(array(array('code', '=', $valor_columna_D))),
                $kwargs
            );

        $json = json_encode($partners, true);
        $decoded_array = json_decode($json, true);
        if (!empty($decoded_array)) {
            foreach ($decoded_array as $item) {
                $clave_udm_sat = $item['id'];
            }
        } else {
            $errores[] = "Error en la fila $fila:, clave: $valor_columna_D invalida.";
        }
    }

    $valor_columna_E = $valores_fila[4];
    if (empty($valor_columna_E)) {
        $errores[] = "Error en la fila $fila: El valor en la columna E no puede estar vacío.";
    } elseif (!is_numeric($valor_columna_E)) {
        $errores[] = "Error en la fila $fila: El valor en la columna E debe ser un número.";
    }

    $valor_columna_F = $valores_fila[5];
    if (empty($valor_columna_F)) {
        $errores[] = "Error en la fila $fila: El valor en la columna F no puede estar vacío.";
    } elseif (strcasecmp($valor_columna_F, "sí") !== 0 && strcasecmp($valor_columna_F, "no") !== 0) {
        $errores[] = "Error en la fila $fila: El valor en la columna F debe ser 'sí' o 'no'.";
    }

    $valor_columna_F = $valores_fila[5];
    $valor_columna_G = $valores_fila[6];

    // Comprobar si la columna G cumple con las condiciones
    if (strcasecmp($valor_columna_F, "Sí") === 0) {
        // Si el valor en la columna F es "sí", entonces la columna G no puede estar vacía y debe ser un número entero
        if (empty($valor_columna_G)) {
            $errores[] = "Error en la fila $fila: El valor en la columna G no puede estar vacío si la columna F es 'sí'.";
        } elseif (!is_numeric($valor_columna_G) || $valor_columna_G != (int)$valor_columna_G) {
            $errores[] = "Error en la fila $fila: El valor en la columna G debe ser un número entero si la columna F es 'sí'.";
        } else {
            $kwargs = ['fields' => ['id', 'code', 'name']];
            $valor_formateado = str_pad($valor_columna_G, 4, "0", STR_PAD_LEFT);

            $partners =
                $models->execute_kw(
                    $db,
                    $uid,
                    $password,
                    'waybill.materiales.peligrosos',
                    'search_read',
                    array(array(array('code', '=', $valor_formateado))),
                    $kwargs
                );

            $json = json_encode($partners, true);
            $decoded_array = json_decode($json, true);
            if (!empty($decoded_array)) {
                foreach ($decoded_array as $item) {
                    $clave_material_peligroso = $item['id'];
                }
            } else {
                $errores[] = "Error en la fila $fila:, clave: $valor_columna_G invalida.";
            }
        }
    } elseif (strcasecmp($valor_columna_F, "no") === 0) {
        // Si el valor en la columna F es "no", entonces la columna G debe estar vacía
        if (!empty($valor_columna_G)) {
            $errores[] = "Error en la fila $fila: El valor en la columna G debe estar vacío si la columna F es 'no'.";
        }
    } else {
        // Si el valor en la columna F no es ni "sí" ni "no", generamos un error
        $errores[] = "Error en la fila $fila: El valor en la columna F debe ser 'sí' o 'no'.";
    }

    $valor_columna_H = $valores_fila[7];

    if (!empty($valor_columna_H)) {

        $kwargs = ['fields' => ['id', 'code', 'name']];

        $partners =
            $models->execute_kw(
                $db,
                $uid,
                $password,
                'waybill.tipo.embalaje',
                'search_read',
                array(array(array('code', '=', $valor_columna_H))),
                $kwargs
            );

        $json = json_encode($partners, true);
        $decoded_array = json_decode($json, true);
        if (!empty($decoded_array)) {
            foreach ($decoded_array as $item) {
                $tipo_embalaje = $item['id'];
            }
        } else {
            $errores[] = "Error en la fila $fila:, clave: $valor_columna_H invalida.";
        }
    }

    $datos_fila = [];

    if (empty($errores)) {
        $datos_fila['descripcion_mercancia'] = $valores_fila[0];
        $datos_fila['clave_producto_sat'] = [$clave_producto_sat, $valores_fila[1]];
        $datos_fila['cantidad'] = $valores_fila[2];
        $datos_fila['clave_udm_sat'] = [$clave_udm_sat, $valores_fila[3]];
        $datos_fila['peso_kg'] = $valores_fila[4];
        $datos_fila['material_peligroso'] = [$valores_fila[5], $valores_fila[5]];
        $datos_fila['clave_material_peligroso'] = [$clave_material_peligroso, $valores_fila[6]];
        $datos_fila['tipo_embalaje'] = [$tipo_embalaje, $valores_fila[7]];
        $datos_fila['dimensiones'] = $valores_fila[8];

        $datos_json[] = $datos_fila;
    }
}

// Imprimir los errores encontrados
if (!empty($errores)) {
    echo "Se encontraron los siguientes errores:\n";
    echo "<ul class='list-pointer list-pointer-primary'>";
    foreach ($errores as $error) {
        echo "<li class='list-pointer-item'>$error</li>";
    }
    echo "</ul>";
} else {
    $json_final = json_encode($datos_json, JSON_PRETTY_PRINT);
    echo $json_final;
}
