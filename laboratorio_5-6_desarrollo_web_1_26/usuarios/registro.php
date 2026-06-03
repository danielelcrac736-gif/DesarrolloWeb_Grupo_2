<h2>Registrar Nuevo Usuario</h2>
<form id="forminsertar">
    <div>
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    
    <div>
        <label for="carnet">Carnet / CI:</label>
        <input type="text" id="carnet" name="carnet" required>
    </div>
    
    <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">
    </div>
    
    <div>
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo">
    </div>
    
    <div>
        <input type="button" value="Guardar Usuario" onclick="createUsuario()">
        <input type="button" value="Cancelar" onclick="cargarContenido('usuarios/lista.php')" style="background-color: #6c757d;">
    </div>
</form>