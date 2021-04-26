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
            <a class="navbar-brand" href="/">Интернет Магазин</a>
        </div>
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="/">Все товары</a></li>
            <li class="nav-item"><a class="nav-link" href="/category">Категории</a></li>
            <li class="nav-item"><a class="nav-link" href="/basket">В корзину</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin">Админка</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?=$_SESSION['currencyCode']?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php foreach($_SESSION['currencies'] as $code => $symbol):?>
                        <li><a class="dropdown-item" href="/currency/code/<?=$code?>"><?=$symbol?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
        </ul>

        <ul class="nav navbar-right">
            <?php if(!isset($_SESSION['guest'])):?>
                <li class="nav-item"><a class="nav-link" href="/login">Войти</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Регистрация</a></li>
            <?php else:?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?=$_SESSION['guest']['name'] ? : $_SESSION['guest']['email']?></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/logout">Выйти</a></li>
                    </ul>
                </li>
            <?php endif?>
        </ul>

    </div>
</nav>
<div class="container">
    <div class="starter-template">
        <?php if(isset($_SESSION['res']['success'])):?>
            <p class="alert alert-success"><?=$_SESSION['res']['success']?></p>
            <?php unset($_SESSION['res']);?>
        <?endif;?>
        <?php if(isset($_SESSION['res']['warning'])):?>
            <p class="alert alert-warning"><?=$_SESSION['res']['warning']?></p>
            <?php unset($_SESSION['res']);?>
        <?endif;?>

