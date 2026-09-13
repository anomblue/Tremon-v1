<?php
require_once('../api/config.php');

if (!isset($_GET['userId'])) {
    die('no id set');
}
$id = (int)$_GET['userId'];

$head;
$torso;
$leftarm;
$rightarm;
$leftleg;
$rightleg;

if ($id !== 0) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
    $stmt->execute([$id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $head = $user['hc'];
    $torso = $user['tc'];
    $leftarm = $user['lac'];
    $rightarm = $user['rac'];
    $leftleg = $user['llc'];
    $rightleg = $user['rlc'];
} else {
    $head = 1;
    $torso = 26;
    $leftarm = 26;
    $rightarm = 26;
    $leftleg = 26;
    $rightleg = 26;
}

header("Content-Type: application/xml")
?>

<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd"
        version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="BodyColors" referent="RBX0">
        <Properties>
            <int name="HeadColor"><?= $head ?></int>
            <int name="LeftArmColor"><?= $leftarm ?></int>
            <int name="LeftLegColor"><?= $leftleg ?></int>
            <string name="Name">Body Colors</string>
            <int name="RightArmColor"><?= $rightarm ?></int>
            <int name="RightLegColor"><?= $rightleg ?></int>
            <int name="TorsoColor"><?= $torso ?></int>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox>