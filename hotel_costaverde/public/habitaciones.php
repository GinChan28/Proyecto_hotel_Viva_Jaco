<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$habitaciones = [];
$message = '';

if ($connection) {
    $sql = 'SELECT ID_HABITACION, NUMERO, TIPO, PRECIO_POR_NOCHE, CAPACIDAD, ESTADO FROM HABITACIONES ORDER BY ID_HABITACION';
    $statement = oci_parse($connection, $sql);
    oci_execute($statement);
    while ($row = oci_fetch_assoc($statement)) {
        $habitaciones[] = $row;
    }
    oci_free_statement($statement);
    oci_close($connection);
} else {
    $message = 'No se pudo conectar a Oracle para cargar las habitaciones.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <h1 class="section-title">Habitaciones</h1>
        <p class="text-muted mb-4">Descubre nuestras opciones diseñadas para ofrecer confort, sofisticación y vistas únicas.</p>
        <?php if ($message): ?><div class="alert alert-warning"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <div class="row g-4">
            <?php foreach ($habitaciones as $habitacion): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm card-hover">
                        <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Habitación">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($habitacion['TIPO']) ?> <?= htmlspecialchars($habitacion['NUMERO']) ?></h5>
                            <p class="text-muted mb-2">Capacidad: <?= (int) $habitacion['CAPACIDAD'] ?> personas</p>
                            <p class="text-muted mb-2">Estado: <?= htmlspecialchars($habitacion['ESTADO']) ?></p>
                            <p class="fw-bold text-primary">₡<?= number_format((float) $habitacion['PRECIO_POR_NOCHE'], 0, '.', ',') ?> / noche</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
