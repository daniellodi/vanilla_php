<?php
    declare(strict_types=1);

    require_once __DIR__ . '/Modelo.php';
    require_once __DIR__ . '/Publicable.php';
    require_once __DIR__ . '/Ciclo.php';

    class Curriculo extends Modelo implements Publicable
    {
        private bool $publicado = false;

        public function __construct(
            int $id,
            public readonly string $alumno,
            public readonly Ciclo $ciclo,
            public readonly ?string $videoCurriculum = null,
        ) {
            parent::__construct($id);
        }

        public function publicar(): void
        {
            $this->publicado = true;
        }

        public function estaPublicado(): bool
        {
            return $this->publicado;
        }

        public function descripcion(): string
        {
            return $this->alumno . ' (' . $this->ciclo->codCiclo . ')';
        }
    }