<?php
    declare(strict_types=1);
    function e(string $texto): string{
        return htmlspecialchars($texto);
    }
    function validarCiclo(array $datos): array{
        $errores = [];

        $codCiclo = trim($datos['codCiclo'] ?? '');
        if ($codCiclo === '') {
            $errores['codCiclo'] = 'El código del ciclo es obligatorio.';
        } elseif (!ctype_upper($codCiclo) || strlen($codCiclo) > 5) {
            $errores['codCiclo'] = 'El código debe tener como máximo 5 letras mayúsculas.';
        }

        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            $errores['nombre'] = 'El nombre es obligatorio.';
        }

        $grado = $datos['grado'] ?? '';
        if (!in_array($grado, ['Medio', 'Superior'], true)) {
            $errores['grado'] = 'El grado debe ser Medio o Superior.';
        }

        $horas = filter_var($datos['horas'] ?? '', FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1000, 'max_range' => 2000],
        ]);
        if ($horas === false) {
            $errores['horas'] = 'Las horas deben ser un número entero entre 1000 y 2000.';
        }

        return $errores;
    }
    