 <?php

    /**
     * Comprueba las credenciales (email y contraseña) de los usuarios.
    */
    class Autenticador
    {
        /**
         * @param array<string, array{firstName: string, lastName: string, rol: string, password: string}> $usuarios
        *        Usuarios indexados por su email; 'password' es el hash de la contraseña.
        */
        public function __construct(
            private readonly array $usuarios,
        ) {
        }

        /**
         * @return array{email: string, firstName: string, lastName: string, rol: string}|null
        *         Los datos del usuario (sin el hash) si las credenciales son correctas; null si no.
        */
        public function autenticar(string $email, string $password): ?array
        {
            $usuario = $this->usuarios[$email] ?? null;

            if ($usuario === null || !password_verify($password, $usuario['password'])) {
                return null;
            }

            return [
                'email'     => $email,
                'firstName' => $usuario['firstName'],
                'lastName'  => $usuario['lastName'],
                'rol'       => $usuario['rol'],
            ];
        }
    }