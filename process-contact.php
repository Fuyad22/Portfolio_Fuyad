<?php
// Set headers to allow client-side handling later
header('Content-Type: text/html; charset=utf-8');

// 1. Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Define variables and sanitize inputs
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST['message']);

    // 3. Validation: Check if fields are empty and email is valid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Simple error handling
        $status = "Error: Please fill in all fields correctly.";
        $success = false;
    } else {
        // 4. Processing (e.g., Sending an Email)

        // --- Configuration for Email ---
        $recipient = "your-email@example.com"; // CHANGE THIS to your actual email address!
        $subject = "New Portfolio Contact from $name";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";
        $email_headers = "From: $name <$email>";
        // ---------------------------------

        // Send the email (Requires a web server with mail functionality, like XAMPP/WAMP)
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            $status = "Thank you! Your message has been sent successfully.";
            $success = true;
        } else {
            $status = "Error: The email could not be sent (Server mail configuration issue).";
            $success = false;
        }
    }
} else {
    // If someone tries to access this script directly without submitting the form
    $status = "Access denied. Please submit the form from the contact page.";
    $success = false;
}

// 5. Display Confirmation/Error Message

if ($success) {
    $title_color = "text-green-500";
    $text_color = "text-gray-300";
    $button_bg = "bg-accent";
} else {
    $title_color = "text-red-500";
    $text_color = "text-gray-300";
    $button_bg = "bg-red-500";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-primary { background-color: #111827; }
        .bg-secondary { background-color: #1F2937; }
    </style>
</head>
<body class="bg-primary flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-secondary p-8 rounded-xl shadow-2xl text-center">
        <h1 class="text-4xl font-bold mb-4 <?php echo $title_color; ?>">
            <?php echo $success ? 'Success!' : 'Oops!'; ?>
        </h1>
        <p class="text-lg mb-8 <?php echo $text_color; ?>">
            <?php echo htmlspecialchars($status); ?>
        </p>
        <a href="portfolio.html#contact" class="inline-block px-6 py-3 <?php echo $button_bg; ?> text-primary font-semibold rounded-lg hover:opacity-90 transition duration-300">
            Go Back to Portfolio
        </a>
    </div>
</body>
</html>