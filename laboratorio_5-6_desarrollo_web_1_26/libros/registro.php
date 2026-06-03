<h2>Registrar Nuevo Libro</h2>
<form id="forminsertar">
    <div>
        <label for="titulo">Título del Libro:</label>
        <input type="text" id="titulo" name="titulo" required>
    </div>
    
    <div>
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>
    </div>
    
    <div>
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn">
    </div>
    
    <div>
        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria">
    </div>
    
    <div>
        <label for="stock">Stock Inicial:</label>
        <input type="number" id="stock" name="stock" value="1" min="1" required>
    </div>
    
    <div>
        <input type="button" value="Guardar Libro" onclick="createLibro()">
    </div>
</form>