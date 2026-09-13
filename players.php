<?php
require_once "./api/config.php";
require_once "./comp/nav.php";
?>

<title><?= $name ?> - Players</title>

<br>
<div class="playerl">
<center>

<h1>Players</h1>

<?php
$page = (int)($_GET["i"] ?? 1);
if ($page < 1) $page = 1;

$bbla = ($page - 1) * 10;

$users = $pdo->query("SELECT uid, name FROM users ORDER BY uid ASC LIMIT 10 OFFSET $bbla");

while ($user = $users->fetch()) {
    echo '<a href="/profile?id=' . $user["uid"] . '">'
       . htmlspecialchars($user["name"])
       . '</a><br>';
}

echo "<br>";

if ($page > 1)
    echo '<a href="?i=' . ($page - 1) . '"><--</a> ';

echo '<a href="?i=' . ($page + 1) . '">--></a>';
?>

</center>
</div>

<br>

<?php include "./comp/footer.php"; ?>
