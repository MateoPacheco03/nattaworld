<?php
// blog.php — Página de Blog (en construcción)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — Nattaworld</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/normativas.css">
    <style>
        .construccion {
            text-align: center;
            padding: 80px 24px;
            max-width: 640px;
            margin: 0 auto;
        }
        .construccion .icono {
            font-size: 72px;
            margin-bottom: 24px;
        }
        .construccion h1 {
            font-size: clamp(28px, 4vw, 44px);
            color: rgb(20, 30, 99);
            margin-bottom: 16px;
            font-weight: 800;
        }
        .construccion p {
            color: rgb(57, 61, 72);
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 32px;
        }
    </style>
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <!-- Cabecera -->
        <div class="legal-hero">
            <span class="eyebrow">Nattaworld</span>
            <h1>Blog</h1>
            <p class="meta">Próximamente</p>
        </div>

        <div class="construccion">
            <div class="icono">🚧</div>
            <h1>Estamos trabajando en ello</h1>
            <p>
                Nuestro blog está en construcción. Muy pronto encontrarás aquí consejos
                para encontrar tu primer empleo, guías para preparar tu CV y novedades
                sobre el mundo laboral junior. ¡Vuelve pronto!
            </p>
            <a href="inicio.php" class="btn-primary">Volver al inicio</a>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

</body>
</html>