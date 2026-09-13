<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');

if ($_SESSION['uid'] !== 1) {
    http_response_code(403);
    die('403 - Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uid'])) {
    $uid = (int)$_POST['uid'];
    $newName = "tremon_user_" . $uid;

    $stmt = $pdo->prepare("
        UPDATE users
        SET name = ?
        WHERE uid = ?
    ");

    $stmt->execute([$newName, $uid]);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

include('./nav.php');

$stmt = $pdo->query("
    SELECT * FROM users ORDER BY uid
");

$onlineUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>users</h1>

<?php foreach ($onlineUsers as $user): ?>
    <div style="margin-bottom: 12px;">
        <div>
            UID: <?= htmlspecialchars($user['uid']) ?> - NM:
            <?= htmlspecialchars($user['name']) ?> - DISCORD: <?php if ((int)$user['discord_verified'] === 1): ?><?= htmlspecialchars($user['discord_id']) ?> - <?= htmlspecialchars($user['discord_username']) ?><?php else: ?>UNLINKED<?php endif; ?>

            <?php if ((int)$user['isban'] === 1): ?>
                <br>
                <span style="color: red;">
                    [ Banned ] - "<?= htmlspecialchars($user['banreas'])?>"
                </span><br>
            <?php endif; ?>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="uid" value="<?= (int)$user['uid'] ?>">
                <button type="submit">reset name</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<form method="POST" action="/admin/ban.php">
    userid to ban:<br>
    <input name="uid"></input><br>
    reason for ban:<br>
    <input name="r"></input><br>
    <button name="submit">ban</button>
</form>

<form method="POST" action="/admin/unban.php">
    userid to unban:<br>
    <input name="uid"></input><br>
    <button name="submit">unban</button>
</form>

<form method="POST" action="/admin/changename.php">
    userid to changename:<br>
    <input name="uid"></input><br>
    new name:<br>
    <input name="n"></input><br>
    <button name="submit">change name</button>
</form>