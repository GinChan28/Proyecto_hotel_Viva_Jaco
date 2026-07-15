<?php
$pages = [
    ['Inicio', 'index.php'],
    ['Habitaciones', 'habitaciones.php'],
    ['Servicios', 'servicios.php'],
    ['Galería', 'galeria.php'],
    ['Nosotros', 'nosotros.php'],
    ['Contacto', 'contacto.php'],
    ['Reservar', 'reservar.php'],
];
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-transparent fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">Hotel Costa Verde</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($pages as $page): ?>
                    <?php $slug = basename($page[1]); ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $slug === $currentPage ? 'active fw-semibold' : '' ?>" href="<?= $page[1] ?>"><?= $page[0] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
