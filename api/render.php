<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

$response = file_get_contents("http://127.0.0.1:8080/avatar");

if ($response === false) {
    echo json_encode([
        "success" => false,
        "error" => "cant connect to renderer."
    ]);
    exit;
}

$data = json_decode($response, true);

if (!$data || !$data["success"]) {
    echo json_encode([
        "success" => false,
        "error" => "bad render respond"
    ]);
    exit;
}

$image = base64_decode($data["image"]);

if ($image === false) {
    echo json_encode([
        "success" => false,
        "error" => "bad image data"
    ]);
    exit;
}

$source = imagecreatefromstring($image);

if (!$source) {
    echo json_encode([
        "success" => false,
        "error" => "could not create image"
    ]);
    exit;
}

$size = 150;

$resized = imagecreatetruecolor($size, $size);

imagealphablending($resized, false);
imagesavealpha($resized, true);

imagecopyresampled(
    $resized,
    $source,
    0, 0,
    0, 0,
    $size,
    $size,
    imagesx($source),
    imagesy($source)
);

$folder = "../images/avatars/";

if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

$filename = "avatar_" . $_SESSION['uid'] . ".png";

imagepng($resized, $folder . $filename, 9);

imagedestroy($source);
imagedestroy($resized);

echo json_encode([
    "success" => true,
    "file" => "images/avatars/" . $filename
]);

header('Location: /editcharacter');