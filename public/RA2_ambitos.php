<?php
    function mostrarCiclo() {
    $nombreCiclo = "Desarrollo de Aplicaciones Web";
    echo '<p>', $nombreCiclo, '</p>';
    }

    mostrarCiclo();

    // Warning: Undefined variable $nombreCiclo
    //La variable esá definida de manera local en la función, pero no de manera global, por lo que acceder a su contenido fuera
    //de la función es imposible

    $totalCiclosMostrados = 0;

    function registrarVisita() {
    global $totalCiclosMostrados;
    $totalCiclosMostrados++;
    }

    registrarVisita();
    registrarVisita();
    registrarVisita();

    echo '<p>Ciclos mostrados: ', $totalCiclosMostrados, '</p>';   // 3

    define('NOMBRE_CENTRO', 'CIFP Carlos III');

    function pie() {
    // Sin "global": las constantes son accesibles en cualquier ámbito
    echo '<footer>', NOMBRE_CENTRO, '</footer>';
    }

    pie();

    function contadorVisitas() {
    static $visitas = 0;
    $visitas++;
    echo '<p>Visita número ', $visitas, '</p>';
    }

    contadorVisitas();   // Visita número 1
    contadorVisitas();   // Visita número 2
    contadorVisitas();   // Visita número 3
?>

