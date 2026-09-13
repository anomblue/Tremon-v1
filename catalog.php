<?php

include('./comp/nav.php');
include('./api/config.php');

$page = isset($_GET['i']) ? (int)$_GET['i'] : 1;

if ($page < 1) {
    $page = 1;
}

$per = 12;
$off = ($page - 1) * $per;

if (isset($_GET['t'])) {

    $t = (int)$_GET['t'];

    $stmt = $pdo->prepare(
        "SELECT * FROM catalog WHERE type = ? ORDER BY id ASC LIMIT ? OFFSET ?"
    );

    $stmt->bindValue(1, $t, PDO::PARAM_INT);
    $stmt->bindValue(2, $per, PDO::PARAM_INT);
    $stmt->bindValue(3, $off, PDO::PARAM_INT);

    $stmt->execute();

    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {

    $stmt = $pdo->prepare(
        "SELECT * FROM catalog ORDER BY id ASC LIMIT ? OFFSET ?"
    );

    $stmt->bindValue(1, $per, PDO::PARAM_INT);
    $stmt->bindValue(2, $off, PDO::PARAM_INT);

    $stmt->execute();

    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Count games */
if (isset($_GET['t'])) {

    $countStmt = $pdo->prepare(
        "SELECT COUNT(*) FROM catalog WHERE type = ?"
    );

    $countStmt->execute([$t]);

} else {

    $countStmt = $pdo->query(
        "SELECT COUNT(*) FROM catalog"
    );
}

$total = (int)$countStmt->fetchColumn();

$totalPages = max(1, (int)ceil($total / $per));

if ($page > $totalPages) {
    $page = $totalPages;
    $off = ($page - 1) * $per;
}

?>

<title><?= htmlspecialchars($name) ?> - Catalog</title>

<center>

    <h1>Catalog:</h1>

    <div class="catcont">
    <div class="cattyp">
        <h1>Type:</h1><br>
        <h2>
        <a href="/Catalog">All</a><br>
        <a href="?t=18">Faces</a><br>
        <a href="?t=8">Hats</a>
        </h2>
    </div>
    <div class="gamep">

        <div class="assets">

            <?php foreach ($assets as $asset): ?>

                <button
                    class="asset"
                    onclick="window.location.href='/Item?id=<?= (int)$asset['id'] ?>';"
                >
                    <?= htmlspecialchars($asset['name']) ?>
                </button>

            <?php endforeach; ?>

        </div>

        <?php if ($total > 0): ?>

            <div class="page">

                <?php if ($page > 1): ?>
                    <a href="?i=<?= $page - 1 ?><?= isset($t) ? '&t=' . $t : '' ?>">
                        Previous
                    </a>
                <?php endif; ?>

                Page <?= $page ?> of <?= $totalPages ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?i=<?= $page + 1 ?><?= isset($t) ? '&t=' . $t : '' ?>">
                        Next
                    </a>
                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>
    </div>
</center>

<?php
include('./comp/footer.php');
?>