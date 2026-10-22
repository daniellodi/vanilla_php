<?php
    declare(strict_types=1);

    require_once __DIR__ . '/Modelo.php';

    class Ciclo extends Modelo
    {
        public const GRADO_MEDIO    = 'Medio';
        public const GRADO_SUPERIOR = 'Superior';

        public function __construct(
            int $id,
            public readonly string $codCiclo,
            public readonly string $nombre,
            public readonly string $grado,
        ) {
            parent::__construct($id);
        }

        public function titulacion(): string
        {
            return $this->grado === self::GRADO_SUPERIOR ? 'Técnico Superior' : 'Técnico';
        }

        public function descripcion(): string
        {
            return $this->codCiclo . ' — ' . $this->nombre;
        }

        public static function desdeArray(array $datos): self
        {
            return new self($datos['id'], $datos['codCiclo'], $datos['nombre'], $datos['grado']);
        }
    }