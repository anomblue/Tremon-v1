<?php
include($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');
session_start();
header("Content-Security-Policy: frame-ancestors 'none'");
header("X-Frame-Options: DENY");
error_reporting(0);
ini_set('display_errors', 0);

$allow = [
    "index",
    "register",
    "login",
    "TOS",
    "apply"
];

$page = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

if ($page === "") {
    $page = "index";
}

$page = preg_replace('/\.php$/', '', $page);

if (!in_array($page, $allow, true) && !isset($_SESSION["name"])) {
    header("Location: /");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$_SESSION['uid']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['isban'] == 1) {
header("Location: /Banned");
}

$rbx = $user['rbx'];
$tix = $user['tix'];

$t = $user['theme'];

$t = $user['theme'];

if (isset($_SESSION['uid'])) {
    echo '<link rel="stylesheet" href="/css/' . (int)$t . '.css">';

    if ((int)$t === 2) {
        echo '<div id="snow" data-count="200"></div>';
        echo '<script src="/css/snow.js" defer></script>';
    }
} else {
    echo '<link rel="stylesheet" href="/css/0.css">';
}
?>
<script>
setInterval(() => {
    fetch('/api/status.php');
}, 60000);

document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.querySelector(".dropdown");
    const button = dropdown.querySelector(":scope > a");

    button.addEventListener("click", function (event) {
        event.preventDefault();
        dropdown.classList.toggle("open");
    });

    document.addEventListener("click", function (event) {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove("open");
        }
    });
});
</script>

<nav class="nav">
  <a href="/">
  <div class="logo">
    <img src="/images/logo.png" width=150px>
</div>
</a>
  <ul class="navstuff">
    <br>
    <?php
    if (isset($_SESSION['name'])) {
        echo '
        <li><a href="/Home">Home</a></li>
        <li><a href="/Games">Games</a></li>
        <li><a href="/Catalog">Catalog</a></li>
        <li><a href="/Avatar">Avatar</a></li>
        <li><a href="/Players">Players</a></li>
        <li><a href="/Discord" target="_blank">Discord</a></li>
          </ul>
    <a class="currency" href="/balance">R$: <coins>' . $rbx . '</coins>
    <tix class="currency" href="/balance">T$: <coins>' . $tix . '</coins>
  </tix>
  </a>
  <span style="color: transparent;">..</span>
  <a href="/profile?id=' . $_SESSION['uid'] . '" class="name">' . $_SESSION['name'] . '</a>
  <span style="color: transparent;">...</span>
  <drop class="dropdown">
    <a href="#"><img src="/images/cog.png" height=35px></a>

    <ul class="dropdownins">
      <li><a href="/download">Download</a></li>
      <li><a href="/settings">Settings</a></li>
      <li><a href="/api/logout.php">Logout</a></li>
    </ul>
</drop>
        ';
    } else {
    echo '
    <li><a href="/login">Login</a></li>
    <li><a href="/apply">Apply</a></li>
    </ul>
    ';
    }
    ?>
</nav>
<alert class="alert">
<b>
Please suggest things via the Discord server in #suggestions.
</b>
</alert>
</body>
</html>