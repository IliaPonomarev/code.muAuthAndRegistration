<?php
$id = $_GET['id'];

$host = 'localhost'; // адрес сервера
$database = 'auth'; // имя базы данных
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

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

</tr>";
}

$content .= '</table>';

echo $content;