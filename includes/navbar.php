<nav>
    <ul class='contenedorNav'>
        <li class='item-grid n1'>Nattaworld</li>
        <li class='item-grid n2'><a href="/nattaworld/inicio.php">Inicio</a></li>
        <li class='item-grid n3'><a href="/nattaworld/candidato.php">Para candidatos</a></li>
        <li class='item-grid n4'><a href="/nattaworld/empresa.php">Para empresas</a></li>
        <li class='item-grid n5'><a href="/nattaworld/ofertas.php">Ofertas</a></li>

        <li class='item-grid' style="grid-column: 7; justify-self: end; display: flex; align-items: center;">
            <button id="btnTema" class="btn-nav-ghost" style="cursor: pointer; background: transparent;" title="Cambiar tema">🌙</button>
        </li>

        <?php if (!isset($_SESSION['id'])): ?>
            <li class='item-grid n7'><a class="btn-nav-ghost" href="/nattaworld/login.php">Entrar</a></li>
            <li class='item-grid n8'><a class="btn-nav-solid" href="/nattaworld/registro_tipo.php">Crear cuenta</a></li>

        <?php elseif ($_SESSION['rol'] == 'candidato'): ?>
            <li class='item-grid n7'><a class="btn-nav-ghost" href="/nattaworld/candidato/panel.php"><?php echo htmlspecialchars($_SESSION['nombre']); ?> · Candidato</a></li>
            <li class='item-grid n8'><a class="btn-nav-solid" href="/nattaworld/cerrar_sesion.php">Cerrar sesión</a></li>

        <?php elseif ($_SESSION['rol'] == 'empresa'): ?>
            <li class='item-grid n7'><a class="btn-nav-ghost" href="/nattaworld/empresa/panel_empresa.php"><?php echo htmlspecialchars($_SESSION['nombre']); ?> · Empresa</a></li>
            <li class='item-grid n8'><a class="btn-nav-solid" href="/nattaworld/cerrar_sesion.php">Cerrar sesión</a></li>
        <?php elseif ($_SESSION['rol'] == 'admin'): ?>
            <li class='item-grid n7'><a class="btn-nav-ghost" href="/nattaworld/admin/panel_admin.php"><?php echo htmlspecialchars($_SESSION['nombre']); ?> · Admin</a></li>
            <li class='item-grid n8'><a class="btn-nav-solid" href="/nattaworld/cerrar_sesion.php">Cerrar sesión</a></li>

        <?php endif; ?>
    </ul>
</nav>

<script src="/nattaworld/assets/js/tema.js"></script>