<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA3_formularios.php';

    $datos   = [];
    $errores = [];
    $enviado = $_SERVER['REQUEST_METHOD'] === 'POST';

    if ($enviado) {
        $datos   = $_POST;
        $errores = validarCiclo($datos);
    }
    ?>
    <h1>Alta de ciclo</h1>

    <?php if ($enviado && $errores === []): ?>
    <p class="exito">Ciclo dado de alta: <?= e($datos['codCiclo']) ?> — <?= e($datos['nombre']) ?></p>
    <?php else: ?>
    <?php if ($errores !== []): ?>
    <ul class="errores">
    <?php foreach ($errores as $error): ?>
        <li><?= e($error) ?></li>
    <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form action="RA3_altaCiclo.php" method="post">
        <label>Código <input name="codCiclo" value="<?= e($datos['codCiclo'] ?? '') ?>"></label>
        <label>Nombre <input name="nombre" value="<?= e($datos['nombre'] ?? '') ?>"></label>
        <label>Grado
            <select name="grado">
                <?php foreach (['Medio', 'Superior'] as $grado): ?>
                <option value="<?= $grado ?>" <?= ($datos['grado'] ?? '') === $grado ? 'selected' : '' ?>><?= $grado ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Horas <input name="horas" type="number" value="<?= e($datos['horas'] ?? '') ?>"></label>
        <button type="submit">Dar de alta</button>
    </form>
<?php endif; ?>