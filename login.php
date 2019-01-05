<?php

session_start();
$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));


$query = "SELECT id, login, date FROM users ";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) {
    ;
}
$content = '<table>
<tr>
<th>id</th>
<th>login</th>
<th>profile list</th>
</tr>';
foreach ($data as $page) {
    $content .= "<tr>
<td>{$page['id']}</td>
<td>{$page['login']}</td>
<td><a href=\"/1/profile.php?id={$page['id']}\">profile list</a></td>

</tr>";
}
$content .= '</table>';

echo $content;


if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login = '$login'";

    $result = mysqli_query($link, $query);

    $user = mysqli_fetch_assoc($result);
    if (!empty($user)) {
        $hash = $user['password'];

        if (password_verify($_POST['password'], $hash)) {
            $_SESSION['message'] = ['text' => 'your auth successfully'];
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $login;
            $_SESSION['status'] = $user['status'];
            echo 'everything okay';
//        header('Location: /1/index2.php'); die();
        } else {
            echo 'something wrong';
            echo '
    <form action="" method="POST">
    password:
    <input type="password" name="password">
    login:
    <input type="text" name="login">
    <input type="submit">
</form>
    ';
        }

    } else {
        echo 'Неправильный логин или пароль';
        echo '
    <form action="" method="POST">
    password:
    <input type="password" name="password">
    login:
    <input type="text" name="login">
    <input type="submit">
</form>
    ';
    }
} else {
    echo '
    <form action="" method="POST">
    password:
    <input type="password" name="password">
    login:
    <input type="text" name="login">
    <input type="submit">
</form>
    ';
}
//include 'index2.php';


$text = $_SESSION['logoutText']['text'];

if (isset($_SESSION['logoutText'])) {

    echo $text;

    unset($_SESSION['logoutText']);
}






