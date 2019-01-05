<?php
session_start();

$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));
if (!empty($_SESSION['auth'])){
    $id = $_SESSION['id']; // id юзера из сессии
    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    $hash = $user['password']; // соленый пароль из БД

    echo '
    <form method="POST">
    <input type="password" name="old_password">
<input type="submit" name="submit" value="Delete">
</form>
    ';


    // Проверяем соответствие хеша из базы введенному старому паролю
    if (password_verify($_POST['old_password'], $hash)) {
        if (isset($_POST['submit'])){
// Выполним UPDATE запрос:
            $query = "DELETE FROM users WHERE id='$id'";
            mysqli_query($link, $query);
            echo 'your page deleted';
        }


    } else {
        echo 'Старый пароль введен неверно';
    }
} else{
    echo 'введите логин и пароль';
    echo "<a href=\"/1/login.php\">auth</a>";
}