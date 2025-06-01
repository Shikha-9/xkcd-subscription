<?php
require 'functions.php';

$to = 'receiveremail@example.com';  // use your email
$subject = 'Test Email from XKCD Bot';
$message = '<h1>This is a test email!</h1>';

if (sendEmail($to, $subject, $message)) {
    echo "✅ Email sent successfully!";
} else {
    echo "❌ Failed to send email.";
}
