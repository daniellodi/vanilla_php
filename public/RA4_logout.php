<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA4_comun.php';

    iniciarSesion();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Vaciar los datos de la sesión.
        $_SESSION = [];

        // 2. Borrar la cookie del navegador: misma ruta, fecha ya pasada.
        $parametros = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 3600,
            'path'     => $parametros['path'],
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        // 3. Destruir la sesión en el servidor.
        session_destroy();
    }

    header('Location: RA4_login.php', true, 303);
    exit;