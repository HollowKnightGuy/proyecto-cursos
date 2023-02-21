<?php if(isset($_SESSION['login'])): ?>

    <form action="<?= $_ENV['BASE_URL'] ?>ponente/actualizar/<?= $ponente[0]['id'] ?>" method="POST">
        <label for="Nombre">Nombre:</label>
        <input type="text" name="data[nombre]" id="Nombre" value=<?= $ponente[0]['nombre'] ?>>
        <br><br>
        <label for="Apellidos">Apellidos:</label>
        <input type="text" name="data[apellidos]" id="Apellidos" value=<?= $ponente[0]['apellidos'] ?>>
        <br><br>
        <label for="Imagen">Imagen:</label>
        <input type="text" name="data[imagen]" id="Imagen" value=<?= $ponente[0]['imagen'] ?>>
        <br><br>
        <label for="Tags">Tags:</label>
        <input type="text" name="data[tags]" id="Tags" value=<?= $ponente[0]['tags'] ?>>
        <br><br>
        <label for="Redes">Redes:</label>
        <input type="text" name="data[redes]" id="Redes" value=<?= $ponente[0]['redes'] ?>>
        <br><br>
        <input type="submit">
        <?php if(isset($mensaje)): ?>
            <span style="color:red"><?= json_encode($mensaje) ?></span>
        <?php endif; ?>
    </form>

<?php else: ?>

    <h1>Necesitas estar logueado para editar ponentes</h1>

<?php endif; ?>