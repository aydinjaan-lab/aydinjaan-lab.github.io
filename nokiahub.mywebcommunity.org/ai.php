<?php
$ip = $_SERVER["REMOTE_ADDR"];
$bans = file_exists("../private/ai_bans.txt")
    ? file("../private/ai_bans.txt", FILE_IGNORE_NEW_LINES)
    : [];

if (in_array($ip, $bans)) {
    die("You are banned.");
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Nokia AI</h2>

<form method="post" action="ai_send.php">
  <input name="q" size="20">
  <button>Ask</button>
</form>

<p><a href="index.php">Back to Nokia Hub</a></p>
<p>If a webpage called "render" loads please refresh after one minute.</p>
</body>
</html>
