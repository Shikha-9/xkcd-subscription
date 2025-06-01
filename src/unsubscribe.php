<?php
require 'functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (sendVerificationCode($email)) {
        $message = "Verification code sent to $email";
    } else {
        $message = "Failed to send code.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_email'], $_POST['verify_code'])) {
    $email = trim($_POST['verify_email']);
    $code = trim($_POST['verify_code']);

    if (verifyCode($email, $code)) {
        unsubscribe($email);
        $message = "You've been unsubscribed.";
    } else {
        $message = "Invalid verification code.";
    }
}
?>

<h2>Unsubscribe from XKCD Comics</h2>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required>
    <button type="submit">Send Verification Code</button>
</form>

<br><hr><br>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="verify_email" required><br>
    <label>Verification Code:</label><br>
    <input type="text" name="verify_code" required>
    <button type="submit">Confirm Unsubscribe</button>
</form>

<p><?= $message ?></p>
