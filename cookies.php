<?php
// cookies.php — Política de Cookies de Nataworld
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Cookies — Nataworld</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/normativas.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">   
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <!-- Cabecera -->
        <div class="legal-hero">
            <span class="eyebrow">Marco legal · Uso de cookies</span>
            <h1>Política de Cookies</h1>
            <p class="meta">Última actualización: 7 junio 2026</p>
        </div>

        <div class="legal-wrapper">
            <p class="legal-intro">
                En Nataworld utilizamos únicamente las cookies estrictamente necesarias para el funcionamiento de la plataforma y una cookie de preferencia para mejorar tu experiencia. No empleamos cookies de publicidad, de seguimiento ni de análisis de terceros. Esta política te explica qué cookies usamos, con qué finalidad y cómo puedes gestionarlas.
            </p>

            <h2>1. ¿Qué es una cookie?</h2>
            <p>Una cookie es un pequeño archivo de texto que un sitio web guarda en el navegador del usuario cuando lo visita. Permite que la web recuerde información sobre la visita, como la sesión iniciada o las preferencias de configuración, facilitando así la navegación y el uso de la plataforma.</p>

            <h2>2. Tipos de cookies que utilizamos</h2>
            <p>Nataworld emplea dos cookies, ambas propias (no de terceros). Según su finalidad, se clasifican en cookies técnicas (necesarias) y cookies de preferencia (funcionales):</p>

            <h2>3. Cookies técnicas o necesarias</h2>
            <p>Son imprescindibles para que la plataforma funcione correctamente. Sin ellas no sería posible mantener la sesión iniciada ni acceder a las áreas privadas según el rol del usuario. Por su carácter necesario, estas cookies no requieren el consentimiento previo del usuario.</p>
            <ul>
                <li><strong>PHPSESSID</strong>: cookie de sesión generada por PHP. Identifica la sesión del usuario en el servidor y permite mantener la sesión iniciada mientras se navega, recordando el rol (candidato, empresa o administrador). Es de sesión, por lo que se elimina automáticamente al cerrar el navegador.</li>
            </ul>

            <h2>4. Cookies de preferencia o funcionales</h2>
            <p>Permiten recordar elecciones del usuario para ofrecer una experiencia más personalizada. No recogen información que permita identificar a la persona ni se utilizan con fines publicitarios.</p>
            <ul>
                <li><strong>nataworld_tema</strong>: guarda la preferencia de tema visual (claro u oscuro) elegida por el usuario, de modo que se respete en futuras visitas. Es persistente, con una duración de un año.</li>
            </ul>

            <h2>5. Cuadro resumen de cookies</h2>
            <p>A modo de resumen, las cookies utilizadas en Nataworld son las siguientes:</p>
            <ul>
                <li><strong>PHPSESSID</strong> — Propia · Técnica/necesaria · De sesión (caduca al cerrar el navegador) · Finalidad: mantener la sesión iniciada.</li>
                <li><strong>nataworld_tema</strong> — Propia · Preferencia/funcional · Persistente (1 año) · Finalidad: recordar el tema visual elegido.</li>
            </ul>

            <h2>6. ¿Solicitamos tu consentimiento?</h2>
            <p>Las cookies que utiliza Nataworld son estrictamente necesarias o de preferencia funcional. De acuerdo con la normativa vigente, las cookies técnicas necesarias están exentas de consentimiento, y la cookie de preferencia se activa únicamente cuando el usuario elige cambiar el tema visual. Por ello, la plataforma no muestra un banner de consentimiento de cookies.</p>

            <h2>7. ¿Cómo gestionar o eliminar las cookies?</h2>
            <p>El usuario puede permitir, bloquear o eliminar las cookies instaladas en su equipo en cualquier momento mediante la configuración de las opciones de su navegador. Ten en cuenta que, si desactivas las cookies técnicas, es posible que algunas funcionalidades de la plataforma, como el inicio de sesión, dejen de funcionar correctamente.</p>
            <ul>
                <li>Google Chrome: Configuración → Privacidad y seguridad → Cookies y otros datos de sitios.</li>
                <li>Mozilla Firefox: Ajustes → Privacidad & Seguridad → Cookies y datos del sitio.</li>
                <li>Microsoft Edge: Configuración → Cookies y permisos del sitio.</li>
                <li>Safari: Preferencias → Privacidad → Gestionar datos de sitios web.</li>
            </ul>

            <h2>8. Cambios en la Política de Cookies</h2>
            <p>Nataworld se reserva el derecho a modificar esta Política de Cookies para adaptarla a novedades legislativas o cambios en la plataforma. Cualquier modificación se reflejará en esta página, actualizándose la fecha de "última actualización".</p>

            <div class="legal-contacto">
                <h2>¿Tienes dudas sobre nuestras cookies?</h2>
                <p>Escríbenos a <a href="mailto:legal@nataworld.es">legal@nataworld.es</a>. Estaremos encantados de ayudarte.</p>
            </div>
        </div>
    </main>

    <?php @include_once('./includes/footer.php'); ?>

</body>
</html>