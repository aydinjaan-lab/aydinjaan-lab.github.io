<?php
$theme_file = "theme.txt";

$mode = ($_GET["mode"] === "night") ? "night" : "day";
file_put_contents($theme_file, $mode);

header("Location: calculator.php");
exit;
