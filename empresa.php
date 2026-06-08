<?php
session_start();

// Variable auxiliar para verificar si el usuario tiene sesión activa
$is_logged = isset($_SESSION['id']);
$user_rol = $is_logged ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Para Empresas y Reclutadores</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/estilos_empresa.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">   

</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <?php if ($is_logged && $user_rol == 'candidato'): ?>
        <div class="info-banner-rol">
            Estás visualizando la sección para Empresas. ¿Buscas empleo? 
            <a href="inicio.php" style="color: rgb(20, 30, 99); margin-left: 10px; font-weight: bold;">Volver al portal de candidatos →</a>
        </div>
    <?php endif; ?>

    <main>
        
        <section class="emp-hero">
            <span class="eyebrow">Construye el equipo del mañana</span>
            <h1>Descubre el talento que impulsará tu empresa</h1>
            <p>En Nattaworld conectamos a tu compañía con perfiles junior altamente motivados, adaptables y listos para aportar valor desde su primer día de trabajo. La energía que tu equipo necesita está aquí.</p>
            
            <div class="hero-botones">
                <?php if (!$is_logged): ?>
                    <a href="empresa/registro_empresa.php" class="btn-accent">Registrar mi empresa</a>
                    <a href="#como-funciona" class="btn-ghost" style="color:white; border: 1px solid rgba(255,255,255,0.4);">¿Cómo funciona?</a>
                <?php elseif ($user_rol == 'empresa' || $user_rol == 'admin'): ?>
                    <a href="empresa/crear_oferta.php" class="btn-accent">Publicar nueva vacante</a>
                    <a href="empresa/panel_empresa.php" class="btn-ghost" style="color:white; border: 1px solid rgba(255,255,255,0.4);">Ir al panel corporativo</a>
                <?php else: ?>
                    <a href="ofertas.php" class="btn-accent">Explorar ofertas publicadas</a>
                <?php endif; ?>
            </div>
        </section>

        <section class="emp-estadisticas">
            <div class="grid-estadisticas">
                <div class="stat-item">
                    <h3>+10k</h3>
                    <p>Candidatos Activos</p>
                </div>
                <div class="stat-item">
                    <h3>100%</h3>
                    <p>Perfiles Junior / Entry-Level</p>
                </div>
                <div class="stat-item">
                    <h3>48h</h3>
                    <p>Tiempo Medio de Aplicación</p>
                </div>
            </div>
        </section>

        <section class="emp-proposito">
            <div class="proposito-texto">
                <span style="color: rgb(65, 202, 81); font-weight: bold; text-transform: uppercase; letter-spacing: 1px; font-size: 14px;">Nuestra Visión</span>
                <h2>El talento no se mide solo en años de experiencia</h2>
                <p>Incorporar perfiles junior a tu equipo no es solo una decisión rentable, es una estrategia de innovación. Los profesionales que están dando sus primeros pasos laborales aportan nuevas perspectivas, dominan las últimas herramientas tecnológicas y poseen una curva de aprendizaje asombrosa.</p>
                <p>NattaWorld es el filtro que necesitas. Nos aseguramos de que conectes con talento que compensa su corta trayectoria con una motivación inquebrantable, lealtad hacia tu proyecto y un deseo genuino de crecer junto a tu empresa.</p>
            </div>
            <div class="proposito-visual">
                <h3>El ROI de la actitud</h3>
                <p style="color: rgb(57, 61, 72); line-height: 1.6;">Las empresas que apuestan por la formación interna retienen el talento un <strong>65% más de tiempo</strong> que aquellas que solo contratan perfiles senior.</p>
            </div>
        </section>

        <section class="emp-beneficios">
            <div class="emp-beneficios-inner">
                <h2 class="seccion-titulo">Reclutamiento optimizado y sin ruido</h2>
                <p class="seccion-subtitulo">Olvídate de recibir cientos de CVs sobrecualificados o que no encajan. Nuestra plataforma está diseñada específicamente para el reclutamiento de perfiles de entrada.</p>
                <div class="grid-beneficios">
                    <div class="beneficio">
                        <div class="icono">🎯</div>
                        <h3>Nicho Especializado</h3>
                        <p>Al publicar en Nattaworld, sabes que el 100% de la audiencia entiende que son vacantes de 0 a 1 año de experiencia.</p>
                    </div>
                    <div class="beneficio">
                        <div class="icono">⚡</div>
                        <h3>Ahorro de Tiempo</h3>
                        <p>Herramientas de filtrado directo por habilidades, proyectos y portafolio, agilizando tu selección inicial.</p>
                    </div>
                    <div class="beneficio">
                        <div class="icono">🌱</div>
                        <h3>Employer Branding</h3>
                        <p>Posiciona a tu compañía como una empresa impulsora de talento joven y mejora tu reputación de marca empleadora.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="como-funciona" class="emp-pasos">
            <div class="emp-pasos-inner">
                <h2 class="seccion-titulo">Empieza a contratar en 3 pasos</h2>
                <div class="grid-pasos">
                    <div class="paso">
                        <div class="paso-numero">1</div>
                        <h3>Crea tu perfil de empresa</h3>
                        <p>Muestra la cultura de tu equipo, tus beneficios y lo que hace a tu compañía un lugar increíble para aprender y trabajar.</p>
                    </div>
                    <div class="paso">
                        <div class="paso-numero">2</div>
                        <h3>Publica tu vacante</h3>
                        <p>Define los requisitos técnicos, modalidad (remoto/presencial) y el plan de crecimiento. Publicar ofertas es rápido e intuitivo.</p>
                    </div>
                    <div class="paso">
                        <div class="paso-numero">3</div>
                        <h3>Recibe aplicaciones</h3>
                        <p>Gestiona los currículums y portafolios desde tu panel corporativo, contacta a los candidatos y cierra tu contratación.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="emp-testimonios">
            <div class="emp-testimonios-inner">
                <h2 class="seccion-titulo">Empresas que ya crecen con nosotros</h2>
                <div class="grid-testimonios">
                    <div class="testimonio-card">
                        <p>"Necesitábamos ampliar nuestro departamento de marketing con alguien fresco y proactivo. Publicamos la oferta en Nattaworld y en 24 horas teníamos candidatos con portafolios increíbles y muchísima energía."</p>
                        <div class="testimonio-autor">
                            <h4>Elena G.</h4>
                            <span>HR Manager en TechNova</span>
                        </div>
                    </div>
                    <div class="testimonio-card">
                        <p>"Como startup, no siempre podemos competir con los salarios de las multinacionales para perfiles Senior. En Nattaworld encontramos un desarrollador Junior brillante al que ahora estamos formando. Ha sido un éxito total."</p>
                        <div class="testimonio-autor">
                            <h4>Marcos T.</h4>
                            <span>CTO en AppSolutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="emp-faq">
            <h2 class="seccion-titulo">Preguntas Frecuentes</h2>
            <div class="faq-item">
                <h3>¿Qué tipo de ofertas puedo publicar?</h3>
                <p>Nattaworld es una plataforma estricta en su propuesta de valor: solo aceptamos ofertas para perfiles Junior, Entry-Level, Prácticas o Trainee (máximo 1 año de experiencia requerida).</p>
            </div>
            <div class="faq-item">
                <h3>¿Cuál es el costo por publicar una vacante?</h3>
                <p>Actualmente ofrecemos planes muy competitivos, incluyendo un plan básico gratuito para que pruebes la plataforma y compruebes la calidad de nuestro talento sin compromiso.</p>
            </div>
            <div class="faq-item">
                <h3>¿Puedo buscar candidatos directamente en la base de datos?</h3>
                <p>Sí, con nuestros planes corporativos premium tendrás acceso a nuestra base de talento para hacer búsquedas proactivas por habilidades técnicas y contactar directamente a los candidatos.</p>
            </div>
        </section>

        <section style="padding: 0 24px;">
            <div class="emp-cta-final">
                <?php if (!$is_logged): ?>
                    <h2>¿Preparado para conocer a tu próximo gran fichaje?</h2>
                    <p>Únete a cientos de empresas innovadoras y publica tu primera oferta hoy mismo.</p>
                    <div style="display:flex; justify-content:center;">
                        <a href="./empresa/registro_empresa.php" class="btn-primary" style="background: rgb(20, 30, 99); color: white; font-weight: bold; border: none; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 16px;">Registrar mi Empresa</a>
                    </div>
                <?php elseif ($user_rol == 'empresa'): ?>
                    <h2>El talento está esperando</h2>
                    <p>Tu equipo tiene espacio para crecer. Revisa las postulaciones a tus vacantes activas o publica una nueva.</p>
                    <div style="display:flex; justify-content:center;">
                        <a href="empresa/panel_empresa.php" class="btn-primary" style="background: rgb(20, 30, 99); color: white; font-weight: bold; border: none; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 16px;">Ir a mi panel de reclutador</a>
                    </div>
                <?php else: ?>
                    <h2>Nattaworld conecta talento y oportunidad</h2>
                    <p>Si conoces a una empresa que busque talento joven, comparte nuestra plataforma con ellos.</p>
                    <div style="display:flex; justify-content:center;">
                        <a href="inicio.php" class="btn-primary" style="background: rgb(20, 30, 99); color: white; font-weight: bold; border: none; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 16px;">Ir al portal de candidatos</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <?php @include_once('./includes/footer.php'); ?>

</body>
</html>