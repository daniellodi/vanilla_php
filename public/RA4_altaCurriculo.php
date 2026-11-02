<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/RA4_comun.php';

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

$ciclos    = catalogoCiclos();
$validador = new ValidadorCurriculo($ciclos);
$datos     = [];
$errores   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos   = $_POST;
    $errores = $validador->validar($datos);

    if ($errores === []) {
        $curriculos = $_SESSION['curriculos'] ?? [];
        $curriculo  = $validador->crearCurriculo($datos, count($curriculos) + 1);

        // En la sesión guardamos los datos, no el objeto: el listado lo reconstruirá.
        $curriculos[] = [
            'alumno' => $curriculo->alumno,
            'ciclo'  => $curriculo->ciclo->codCiclo,
            'video'  => $curriculo->videoCurriculum ?? '',
        ];
        $_SESSION['curriculos'] = $curriculos;
        $_SESSION['mensaje']    = 'Currículo dado de alta: ' . $curriculo->descripcion();

        // Recordamos el ciclo elegido durante 30 días para proponerlo la próxima vez.
        setcookie('ultimo_ciclo', $curriculo->ciclo->codCiclo, [
            'expires'  => time() + 60 * 60 * 24 * 30,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        // POST/Redirect/GET: el navegador pedirá el listado con GET.
        header('Location: RA4_curriculos.php', true, 303);
        exit;
    }
}

// Ciclo que aparece elegido: el que se acaba de enviar o, si no, el de la cookie.
$cicloElegido = $datos['ciclo'] ?? $_COOKIE['ultimo_ciclo'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alta de currículo — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Alta de currículo</h1>

<?php if ($errores !== []): ?>
    <ul class="errores">
    <?php foreach ($errores as $error): ?>
        <li><?= e($error) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="RA4_altaCurriculo.php" method="post">
    <p>
    <label>Alumno
        <input name="alumno" value="<?= e($datos['alumno'] ?? '') ?>">
    </label>
    </p>
    <p>
    <label>Ciclo
        <select name="ciclo">
        <option value="">— Elige un ciclo —</option>
        <?php foreach ($ciclos as $codigo => $ciclo): ?>
            <option value="<?= e($codigo) ?>" <?= $cicloElegido === $codigo ? 'selected' : '' ?>><?= e($ciclo->descripcion()) ?></option>
        <?php endforeach; ?>
        </select>
    </label>
    </p>
    <p>
    <label>Vídeo de presentación (opcional)
        <input name="video" type="url" value="<?= e($datos['video'] ?? '') ?>">
    </label>
    </p>
    <button type="submit">Dar de alta</button>
</form>

<p><a href="RA4_curriculos.php">Ver los currículos dados de alta</a></p>
</body>
</html>