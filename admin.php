<?php
session_start();

$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

function checkBanned(&$banned){
    if ($banned == '1'){
        $banned = 'разбанить';
    } else {
        $banned =  'Забанить';
    }
return $banned;
}

if (!empty($_SESSION['auth'])) {
    if ($_SESSION['status'] == 'admin') {
        echo 'Эту информация видит только администратор';
        $query = "SELECT id, login,status_id,banned FROM users";
        $result = mysqli_query($link, $query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row)
        $content = '<link rel="stylesheet" href="style.css">
<table>
<tr>
<th>login</th>
<th>status</th>
</tr>';

        foreach ($data as $page) {
            $status = $page['status_id'];
            $banned = $page['banned'];
            checkBanned($banned);
            $content .= "<tr>
<td>{$page['id']}</td>
<td>{$page['login']}</td>
<td class=\"$status\">{$page['status_id']}</td>
<td><a href=\"/1/admin.php?del={$page['id']}\">delete</a></td>
<td><a href=\"/1/admin.php?changeRight={$page['id']}\">Поменять статус юзера </a></td>
<td><a href=\"/1/admin.php?banned={$page['id']}\">$banned </a></td>
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
    if (isset($_GET['changeRight'])){
        if ($status == 'admin'){
            $id = $_GET['changeRight'];
            $query = "UPDATE users SET  status_id = 'user' WHERE id = '$id'";
            mysqli_query($link, $query) or die(mysqli_error($link));
        }else {
            $id = $_GET['changeRight'];
            $query = "UPDATE users SET  status_id = 'admin' WHERE id = '$id'";
            mysqli_query($link, $query) or die(mysqli_error($link));
        }
    }
    if (isset($_GET['banned'])){
        $id = $_GET['banned'];
        $query = "SELECT banned FROM users WHERE id = '$id'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $banned = $row['banned'];

        if ($banned == '0'){
            $query = "UPDATE users SET banned='1' WHERE id='$id'";
            mysqli_query($link, $query) or die(mysqli_error($link));
        } else {
            $query = "UPDATE users SET banned='0' WHERE id='$id'";
            mysqli_query($link, $query) or die(mysqli_error($link));
        }

    }
} else {
    echo 'введите логин и пароль';
    echo "<a href=\"/1/login.php\">auth</a>";
}

