<?php
include('./comp/nav.php');

session_start();
if (isset($_SESSION['uid'])) {
    header("Location: /Home");
}
?>

<title><?=$name?> - login</title>
<center>
<div class="bigeo">
    <div class="box">
        <h1>login:</h1>
        <form method="POST" action="/api/login.php">
            name<br>
            <input name="n" type="text" maxlength="15" required><br><br>

            password<br>
            <input name="p" type="password" maxlength="50" required><br><br>

            <button name="submit">login</button>

            <!-- <h2 style="color:red;">*Notice: 09/08/2026. <a href="#no">Read more.</a></h2> -->
        </form>
    </div>

    <div class="video">
        <iframe
            src="https://www.youtube.com/embed/zxjpTBM7rtM?rel=0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>
</div>
</center>
<?php
include('./comp/footer.php');
?>