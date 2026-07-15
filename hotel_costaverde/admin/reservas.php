<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdminLogin();

$connection = getOracleConnection();
$message = '';

if ($connection) {
    $sql = "SELECT ID_RESERVA, ID_CLIENTE, ID_HABITACION, FECHA_ENTRADA, FECHA_SALIDA, ESTADO FROM RESERVAS ORDER BY ID_RESERVA";
    $statement = oci_parse($connection, $sql);
    oci_execute($statement);

    $reservas = [];
    while ($row = oci_fetch_assoc($statement)) {
        $reservas[] = $row;
    }

    oci_free_statement($statement);
    oci_close($connection);
} else {
    $reservas = [];
    $message = 'No se pudo conectar a Oracle.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-lg-2 sidebar p-3">
                <h4 class="text-white fw-bold mb-4">Costa Verde</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="habitaciones.php">Habitaciones</a></li>
                    <li class="nav-item"><a class="nav-link active" href="reservas.php">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="empleados.php">Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </aside>
            <main class="col-md-9 col-lg-10 p-4">
                <h2 class="fw-bold mb-3">Reservas</h2>
                <p class="text-muted">CRUD básico de reservas.</p>
                <?php if ($message): ?><div class="alert alert-warning"><?= htmlspecialchars($message) ?></div><?php endif; ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Habitación</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Estado</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservas as $reserva): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reserva['ID_RESERVA']) ?></td>
                                            <td><?= htmlspecialchars($reserva['ID_CLIENTE']) ?></td>
                                            <td><?= htmlspecialchars($reserva['ID_HABITACION']) ?></td>
                                            <td><?= htmlspecialchars($reserva['FECHA_ENTRADA']) ?></td>
                                            <td><?= htmlspecialchars($reserva['FECHA_SALIDA']) ?></td>
                                            <td><?= htmlspecialchars($reserva['ESTADO']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
