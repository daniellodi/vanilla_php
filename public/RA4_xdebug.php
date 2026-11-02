<?php
declare(strict_types=1);
?>
<p>Xdebug: <?= extension_loaded('xdebug') ? 'cargado' : 'no cargado' ?></p>
<p>Modo: <?= ini_get('xdebug.mode') ?: '(ninguno)' ?></p>
<p>Inicio de la depuración: <?= ini_get('xdebug.start_with_request') ?: '(no definido)' ?></p>