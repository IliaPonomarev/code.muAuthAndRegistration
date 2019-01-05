<?php
session_start();
$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

if (!empty($_POST['login']) && !empty($_POST['password'])
    && !empty($_POST['email']) && !empty($_POST['date'])) {
    if ($_POST['password'] == $_POST['confirm']) {
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $date = $_POST['date'];
        $registration_date = date('Y-m-d');

        $rightLogin = preg_match("/^([-_a-zA-Z0-9]){5,10}$/", $login);
        if ($rightLogin) {
            $query = "SELECT * FROM users WHERE login = '$login'";
            $user = mysqli_fetch_assoc(mysqli_query($link, $query));
            if (empty($user)) {
                $query = "INSERT INTO users SET login = '$login', password='$password', email = '$email', date = '$date', registration_date = '$registration_date',status = 'user' ";
                mysqli_query($link, $query);
                $_SESSION['auth'] = true;

                $id = mysqli_insert_id($link);
                $_SESSION['id'] = $id;
            } else {
                echo 'that login busy';
            }
        }
    } else {
        echo 'enter the same password';
    }
}
?>

<form action="" method="POST">
    <br>login:<?php if (!$rightLogin) {
        echo 'login has exists only latin letters and its lenght has 4-6 letters';
    } ?><br>
    <input type="text" name="login" value="<?= $_POST['login'] ?>">
    <br>password:
    <input type="password" name="password" value="<?= $_POST['password'] ?>">
    <br>repeat:<br>
    <input type="password" name="confirm" value="<?= $_POST['confirm'] ?>">
    <br>email:<br>
    <input type="email" name="email" value="<?= $_POST['email'] ?>">
    <br>date:<br>
    <input type="text" name="date" value="<?= $_POST['date'] ?>">
    <input type="submit">
</form>
