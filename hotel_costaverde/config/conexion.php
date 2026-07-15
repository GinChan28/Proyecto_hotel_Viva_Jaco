<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$oracleConfig = [
    'host' => 'localhost',
    'port' => 15211,
    'sid' => 'XE',
    'username' => 'hotel_verde',
    'password' => 'CostaVerde2026'
];

function getOracleConnection($throwOnError = false)
{
    global $oracleConfig;

    $connectString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$oracleConfig['host']})(PORT={$oracleConfig['port']}))(CONNECT_DATA=(SID={$oracleConfig['sid']})))";

    $connection = @oci_connect($oracleConfig['username'], $oracleConfig['password'], $connectString, 'AL32UTF8');

    if (!$connection) {
        $error = oci_error();
        if ($throwOnError) {
            throw new Exception($error['message'] ?? 'No se pudo conectar a Oracle.');
        }
        return null;
    }

    return $connection;
}

function getOracleErrorMessage($error)
{
    if (is_array($error) && isset($error['message'])) {
        return $error['message'];
    }

    return 'Error inesperado en la conexión a Oracle.';
}

function getTableColumns($connection, $tableName)
{
    $sql = "SELECT column_name FROM user_tab_columns WHERE table_name = :table_name ORDER BY column_id";
    $statement = oci_parse($connection, $sql);
    $name = strtoupper($tableName);
    oci_bind_by_name($statement, ':table_name', $name);
    oci_execute($statement);

    $columns = [];
    while ($row = oci_fetch_assoc($statement)) {
        $columns[] = strtoupper($row['COLUMN_NAME']);
    }

    oci_free_statement($statement);
    return $columns;
}

function getPrimaryKeyColumn($connection, $tableName)
{
    $sql = "
        SELECT cc.column_name
        FROM user_constraints c
        JOIN user_cons_columns cc ON c.constraint_name = cc.constraint_name
        WHERE c.table_name = :table_name
          AND c.constraint_type = 'P'
        ORDER BY cc.position
    ";

    $statement = oci_parse($connection, $sql);
    $name = strtoupper($tableName);
    oci_bind_by_name($statement, ':table_name', $name);
    oci_execute($statement);

    $row = oci_fetch_assoc($statement);
    oci_free_statement($statement);

    return $row ? strtoupper($row['COLUMN_NAME']) : null;
}

function tableExists($connection, $tableName)
{
    $sql = "SELECT COUNT(*) AS total FROM user_tables WHERE table_name = :table_name";
    $statement = oci_parse($connection, $sql);
    $name = strtoupper($tableName);
    oci_bind_by_name($statement, ':table_name', $name);
    oci_execute($statement);

    $row = oci_fetch_assoc($statement);
    oci_free_statement($statement);

    return isset($row['TOTAL']) && (int) $row['TOTAL'] > 0;
}
