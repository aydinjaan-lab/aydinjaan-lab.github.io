<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo "Invalid request.";

    exit;

}

if (!isset($_POST["q"])) {

    echo "No question.";

    exit;

}

$q = trim($_POST["q"]);

if ($q === "") {

    echo "Empty question.";

    exit;

}

/* YOUR CONFIRMED WORKING BACKEND */

$url = "https://nokia-ai-backend.onrender.com/ask?q=" . urlencode($q);

/* USE CURL – SIMPLE, NO LIMITS, NO BANS, NO EXTRA LOGIC */

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_TIMEOUT, 20);

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);

if ($response === false) {

    echo "Curl error: " . curl_error($ch);

    curl_close($ch);

    exit;

}

curl_close($ch);

/* OUTPUT EXACTLY WHAT BACKEND RETURNS */

header("Content-Type: text/plain");

echo $response;