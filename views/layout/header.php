<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1><a href="<?= $_ENV['BASE_URL'] ?>">Proyecto Cursos</a></h1>
        <br><br>
        <nav>
            <a href="<?= $_ENV['BASE_URL'] ?>">Mostrar Ponentes</a><br>
            <a href="<?= $_ENV['BASE_URL'] ?>ponente/crear">Crear Ponente</a><br>
            <a href="<?= $_ENV['BASE_URL'] ?>usuario/crear">Registrarse</a><br>
            <a href="<?= $_ENV['BASE_URL'] ?>usuario/login">Log in</a>
        </nav>
        <br><br>
    </header>