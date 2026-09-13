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

// Not finished sadly
?>
<br>
<div class="chat-cntain">
<div class="left-chatp">
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
<button class="chat-user">User</button>
</div>
<div class="right-chatp">

</div><br>
</div>
<?php
include('./comp/footer.php');
?>