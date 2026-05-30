<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="./assets/css/stylos.css">
    <link rel="stylesheet" href="./assets/css/botones.css">
</head>
<body>
    <?php @include_once('./includes/navbar.php');?>
    <main>
        <section class="hero">
    <div class="hero-texto">
      <span class="eyebrow">Empleo junior · España</span>
      <h1>Tu primer empleo no debería depender de la experiencia que no tienes.</h1>
      <p>JuniorWorld evalúa tu talento por aptitudes y ganas, no por años de currículum.</p>
      <div class="hero-botones">
        <button class="btn-primary">Soy candidato</button>
        <button class="btn-ghost">Soy empresa</button>
      </div>
    </div>
    <div class="hero-imagen">
      <!-- imagen o tarjeta destacada -->
    </div>
  </section>
   <section class="como-funciona">
    <h2>Tres pasos hacia tu primer empleo</h2>
    <div class="pasos">
      <article class="paso">
        <span class="num">01</span>
        <h3>Crea tu perfil</h3>
        <p>Sin un CV largo. Cuéntanos qué sabes hacer.</p>
      </article>
      <article class="paso">
        <span class="num">02</span>
        <h3>Conecta con empresas</h3>
        <p>Ofertas filtradas por aptitudes, no por experiencia.</p>
      </article>
      <article class="paso">
        <span class="num">03</span>
        <h3>Crece en tu primer trabajo</h3>
        <p>Mentoría, formación y comunidad junior.</p>
      </article>
    </div>
  </section>
  <!-- 3️⃣ BENEFICIOS: candidatos vs empresas -->
  <section class="beneficios">
    <div class="bloque-beneficio">
      <h3>Para candidatos</h3>
      <ul>
        <li>Test de aptitudes que destaca tu potencial</li>
        <li>Sin discriminación por experiencia</li>
        <li>Mentoría y comunidad gratis</li>
      </ul>
    </div>
    <div class="bloque-beneficio">
      <h3>Para empresas</h3>
      <ul>
        <li>Filtra por aptitudes, no por años</li>
        <li>+25.000 candidatos junior verificados</li>
        <li>Dashboard con métricas</li>
      </ul>
    </div>
  </section>
   <!-- 4️⃣ STATS: cifras (fondo oscuro) -->
  <section class="stats">
    <div class="stat"><span class="num">24.891</span><span>Candidatos activos</span></div>
    <div class="stat"><span class="num">1.247</span><span>Empresas</span></div>
    <div class="stat"><span class="num">3.406</span><span>Ofertas en 2026</span></div>
    <div class="stat"><span class="num">87%</span><span>Inserción laboral</span></div>
  </section>
  <!-- 5️⃣ OFERTAS DESTACADAS -->
  <section class="ofertas">
    <h2>Empieza por aquí</h2>
    <div class="lista-ofertas">
      <!-- tarjetas de oferta -->
    </div>
  </section>

  <!-- 6️⃣ CTA FINAL -->
  <section class="cta-final">
    <h2>Tu primer empleo está más cerca de lo que crees.</h2>
    <button class="btn-accent">Crear mi perfil junior</button>
  </section>
    </main>
    <?php @include_once('./includes/footer.php');?>
</body>
</html>