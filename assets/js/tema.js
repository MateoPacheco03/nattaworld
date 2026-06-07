// tema.js — Gestiona la preferencia de tema (claro/oscuro)
// mediante una cookie. No usa base de datos ni sesión de PHP.

// Lee el valor de una cookie por su nombre
function leerCookie(nombre) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const c = cookies[i].trim();
        if (c.indexOf(nombre + '=') === 0) {
            return c.substring(nombre.length + 1);
        }
    }
    return '';
}

// Guarda una cookie con caducidad en días
function guardarCookie(nombre, valor, dias) {
    const fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
    document.cookie = nombre + '=' + valor + '; expires=' + fecha.toUTCString() + '; path=/; SameSite=Lax';
}

// Aplica el tema guardado al cargar la página
function aplicarTemaGuardado() {
    const tema = leerCookie('nataworld_tema');
    if (tema === 'oscuro') {
        document.body.classList.add('tema-oscuro');
    }
}

// Alterna entre claro y oscuro y guarda la preferencia
function alternarTema() {
    document.body.classList.toggle('tema-oscuro');
    const esOscuro = document.body.classList.contains('tema-oscuro');
    guardarCookie('nataworld_tema', esOscuro ? 'oscuro' : 'claro', 365);
}

// Al cargar el documento, aplicar el tema y enganchar el botón
document.addEventListener('DOMContentLoaded', function () {
    aplicarTemaGuardado();
    const boton = document.getElementById('btnTema');
    if (boton) {
        boton.addEventListener('click', alternarTema);
    }
});