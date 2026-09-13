<?php
include('./comp/nav.php');
if (isset($_SESSION['name'])) {
    header('Location: /home');
}
?>

<title><?=$name?></title><br>
<div class="welcome">
<h1><?=$name?></h1>
Does TikTok connect to the wifi in my house?<br>
So tiktok is wifi?<br>
I change this like daily the text here, i might add statistics.
</div><br>
<?php
include('./comp/footer.php');
?>