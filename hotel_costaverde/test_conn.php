<?php
require 'c:/xampp/htdocs/hotel_costaverde/config/conexion.php';
$conn = getOracleConnection();
if ($conn) {
    echo 'CONNECTED';
    oci_close($conn);
} else {
    echo 'FAILED';
}
