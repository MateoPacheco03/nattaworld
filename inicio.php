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
    <title>Natt World — Tu primer empleo</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
</head>
<body>

    <?php @include_once('./includes/navbar.php'); ?>

    <main>
        <!-- HERO -->
        <section class="hero">
            <div class="hero-texto">
                <span class="eyebrow">Empleo junior · España</span>
                <h1>Tu primer empleo no debería depender de la experiencia que no tienes.</h1>
                <p>Natt World evalúa tu talento por aptitudes y ganas, no por años de currículum. Encuentra empresas que apuestan por ti desde el día uno.</p>
                <div class="hero-botones">
                    <a href="registro.php" class="btn-primary">Soy candidato</a>
                    <a href="empresa/registro_empresa.php" class="btn-ghost">Soy empresa</a>
                </div>
            </div>
            <div class="hero-imagen">
                <div class="tarjeta-match">
                    <span class="eyebrow">Match score</span>
                    <p class="match-titulo">Junior Frontend · Glovo</p>
                    <div class="match-num">68<span>/100</span></div>
                    <p class="match-aptitudes">Tus aptitudes coinciden: <strong>HTML, CSS</strong></p>
                </div>
                <div class="tarjeta-oferta-mini">
                    <span class="badge-nueva">● Nueva oferta</span>
                    <p class="oferta-mini-titulo">Junior Data Analyst</p>
                    <p class="oferta-mini-empresa">Cabify · Madrid · Remoto</p>
                    <div class="oferta-mini-tags">
                        <span>SQL</span><span>Excel</span><span>Python</span>
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
                    <p>Sin un CV largo. Cuéntanos qué sabes hacer y qué quieres aprender.</p>
                </article>
                <article class="paso">
                    <span class="num">02</span>
                    <h3>Conecta con empresas</h3>
                    <p>Ofertas filtradas por aptitudes, no por años de experiencia.</p>
                </article>
                <article class="paso">
                    <span class="num">03</span>
                    <h3>Crece en tu primer trabajo</h3>
                    <p>Mentoría, formación y comunidad junior. No estás solo en el camino.</p>
                </article>
            </div>
        </section>

        <!-- BENEFICIOS -->
        <section class="beneficios">
            <div class="bloque-beneficio">
                <h3>Para candidatos</h3>
                <ul>
                    <li>Test de aptitudes que destaca tu potencial real</li>
                    <li>Sin discriminación por edad, género o experiencia</li>
                    <li>Solo empresas que aceptan perfiles junior</li>
                    <li>Mentoría y comunidad incluidas, gratis</li>
                </ul>
                <a href="registro.php" class="btn-primary">Crear cuenta de candidato</a>
            </div>
            <div class="bloque-beneficio">
                <h3>Para empresas</h3>
                <ul>
                    <li>Filtra por aptitudes, no por años de carrera</li>
                    <li>Acceso a candidatos junior verificados</li>
                    <li>Dashboard con métricas y seguimiento</li>
                    <li>Marca tu empresa como Junior-Friendly</li>
                </ul>
                <a href="empresa/registro_empresa.php" class="btn-accent">Publicar oferta gratis</a>
            </div>
        </section>

        <!-- STATS REALES -->
        <section class="stats">
            <div class="stat"><span class="num"><?php echo $total_usuarios; ?></span><span>Candidatos registrados</span></div>
            <div class="stat"><span class="num"><?php echo $total_empresas; ?></span><span>Empresas</span></div>
            <div class="stat"><span class="num"><?php echo $total_ofertas; ?></span><span>Ofertas publicadas</span></div>
            <div class="stat"><span class="num">87%</span><span>Inserción laboral</span></div>
        </section>

        <!-- OFERTAS DESTACADAS REALES -->
        <section class="ofertas">
            <h2>Empieza por aquí</h2>
            <div class="lista-ofertas">
                <?php if (count($ofertas_destacadas) == 0): ?>
                    <p>Pronto publicaremos nuevas ofertas. ¡Vuelve pronto!</p>
                <?php else: ?>
                    <?php foreach ($ofertas_destacadas as $o): ?>
                        <article class="card-oferta">
                            <p class="oferta-empresa"><?php echo htmlspecialchars($o['empresa']); ?></p>
                            <h3><?php echo htmlspecialchars($o['titulo']); ?></h3>
                            <div class="oferta-tags">
                                <span>📍 <?php echo htmlspecialchars($o['ubicacion']); ?></span>
                                <span><?php echo htmlspecialchars($o['area']); ?></span>
                            </div>
                            <a href="candidato/ofertas.php" class="btn-ghost">Ver oferta</a>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section class="cta-final">
            <h2>Tu primer empleo está más cerca de lo que crees.</h2>
            <p>Únete gratis hoy. Sin contratos, sin letra pequeña, sin discriminación por experiencia.</p>
            <a href="registro.php" class="btn-accent">Crear mi perfil junior</a>
        </section>
    </main>

    <?php @include_once('./includes/footer.php'); ?>
</body>
</html>