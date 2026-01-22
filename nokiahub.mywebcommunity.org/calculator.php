<?php
$history_file = "calc_history.txt";
$result = "";
$error = "";

if (isset($_POST["expr"])) {
    $expr = trim($_POST["expr"]);

    if ($expr !== "") {

        /* Replace constants */
        $safe = $expr;
        $safe = str_replace("pi", M_PI, $safe);
        $safe = str_replace("e", M_E, $safe);

        /* Replace power */
        $safe = preg_replace("/(\d+|\))\s*\^\s*(\d+|\()/", "pow($1,$2)", $safe);

        /* Replace root(x,n) */
        $safe = preg_replace(
            "/root\s*\(\s*([^,]+)\s*,\s*([^)]+)\s*\)/",
            "pow($1,1/$2)",
            $safe
        );

        /* Replace ln */
        $safe = str_replace("ln", "log", $safe);

        /* Validate input */
        if (!preg_match("/^[0-9+\-*\/()., powrtsincolgeabx ]+$/", $safe)) {
            $error = "Invalid characters.";
        } else {
            try {
                $result = @eval("return $safe;");
                if ($result === false) {
                    $error = "Math error.";
                } else {
                    /* Save to history */
                    $entry = $expr . " = " . $result;

                    $history = file_exists($history_file)
                        ? file($history_file, FILE_IGNORE_NEW_LINES)
                        : [];

                    array_unshift($history, $entry);
                    $history = array_slice($history, 0, 50);

                    file_put_contents($history_file, implode("\n", $history));
                }
            } catch (Throwable $t) {
                $error = "Error.";
            }
        }
    }
}

/* Load history */
$history = file_exists($history_file)
    ? file($history_file, FILE_IGNORE_NEW_LINES)
    : [];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Scientific Calculator</title>
</head>
<body>

<h2>Scientific Calculator</h2>

<form method="post">
  <input type="text" name="expr" size="20">
  <br><br>
  <button type="submit">Calculate</button>
</form>

<?php if ($result !== "") { ?>
<p><b>Result:</b></p>
<pre><?php echo htmlspecialchars($result); ?></pre>
<?php } ?>

<?php if ($error !== "") { ?>
<p><b>Error:</b> <?php echo htmlspecialchars($error); ?></p>
<?php } ?>

<hr>

<h3>Last 50 Calculations</h3>

<?php
if (empty($history)) {
    echo "<p>No history yet.</p>";
} else {
    foreach ($history as $line) {
        echo "<pre>" . htmlspecialchars($line) . "</pre>";
    }
}
?>

<hr>

<p><b>Examples:</b></p>
<pre>
2+3*4
2^5
sqrt(16)
root(27,3)
sin(3.14159/2)
log(100)
ln(2)
</pre>

<p>
<a href="index.php">Back to Nokia Hub</a>
</p>

</body>
</html>
