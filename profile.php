<?php
include('./comp/nav.php');
include('./api/config.php');

if (!isset($_GET['id'])) {
    header('Location: /404.php');
}

$uid = (int) $_GET['id'];

if ($_SESSION['uid'] == 0) {
    die('Make an account to access this page.');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$uid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: /404.php");
    exit;
}
$description;
if ($user['description'] == NULL) {
    $description = "No description set.";
} else {
    $description = $user['description'];
}

$m = $user['membership'];
?>

<div class="profile">
<title><?=$name?> - <?=$user['name']?>`s profile</title>

<h1>
    <img src="/images/bc/<?=$m?>.png" height=32px width=32px>
    <?=$user['name']?>`s profile
</h1>
<?=$user['name']?>`s description:<br>
<textarea style="height:200px;width:500px;resize:none;" readonly>
<?=htmlspecialchars($description)?>
</textarea>
<?php
if ($uid == $_SESSION['uid']) {
echo '
<hr>
<form method="POST" action="/api/setdesc.php">
<input name="d" maxlength="50"></input>
<button name="submit">Apply description</button>
</form>
';
}
?>
</div>
<?php
include('./comp/footer.php');
?>