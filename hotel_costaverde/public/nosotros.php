<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$hotel = null;

if ($connection) {
    $sql = 'SELECT NOMBRE, DIRECCION, CIUDAD, PAIS, TELEFONO, EMAIL FROM HOTEL WHERE ROWNUM = 1';
    $statement = oci_parse($connection, $sql);
    oci_execute($statement);
    $hotel = oci_fetch_assoc($statement);
    oci_free_statement($statement);
    oci_close($connection);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h1 class="section-title">Nosotros</h1>
                <p class="text-muted"><?= htmlspecialchars($hotel['NOMBRE'] ?? 'Hotel Costa Verde') ?> nace con la idea de ofrecer una experiencia inolvidable donde el confort, la naturaleza y el servicio se fusionan.</p>
                <p class="text-muted">Nuestra ubicación en <?= htmlspecialchars($hotel['CIUDAD'] ?? 'la costa') ?> y nuestro compromiso con una atención de calidad convierten cada estancia en un momento especial para viajeros, familias y parejas.</p>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold">Nuestro compromiso</h4>
                    <ul class="text-muted mt-3">
                        <li>Atención personalizada</li>
                        <li>Ambientes elegantes y modernos</li>
                        <li>Ubicación privilegiada en <?= htmlspecialchars($hotel['CIUDAD'] ?? 'la región') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
