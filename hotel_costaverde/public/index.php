<?php
require_once __DIR__ . '/../config/conexion.php';

$connection = getOracleConnection();
$hotel = null;
$habitaciones = [];

if ($connection) {
    $hotelSql = 'SELECT NOMBRE, CIUDAD, PAIS, TELEFONO, EMAIL FROM HOTEL WHERE ROWNUM = 1';
    $hotelStmt = oci_parse($connection, $hotelSql);
    oci_execute($hotelStmt);
    $hotel = oci_fetch_assoc($hotelStmt);
    oci_free_statement($hotelStmt);

    $roomSql = 'SELECT ID_HABITACION, NUMERO, TIPO, PRECIO_POR_NOCHE, CAPACIDAD, ESTADO FROM HABITACIONES WHERE ESTADO = :estado ORDER BY ID_HABITACION';
    $roomStmt = oci_parse($connection, $roomSql);
    $estado = 'Disponible';
    oci_bind_by_name($roomStmt, ':estado', $estado);
    oci_execute($roomStmt);
    while ($row = oci_fetch_assoc($roomStmt)) {
        $habitaciones[] = $row;
    }
    oci_free_statement($roomStmt);
    oci_close($connection);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Costa Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <section class="hero-section">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="overlay-card p-4 p-lg-5">
                        <p class="text-uppercase small fw-semibold mb-3">Escapada de lujo en la costa</p>
                        <h1 class="display-4 fw-bold mb-3">Tu reserva ideal comienza aquí</h1>
                        <p class="lead mb-4">Disfruta de habitaciones elegantes, paisajes espectaculares y un servicio impecable en <?= htmlspecialchars($hotel['NOMBRE'] ?? 'Hotel Costa Verde') ?>.</p>
                        <a href="reservar.php" class="btn btn-warning text-dark fw-semibold px-4">Reservar ahora</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="overlay-card p-4">
                        <h4 class="fw-bold mb-3">Busca tu estadía</h4>
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
                                <label class="form-label">Cantidad de personas</label>
                                <select class="form-select">
                                    <option>1 persona</option>
                                    <option>2 personas</option>
                                    <option>3 personas</option>
                                    <option>4+ personas</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-light w-100 fw-semibold">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="container py-5">
        <section class="mb-5">
            <h2 class="section-title">Habitaciones destacadas</h2>
            <div class="row g-4">
                <?php foreach (array_slice($habitaciones, 0, 3) as $habitacion): ?>
                    <div class="col-md-4">
                        <div class="card h-100 card-hover border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Habitación">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($habitacion['TIPO']) ?> <?= htmlspecialchars($habitacion['NUMERO']) ?></h5>
                                <p class="card-text text-muted">Capacidad: <?= (int) $habitacion['CAPACIDAD'] ?> personas · Estado: <?= htmlspecialchars($habitacion['ESTADO']) ?></p>
                                <p class="fw-bold text-primary">₡<?= number_format((float) $habitacion['PRECIO_POR_NOCHE'], 0, '.', ',') ?> / noche</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
