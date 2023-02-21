
<form action="<?= $_ENV['BASE_URL'] ?>usuario/crear" method="POST">
    <label for="Nombre">Nombre:</label>
    <input type="text" name="data[nombre]" id="Nombre">
    <br><br>
    <label for="Apellidos">Apellidos:</label>
    <input type="text" name="data[apellidos]" id="Apellidos">
    <br><br>
    <label for="Email">Email:</label>
    <input type="email" name="data[email]" id="Email">
    <br><br>
    <label for="Contraseña">Contraseña:</label>
    <input type="password" name="data[contrasenia]" id="Contraseña">
    <br><br>
    <input type="submit" value="Registrar">
    
    <?php if(isset($mensaje)): ?>
        <span style="color:red"><?= json_encode($mensaje) ?></span>
    <?php endif; ?>
</form>