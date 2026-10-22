<?php
    abstract class Modelo{
        public function __construct(
            public readonly int $id,
        ) {
        }

        abstract public function descripcion(): string;
    }