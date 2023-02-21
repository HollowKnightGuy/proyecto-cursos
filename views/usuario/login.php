
<form action="<?= $_ENV['BASE_URL'] ?>usuario/login" method="POST">
    <label for="Email">Email:</label>
    <input type="email" name="data[email]" id="Email">
    <br><br>
    <label for="Contraseña">Contraseña:</label>
    <input type="password" name="data[contrasenia]" id="Contraseña">
    <br><br>
    <input type="submit" value="Login">
    
    <?php if(isset($mensaje)): ?>
        <span style="color:red"><?= json_encode($mensaje) ?></span>
    <?php endif; ?>
</form>