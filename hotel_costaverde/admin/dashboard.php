<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdminLogin();

$connection = getOracleConnection();
$stats = [
    'clientes' => 0,
    'habitaciones' => 0,
    'reservas' => 0,
    'usuarios' => 0,
];

if ($connection) {
    $queries = [
        'clientes' => 'SELECT COUNT(*) AS total FROM CLIENTES',
        'habitaciones' => 'SELECT COUNT(*) AS total FROM HABITACIONES',
        'reservas' => 'SELECT COUNT(*) AS total FROM RESERVAS',
        'usuarios' => 'SELECT COUNT(*) AS total FROM USUARIOS',
    ];

    foreach ($queries as $key => $sql) {
        $statement = oci_parse($connection, $sql);
        oci_execute($statement);
        $row = oci_fetch_assoc($statement);
        $stats[$key] = (int) ($row['TOTAL'] ?? 0);
        oci_free_statement($statement);
    }
    oci_close($connection);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-lg-2 sidebar p-3">
                <h4 class="text-white fw-bold mb-4">Costa Verde</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="habitaciones.php">Habitaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservas.php">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="empleados.php">Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </aside>
            <main class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">Dashboard</h2>
                        <p class="text-muted mb-0">Resumen general del hotel.</p>
                    </div>
                    <span class="status-badge">Administrador</span>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Clientes</h6>
                                <h3 class="fw-bold"><?= $stats['clientes'] ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Habitaciones</h6>
                                <h3 class="fw-bold"><?= $stats['habitaciones'] ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Reservas</h6>
                                <h3 class="fw-bold"><?= $stats['reservas'] ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Usuarios</h6>
                                <h3 class="fw-bold"><?= $stats['usuarios'] ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
