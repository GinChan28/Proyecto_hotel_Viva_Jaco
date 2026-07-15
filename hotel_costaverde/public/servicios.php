<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$servicios = [];
$message = '';

if ($connection) {
    $sql = 'SELECT ID_SERVICIO, NOMBRE, PRECIO FROM SERVICIOS ORDER BY ID_SERVICIO';
    $statement = oci_parse($connection, $sql);
    oci_execute($statement);
    while ($row = oci_fetch_assoc($statement)) {
        $servicios[] = $row;
    }
    oci_free_statement($statement);
    oci_close($connection);
} else {
    $message = 'No se pudo conectar a Oracle para cargar los servicios.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <h1 class="section-title">Servicios</h1>
        <p class="text-muted mb-4">Disfruta de una experiencia completa con servicios pensados para tu comodidad.</p>
        <?php if ($message): ?><div class="alert alert-warning"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <div class="row g-4">
            <?php foreach ($servicios as $servicio): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($servicio['NOMBRE']) ?></h5>
                            <p class="card-text text-muted">Servicio disponible para tus huéspedes con precios especiales.</p>
                            <p class="fw-bold text-primary">₡<?= number_format((float) $servicio['PRECIO'], 0, '.', ',') ?></p>
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
