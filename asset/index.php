<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("id");
}

$assetid = $_GET['id'];

if (preg_match('/[^a-zA-Z0-9._-]/', $assetid)) {
    die("no id");
}

$files = __DIR__ . "/storage/" . $assetid;

if (!file_exists($files)) {
    header("Location: https://proxy.95.fyi/assetrequest.php?id=" . urlencode($assetid));
    exit;
}

$content = file_get_contents($files);

$shouldbe = is_numeric($assetid) && $assetid >= 1 && $assetid <= 20 || $assetid == 40; // signs first 20, comment from BG9D to bluedum

if ($shouldbe) {
    $asset = "%" . $assetid . "%\r\n" . $content;
    $asset = str_replace("www.roblox.com", "n.cloudpub.ru", $asset);

    $signature = null;
    $pathh = "./PrivateKey.pem"; // CHANGE to YOUR path to privatekey
    
    if (file_exists($pathh)) {
        $key = file_get_contents($pathh);
        if ($key !== false) {
            openssl_sign($asset, $signature, $key, OPENSSL_ALGO_SHA1);
        }
    }
    
    $asset = sprintf("%%%s%%%s", base64_encode($signature ?? ''), $asset);
} else {
    $asset = $content;
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$assetid\"");
header("Content-Length: " . strlen($asset));

echo $asset;
exit;
?>