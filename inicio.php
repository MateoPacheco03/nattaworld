<?php
session_start();
require_once './includes/Estadisticas.class.php';
require_once './includes/Oferta.class.php';

// Datos reales para la portada
$total_usuarios = Estadisticas::totalUsuarios();
$total_empresas = Estadisticas::totalEmpresas();
$total_ofertas = Estadisticas::totalOfertas();

// Ultimas ofertas para mostrar en destacadas (maximo 3)
$ofertas = Oferta::listarTodas();
$ofertas_destacadas = array_slice($ofertas, 0, 3);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nattaworld — Tu primer empleo</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
    <link rel="stylesheet" href="./assets/css/estilos_inicio.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/nattaworld/assets/img/iconos/iconoNattaworld.png">   
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <!-- HERO -->
        <section class="hero">
            <div class="hero-texto">
                <span class="eyebrow">Bienvenido a Nattaworld</span>
                <h1>Tu primer empleo no debería depender de la experiencia que no tienes.</h1>
                <p>Nattaworld evalúa tu talento por aptitudes y ganas, no por años de currículum. Encuentra empresas que apuestan por ti desde el día uno.</p>
                <div class="hero-botones">
                    <a href="registro.php" class="btn-primary">Soy candidato</a>
                    <a href="empresa/registro_empresa.php" class="btn-ghost">Soy empresa</a>
                </div>
            </div>
            
            <!-- Representación visual del dashboard -->
            <div class="hero-visual">
                <div class="mockup-window">
                    <div class="mockup-header">
                        <div class="mockup-dot"></div><div class="mockup-dot"></div><div class="mockup-dot"></div>
                    </div>
                    <div class="mockup-body">
                        <div class="mockup-title">⚡ Tu talento hace match</div>
                        
                        <div class="mockup-item">
                            <h4>Junior Frontend Developer</h4>
                            <p>TechNova Studios · Remoto</p>
                            <div class="mockup-bar"><div class="mockup-fill" style="width: 92%;"></div></div>
                            <small>92% de compatibilidad técnica</small>
                        </div>
                        
                        <div class="mockup-item">
                            <h4>Data Analyst Intern</h4>
                            <p>Global Analytics · Madrid</p>
                            <div class="mockup-bar"><div class="mockup-fill" style="width: 78%;"></div></div>
                            <small>78% de compatibilidad técnica</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- COMO FUNCIONA -->
        <section class="como-funciona">
            <h2>Tres pasos hacia tu primer empleo</h2>
            <div class="pasos">
                <article class="paso">
                    <span class="num">01</span>
                    <h3>Crea tu perfil</h3>
                    <p>Olvídate del típico CV aburrido. Cuéntanos qué sabes hacer, qué herramientas dominas y qué te apasiona aprender.</p>
                </article>
                <article class="paso">
                    <span class="num">02</span>
                    <h3>Conecta con empresas</h3>
                    <p>Nuestra plataforma filtra las ofertas por tus aptitudes reales, eliminando la barrera de los años de experiencia.</p>
                </article>
                <article class="paso">
                    <span class="num">03</span>
                    <h3>Inicia tu carrera</h3>
                    <p>Conecta con reclutadores que buscan formar talento. Mentoría, crecimiento y comunidad en tu primer trabajo.</p>
                </article>
            </div>
        </section>

        <!-- BENEFICIOS -->
        <section class="beneficios">
            <div class="bloque-beneficio">
                <h3>Para candidatos</h3>
                <ul>
                    <li>Validación de aptitudes que destaca tu potencial.</li>
                    <li>Cero discriminación por falta de experiencia laboral.</li>
                    <li>Acceso a empresas verificadas <em>Junior-Friendly</em>.</li>
                    <li>Plataforma 100% gratuita, comunidad incluida.</li>
                </ul>
                <a href="registro.php" class="btn-primary">Crear cuenta de candidato</a>
            </div>
            <div class="bloque-beneficio">
                <h3>Para empresas</h3>
                <ul>
                    <li>Filtra talento por conocimientos, no por años.</li>
                    <li>Acceso directo a candidatos junior motivados.</li>
                    <li>Dashboard integral con seguimiento de procesos.</li>
                    <li>Posiciona tu marca como empresa formadora.</li>
                </ul>
                <a href="empresa/registro_empresa.php" class="btn-accent">Publicar oferta gratis</a>
            </div>
        </section>

        <!-- STATS REALES (Ahora con diseño corregido) -->
        <section class="stats">
            <div class="stat">
                <span class="num"><?php echo $total_usuarios; ?></span>
                <span class="label">Talentos</span>
            </div>
            <div class="stat">
                <span class="num"><?php echo $total_empresas; ?></span>
                <span class="label">Empresas</span>
            </div>
            <div class="stat">
                <span class="num"><?php echo $total_ofertas; ?></span>
                <span class="label">Vacantes</span>
            </div>
            <div class="stat">
                <span class="num">87%</span>
                <span class="label">Éxito laboral</span>
            </div>
        </section>

        <!-- OFERTAS DESTACADAS REALES -->
        <section class="ofertas">
            <h2>Empieza por aquí</h2>
            <div class="lista-ofertas">
                <?php if (count($ofertas_destacadas) == 0): ?>
                    <p style="text-align:center; grid-column: 1 / -1; color: #64748b;">Pronto publicaremos nuevas ofertas. ¡Vuelve pronto!</p>
                <?php else: ?>
                    <?php foreach ($ofertas_destacadas as $o): ?>
                        <article class="card-oferta">
                            <p class="oferta-empresa"><?php echo htmlspecialchars($o['empresa']); ?></p>
                            <h3><?php echo htmlspecialchars($o['titulo']); ?></h3>
                            <div class="oferta-tags">
                                <span>📍 <?php echo htmlspecialchars($o['ubicacion']); ?></span>
                                <span>💼 <?php echo htmlspecialchars($o['area']); ?></span>
                            </div>
                            <a href="ofertas.php" class="btn-ghost">Ver vacante</a>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section class="cta-final">
            <h2>Tu primer empleo está más cerca de lo que crees.</h2>
            <p>Únete gratis hoy. Sin contratos, sin letra pequeña, y sin discriminación por la experiencia que aún no has tenido oportunidad de ganar.</p>
            <a href="registro.php" class="btn-accent">Crear mi perfil junior</a>
        </section>
    </main>

    <?php @include_once('./includes/footer.php'); ?>
</body>
</html>