<?php
declare(strict_types=1);

require_once __DIR__ . '/Curriculo.php';

/**
 * Cuenta cuántos currículos hay de cada ciclo.
*
* @param list<Curriculo> $curriculos
* @return array<string, int> Código del ciclo => número de currículos, en orden de aparición.
*/
function contarPorCiclo(array $curriculos): array
{
    $cuenta = [];
    foreach ($curriculos as $curriculo) {
        $codigo = $curriculo->ciclo->codCiclo;
        $cuenta[$codigo] = isset($cuenta[$codigo]) ? ++$cuenta[$codigo] : 1;
    }

    return $cuenta;
}

/** Porcentaje (redondeado a entero) que representa $parte sobre $total. */
function porcentaje(int $parte, int $total): int
{
    return (int) (($parte / $total) * 100);
}