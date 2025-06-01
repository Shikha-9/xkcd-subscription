<?php
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // STEP A: User submitted email to get code
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (sendVerificationCode($email)) {
            echo "<p>✅ Verification code sent to <b>$email</b></p>";
            echo "
                <form method='POST'>
                    <input type='hidden' name='verify_email' value='$email'>
                    <input type='text' name='code' placeholder='Enter verification code' required>
                    <button type='submit'>Verify</button>
                </form>
            ";
        } else {
            echo "<p>❌ Failed to send email. Try again.</p>";
        }
    }

    // STEP B: User submitted code to verify
    if (isset($_POST['verify_email']) && isset($_POST['code'])) {
        $email = $_POST['verify_email'];
        $code = $_POST['code'];

        if (verifyCode($email, $code)) {
            saveVerifiedEmail($email);
            echo "<p>🎉 Email verified and subscribed successfully!</p>";
        } else {
            echo "<p>❌ Incorrect code. Please try again.</p>";
        }
    }
}
?>

<!-- STEP 0: Default form to enter email -->
<h2>Subscribe to XKCD Comics</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Subscribe</button>
</form>
