<?php
session_start();
$PASS = "thesamaritanatethebunny20052011";

if (isset($_POST["password"])) {
    if ($_POST["password"] === $PASS) {
        $_SESSION["admin"] = true;
        header("Location: admin_ai.php");
        exit;
    }
    $err = "Wrong password";
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Admin Login</h2>

<?php if (!empty($err)) echo "<p>$err</p>"; ?>

<form method="post">
  <input type="password" name="password">
  <button>Login</button>
</form>

</body>
</html>
