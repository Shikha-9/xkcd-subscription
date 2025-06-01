<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload Composer dependencies (if using Composer)
require 'vendor/autoload.php';

// Send email using PHPMailer
function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // 👉 Replace with your Gmail + App Password
        $mail->Username = 'shigautam95@gmail.com';
        $mail->Password = 'ptje bgph bmro ighy';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('shigautam95@gmail.com', 'XKCD Bot');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

// Generate and send a verification code
function sendVerificationCode($email) {
    $code = rand(100000, 999999);
    file_put_contents("verification_codes.txt", "$email:$code\n", FILE_APPEND);
    $subject = "Your XKCD Verification Code";
    $message = "Your verification code is: <b>$code</b>";
    return sendEmail($email, $subject, $message);
}

// Save verified email
function saveVerifiedEmail($email) {
    file_put_contents("registered_emails.txt", $email . "\n", FILE_APPEND);
}

// Check if the entered code matches
function verifyCode($email, $inputCode) {
    $lines = file("verification_codes.txt", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($storedEmail, $storedCode) = explode(":", $line);
        if ($storedEmail == $email && trim($storedCode) == $inputCode) {
            return true;
        }
    }
    return false;
}

// Unsubscribe a user
function unsubscribe($email) {
    $subscribers = file("registered_emails.txt", FILE_IGNORE_NEW_LINES);
    $subscribers = array_filter($subscribers, fn($e) => trim($e) !== trim($email));
    file_put_contents("registered_emails.txt", implode("\n", $subscribers));
    return true;
}
?>
