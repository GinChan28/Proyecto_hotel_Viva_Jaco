<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $connection = getOracleConnection();
    if ($connection) {
        $sql = "SELECT ID_USUARIO, NOMBRE, EMAIL, PASSWORD FROM USUARIOS WHERE EMAIL = :email";
        $statement = oci_parse($connection, $sql);
        oci_bind_by_name($statement, ':email', $email);
        oci_execute($statement);
        $user = oci_fetch_assoc($statement);
        oci_free_statement($statement);
        oci_close($connection);

        if ($user && $user['PASSWORD'] === $password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $user['NOMBRE'] ?? $email;
            header('Location: dashboard.php');
            exit;
        }
    }

    $message = 'Credenciales incorrectas.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-3">Panel Administrativo</h2>
                        <p class="text-muted">Ingresa tus credenciales para continuar.</p>
                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
