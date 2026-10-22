<?php
  $nombreCiclo = "Desarrollo de Aplicaciones Web";
  $familia     = "Informática y Comunicaciones";
  $horas       = 2000;
 
    echo '<p>El ciclo <strong>',
       $nombreCiclo,
       '</strong> pertenece a la familia de ',
       $familia,
       ' y tiene ',
       $horas,
       ' horas.</p>';

    print '<p>El ciclo <strong>'.
       $nombreCiclo.
       '</strong> pertenece a la familia de '.
       $familia.
       ' y tiene '.
       $horas.
       ' horas.</p>';

    $resultado = echo "Hola";
    echo $resultado;
?>
