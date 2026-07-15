<?php
require 'c:/xampp/htdocs/hotel_costaverde/config/conexion.php';
$conn = getOracleConnection();
if ($conn) {
    $sql = 'SELECT COUNT(*) AS total FROM HABITACIONES';
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    echo $row['TOTAL'];
    oci_free_statement($stmt);
    oci_close($conn);
} else {
    echo 'FAILED';
}
