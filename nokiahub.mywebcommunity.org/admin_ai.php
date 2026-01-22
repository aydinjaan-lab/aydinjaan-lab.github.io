<?php
session_start();
if (empty($_SESSION["admin"])) die("Access denied.");

$LOG = "../private/ai_logs.txt";
$BAN = "../private/ai_bans.txt";

$logs = file_exists($LOG) ? file($LOG, FILE_IGNORE_NEW_LINES) : [];
$bans = file_exists($BAN) ? file($BAN, FILE_IGNORE_NEW_LINES) : [];

$stats = [];
$last  = [];

foreach ($logs as $l) {
    if (preg_match("/IP:(.*?)\|(USER|AI):(.*)/", $l, $m)) {
        $ip = $m[1];
        $stats[$ip] = ($stats[$ip] ?? 0) + 1;
        $last[$ip][] = $m[2] . ": " . $m[3];
        if (count($last[$ip]) > 10) array_shift($last[$ip]);
    }
}

if (isset($_POST["ban"])) {
    file_put_contents($BAN, $_POST["ban"] . "\n", FILE_APPEND);
}
if (isset($_POST["unban"])) {
    $new = array_filter($bans, fn($b) => trim($b) !== $_POST["unban"]);
    file_put_contents($BAN, implode("\n", $new));
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>AI Admin Panel</h2>

<?php foreach ($stats as $ip => $count): ?>
<hr>
<p>IP: <?php echo htmlspecialchars($ip); ?></p>
<p>Messages: <?php echo $count; ?></p>
<pre><?php echo htmlspecialchars(implode("\n", $last[$ip])); ?></pre>

<form method="post" style="display:inline">
<input type="hidden" name="ban" value="<?php echo $ip; ?>">
<button>Ban</button>
</form>

<form method="post" style="display:inline">
<input type="hidden" name="unban" value="<?php echo $ip; ?>">
<button>Unban</button>
</form>
<?php endforeach; ?>

<p><a href="admin_logout.php">Logout</a></p>

</body>
</html>
