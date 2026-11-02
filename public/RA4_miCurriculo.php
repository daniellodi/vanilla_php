<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/RA4_comun.php';

iniciarSesion();
$usuario = exigirRol('alumno');

$ciclos    = catalogoCiclos();
$validador = new ValidadorCurriculo($ciclos);
$nombre    = $usuario['firstName'] . ' ' . $usuario['lastName'];
$errores   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // El alumno sale de la sesión, nunca del formulario: cada uno, solo su currículo.
    $datos = [
        'alumno' => $nombre,
        'ciclo'  => $_POST['ciclo'] ?? '',
        'video'  => $_POST['video'] ?? '',
    ];
    $errores = $validador->validar($datos);

    if ($errores === []) {
        $guardado = $validador->crearCurriculo($datos, 1);
        $_SESSION['curriculo'] = [
            'alumno' => $guardado->alumno,
            'ciclo'  => $guardado->ciclo->codCiclo,
            'video'  => $guardado->videoCurriculum ?? '',
        ];
        $_SESSION['mensaje'] = 'Currículo guardado.';

        header('Location: RA4_miCurriculo.php', true, 303);
        exit;
    }
} else {
    // Al editar, el formulario parte de lo guardado.
    $datos = $_SESSION['curriculo'] ?? ['alumno' => $nombre, 'ciclo' => '', 'video' => ''];
}

// Uno por alumno, como User y Curriculo en la aplicación: el id siempre es 1.
$curriculo = isset($_SESSION['curriculo'])
    ? $validador->crearCurriculo($_SESSION['curriculo'], 1)
    : null;

// Formulario si no hay currículo, si se ha pedido editar o si hay errores que mostrar.
$editando = $curriculo === null || isset($_GET['editar']) || $errores !== [];

$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi currículo — <?= NOMBRE_CENTRO ?></title>
</head>
<body>
<h1><?= NOMBRE_CENTRO ?> — Mi currículo</h1>

<?php if ($mensaje !== null): ?>
    <p class="exito"><?= e($mensaje) ?></p>
<?php endif; ?>

<?php if (!$editando): ?>
    <p><?= e($curriculo->descripcion()) ?></p>
    <p>Ciclo: <?= e($curriculo->ciclo->nombre) ?> — titulación de <?= e($curriculo->ciclo->titulacion()) ?></p>
    <p>Vídeo:
    <?php if ($curriculo->videoCurriculum !== null): ?>
        <a href="<?= e($curriculo->videoCurriculum) ?>">ver vídeo</a>
    <?php else: ?>
        sin vídeo
    <?php endif; ?>
    </p>
    <p><a href="RA4_miCurriculo.php?editar=1">Editar mi currículo</a></p>
<?php else: ?>
    <?php if ($curriculo === null): ?>
    <p>Todavía no tienes currículo: rellena el formulario para darlo de alta.</p>
    <?php endif; ?>

    <?php if ($errores !== []): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
        <li><?= e($error) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form action="RA4_miCurriculo.php" method="post">
    <p>Alumno: <?= e($nombre) ?></p>
    <p>
        <label>Ciclo
        <select name="ciclo">
            <option value="">— Elige un ciclo —</option>
            <?php foreach ($ciclos as $codigo => $ciclo): ?>
            <option value="<?= e($codigo) ?>" <?= ($datos['ciclo'] ?? '') === $codigo ? 'selected' : '' ?>><?= e($ciclo->descripcion()) ?></option>
            <?php endforeach; ?>
        </select>
        </label>
    </p>
    <p>
        <label>Vídeo de presentación (opcional)
        <input name="video" type="url" value="<?= e($datos['video'] ?? '') ?>">
        </label>
    </p>
    <button type="submit">Guardar</button>
    </form>
<?php endif; ?>

<p><a href="RA4_perfil.php">Volver a mi área</a></p>
</body>
</html>
<!-- 
Ejercicio 4
    1. Si queremos entrar directamente a RA4_miCurriculo.php, nos redirige a RA4_login.php. Esto es porque, al entrar por primera vez, se inicia la sesión y 
    se exige el rol de alumno, pero como aún no hay ningún usuario almacenado en la sesión ($usuario = usuarioActual() es null), exigirLogin() nos redirige a
    la página del login. Al hacer el login con el usuario de Ana López, $curriculo es null, por lo que nos imprime este mensaje en el área personal:
    <p>Todavía no tienes currículo: rellena el formulario para darlo de alta.</p>. Una vez rellenamos el curriculo, RA4_miCurriculo.php se rellena con el curriculo
    nuevo, si le damos a F5, como la sesión no se ha cerrado, Ana López conserva su curriculo, pero si cerramos el navegador, se cierra la sesión y con ello
    Ana pierde su currículo. Al introducir el label con el name de alumno, el nombre no cambia porque la sesión ya ha guardado en la variable $usuario el campo 
    ['firstName'] y ['lastName']. Como no podemos acceder a esa zona sin autenticarnos, esos campos nunca van a estar vacíos y no se van a sobreescribir, por
    eso no se actualiza el nombre. Si iniciamos sesión como Elena Ruiz e intentamos acceder a RA4_miCurriculo.php, el rol de $usuario no es alumno, por lo que
    nos tirará un código 403 forbbiden y no nos dejará entrar a esa área.

Ejercicio 5
    ¿Qué diferencia hay entre los códigos de estado 401 y 403? ¿Por qué una página web redirige al login en lugar de responder 401?
    403 es forbbiden, es decir, que no se tiene acceso a ese fichero porque el cliente lo está bloqueando, 401 es lo mismo, pero lo bloquea el servidor.
    La página redirige a login para que el usuario pueda volver a iniciar sesión
    
    Para que Elena pudiera ver los currículos de todos sus alumnos, ¿dónde tendrían que guardarse? ¿Qué datos haría falta guardar junto a cada currículo para saber de qué alumno es? (Pista: el campo user_id del modelo Curriculo.)
    Los currículos tendrían que guardarse en una base datos para que no se perdieran cada vez que se cierre la sesión, haría falta que cada currículo tuviera,
    además de su id, un id correspondiente al usuario del currículo para que se pudiera relacionar con otra tabla que contenga la información de ese usuario. La 
    docente podría ver la información de la tabla de usuarios, no la de cada currículo de los alumnos.
-->