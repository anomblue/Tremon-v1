<?php
require_once('./api/config.php');
session_start();
$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$_SESSION['uid']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['isban'] == 0) {
header("Location: /Home");
}
?>
<center>
<h1>
You have been permanently banned for breaking our terms of service.
</h1>
<hr>
<h2>
Moderator note:<br><br>
<textarea readonly style="resize:none;height:200px;width:400px;">
<?=htmlspecialchars($user['banreas'])?>
</textarea>
</h2>
<hr>
If you believe this was a mistake please contact our support team.<br>
<a href="https://discord.gg/7WNgknpBSS">Support Discord server</a>
</center>