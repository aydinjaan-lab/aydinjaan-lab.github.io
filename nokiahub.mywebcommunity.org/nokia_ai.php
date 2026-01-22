<?php
$response = "";
$error = "";

if (isset($_POST["q"])) {
    $q = trim($_POST["q"]);

    if ($q !== "") {
        $data = json_encode([
            "model" => "mistral",
            "prompt" => $q,
            "stream" => false
        ]);

        /* IMPORTANT: replace the URL below */
        $ch = curl_init("https://Victor-administrative-lamps-blues.trycloudflare.com/api/generate");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $result = curl_exec($ch);

        if ($result === false) {
            $error = "AI not reachable.";
        } else {
            $json = json_decode($result, true);
            if (isset($json["response"])) {
                $response = $json["response"];
            } else {
                $error = "AI error.";
            }
        }

        curl_close($ch);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Nokia AI</title>
</head>
<body>

<h3>Nokia AI</h3>

<form method="post">
  <input type="text" name="q" size="20" autocomplete="off">
  <br><br>
  <button type="submit">Ask</button>
</form>

<?php if ($response !== "") { ?>
<hr>
<pre><?php echo htmlspecialchars($response); ?></pre>
<?php } ?>

<?php if ($error !== "") { ?>
<p><?php echo htmlspecialchars($error); ?></p>
<?php } ?>

<p>
Tip: If the reply stops, type <b>continue</b>
</p>

<p>
<a href="index.php">Back to Nokia Hub</a>
</p>

</body>
</html>