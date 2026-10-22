<?php
    interface Publicable{
        public function publicar(): void;
        public function estaPublicado(): bool;
    }
