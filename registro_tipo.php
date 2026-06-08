<?php
// registro_tipo.php — Eleccion de tipo de cuenta
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Crear cuenta</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/registro_tipo.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">

</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <div class="registro-tipo">
            <span class="eyebrow">Únete a Nattaworld</span>
            <h1>¿Cómo quieres registrarte?</h1>
            <p>Elige el tipo de cuenta que mejor encaja contigo</p>

            <div class="tarjetas-tipo">
                <div class="tarjeta-tipo">
                    <div class="tarjeta-icono icono-candidato">👤</div>
                    <h2>Soy candidato</h2>
                    <p>Busco mi primer empleo y quiero que me valoren por mis aptitudes, no por mi experiencia.</p>
                    <a href="registro.php" class="btn-primary">Crear cuenta de candidato</a>
                </div>

                <div class="tarjeta-tipo">
                    <div class="tarjeta-icono icono-empresa">🏢</div>
                    <h2>Soy empresa</h2>
                    <p>Quiero publicar ofertas y encontrar talento junior motivado para mi equipo.</p>
                    <a href="empresa/registro_empresa.php" class="btn-accent">Crear cuenta de empresa</a>
                </div>
            </div>

            <p class="registro-login">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

</body>
</html>