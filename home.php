<?php
include('./comp/nav.php');

$stmt = $pdo->query("SELECT * FROM games ORDER BY RAND() LIMIT 1");
$randomgame = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->query("
    SELECT *
    FROM games
    ORDER BY RAND(TO_DAYS(CURDATE()))
    LIMIT 1
");

$gameofday = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<title><?=$name?> - home</title>
<center>
    <br>
<div class="panels">
    <div class="mainp">
        <h1>Welcome, <?=$_SESSION['name']?>!</h1>
        <h2>New to Tremon?</h2>
        Heres some things to get started with!
        <h2>Install</h2>
        Install the game client by pressing the settings cog then download in the top right.
        <h2>Customize your avatar</h2>
        In the navigation bar click avatar to customize your avatar.
    </div>

    <div class="topr">
        <h3>Game of the day:</h3>
        <button class="game" onclick="window.location.href='/Place?id=<?=$gameofday['gid']?>'">
            <?=$gameofday['name']?>
        </button>
    </div>

    <div class="bottr">
        <h3>Random game:</h3>
        <button class="game" onclick="window.location.href='/Place?id=<?=$randomgame['gid']?>'">
            <?=$randomgame['name']?>
        </button>
    </div>
</div>
<br>
</center>
<?php
include('./comp/footer.php');
?>