<?php
include('./comp/nav.php');
include('./api/config.php');

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$_SESSION['uid']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$m = $user['membership'];
$t = $user['theme'];

if ($_SESSION['uid'] == 0) {
    die('Make an account to access this page.');
}
?>
<br>
<!-- style="background-image: url('/images/studs/Universal.png');" -->
<div class="settingsp">
<h2>Account settings:</h2>
<h2>Name:</h2>
SOON
<h2>Password:</h2>
SOON
<h2>Discord:</h2>
<?php
if ($user['dc_verif'] == 0) {
    echo '<a href="/api/dclogin.php">Link your Discord</a>';
} else {
    echo 'Discord linked: @' . htmlspecialchars($user['dc_uname']);
    echo '<br><a href="/api/unlink.php">Unlink discord</a>';
}
?>
<h2>Membership:</h2>
<form method="POST" action="/api/setmemb.php" style="display:flex;align-items:center;">
<img src="/images/bc/<?=$m?>.png" height=32px width=32px>
<span style="color:transparent;">..</span>
<select name="m">
<option value="0" <?= $m == 0 ? 'selected' : '' ?>>None</option>
<option value="1" <?= $m == 1 ? 'selected' : '' ?>>Buildersclub</option>
<option value="2" <?= $m == 2 ? 'selected' : '' ?>>TurboBuildersClub</option>
<option value="3" <?= $m == 3 ? 'selected' : '' ?>>OutrageousBuildersClub</option>
</select>
<button name="submit">Apply</button>
</form>

<h2>Theme:</h2>
<form method="POST" action="/api/settheme.php">
<select name="t">
<option value="0" <?= $t == 0 ? 'selected' : '' ?>>Dark</option>
<option value="1" <?= $t == 1 ? 'selected' : '' ?>>Classic</option>
<option value="2" <?= $t == 2 ? 'selected' : '' ?>>Snow</option>
<option value="3" <?= $t == 3 ? 'selected' : '' ?>>Kha2513_ [Deprecated]</option>
</select>
<button name="submit">Apply</button><br>
</form>
<h2 style="color:red;">If it doesn't work press "SHIFT" + "F5", it reloads the page completely.</h2>
</div><br>
<?php
include('./comp/footer.php');
?>