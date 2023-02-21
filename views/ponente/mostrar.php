
<?php if(isset($_SESSION['login'])): ?>

    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Imagen</th>
                <th>Tags</th>
                <th>Redes</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ponentes as $ponente): ?>
                <tr>
                    <td><?= $ponente['id'] ?></td>
                    <td><?= $ponente['nombre'] ?></td>
                    <td><?= $ponente['apellidos'] ?></td>
                    <td><?= $ponente['imagen'] ?></td>
                    <td><?= $ponente['tags'] ?></td>
                    <td><?= $ponente['redes'] ?></td>
                    <td><a href="<?= $_ENV['BASE_URL']?>ponente/borrar/<?= $ponente['id']?>">Borrar Ponente</a></td>
                    <td><a href="<?= $_ENV['BASE_URL']?>ponente/actualizar/<?= $ponente['id']?>">Editar</a></td>
                </tr>
        
            <?php endforeach ?>
        </tbody>
    </table>

<?php else: ?>

    <h1>Necesitasestar logueado para ver los ponentes</h1>

<?php endif; ?>