<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../src/RA4_comun.php';

    iniciarSesion();

    // Si ya hay alguien identificado, no tiene sentido volver a pedirle las credenciales.
    if (usuarioActual() !== null) {
        header('Location: RA4_perfil.php', true, 303);
        exit;
    }

    $email = '';
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $usuario = (new Autenticador(usuarios()))->autenticar($email, $password);

        if ($usuario === null) {
            // El mismo mensaje tanto si falla el email como si falla la contraseña.
            $error = 'Email o contraseña incorrectos.';
        } else {
            // Identificador de sesión nuevo al iniciar sesión: evita la fijación de sesión.
            session_regenerate_id(true);
            $_SESSION['usuario'] = $usuario;
            $_SESSION['mensaje'] = 'Hola, ' . $usuario['firstName'] . '. Has iniciado sesión.';

            header('Location: RA4_perfil.php', true, 303);
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Iniciar sesión — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Iniciar sesión</h1>

<?php if ($error !== null): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<form action="RA4_login.php" method="post">
    <p>
    <label>Email
        <input name="email" type="email" value="<?= e($email) ?>">
    </label>
    </p>
    <p>
    <label>Contraseña
        <input name="password" type="password">
    </label>
    </p>
    <button type="submit">Entrar</button>
</form>
</body>
</html>

<!--Ejercicio 6.
Al abrir la página de pérfil sin haber iniciado sesión, te redirige a la página del login

-->