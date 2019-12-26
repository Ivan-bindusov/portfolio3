<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/Db.php");

$db = Db::getInstance();
$articles = $db->getAll();

if(isset($_POST["submit"])) {
    if(!empty($_POST["title"]) && !empty($_POST["content"]) && $_POST["id"]) {
        $id = (int)$_POST["id"];
        $title = htmlspecialchars($_POST["title"]);
        $content = htmlspecialchars($_POST["content"]);
        $res = $db->update($id, $title, $content);
        if($res){
            $_SESSION["MESSAGE"] = "Статья успешно изменена";
            header("Location: ".$_SERVER["REQUEST_URI"]);
        }else{
            $_SESSION["ERROR_MESSAGE"] = "Статья не была изменена";
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
                <div class="col-md-12">
                    <form method="post" action="/edit.php">
                        <div class="form-group">
                            <label class="form-label" for="title">Заголовок</label>
                            <input class="form-control" id="title" type="text" name="title" value="<?=$article["title"]?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="content">Текст</label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?=$article["content"]?></textarea>
                        </div>
                        <input type="hidden" name="id" value="<?=$article["id"]?>">
                        <input class="btn btn-primary" type="submit" name="submit" value="Сохранить">
                    </form>
                </div>
            <?endforeach?>
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