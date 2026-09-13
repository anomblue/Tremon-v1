<?php
require_once('../api/ronfig.php');
require_once('../api/config.php');

if (!isset($_GET['port'])) {
	die('👿👿 EVIL DEFENSE SYSTEMS ACTIVATED 👿👿 code=2');
}

if (isset($_SESSION['uid'])) {
	die('👿👿 EVIL DEFENSE SYSTEMS ACTIVATED 👿👿 code=3');
}

if (!isset($_GET['uid'])) {
    die('👿👿 EVIL DEFENSE SYSTEMS ACTIVATED 👿👿 code=1');
}

$name;
$uid = (int) $_GET['uid'];
$memb = "None";
$port = (int) $_GET['port'];
$gid = $port / 2048;
$guest;

if ($uid !== 0) {
	$guest = false;
	$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
	$stmt->execute([$uid]);

	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user['membership'] == 1) {
		$memb = "BuildersClub";
	} elseif ($user['membership'] == 2) {
		$memb = "TurboBuildersClub";
	} elseif ($user['membership'] == 3) {
		$memb = "OutrageousBuildersClub";
	} else {
		$memb = "None";
	}

	$name = (string) $user['name'];
} else {
	$uid = (string) $_GET['uid'];
	if (substr($uid, 0, 6) == "Guest ") {
		$name = (string) $uid;
		$uid = (int) rand(100000,999999);
		$guest = true;
	}
}

$script = '
pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end)
local threadSleepTime = 0
local Visit = game:service("Visit")
local Players = game:service("Players")
local NetworkClient = game:service("NetworkClient")

local function onConnectionRejected()
	game:SetMessage("This game is not available. Please try another")
end

local function onConnectionFailed(_, id, reason)
	game:SetMessage("Failed to connect to the Game. (ID=" .. id .. ", " .. reason .. ")")
end
pcall(function() game:SetPlaceID(' . $gid . ', false) end)
local function onConnectionAccepted(peer, replicator)
	local worldReceiver = replicator:SendMarker()
	local received = false

	local function onWorldReceived()
		received = true
	end

	worldReceiver.Received:connect(onWorldReceived)
	game:SetMessageBrickCount()

	while not received do
		workspace:ZoomToExtents()
		wait(0.5)
	end

	local player = Players.LocalPlayer
	game:SetMessage("Requesting character")

	replicator:RequestCharacter()
	game:SetMessage("Waiting for character")

	while not player.Character do
		player.Changed:wait()
	end

	game:ClearMessage()
end

NetworkClient.ConnectionAccepted:connect(onConnectionAccepted)
NetworkClient.ConnectionRejected:connect(onConnectionRejected)
NetworkClient.ConnectionFailed:connect(onConnectionFailed)
game:SetMessage("Connecting to Server")
local success, errorMsg = pcall(function ()
	playerConnectSucces, player = pcall(function() return NetworkClient:PlayerConnect(0, "26.143.156.170", ' . $port . ', 0, threadSleepTime) end)
	print("! Joining game place ' . $gid . ' at 26.143.156.170")
	pcall(function() player.Name = "' . htmlspecialchars($name) . '" end)
	pcall(function() player.CharacterAppearance = "http://n.cloudpub.ru/Asset/CharacterFetch.ashx?userId=' . $uid . '" end)
	pcall(function() player.userId = "' . htmlspecialchars($uid) . '" end)
	player:SetSuperSafeChat(' . $guest . ')
	pcall(function() player:SetMembershipType(Enum.MembershipType.' . $memb . ') end)
	pcall(function() player:SetAccountAge(365) end)
	if not playerConnectSucces then
		player = game:GetService("Players"):CreateLocalPlayer(0)
		NetworkClient:Connect("26.143.156.170", ' . htmlspecialchars($port) . ', 0, threadSleepTime)
	end
end)

if not success then
	game:SetMessage(errorMsg)
end
';

echo sign($script);
?>
