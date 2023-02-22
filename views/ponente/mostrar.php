

    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Imagen</th>
                <th>Tags</th>
                <th>Redes</th>
                <?php if(isset($_SESSION['login'])): ?>

                    <th colspan="2">Acciones</th>

                <?php endif; ?>

            </tr>
        </thead>
        <tbody>
            <!-- Recorremos un array de ponentes -->
            <?php foreach($ponentes as $ponente): ?>

                <tr>
                    <td><?= $ponente['id'] ?></td>
                    <td><?= $ponente['nombre'] ?></td>
                    <td><?= $ponente['apellidos'] ?></td>
                    <td><?= $ponente['imagen'] ?></td>
                    <td><?= $ponente['tags'] ?></td>
                    <td><?= $ponente['redes'] ?></td>
                    <?php if(isset($_SESSION['login'])): ?>

                        <td><a href="<?= $_ENV['BASE_URL']?>ponente/borrar/<?= $ponente['id']?>">Borrar Ponente</a></td>
                        <td><a href="<?= $_ENV['BASE_URL']?>ponente/actualizar/<?= $ponente['id']?>">Editar</a></td>

                    <?php endif; ?>
                </tr>
        
            <?php endforeach ?>
        </tbody>
    </table>

