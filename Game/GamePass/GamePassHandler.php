<?php
$action = $_GET['Action'];
$UserID = $_GET['UserID'];
$PassID = $_GET['PassID'];

if ($action == "HasPass") {
    echo 'HasPass';
}
header("Content-Type: application/xml");
// true = haspass false = not pass, yea
/* <?xml version="1.0" encoding="UTF-8"?><Value Type="boolean">false</Value>*/
/* <?xml version="1.0" encoding="UTF-8"?><Value Type="boolean">true</Value> */