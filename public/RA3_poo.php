<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/Curriculo.php';

    $daw = new Ciclo(1, 'DAW', 'Desarrollo de Aplicaciones Web', Ciclo::GRADO_SUPERIOR);
    $curriculo = new Curriculo(1, 'Ana López', $daw, 'https://youtu.be/curriculo1');

    $mismoCurriculo = $curriculo;   // no es una copia: es el mismo objeto
    ?>
    <h1><?= $daw->descripcion() ?></h1> <!--Desarrollo de Aplicaciones Web-->
    <p>Titulación: <?= $daw->titulacion() ?></p> <!--Tecnico Superior-->
    <p><?= $curriculo->descripcion() ?>:<!--Ana - DAW--> <?= $curriculo->estaPublicado() ? 'publicado' : 'en borrador' ?><!--publicado--></p>
                                                                                                          