<?php
$history_file = "txt_history.txt";

if (!isset($_GET["id"])) exit;

$id = (int) $_GET["id"];
$entries = file_exists($history_file)
    ? explode("\n---\n", file_get_contents($history_file))
    : [];

if (!isset($entries[$id])) exit;

header("Content-Type: text/plain");
echo $entries[$id];
exit;
