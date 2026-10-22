<?php
    define('NOMBRE_CENTRO', 'CIFP Carlos III');
    $ciclos = ['DAW', 'DAM', 'ASIR'];
    $curriculos = [
        ['alumno' => 'Ana López',    'ciclo' => 'DAW',  'video' => 'https://youtu.be/curriculo1'],
        ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAM',  'video' => 'https://youtu.be/curriculo2'],
        ['alumno' => 'Laura García', 'ciclo' => 'ASIR', 'video' => 'https://youtu.be/curriculo3'],
        ['alumno' => 'Daniel Lopez', 'ciclo' => 'DAW', 'video' => 'https://youtu.be/curriculo3'],
    ];

    function mostrarCurriculo(array $curriculo) {
        echo '<li>', $curriculo['alumno'], ' — ', $curriculo['ciclo'],
        ' — <a href="', $curriculo['video'], '">vídeo</a></li>';
    }

    echo '<h1>', NOMBRE_CENTRO, ' — Currículos</h1>';
    echo '<ul>';
    mostrarCurriculo($curriculos[0]);
    mostrarCurriculo($curriculos[1]);
    mostrarCurriculo($curriculos[2]);
    mostrarCurriculo($curriculos[3]);
    echo '</ul>';
?>