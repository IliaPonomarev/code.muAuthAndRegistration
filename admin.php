<?php
session_start();

$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

if (!empty($_SESSION['auth'])) {
    if ($_SESSION['status'] == 'admin') {
        echo 'Эту информация видит только администратор';
        $query = "SELECT id, login,status FROM users";
        $result = mysqli_query($link, $query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row)
        $content = '<link rel="stylesheet" href="style.css">
<table>
<tr>
<th>login</th>
<th>status</th>
</tr>';

        foreach ($data as $page) {
            $status = $page['status'];
            $content .= "<tr>
<td>{$page['id']}</td>
<td>{$page['login']}</td>
<td class=\"$status\">{$page['status']}</td>
<td><a href=\"/1/admin.php?del={$page['id']}\">delete</a></td>
</tr>";
        }
        $content .= '</table>';
        echo $content;

    } else {
        echo 'Вы не администратор';
    }
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $query = "DELETE FROM users WHERE id = $id ";
        mysqli_query($link, $query) or die(mysqli_error($link));
    }
} else {
    echo 'введите логин и пароль';
    echo "<a href=\"/1/login.php\">auth</a>";
}

