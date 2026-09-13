<?php
include('./comp/nav.php');
session_start();

if (isset($_SESSION['uid'])) {
    header("Location: /Home");
}

$words = [
    "Tremon",
    "Sky",
    "Cloud",
    "Amazing",
    "Porkchop",
    "Jane",
    "John",
    "Lake",
    "Europe",
    "Apple",
    "River",
    "Thunder",
    "Shadow",
    "Rocket",
    "Forest",
    "Crystal",
    "Dragon",
    "Sunset",
    "Winter",
    "Falcon",
    "Ocean",
    "Mountain",
    "Pixel",
    "Golden",
    "Storm",
    "Cactus",
    "Comet",
    "Galaxy",
    "Breeze",
    "Anomn",
    "BG9D",
    "Kha2513_",
    "Skidding",
    "Skid"
];

function createverif() {
    global $words;

    $keys = array_rand($words, 10);

    $selected = [];

    foreach ($keys as $key) {
        $selected[] = $words[$key];
    }

    return implode(' ', $selected);
}

if (isset($_COOKIE['applicationid'])) {
$stmt = $pdo->prepare("
    SELECT * FROM applications
    WHERE application_token = ?
    LIMIT 1
");

$stmt->execute([$_COOKIE['applicationid']]);

$app = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$app) {
    setcookie('applicationid', '', time() - 3600, '/');
    header('Location: /apply');
    exit;
}

if ($app['isaccept'] == 1) {
$stmt = $pdo->prepare("SELECT invitekey FROM invitekeys WHERE appid = ? LIMIT 1");
$stmt->execute([$app['appid']]);

$existingKey = $stmt->fetchColumn();

if ($existingKey) {
    $key = $existingKey;
} else {
    $key = "tremon-key-" . bin2hex(random_bytes(32));

    $stmt = $pdo->prepare("
        INSERT INTO invitekeys (appid, invitekey)
        VALUES (?, ?)
    ");

    $stmt->execute([$app['appid'], $key]);
}

die('
<center>
You have been accepted!<br>
Your invite key is: <span style="color:red;">' . $key . '</span><br>
<a href="/register">Sign up here</a>
</center>
');
} elseif ($app['isaccept'] == 2) {
die('
<center>
Your application has been declined.
</center>
');
}

die("
<center>
Please wait until we review your application.<br>
Refresh your page to recheck the status.
</center>
");
}

if (isset($_POST['f'])) {
$recaptchaSecret = '6Lc-25YtAAAAAAxXQj-WakoTtxgBq4I1F18sgeGz';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptchaResponse)) {
    die('complete captcha');
}

$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

$data = [
    'secret'   => $recaptchaSecret,
    'response' => $recaptchaResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10
    ]
];

$context = stream_context_create($options);

$verifyResult = file_get_contents($verifyUrl, false, $context);

if ($verifyResult === false) {
    die('captcha fail');
}

$captcha = json_decode($verifyResult, true);

if (empty($captcha['success'])) {
    die('captcha fail');
}

    $token = bin2hex(random_bytes(32));

    $stmt = $pdo->prepare("
        INSERT INTO applications (reason, find, roblox, phrase, application_token)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['r'],
        $_POST['f'],
        $_POST['w'],
        $_POST['s'],
        $token
    ]);

    setcookie(
        'applicationid',
        $token,
        [
            'expires' => time() + 2147483647,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]
    );

    header('Location: /apply');
    exit;
}
?>
<title>Tremon - Application</title>
<br>
<div class="application">
<h1>Tremon application</h1>
<h2>Fill this in seriously</h2>
<form method="POST" action>
<h2>Why do you want to join us</h2>
<textarea name="r" placeholder="Enter here..." style="height:100px;width:500px;resize:none;"></textarea>

<h2>How did you find us</h2>
<textarea name="f" placeholder="Enter here..." style="height:100px;width:500px;resize:none;"></textarea>

<h2>What is your Roblox account</h2>
<textarea name="w" placeholder="Enter here..." style="height:100px;width:500px;resize:none;"></textarea>

<h2>Set this to your description on Roblox</h2>
<textarea name="s" readonly style="height:100px;width:500px;resize:none;"><?= htmlspecialchars(createverif()) ?></textarea>
<hr>
<center>
I am a robot
<div class="g-recaptcha" data-sitekey="6Lc-25YtAAAAACx7F3tqHMzvXTsS6-_wOlVwSxRf"></div>
</center>
<hr>
<div style="text-align:center;">
<button type="submit" name="submit">Submit application</button>
</div>
</form>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</div><br>
<?php
include('./comp/footer.php');
?>