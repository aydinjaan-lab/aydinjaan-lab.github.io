<?php
$dir = "txt";

/* Make sure folder exists */
if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

/* Save new text */
if (isset($_POST["text"])) {
    $text = trim($_POST["text"]);
    if ($text !== "") {
        $files = glob("$dir/*.txt");
        $id = count($files) + 1;
        file_put_contents("$dir/$id.txt", $text);
    }
}

/* Load last 10 files */
$files = glob("$dir/*.txt");
rsort($files);
$files = array_slice($files, 0, 10);
?>
<!DOCTYPE html>
<html>
<head>
  <title>TXT Grabber</title>
</head>
<body>

<h2>TXT Grabber</h2>

<form method="post">
  <textarea name="text" rows="5" cols="20"></textarea><br>
  <button type="submit">Save Text</button>
</form>

<hr>

<h3>Last Saved Texts</h3>

<?php
if (empty($files)) {
    echo "<p>No saved text yet.</p>";
} else {
    foreach ($files as $file) {
        $name = basename($file);
        echo "<a href=\"txt/$name\">Open $name</a><br>";
    }
}
?>

<p>
<a href="index.php">Back to Nokia Hub</a>
</p>

</body>
</html>
