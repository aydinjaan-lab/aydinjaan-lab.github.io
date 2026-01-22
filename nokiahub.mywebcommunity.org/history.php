<?php
$history_file = "calc_history.txt";
$theme_file = "theme.txt";

$theme = file_exists($theme_file) ? trim(file_get_contents($theme_file)) : "day";
$bg = ($theme === "night") ? "#000000" : "#ffffff";
$fg = ($theme === "night") ? "#ffffff" : "#000000";

$history = file_exists($history_file)
  ? file($history_file, FILE_IGNORE_NEW_LINES)
  : [];
?>
<!DOCTYPE html>
<html>
<head><title>Calculation History</title></head>
<body bgcolor="<?php echo $bg; ?>" text="<?php echo $fg; ?>">

<h2>Last 50 Calculations</h2>

<?php
if (empty($history)) {
    echo "<p>No history yet.</p>";
} else {
    echo "<pre>";
    foreach ($history as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
}
?>

<p>
<a href="calculator.php">Back to Calculator</a><br>
<a href="index.php">Back to Nokia Hub</a>
</p>

</body>
</html>
