<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Интернет Магазин:</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <?php $this->getStyles(); ?>
</head>
<body>
<nav class="navbar navbar-dark bg-dark navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Интернет Магазин</a>
        </div>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="#">Все товары</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Категории</a></li>
                <li class="nav-item"><a class="nav-link" href="#">В корзину</a></li>
                <li class="nav-item"><a class="nav-link" href="#"></a></li>
            </ul>

            <ul class="nav navbar-right">
                <li class="nav-item"><a class="nav-link" href="">Войти</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Регистрация</a></li>
            </ul>

    </div>
</nav>
<div class="container">
    <div class="starter-template">
        <?php
        if(isset($_SESSION['res']['answer'])){
            echo $_SESSION['res']['answer'];
            unset($_SESSION['res']);
        }
        ?>

