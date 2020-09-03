<?php
session_start();
require_once '../classes/CommentLogic.php';
require_once '../functions.php';
$_SESSION['err'] = array();
$_SESSION['suc'] = array();

if(isset($_POST['post'])) {
    if($result = ValidateForm::validate_form($_POST)) {
        FileWrite::file_write($result);
    }
}

$comments = FileRead::file_read();
if(empty($comments)) {
    $err = 'まだ書き込みはありません';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一言掲示板</title>
    <style>
    p {
        margin-bottom: 3px;
    }
    .li {
        list-style: none;
    }
    .div {
        width: auto;
        height: auto;
        background-color: #fafafa;
        margin: 4px;
    }
    .name, .date, .message {
        color: #666;
    }
    </style>
</head>
<body>
    <h1>一言掲示板</h1>

    <ul>
    <?php
    if(isset($_SESSION['err']) && !empty($_SESSION['err'])) {
        foreach($_SESSION['err'] as $e) {
            echo '<li>' . $e . '</li>';
        }
    } else if(is_null($_SESSION['err']) && !empty($_SESSION['suc'])) {
        echo '<li>' . $_SESSION['suc'] . '</li>';
    }
    ?>
    </ul>

    <h2>書き込む</h2>
    <form action="./index.php" method="post">
    <p><label for="name">お名前 : </label></p>
    <input id="name" type="text" name="name"></br>
    <p><label for="message">コメント : </label></p>
    <textarea id="message" name="message" cols="20" rows="4"></textarea></br>
    <input type="submit" name="post" value="投稿する">
    </form>

    <h2>コメント一覧</h2>
    <?php
    if(isset($err)):
    ?>
    <p><?= $err ?></p>
    <?php
    endif;
    ?>
    <ul>
    <?php
    if(!empty($comments)):
    foreach($comments as $comment):
    ?>
    <li class="li">
        <div class="div">
            <p><span class="name">Name</span> : <?= h($comment['name']) ?></p>
            <p><span class="date">Date</span> : <?= h($comment['date']) ?></p>
            <p><span class="message">Message</span> : <?= h($comment['message']) ?></p>
        </div>
    </li>
    <?php
    endforeach;
    endif;
    ?>
    </ul>
</body>
</html>