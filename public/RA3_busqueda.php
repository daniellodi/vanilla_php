<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA3_funciones.php';
    require_once __DIR__ . '/../src/RA3_formularios.php';

    $curriculos = [
        ['alumno' => 'Ana López',    'ciclo' => 'DAW',  'video' => 'https://youtu.be/curriculo1'],
        ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAM',  'video' => 'https://youtu.be/curriculo2'],
        ['alumno' => 'Laura García', 'ciclo' => 'ASIR', 'video' => 'https://youtu.be/curriculo3'],
        ['alumno' => 'Pablo Ruiz',   'ciclo' => 'DAW',  'video' => ''],
    ];

    $ciclo = trim($_GET['ciclo'] ?? '');
    $resultados = $ciclo === '' ? $curriculos : curriculosDeCiclo($curriculos, $ciclo);
    ?>
    <form action="RA3_busqueda.php" method="get">
    <label>Ciclo <input name="ciclo" value="<?= e($ciclo) ?>"></label>
    <button type="submit">Buscar</button>
    </form>

    <?php if ($ciclo !== ''): ?>
    <p>Resultados para: <?= e($ciclo) ?></p>
    <?php endif; ?>
    <ul>
    <?php foreach ($resultados as $curriculo): ?>
        <li class="curriculo"><?= e($curriculo['alumno']) ?> — <?= e($curriculo['ciclo']) ?></li>
    <?php endforeach; ?>
    </ul>