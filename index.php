<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/Db.php");

$db = Db::getInstance();
$articles = $db->getAll();

if(isset($_POST["delete"])) {
    $res = $db->delete($_POST["id"]);
    if($res) {
        $_SESSION["MESSAGE"] = "Запись успешно удалена";
        header("Location: /");
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
        <?foreach($articles as $article):?>
            <div class="col-md-9">
                <h2><?=$article["title"]?></h2>
                <p><?=$article["content"]?></p>
            </div>
            <div class="col-md-3">
                <form method="post" action="/">
                    <input name="id" value="<?=$article["id"]?>" type="hidden">
                    <input type="submit" name="delete" value="Удалить">
                </form>
            </div>
        <?endforeach?>
    </div>
</div>

<script link="/libs/bootstrap.min.js"></script>
</body>
</html>

<?php
unset($_SESSION["MESSAGE"]);
unset($_SESSION["ERROR_MESSAGE"]);
?>