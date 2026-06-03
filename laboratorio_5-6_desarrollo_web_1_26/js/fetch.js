function cargarContenido(abrir) {
    var contenedor = document.getElementById('contenido');
    fetch(abrir)
        .then(response => response.text())
        .then(data => contenedor.innerHTML = data);
}

function createLibro() {
    var forminsertar = document.getElementById('forminsertar');
    var datos = new FormData(forminsertar);
    
    fetch("libros/create.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        if (data.status === "ok") {
            cargarContenido('libros/lista.php');
        }
    });
}

function cargarEditarLibro(id) {
    fetch('libros/form-editar.php?id=' + id)
        .then(response => response.text())
        .then(data => document.getElementById('contenido').innerHTML = data);
}

function updateLibro() {
    var formeditar = document.getElementById('formeditar');
    var datos = new FormData(formeditar);
    
    fetch("libros/update.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        if (data.status === "ok") {
            cargarContenido('libros/lista.php');
        }
    });
}

function eliminarLibro(id) {
    if (confirm("¿Está seguro de que desea eliminar este libro?")) {
        fetch('libros/delete.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje);
                if (data.status === "ok") {
                    cargarContenido('libros/lista.php');
                }
            });
    }
}

function createUsuario() {
    var forminsertar = document.getElementById('forminsertar');
    var datos = new FormData(forminsertar);
    
    fetch("usuarios/create.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        if (data.status === "ok") {
            cargarContenido('usuarios/lista.php');
        }
    });
}

function cargarEditarUsuario(id) {
    fetch('usuarios/form-editar.php?id=' + id)
        .then(response => response.text())
        .then(data => document.getElementById('contenido').innerHTML = data);
}

function updateUsuario() {
    var formeditar = document.getElementById('formeditar');
    var datos = new FormData(formeditar);
    
    fetch("usuarios/update.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        if (data.status === "ok") {
            cargarContenido('usuarios/lista.php');
        }
    });
}

function eliminarUsuario(id) {
    if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
        fetch('usuarios/delete.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje);
                if (data.status === "ok") {
                    cargarContenido('usuarios/lista.php');
                }
            });
    }
}

function createPrestamo() {
    var forminsertar = document.getElementById('forminsertar');
    var datos = new FormData(forminsertar);
    
    fetch("prestamos/create.php", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        if (data.status === "ok") {
            cargarContenido('prestamos/lista.php');
        }
    });
}

function devolverPrestamo(id) {
    if (confirm("¿Marcar este préstamo como devuelto?")) {
        fetch('prestamos/devolver.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje);
                if (data.status === "ok") {
                    cargarContenido('prestamos/lista.php');
                }
            });
    }
}

function filtrarPrestamos() {
    var libro = document.getElementById('filtro_libro') ? document.getElementById('filtro_libro').value : '';
    var usuario = document.getElementById('filtro_usuario') ? document.getElementById('filtro_usuario').value : '';
    var estado = document.getElementById('filtro_estado') ? document.getElementById('filtro_estado').value : '';
    
    fetch(`prestamos/lista.php?filtro_libro=${libro}&filtro_usuario=${usuario}&filtro_estado=${estado}`)
        .then(response => response.text())
        .then(data => document.getElementById('contenido').innerHTML = data);
}