<?php
session_start();
$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

if (!empty($_SESSION['auth'])) {
    $id = $_SESSION['id'];
    $query = "SELECT id, login, date FROM users WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) {
        ;
    }

    $content = '<table>
<tr>
<th>id</th>
<th>login</th>
<th>дата рождения</th>
</tr>';

    foreach ($data as $page) {
        $content .= "<tr>
<td>{$page['id']}</td>
<td>{$page['login']}</td>
<td>{$page['date']}</td>
<td><a href=\"/1/personalArea.php?id={$page['id']}\">edit</a></td>
</tr>";
    }
    $content .= '</table>';
    echo $content;
    if (isset($_GET['id'])) {
        echo '<form>
<input type="text" name="newLogin">
<input type="text" name="newDate">
<input type="submit" name="submit">
</form>';
    }
    if (!empty($_GET['newLogin']) && !empty($_GET['newDate'])) {
        echo 'исправлено';
        $newLogin = $_GET['newLogin'];
        $newDate = $_GET['newDate'];

        $query = "UPDATE users SET login = '$newLogin', date = '$newDate' WHERE id = '$id'";
        mysqli_query($link, $query);
    } else {
        echo 'что-то не так';
    }
} else {
    echo 'введите логин и пароль';
    echo "<a href=\"/1/login.php\">auth</a>";
}