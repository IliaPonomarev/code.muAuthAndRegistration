<?php
session_start();

$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));
if (!empty($_SESSION['auth'])) {
    $id = $_SESSION['id']; // id юзера из сессии
    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    $hash = $user['password']; // соленый пароль из БД

    echo '
    <form method="POST">
    <p>old password:</p>
<input type="text" name="old_password">
<p>new password:</p>
<input type="text" name="new_password">
<p>confirm new password:</p>
<input type="text" name="confirm">
<input type="submit" name="submit">
</form>
    ';

    // Проверяем соответствие хеша из базы введенному старому паролю
    if (password_verify($_POST['old_password'], $hash)) {
        if ($_POST['password'] == $_POST['confirm']) {
            // Все ок, меняем пароль...

            // Хеш нового пароля:
            $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

            // Выполним UPDATE запрос:
            $query = "UPDATE users SET password='$newPasswordHash' WHERE id='$id'";
            mysqli_query($link, $query);
            echo 'password changed';
        } else {
            echo 'Passwords do not match';
        }
    } else {
        echo 'Старый пароль введен неверно';
    }
} else {
    echo 'введите логин и пароль';
    echo "<a href=\"/1/login.php\">auth</a>";
}