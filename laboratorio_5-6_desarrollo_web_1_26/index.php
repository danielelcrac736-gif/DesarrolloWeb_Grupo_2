<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Biblioteca - SIS 256</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Gestión de Biblioteca - SIS 256</h1>
    
    <div class="contenedor">
        <nav>
            <h3>Menú Libros</h3>
            <ul>
                <li><a href="javascript:cargarContenido('libros/lista.php')">Listar Libros</a></li>
                <li><a href="javascript:cargarContenido('libros/registro.php')">Registrar Libro</a></li>
            </ul>
            
            <h3>Menú Usuarios</h3>
            <ul>
                <li><a href="javascript:cargarContenido('usuarios/lista.php')">Listar Usuarios</a></li>
                <li><a href="javascript:cargarContenido('usuarios/registro.php')">Registrar Usuario</a></li>
            </ul>
            
            <h3>Menú Préstamos</h3>
            <ul>
                <li><a href="javascript:cargarContenido('prestamos/lista.php')">Listar Préstamos</a></li>
                <li><a href="javascript:cargarContenido('prestamos/registro.php')">Nuevo Préstamo</a></li>
            </ul>
        </nav>
        
        <div id="contenido">
            <h2>Bienvenido al Sistema de Biblioteca</h2>
            <p>Selecciona una opción del menú para comenzar.</p>
        </div>
    </div>
    
    <script src="js/fetch.js"></script>
</body>
</html>