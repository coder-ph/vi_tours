<?php
// Include Composer's autoloader (PHPMailer, Dotenv)
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load .env variables from the backend folder
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Helper function to sanitize input (prevents XSS)
function sanitize($val) {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

// Collect and sanitize input data
$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$message = sanitize($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    die('All fields are required.');
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}

// Setup PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP settings from .env
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];      // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER'];      // Email login
    $mail->Password   = $_ENV['SMTP_PASS'];      // Email password
    $mail->SMTPSecure = 'ssl';                   // Encryption: 'ssl' or 'tls'
    $mail->Port       = $_ENV['SMTP_PORT'];      

    // Email headers
    $mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']); // Sender identity
    $mail->addAddress($_ENV['TO_EMAIL']);                    // Where email is delivered
    $mail->addReplyTo($email, $name);                        // Allows recipient to reply directly

    // Email body
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
    ";
    $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";

    $mail->send();
    echo 'Message sent successfully.';
} catch (Exception $e) {
    echo 'Message could not be sent. Please try again later.';
    // Optionally log: error_log($mail->ErrorInfo);
}