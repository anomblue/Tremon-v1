<?php
include('./comp/nav.php');

session_start();
if (isset($_SESSION['uid'])) {
    header("Location: /Home");
}
?>

<title><?=$name?> - register</title>
<center>
<div class="bigeo">
    <div class="box">
        <h1>Sign up:</h1>
        <b>Do not make alts or else you will be banned.</b>
        <form method="POST" action="/api/register.php">
        Create your Characters name<br>
        <input name="n" maxlength="15" type="text" required><br><br>
        Create your password<br>
        <input name="p" maxlength="50" type="password" required><br><br>
        Confirm your password<br>
        <input name="c" maxlength="50" type="password" required><br><br>
        Enter your unique Invite key<br>
        <input name="i" maxlength="150" type="password" required><br><br>
        Suffer.
        <div class="g-recaptcha" data-sitekey="6Lc-25YtAAAAACx7F3tqHMzvXTsS6-_wOlVwSxRf"></div>
        
        <br>
        <button name="submit">Sign up</button>
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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