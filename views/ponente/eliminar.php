
<form action="" method="POST">
    <label for="ponentes"></label>
    <select name="data[ponente]" id="-ponentes">
        <?php foreach($ponentes as $ponente): ?>
            <option value=<?= $ponente -> nombre ?>><?= $ponente -> nombre ?></option>
        <?php endforeach ?>
    </select>
</form>