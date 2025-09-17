<?php
header('Content-Type: application/json');

// Replace with your email
$to_email = "your-email@example.com";

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Validate inputs
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Please fill all fields']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email format']);
    exit;
}

// Email headers
$subject = "New Contact Form Submission from Portfolio";
$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Email body
$email_body = "
<html>
<head>
  <title>New Contact Form Submission</title>
</head>
<body>
  <h2>New Contact Form Submission</h2>
  <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
  <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
  <p><strong>Message:</strong></p>
  <p>" . nl2br(htmlspecialchars($message)) . "</p>
</body>
</html>
";

// Send email
$mail_sent = mail($to_email, $subject, $email_body, $headers);

if ($mail_sent) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to send email']);
}
?>
