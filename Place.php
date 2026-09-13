    <?php
    include('./comp/nav.php');

    if (!isset($_GET['id'])) {
    header('Location: /404');
    exit;
    }

    $gid = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM games WHERE gid = ?");
    $stmt->execute([$gid]);

    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$game) {
        header('Location: /404');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
    $stmt->execute([$game['creatorid']]);
    $creator = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$game) {
    header('Location: /404');
    exit;
    }
    ?>
    
    <title><?= htmlspecialchars($name) ?> - <?= htmlspecialchars($game['name']) ?></title>
    <br>
    <div class="placep">
    <div>
    <h1>
    <div class="titlebox">
    <?= htmlspecialchars($game['name'])?><br>
    </div>
    </h1>
    <span style="text-align:center;display:block;">
    <a href="/profile?id=<?=$creator['uid']?>">
    <?=htmlspecialchars($creator['name'])?>
    </a>
    </span>
    <img class="thumbtoenail" src="/images/fail.png"><br>
    <div class="descbox">
    <h3><?=htmlspecialchars($game['description'])?></h3>
    </div>
    <div class="btns">
        <button class="shittyplaybtn" onclick="start();"></button>
        <button class="gamesbtn" onclick="window.location.href='/games'">Back</button>
    </div>
    </div>
    <center>
    <div id="showmeboii" class="popupthingy">
        <div class="popup">
            <button class="close" onclick="closeload()">×</button>
            <h2 id="pepe">
            preparing server...<br>
            <img src="/images/loading.png" class="loadingspin" height="70px">
        </h2>
            
        </div>
    </div>
    </center>
    </div>
    <script>
    function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    let og = document.getElementById("pepe").innerHTML;

    async function start() {
        document.getElementById("showmeboii").style.display = "flex";
        document.getElementById("pepe").innerHTML = og;

        const getOutOfMyCode = await fetch('/api/startserver.php?gid=<?= (int)$game['gid'] ?>');
        if (!getOutOfMyCode.ok) {
            document.getElementById("pepe").innerHTML = "failed to start server";
            return;
        }

        // theres waits just cuz servers are slow dont blame me

        await wait(17000);

        document.getElementById("pepe").innerHTML = 'eating testers...';

        await wait(1000);

        document.getElementById("pepe").innerHTML = 'server started!<br><img src="/images/loading.png" class="loadingspin" height="70px">';

        await wait(1000);

        document.getElementById("pepe").innerHTML = 'preparing uri...<br><img src="/images/loading.png" class="loadingspin" height="70px">';


        await wait(3000);
        
        window.location.replace('/api/join.php?gid=<?= (int)$game['gid'] ?>');
        document.getElementById("pepe").innerHTML = 'uri launched<br><img src="/images/success.gif" height="120px"><br>If Tremon isn\'t installed, <a href="/download">Install here</a>.';
    }

    function closeload() {
        document.getElementById("pepe").innerHTML = og;
        document.getElementById("showmeboii").style.display = "none";
    }
    </script>

    <?php
    include('./comp/footer.php');
    ?>
