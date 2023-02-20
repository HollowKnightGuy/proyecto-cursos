

<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Imagen</th>
            <th>Tags</th>
            <th>Redes</th>
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
                <td><a href="<?= $_ENV['BASE_URL']?>.ponente/borrar/".<?= $ponente['id']?> ></a></td>
                <td><a href="<?= $_ENV['BASE_URL']?>.ponente/actualizar/".<?= $ponente['id']?> ></a></td>
            </tr>
    
        <?php endforeach ?>
    </tbody>
</table>