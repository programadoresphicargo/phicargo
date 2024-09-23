<?php
function insertarCorreos($pdo, $id_maniobra, $correos_ligados)
{
    try {
        $sql_insert = "INSERT INTO maniobras_correos (id_maniobra, id_correo) VALUES (:id_maniobra, :id_correo)";
        $stmt_insert = $pdo->prepare($sql_insert);

        foreach ($correos_ligados as $correo_ligado) {
            $stmt_insert->bindParam(':id_maniobra', $id_maniobra);
            $stmt_insert->bindParam(':id_correo', $correo_ligado['value']);
            $stmt_insert->execute();
        }
    } catch (PDOException $e) {
        echo "Error al insertar: " . $e->getMessage() . "<br>";
    }
}

function eliminarCorreos($pdo, $id_maniobra, $correos_desligados)
{
    try {
        $sql_delete = "DELETE FROM maniobras_correos WHERE id = :id";
        $stmt_delete = $pdo->prepare($sql_delete);

        foreach ($correos_desligados as $correo_desligado) {
            $stmt_delete->bindParam(':id', $correo_desligado['id']);
            $stmt_delete->execute();
        }
    } catch (PDOException $e) {
        echo "Error al eliminar: " . $e->getMessage() . "<br>";
    }
}
