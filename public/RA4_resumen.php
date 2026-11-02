<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA4_comun.php';
    require_once __DIR__ . '/../src/RA4_depuracion.php';

    $ciclos = catalogoCiclos();
    $curriculos = [
        new Curriculo(1, 'Ana López', $ciclos['DAW'], 'https://youtu.be/curriculo1'),
        new Curriculo(2, 'Marcos Pérez', $ciclos['DAM'], 'https://youtu.be/curriculo2'),
        new Curriculo(3, 'Laura García', $ciclos['ASIR'], 'https://youtu.be/curriculo3'),
        new Curriculo(4, 'Lucía Martín', $ciclos['DAW']),
    ];

    $cuenta = contarPorCiclo($curriculos);
    $total  = count($curriculos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resumen — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Currículos por ciclo</h1>
<ul>
    <?php foreach ($cuenta as $codigo => $numero): ?>
    <li><?= e($codigo) ?>: <?= $numero ?> (<?= porcentaje($numero, $total) ?> %)</li>
    <?php endforeach; ?>
</ul>
<p>Total: <?= $total ?> currículos.</p>
</body>
</html>