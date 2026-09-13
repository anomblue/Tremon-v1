<?php
session_start();

if ($_SESSION['uid'] !== 1) {
    http_response_code(403);
    die('403 - Forbidden');
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');
include('./nav.php');

$stmt = $pdo->query("
    SELECT * FROM applications ORDER BY appid
");

$apps = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['appid'], $_POST['action'])) {
    $appid = (int)$_POST['appid'];
    $action = $_POST['action'];

    if ($action == 9) {
        $stmt = $pdo->prepare("DELETE FROM applications WHERE `applications`.`appid` = ?");
        $stmt->execute([$appid]);
    }

    $stmt = $pdo->prepare("UPDATE applications SET isaccept = ? WHERE appid = ?");

    $stmt->execute([$action, $appid]);
}
?>

<h1>applications</h1>
if nothing then = no apps
<?php foreach ($apps as $app): ?>
    <div style="margin-bottom: 12px;">
        <div>
            APPID: "<?= htmlspecialchars($app['appid']) ?>"<br>
            REASON: "<?= htmlspecialchars($app['reason']) ?>"<br>
            HOWFIND: "<?= htmlspecialchars($app['find']) ?>"<br>
            ROBLOXUSER: "<?= htmlspecialchars($app['roblox']) ?>"<br>
            PHRASE: "<?= htmlspecialchars($app['phrase']) ?>"<br>
            TIMEAPPLIED: "<?= htmlspecialchars($app['date']) ?>"<br>
            ACCEPTED: "<?= htmlspecialchars($app['isaccept']) ?>"<br>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="appid" value="<?= (int)$app['appid'] ?>">

                <button type="submit" name="action" value="1">
                    accept
                </button>

                <button type="submit" name="action" value="2">
                    decline
                </button>

                <button type="submit" name="action" value="0">
                    none
                </button>

                <button type="submit" name="action" value="9">
                    delete
                </button>
            </form>
        </div>
    </div>
<?php endforeach; ?>