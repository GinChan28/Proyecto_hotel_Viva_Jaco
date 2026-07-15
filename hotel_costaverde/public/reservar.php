<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$roomMessage = null;

if ($connection) {
    $sql = "SELECT ID_HABITACION, NUMERO, TIPO, PRECIO_POR_NOCHE, CAPACIDAD, ESTADO FROM HABITACIONES WHERE ESTADO = :estado ORDER BY ID_HABITACION";
    $statement = oci_parse($connection, $sql);
    $estado = 'DISPONIBLE';
    oci_bind_by_name($statement, ':estado', $estado);
    oci_execute($statement);

    $rooms = [];
    while ($row = oci_fetch_assoc($statement)) {
        $rooms[] = $row;
    }

    oci_free_statement($statement);
    oci_close($connection);
} else {
    $rooms = [];
    $roomMessage = 'No se pudo conectar a Oracle. Verifique la configuración del listener y credenciales.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <h1 class="section-title">Reservar</h1>
        <p class="text-muted mb-4">Consulta las habitaciones disponibles directamente desde Oracle mediante OCI8.</p>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold">Buscar estancia</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Fecha de entrada</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de salida</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Personas</label>
                            <select class="form-select">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4+</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold">Habitaciones disponibles</h4>
                    <?php if ($roomMessage): ?>
                        <div class="alert alert-warning"><?= htmlspecialchars($roomMessage) ?></div>
                    <?php elseif (!empty($rooms)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Número</th>
                                        <th>Tipo</th>
                                        <th>Capacidad</th>
                                        <th>Precio/noche</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rooms as $room): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($room['ID_HABITACION']) ?></td>
                                            <td><?= htmlspecialchars($room['NUMERO']) ?></td>
                                            <td><?= htmlspecialchars($room['TIPO']) ?></td>
                                            <td><?= htmlspecialchars($room['CAPACIDAD']) ?></td>
                                            <td>$<?= number_format((float) $room['PRECIO_POR_NOCHE'], 2, '.', ',') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No se encontraron habitaciones disponibles.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
