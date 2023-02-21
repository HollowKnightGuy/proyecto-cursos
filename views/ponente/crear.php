<!-- Comprobamos si el usuario esta logueado -->

<?php if(isset($_SESSION['login'])): ?>

    <form action="<?= $_ENV['BASE_URL'] ?>ponente/crear" method="POST">
        <label for="Nombre">Nombre:</label>
        <input type="text" name="data[nombre]" id="Nombre">
        <br><br>
        <label for="Apellidos">Apellidos:</label>
        <input type="text" name="data[apellidos]" id="Apellidos">
        <br><br>
        <label for="Imagen">Imagen:</label>
        <input type="text" name="data[imagen]" id="Imagen">
        <br><br>
        <label for="Tags">Tags:</label>
        <input type="text" name="data[tags]" id="Tags">
        <br><br>
        <label for="Redes">Redes:</label>
        <input type="text" name="data[redes]" id="Redes">
        <br><br>

        <?php if(isset($mensaje)): ?>
            <span style="color:red"><?= json_encode($mensaje) ?></span>
        <?php endif; ?>

        <br><br>
        <input type="submit">
    </form>


<?php else: ?>

    <h1>Necesitas estar logueado para crear ponentes</h1>

<?php endif; ?>