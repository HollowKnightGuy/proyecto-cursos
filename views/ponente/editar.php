
<form action="" method="POST">
    <label for="Nombre">Nombre:</label>
    <input type="text" name="data[nombre]" id="Nombre" value=<?= $ponente -> nombre ?>>
    <br><br>
    <label for="Apellidos">Apellidos:</label>
    <input type="text" name="data[apellidos]" id="Apellidos" value=<?= $ponente -> apellidos ?>>
    <br><br>
    <label for="Imagen">Imagen:</label>
    <input type="text" name="data[imagen]" id="Imagen" value=<?= $ponente -> imagen ?>>
    <br><br>
    <label for="Tags">Tags:</label>
    <input type="text" name="data[tags]" id="Tags" value=<?= $ponente -> tags ?>>
    <br><br>
    <label for="Redes">Redes:</label>
    <input type="text" name="data[redes]" id="Redes" value=<?= $ponente -> redes ?>>
    <br><br>
    <input type="submit">
</form>