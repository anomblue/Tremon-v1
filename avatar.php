<?php
include('./comp/nav.php');

if ($_SESSION['uid'] == 0) {
    die('Make an account to access this page.');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$_SESSION['uid']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$head = brick2hex($user['hc']);
$torso = brick2hex($user['tc']);
$leftarm = brick2hex($user['lac']);
$rightarm = brick2hex($user['rac']);
$leftleg = brick2hex($user['llc']);
$rightleg = brick2hex($user['rlc']);

$hat = $user['hat'];
$face = $user['face'];

$stmt = $pdo->prepare("
    SELECT inventory.*, catalog.name
    FROM inventory
    JOIN catalog ON catalog.id = inventory.asset
    WHERE inventory.uid = ? AND type = 8
");

$stmt->execute([$_SESSION['uid']]);

$hats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT inventory.*, catalog.name
    FROM inventory
    JOIN catalog ON catalog.id = inventory.asset
    WHERE inventory.uid = ? AND type = 18
");

$stmt->execute([$_SESSION['uid']]);

$faces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<title><?=$name?> - Avatar</title><br>
<div class="avatar">
<h1>Edit Character</h1>

<div class="bc_rend">
<div class="renderb">
<h2>
<center>Your avatar:<br>
<img src="/Thumb/Avatar.php?id=<?=$_SESSION['uid']?>" class="avatar-icon">
<br>
<a href="/api/render">Render avatar</a>
</h2>
<small>
Maintenance
</small>
</center>
</div>
<div class="bodybackground"><br>
<h2>Change bodycolors:</h2>
<a href="#">
<span style="display:inline-block;width:65px;"></span>
<span onclick="pickcol('hc')" class="miniplrhead" style="background-color:<?=$head?>;"></span><br>
<span onclick="pickcol('lac')" class="miniplrlimb" style="background-color:<?=$leftarm?>;"></span>
<span onclick="pickcol('tc')" class="miniplrtorso" style="background-color:<?=$torso?>;"></span>
<span onclick="pickcol('rac')" class="miniplrlimb" style="background-color:<?=$rightarm?>;"></span><br>
<span style="display:inline-block;width:45px;"></span>
<span onclick="pickcol('llc')" class="miniplrlimb" style="background-color:<?=$leftleg?>;"></span>
<span onclick="pickcol('rlc')" class="miniplrlimb" style="background-color:<?=$rightleg?>;"></span>
</a>
</div>
</div>
<hr>
<div class="hat_face">
<div class="hats">
<h2 class="yourhats">Your hats:</h2>
<button class="hat <?= $hat == 0 ? 'selected' : '' ?>" id="0" onclick="selecthat(this)">None</button>
<?php foreach ($hats as $asset): ?>
<button class="face <?= $hats == 0 ? 'selected' : '' ?>" id="<?=$asset['asset']?>" onclick="selectface(this)"><?=$asset['name']?></button>
<?php endforeach; ?>
</div>

<div class="faces">
<h2 class="yourfaces">Your faces:</h2>
<button class="face <?= $face == 0 ? 'selected' : '' ?>" id="0" onclick="selectface(this)">None</button>
<?php foreach ($faces as $asset): ?>
<button class="face <?= $face == 0 ? 'selected' : '' ?>" id="<?=$asset['asset']?>" onclick="selectface(this)"><?=$asset['name']?></button>
<?php endforeach; ?>
</div>
</div>
</div>
<br>
<div id="avatarpopfart" class="colorpicker">
    <div class="colorpickerthing">
        <button class="close" onclick="DONTpickcol()">×</button>
        <center><h1 id="editingpart">Editing color</h1></center>
        <a href="#">
        <span id="232" class="color" style="background-color:rgb(125, 187, 221);" onclick="selectcalar(this)"></span>
        <span id="268" class="color" style="background-color:rgb(52, 43, 117);" onclick="selectcalar(this)"></span>
        <span id="301" class="color" style="background-color:rgb(80, 109, 84);" onclick="selectcalar(this)"></span>
        <span id="302" class="color" style="background-color:rgb(91, 93, 105);" onclick="selectcalar(this)"></span>
        <span id="303" class="color" style="background-color:rgb(0, 16, 176);" onclick="selectcalar(this)"></span>
        <span id="304" class="color" style="background-color:rgb(44, 101, 29);" onclick="selectcalar(this)"></span>
        <span id="305" class="color" style="background-color:rgb(82, 124, 174);" onclick="selectcalar(this)"></span>
        <span id="306" class="color" style="background-color:rgb(51, 88, 130);" onclick="selectcalar(this)"></span>
        <span id="307" class="color" style="background-color:rgb(16, 42, 220);" onclick="selectcalar(this)"></span>
        <span id="308" class="color" style="background-color:rgb(61, 21, 133);" onclick="selectcalar(this)"></span>
        <span id="309" class="color" style="background-color:rgb(52, 142, 64);" onclick="selectcalar(this)"></span>
        <span id="310" class="color" style="background-color:rgb(91, 154, 76);" onclick="selectcalar(this)"></span>
        <span id="311" class="color" style="background-color:rgb(159, 161, 172);" onclick="selectcalar(this)"></span>
        <span id="312" class="color" style="background-color:rgb(89, 34, 89);" onclick="selectcalar(this)"></span>
        <span id="313" class="color" style="background-color:rgb(31, 128, 29);" onclick="selectcalar(this)"></span>
        <span id="314" class="color" style="background-color:rgb(159, 173, 192);" onclick="selectcalar(this)"></span>
        <span id="315" class="color" style="background-color:rgb(9, 137, 207);" onclick="selectcalar(this)"></span>
        <span id="316" class="color" style="background-color:rgb(123, 0, 123);" onclick="selectcalar(this)"></span>
        <span id="317" class="color" style="background-color:rgb(124, 156, 107);" onclick="selectcalar(this)"></span>
        <span id="318" class="color" style="background-color:rgb(138, 171, 133);" onclick="selectcalar(this)"></span>
        <span id="319" class="color" style="background-color:rgb(185, 196, 177);" onclick="selectcalar(this)"></span>
        <span id="320" class="color" style="background-color:rgb(202, 203, 209);" onclick="selectcalar(this)"></span>
        <span id="321" class="color" style="background-color:rgb(167, 94, 155);" onclick="selectcalar(this)"></span>
        <span id="322" class="color" style="background-color:rgb(123, 47, 123);" onclick="selectcalar(this)"></span>
        <span id="323" class="color" style="background-color:rgb(148, 190, 129);" onclick="selectcalar(this)"></span>
        <span id="324" class="color" style="background-color:rgb(168, 189, 153);" onclick="selectcalar(this)"></span>
        <span id="325" class="color" style="background-color:rgb(223, 223, 222);" onclick="selectcalar(this)"></span>
        <span id="327" class="color" style="background-color:rgb(151, 0, 0);" onclick="selectcalar(this)"></span>
        <span id="328" class="color" style="background-color:rgb(177, 229, 166);" onclick="selectcalar(this)"></span>
        <span id="329" class="color" style="background-color:rgb(152, 194, 219);" onclick="selectcalar(this)"></span>
        <span id="330" class="color" style="background-color:rgb(255, 152, 220);" onclick="selectcalar(this)"></span>
        <span id="331" class="color" style="background-color:rgb(255, 89, 89);" onclick="selectcalar(this)"></span>
        <span id="332" class="color" style="background-color:rgb(117, 0, 0);" onclick="selectcalar(this)"></span>
        <span id="334" class="color" style="background-color:rgb(248, 217, 109);" onclick="selectcalar(this)"></span>
        <span id="335" class="color" style="background-color:rgb(231, 231, 236);" onclick="selectcalar(this)"></span>
        <span id="336" class="color" style="background-color:rgb(199, 212, 228);" onclick="selectcalar(this)"></span>
        <span id="337" class="color" style="background-color:rgb(255, 148, 148);" onclick="selectcalar(this)"></span>
        <span id="338" class="color" style="background-color:rgb(190, 104, 98);" onclick="selectcalar(this)"></span>
        <span id="339" class="color" style="background-color:rgb(86, 36, 36);" onclick="selectcalar(this)"></span>
        <span id="340" class="color" style="background-color:rgb(241, 231, 199);" onclick="selectcalar(this)"></span>
        <span id="341" class="color" style="background-color:rgb(254, 243, 187);" onclick="selectcalar(this)"></span>
        <span id="342" class="color" style="background-color:rgb(224, 178, 208);" onclick="selectcalar(this)"></span>
        <span id="343" class="color" style="background-color:rgb(212, 144, 189);" onclick="selectcalar(this)"></span>
        <span id="344" class="color" style="background-color:rgb(150, 85, 85);" onclick="selectcalar(this)"></span>
        <span id="345" class="color" style="background-color:rgb(143, 76, 42);" onclick="selectcalar(this)"></span>
        <span id="346" class="color" style="background-color:rgb(211, 190, 150);" onclick="selectcalar(this)"></span>
        <span id="347" class="color" style="background-color:rgb(226, 220, 188);" onclick="selectcalar(this)"></span>
        <span id="348" class="color" style="background-color:rgb(237, 234, 234);" onclick="selectcalar(this)"></span>
        <span id="349" class="color" style="background-color:rgb(233, 218, 218);" onclick="selectcalar(this)"></span>
        <span id="350" class="color" style="background-color:rgb(136, 62, 62);" onclick="selectcalar(this)"></span>
        <span id="351" class="color" style="background-color:rgb(188, 155, 93);" onclick="selectcalar(this)"></span>
        <span id="352" class="color" style="background-color:rgb(199, 172, 120);" onclick="selectcalar(this)"></span>
        <span id="353" class="color" style="background-color:rgb(202, 191, 163);" onclick="selectcalar(this)"></span>
        <span id="354" class="color" style="background-color:rgb(187, 179, 178);" onclick="selectcalar(this)"></span>
        <span id="355" class="color" style="background-color:rgb(108, 88, 75);" onclick="selectcalar(this)"></span>
        <span id="356" class="color" style="background-color:rgb(160, 132, 79);" onclick="selectcalar(this)"></span>
        <span id="357" class="color" style="background-color:rgb(149, 137, 136);" onclick="selectcalar(this)"></span>
        <span id="358" class="color" style="background-color:rgb(171, 168, 158);" onclick="selectcalar(this)"></span>
        <span id="359" class="color" style="background-color:rgb(175, 148, 131);" onclick="selectcalar(this)"></span>
        <span id="360" class="color" style="background-color:rgb(150, 103, 102);" onclick="selectcalar(this)"></span>
        <span id="361" class="color" style="background-color:rgb(86, 66, 54);" onclick="selectcalar(this)"></span>
        <span id="362" class="color" style="background-color:rgb(126, 104, 63);" onclick="selectcalar(this)"></span>
        <span id="363" class="color" style="background-color:rgb(105, 102, 92);" onclick="selectcalar(this)"></span>
        <span id="364" class="color" style="background-color:rgb(90, 76, 66);" onclick="selectcalar(this)"></span>
        <span id="365" class="color" style="background-color:rgb(106, 57, 9);" onclick="selectcalar(this)"></span>
        <span id="1001" class="color" style="background-color:rgb(248, 248, 248);" onclick="selectcalar(this)"></span>
        <span id="1002" class="color" style="background-color:rgb(205, 205, 205);" onclick="selectcalar(this)"></span>
        <span id="1003" class="color" style="background-color:rgb(17, 17, 17);" onclick="selectcalar(this)"></span>
        <span id="1004" class="color" style="background-color:rgb(255, 0, 0);" onclick="selectcalar(this)"></span>
        <span id="1005" class="color" style="background-color:rgb(255, 176, 0);" onclick="selectcalar(this)"></span>
        <span id="1006" class="color" style="background-color:rgb(180, 128, 255);" onclick="selectcalar(this)"></span>
        <span id="1007" class="color" style="background-color:rgb(163, 75, 75);" onclick="selectcalar(this)"></span>
        <span id="1008" class="color" style="background-color:rgb(193, 190, 66);" onclick="selectcalar(this)"></span>
        <span id="1009" class="color" style="background-color:rgb(255, 255, 0);" onclick="selectcalar(this)"></span>
        <span id="1010" class="color" style="background-color:rgb(0, 0, 255);" onclick="selectcalar(this)"></span>
        <span id="1011" class="color" style="background-color:rgb(0, 32, 96);" onclick="selectcalar(this)"></span>
        <span id="1012" class="color" style="background-color:rgb(33, 84, 185);" onclick="selectcalar(this)"></span>
        <span id="1013" class="color" style="background-color:rgb(4, 175, 236);" onclick="selectcalar(this)"></span>
        <span id="1014" class="color" style="background-color:rgb(170, 85, 0);" onclick="selectcalar(this)"></span>
        <span id="1015" class="color" style="background-color:rgb(170, 0, 170);" onclick="selectcalar(this)"></span>
        <span id="1016" class="color" style="background-color:rgb(255, 102, 204);" onclick="selectcalar(this)"></span>
        <span id="1017" class="color" style="background-color:rgb(255, 175, 0);" onclick="selectcalar(this)"></span>
        <span id="1018" class="color" style="background-color:rgb(18, 238, 212);" onclick="selectcalar(this)"></span>
        <span id="1019" class="color" style="background-color:rgb(0, 255, 255);" onclick="selectcalar(this)"></span>
        <span id="1020" class="color" style="background-color:rgb(0, 255, 0);" onclick="selectcalar(this)"></span>
        <span id="1021" class="color" style="background-color:rgb(58, 125, 21);" onclick="selectcalar(this)"></span>
        <span id="1022" class="color" style="background-color:rgb(127, 142, 100);" onclick="selectcalar(this)"></span>
        <span id="1023" class="color" style="background-color:rgb(140, 91, 159);" onclick="selectcalar(this)"></span>
        <span id="1024" class="color" style="background-color:rgb(175, 221, 255);" onclick="selectcalar(this)"></span>
        <span id="1025" class="color" style="background-color:rgb(255, 201, 201);" onclick="selectcalar(this)"></span>
        <span id="1026" class="color" style="background-color:rgb(177, 167, 255);" onclick="selectcalar(this)"></span>
        <span id="1027" class="color" style="background-color:rgb(159, 243, 233);" onclick="selectcalar(this)"></span>
        <span id="1028" class="color" style="background-color:rgb(204, 255, 204);" onclick="selectcalar(this)"></span>
        <span id="1029" class="color" style="background-color:rgb(255, 255, 204);" onclick="selectcalar(this)"></span>
        <span id="1030" class="color" style="background-color:rgb(255, 204, 153);" onclick="selectcalar(this)"></span>
        <span id="1031" class="color" style="background-color:rgb(98, 37, 209);" onclick="selectcalar(this)"></span>
        <span id="1032" class="color" style="background-color:rgb(255, 0, 191);" onclick="selectcalar(this)"></span>
        </a>
    </div>
</div>

<script>
let selp = null;

const pname = {
    hc: "Head",
    tc: "Torso",
    lac: "Left Arm",
    rac: "Right Arm",
    llc: "Left Leg",
    rlc: "Right Leg"
};

function pickcol(part) {
    selp = part;

    document.getElementById("editingpart").textContent =
        pname[part] + " color";

    document.getElementById("avatarpopfart").style.display = "flex";
}

function DONTpickcol() {
    document.getElementById("avatarpopfart").style.display = "none";
}

function selectcalar(element) {
    let colid = element.id;

    window.location.replace(
        '/api/setcol.php?c=' + encodeURIComponent(colid) +
        '&t=' + encodeURIComponent(selp)
    );
}

function selecthat(element) {
    let hat = element.id;

    window.location.replace(
        '/api/sethat.php?id=' + encodeURIComponent(hat)
    );
}

function selectface(element) {
    let face = element.id;

    window.location.replace(
        '/api/setface.php?id=' + encodeURIComponent(face)
    );
}
</script>
<?php
include('./comp/footer.php');
?>