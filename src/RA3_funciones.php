<?php
    declare(strict_types=1);

    function horasRestantes(int $horasTotales, int $horasCursadas): int{
        return $horasTotales - $horasCursadas;
    }

    function titulacion(string $grado = 'Superior'): string{
        return match ($grado) {
            'Superior' => 'Técnico Superior',
            'Medio'    => 'Técnico',
            default    => 'Titulación desconocida',
        };
    }

    function enlaceVideo(?string $video): string{
        if ($video === null || $video === '') {
            return 'Sin vídeo';
        }
        return '<a href="' . $video . '">vídeo</a>';
    }

    function nombresAlumnos(array $curriculos): array{
        return array_map(fn(array $curriculo): string => $curriculo['alumno'], $curriculos);
    }

    function curriculosDeCiclo(array $curriculos, string $codCiclo): array{
        return array_values(array_filter(
            $curriculos,
            fn(array $curriculo): bool => $curriculo['ciclo'] === $codCiclo
        ));
    }

    function ordenarPorAlumno(array $curriculos): array{
        usort($curriculos, fn(array $a, array $b): int => $a['alumno'] <=> $b['alumno']);
        return $curriculos;
    }
