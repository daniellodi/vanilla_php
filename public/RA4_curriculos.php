<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/RA4_comun.php';

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

$validador = new ValidadorCurriculo(catalogoCiclos());

// Reconstruimos cada currículo de la sesión; su id es su posición + 1.
$curriculos = [];
foreach ($_SESSION['curriculos'] ?? [] as $posicion => $datos) {
    $curriculos[] = $validador->crearCurriculo($datos, $posicion + 1);
}

// Mensaje flash: se muestra una vez y se borra de la sesión.
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Currículos — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Currículos</h1>

<?php if ($mensaje !== null): ?>
    <p class="exito"><?= e($mensaje) ?></p>
<?php endif; ?>

<?php if ($curriculos === []): ?>
    <p>Todavía no has dado de alta ningún currículo.</p>
<?php else: ?>
    <ul>
    <?php foreach ($curriculos as $curriculo): ?>
        <li>
        <?= e($curriculo->id . '. ' . $curriculo->descripcion()) ?>
        <?php if ($curriculo->videoCurriculum !== null): ?>
            — <a href="<?= e($curriculo->videoCurriculum) ?>">ver vídeo</a>
        <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="RA4_altaCurriculo.php">Dar de alta un currículo</a></p>
</body>
</html>