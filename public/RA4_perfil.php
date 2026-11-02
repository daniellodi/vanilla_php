<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA4_comun.php';

    iniciarSesion();
    $usuario = exigirLogin();

    $mensaje = $_SESSION['mensaje'] ?? null;
    unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi área — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Mi área</h1>

<?php if ($mensaje !== null): ?>
    <p class="exito"><?= e($mensaje) ?></p>
<?php endif; ?>

<p>Usuario: <?= e($usuario['firstName'] . ' ' . $usuario['lastName']) ?></p>
<p>Email: <?= e($usuario['email']) ?></p>
<p>Rol: <?= e($usuario['rol']) ?></p>

<form action="RA4_logout.php" method="post">
    <button type="submit">Cerrar sesión</button>
</form>
<?php if ($usuario['rol'] === 'alumno'): ?>
<p><a href="RA4_miCurriculo.php">Mi currículo</a></p>
<?php endif; ?>
</body>
</html>