<?php

require($_SERVER["DOCUMENT_ROOT"]."/Db.php");

if(isset($_POST["submit"])) {
    if(!empty($_POST["title"]) && !empty($_POST["content"])) {
        $db = Db::getInstance(); //получаем объект класса работы с базой данных
        $title = htmlspecialchars($_POST["title"]);
        $content = htmlspecialchars($_POST["content"]);
        $res = $db->add($title, $content); //выполняем добавление записи в базу данных
        if($res){
            $_SESSION["MESSAGE"] = "Статья успешно добавлена";
        }else{
            $_SESSION["ERROR_MESSAGE"] = "Статья не была добавлена";
        }
    }else{
        $_SESSION["ERROR_MESSAGE"] = "Заполните все поля";
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/style/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/style/bootstrap.min.css">
    <link rel="stylesheet" href="/style/main.css">
    <title>Blog</title>
</head>
<body>

<div class="container">
    <?php
    include('menu.php');
    ?>
    <?if(isset($_SESSION["ERROR_MESSAGE"])):?>
        <div class="alert alert-danger">
            <?=$_SESSION["ERROR_MESSAGE"]?>
        </div>
    <?endif?>
    <?if(isset($_SESSION["MESSAGE"])):?>
        <div class="alert alert-success">
            <?=$_SESSION["MESSAGE"]?>
        </div>
    <?endif?>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="/add.php">
                <div class="form-group">
                    <label class="form-label" for="title">Введите заголовок</label>
                    <input class="form-control" id="title" type="text" name="title">
                </div>
                <div class="form-group">
                    <label class="form-label" for="content">Введите текст</label>
                    <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Добавить статью">
            </form>
        </div>
    </div>
</div>

<script link="/libs/bootstrap.min.js"></script>
</body>
</html>

<?php
if(!isset($_POST["submit"])) {
    unset($_SESSION["MESSAGE"]);
    unset($_SESSION["ERROR_MESSAGE"]);
}
?>