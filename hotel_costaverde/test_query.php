<?php
require 'c:/xampp/htdocs/hotel_costaverde/config/conexion.php';
$conn = getOracleConnection();
if ($conn) {
    $sql = 'SELECT ID_HABITACION, NUMERO, TIPO, PRECIO_POR_NOCHE, CAPACIDAD, ESTADO FROM HABITACIONES WHERE ESTADO = :estado ORDER BY ID_HABITACION';
    $stmt = oci_parse($conn, $sql);
    $estado = 'DISPONIBLE';
    oci_bind_by_name($stmt, ':estado', $estado);
    oci_execute($stmt);
    $rows = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $rows[] = $row;
    }
    echo count($rows);
    oci_free_statement($stmt);
    oci_close($conn);
} else {
    echo 'FAILED';
}
