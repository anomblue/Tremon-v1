<?php
include('./comp/nav.php');
include('./api/config.php');

$page = isset($_GET['i']) ? (int)$_GET['i'] : 1;

if ($page < 1) {
    $page = 1;
}

$per = 12;
$off = ($page - 1) * $per;

$countStmt = $pdo->query("SELECT COUNT(*) FROM games");
$total = (int)$countStmt->fetchColumn();

$totalPages = max(1, (int)ceil($total / $per));

if ($page > $totalPages) {
    $page = $totalPages;
    $off = ($page - 1) * $per;
}

$stmt = $pdo->prepare("SELECT * FROM games ORDER BY gid ASC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $per, PDO::PARAM_INT);
$stmt->bindValue(2, $off, PDO::PARAM_INT);
$stmt->execute();

$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<title><?=$name?> - games</title>

<center>
    <h1>Games:</h1>

To join our servers you must join the <a href="/radmin">Radmin VPN</a> server<br><br>
<div class="gamep">
<div class="games">
    <?php foreach ($games as $game): ?>
        <button class="game" onclick="window.location.href='/Place?id=<?= (int)$game['gid'] ?>' // window.location.replace('/api/join.php?gid=<?= (int)$game['gid'] ?>');">
            <?= htmlspecialchars($game['name']) ?>
        </button>
    <?php endforeach; ?>
</div>

<?php if ($total > 0): ?>
    <div class="page">
        <?php if ($page > 1): ?>
            <a href="?i=<?= $page - 1 ?>">Previous</a>
        <?php endif; ?>

        Page <?= $page ?> of <?= $totalPages ?>

        <?php if ($page < $totalPages): ?>
            <a href="?i=<?= $page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

</div>

</center>

<?php
include('./comp/footer.php');
?>