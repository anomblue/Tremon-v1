<?php
include('./comp/nav.php');
http_response_code(404)
?>

<title><?=$name?> - 404</title>
<center>
<h1>error 404</h1>
page not found
</center>
<?php
include('./comp/footer.php');
?>