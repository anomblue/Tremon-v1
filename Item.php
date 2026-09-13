    <?php
    include('./comp/nav.php');

    if (!isset($_GET['id'])) {
    header('Location: /404');
    exit;
    }

    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM catalog WHERE id = ?");
    $stmt->execute([$id]);

    $asset = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$asset) {
        header('Location: /404');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
    $stmt->execute([$asset['creatorid']]);
    $creator = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$asset) {
    header('Location: /404');
    exit;
    }
    ?>
    
    <title><?= htmlspecialchars($name) ?> - <?= htmlspecialchars($asset['name']) ?></title>
    <br>
    <div class="placep">
    <div>
    <h1>
    <div class="titlebox">
    <?= htmlspecialchars($asset['name'])?><br>
    </div>
    </h1>
    <span style="text-align:center;display:block;">
    <a href="/profile?id=<?=$creator['uid']?>">
    <?=htmlspecialchars($creator['name'])?>
    </a>
    </span>
    <center><img class="catalogthumb" src="/images/fail.png"><br>
    <div class="descbox">
    <h3><?=htmlspecialchars($asset['description'])?></h3>
    </div>
    R$: <?=$asset['rbx']?><span style="color:transparent;">...</span>T$: <?=$asset['tix']?><br><br>
    </center>
    <div class="btns">
        <button class="gamesbtn" onclick="window.location.replace('/api/buy.php?id=<?=$asset['id']?>');">Buy</button>
        <button class="gamesbtn" onclick="window.location.href='/catalog'">Back</button>
    </div>
    </div>
    </div>

        <script>
    async function verify() {
        document.getElementById("showmeboii").style.display = "flex";
    }

    function closeload() {
        document.getElementById("showmeboii").style.display = "none";
    }
    </script>
    <?php
    include('./comp/footer.php');
    ?>
