<?php
session_start();
$is_logged = isset($_SESSION['id']);
$user_rol = $is_logged ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Portal del Candidato</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/estilos_candidato.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">   
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <?php if ($is_logged && ($user_rol == 'empresa' || $user_rol == 'admin')): ?>
        <div class="info-banner-rol">
            Visualizando la sección de candidatos como <strong><?php echo $user_rol == 'empresa' ? 'Empresa' : 'Administrador'; ?></strong>.
            <a href="empresa/panel_empresa.php" style="color: rgb(20, 30, 99); margin-left: 10px; font-weight: bold;">Gestionar vacantes →</a>
        </div>
    <?php endif; ?>

    <main>
        <section class="cand-hero">
            <span class="eyebrow">Impulsamos tu trayectoria</span>
            <h1>Tu primer empleo, sin la barrera de la experiencia</h1>
            <p>En Nattaworld conectamos el talento emergente con empresas que valoran la actitud, la motivación y el potencial por encima de los años de experiencia. Empieza tu carrera profesional hoy mismo.</p>
            <div class="hero-botones">
                <?php if (!$is_logged): ?>
                    <a href="registro.php" class="btn-accent">Crear mi cuenta gratuita</a>
                    <a href="ofertas.php" class="btn-ghost" style="color:white; border: 1px solid rgba(255,255,255,0.4);">Ver vacantes disponibles</a>
                <?php elseif ($user_rol == 'candidato'): ?>
                    <a href="ofertas.php" class="btn-accent">Explorar ofertas de empleo</a>
                    <a href="candidato/panel.php" class="btn-ghost" style="color:white; border: 1px solid rgba(255,255,255,0.4);">Ir a mi panel</a>
                <?php else: ?>
                    <a href="ofertas.php" class="btn-accent">Ver bolsa de trabajo</a>
                <?php endif; ?>
            </div>
        </section>

        <section class="cand-estadisticas">
            <div class="grid-estadisticas">
                <div class="stat-item"><h3>100%</h3><p>Ofertas Nivel Junior</p></div>
                <div class="stat-item"><h3>0€</h3><p>Siempre Gratis</p></div>
                <div class="stat-item"><h3>+500</h3><p>Empresas Verificadas</p></div>
            </div>
        </section>

        <section class="cand-proposito">
            <div class="proposito-texto">
                <span style="color: rgb(65, 202, 81); font-weight: bold; text-transform: uppercase; letter-spacing: 1px; font-size: 14px;">Nuestra Esencia</span>
                <h2>Más que un portal de empleo, una plataforma con alma</h2>
                <p>Nattaworld nació de una convicción profunda: todo gran profesional necesitó que alguien creyera en él por primera vez. Sabemos lo frustrante que es enfrentarse a la paradoja de "necesitas experiencia para trabajar, pero necesitas trabajar para tener experiencia".</p>
                <p>Por eso, hemos construido un espacio seguro donde el talento emergente es el protagonista. Aquí no te evaluamos por el pasado laboral que aún no tienes, sino por la energía, las habilidades y la visión que puedes aportar al futuro de las empresas.</p>
            </div>
            <div class="proposito-visual">
                <h3>Tu actitud es tu mejor currículum</h3>
                <p style="color: rgb(57, 61, 72); line-height: 1.6;">Conectamos tu talento con equipos dispuestos a formarte, guiarte y verte crecer profesionalmente.</p>
            </div>
        </section>

        <section class="cand-beneficios">
            <div class="cand-beneficios-inner">
                <h2 class="seccion-titulo">Diseñado exclusivamente para tu perfil</h2>
                <p class="seccion-subtitulo">Hemos eliminado el ruido para que te centres únicamente en las ofertas donde tienes posibilidades reales de ser contratado.</p>
                <div class="grid-beneficios">
                    <div class="beneficio"><div class="icono">🚀</div><h3>Impulsa tu potencial</h3><p>Cada oferta publicada exige un máximo de 0 a 1 año de experiencia. Tu motivación es tu mayor ventaja competitiva.</p></div>
                    <div class="beneficio"><div class="icono">🤝</div><h3>Empresas comprometidas</h3><p>Colaboramos con compañías que entienden el valor de formar talento y ofrecen un entorno real de mentoría.</p></div>
                    <div class="beneficio"><div class="icono">⚡</div><h3>Procesos transparentes</h3><p>Olvídate de aplicar y no recibir respuesta. Fomentamos una comunicación clara en cada etapa de selección.</p></div>
                </div>
            </div>
        </section>

        <section class="cand-pasos">
            <div class="cand-pasos-inner">
                <h2 class="seccion-titulo">Inicia tu camino en 3 pasos</h2>
                <div class="grid-pasos">
                    <div class="paso"><div class="paso-numero">1</div><h3>Crea tu perfil profesional</h3><p>Registra tus datos, destaca tus proyectos y muestra tus habilidades técnicas y blandas.</p></div>
                    <div class="paso"><div class="paso-numero">2</div><h3>Encuentra tu match ideal</h3><p>Filtra vacantes por sector, ubicación o modalidad y encuentra la empresa perfecta para ti.</p></div>
                    <div class="paso"><div class="paso-numero">3</div><h3>Inscríbete al instante</h3><p>Envía tu candidatura directamente a los reclutadores y gestiona el estado de tus procesos desde tu panel.</p></div>
                </div>
            </div>
        </section>

        <section class="cand-faq">
            <h2 class="seccion-titulo">Preguntas Frecuentes</h2>
            <div class="faq-item"><h3>¿Tiene algún costo registrarme en Nattaworld?</h3><p>Absolutamente ninguno. La plataforma es y será siempre 100% gratuita para los candidatos. Nuestro objetivo es eliminar barreras laborales, no crear nuevas.</p></div>
            <div class="faq-item"><h3>¿Realmente no necesito experiencia previa?</h3><p>Exacto. Todas las empresas que publican en Nattaworld saben que se dirigen a perfiles Entry-Level. Evaluarán tu formación, tus proyectos y tu motivación por crecer.</p></div>
            <div class="faq-item"><h3>¿Cómo protegen mis datos y mi privacidad?</h3><p>Tus datos son confidenciales y solo se compartirán con las empresas a las que decidas enviar tu candidatura. Tienes control total sobre tu perfil.</p></div>
        </section>

        <section style="padding: 0 24px;">
            <div class="cand-cta-final">
                <?php if (!$is_logged): ?>
                    <h2>¿Listo para dar el salto profesional?</h2>
                    <p>Únete a la comunidad de talento joven con mayor proyección. Crea tu perfil hoy mismo y deja que tu carrera despegue.</p>
                    <div style="display:flex; justify-content:center;"><a href="registro.php" class="btn-accent">Crear cuenta gratuita</a></div>
                <?php elseif ($user_rol == 'candidato'): ?>
                    <h2>¡Tu perfil está preparado para el éxito!</h2>
                    <p>Publicamos nuevas vacantes periódicamente. Revisa nuestro tablón de ofertas y aplica a las posiciones que encajen contigo.</p>
                    <div style="display:flex; justify-content:center;"><a href="ofertas.php" class="btn-accent">Buscar vacantes ahora</a></div>
                <?php else: ?>
                    <h2>¿Buscando incorporar talento junior?</h2>
                    <p>Accede a tu panel para publicar vacantes y conectar con perfiles de alto potencial.</p>
                    <div style="display:flex; justify-content:center;"><a href="empresa/crear_oferta.php" class="btn-accent">Crear oferta</a></div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php @include_once('./includes/footer.php'); ?>
</body>
</html>