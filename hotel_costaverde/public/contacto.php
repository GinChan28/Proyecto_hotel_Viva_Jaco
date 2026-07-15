<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$hotel = null;
$message = '';

if ($connection) {
    $sql = 'SELECT NOMBRE, DIRECCION, CIUDAD, PAIS, TELEFONO, EMAIL FROM HOTEL WHERE ROWNUM = 1';
    $statement = oci_parse($connection, $sql);
    oci_execute($statement);
    $hotel = oci_fetch_assoc($statement);
    oci_free_statement($statement);
    oci_close($connection);
} else {
    $message = 'No se pudo conectar a Oracle para cargar los datos del hotel.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-5" style="padding-top: 7rem !important;">
        <div class="row g-5">
            <div class="col-lg-6">
                <h1 class="section-title">Contacto</h1>
                <p class="text-muted">Estamos listos para ayudarte con tu reserva o cualquier consulta.</p>
                <?php if ($message): ?><div class="alert alert-warning"><?= htmlspecialchars($message) ?></div><?php endif; ?>
                <?php if ($hotel): ?>
                    <ul class="list-unstyled text-muted">
                        <li><strong>Hotel:</strong> <?= htmlspecialchars($hotel['NOMBRE']) ?></li>
                        <li><strong>Email:</strong> <?= htmlspecialchars($hotel['EMAIL']) ?></li>
                        <li><strong>Teléfono:</strong> <?= htmlspecialchars($hotel['TELEFONO']) ?></li>
                        <li><strong>Dirección:</strong> <?= htmlspecialchars($hotel['DIRECCION']) ?>, <?= htmlspecialchars($hotel['CIUDAD']) ?>, <?= htmlspecialchars($hotel['PAIS']) ?></li>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mensaje</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
