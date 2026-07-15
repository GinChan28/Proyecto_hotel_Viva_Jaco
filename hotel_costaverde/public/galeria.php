<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$hotel = null;

if ($connection) {
    $sql = 'SELECT NOMBRE, CIUDAD FROM HOTEL WHERE ROWNUM = 1';
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
    <title>Galería - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <h1 class="section-title">Galería</h1>
        <p class="text-muted mb-4">Un vistazo a los espacios, detalles y paisajes que hacen especial nuestra experiencia en <?= htmlspecialchars($hotel['NOMBRE'] ?? 'Hotel Costa Verde') ?>.</p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded shadow-sm" alt="Habitación principal">
            </div>
            <div class="col-md-6 col-lg-4">
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded shadow-sm" alt="Suite deluxe">
            </div>
            <div class="col-md-6 col-lg-4">
                <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded shadow-sm" alt="Zona común">
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
