<?php
// 404.php — Página de error personalizada
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada — NattaWorld</title>
    <link rel="stylesheet" href="/juniorworld/assets/css/stylos.css">
    <link rel="stylesheet" href="/juniorworld/assets/css/botones.css">
    <style>
        .error-wrapper {
            text-align: center;
            padding: 100px 24px;
        }
        .error-codigo {
            font-size: clamp(80px, 15vw, 160px);
            font-weight: 800;
            color: rgb(50, 70, 169);
            line-height: 1;
        }
        .error-wrapper h1 {
            font-size: 28px;
            color: rgb(20, 30, 99);
            margin: 16px 0;
        }
        .error-wrapper p {
            color: rgb(57, 61, 72);
            font-size: 17px;
            margin-bottom: 28px;
        }
    </style>
</head>
<body>

    <?php @include_once($_SERVER['DOCUMENT_ROOT'] . '/juniorworld/includes/navbar.php'); ?>

    <main>
        <div class="error-wrapper">
            <div class="error-codigo">404</div>
            <h1>Vaya, esta página no existe</h1>
            <p>La dirección que buscas no se encuentra o ha sido movida.</p>
            <a href="/juniorworld/inicio.php" class="btn-primary">Volver al inicio</a>
        </div>
    </main>

    <?php @include_once($_SERVER['DOCUMENT_ROOT'] . '/juniorworld/includes/footer.php'); ?>

</body>
</html>