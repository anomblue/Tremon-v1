<?php
$method = $_GET['method'];
$playerid = $_GET['playerid'];
$userid = $_GET['userid'];

if ($method == "IsFriendsWith") {
    //echo 'IsFriendsWith';
    die('<?xml version="1.0" encoding="UTF-8"?><Value Type="boolean">false</Value>');
} elseif ($method == "IsBestFriendsWith") {
    echo 'IsBestFriendsWith';
// havent figured this out yet V
} elseif ($method == "IsInGroup") {
    echo 'IsInGroup';
} elseif ($method == "GetGroupRank") {
    echo 'GetGroupRank';
} elseif ($method == "GetGroupRole") {
    echo 'GetGroupRole';
}
header("Content-Type: application/xml");
// true = isfriends false = not friends, yea
/* <?xml version="1.0" encoding="UTF-8"?><Value Type="boolean">false</Value>*/
/* <?xml version="1.0" encoding="UTF-8"?><Value Type="boolean">true</Value> */