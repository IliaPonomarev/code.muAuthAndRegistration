<?php
////session_start();
////
//////$_SESSION['message'] = ['text' => 'your auth successfully'];
////$text = $_SESSION['message']['text'];
////
////if(isset($_SESSION['message'])) {
////
////    echo $text;
////
////    unset($_SESSION['message']);
////}
//?>
<?php
session_start();

if (!empty($_SESSION['auth'])) {
    $userName = $_SESSION['login'];
    echo "Вы зашли как $userName";
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
    <p>Добро пожаловать</p>
    </body>
    </html>
    <?php
} else {
    ?>
    <p>авторизуйтесь</p>
    <?php
} ?>



