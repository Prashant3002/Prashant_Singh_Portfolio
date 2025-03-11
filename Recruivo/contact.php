<?php
session_start();
include 'includes/header.php'; // Include the header
include 'backend/db/db_connection.php'; // Include the database connection

$errors = [];
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Server-side validation
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // Process the form if there are no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, submitted_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $successMessage = "Thank you for reaching out! We'll get back to you soon.";
        } else {
            $errors[] = "An error occurred. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Recruivo</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Global styles -->
    <link rel="stylesheet" href="assets/css/contact.css"> <!-- Contact-specific styles -->
</head>
<body>
    <!-- Contact Form Section -->
    <div class="contact-container">
        <div class="contact-card">
            <h1>Contact Us</h1>
            <p>Have a question or need assistance? We're here to help!</p>

            <!-- Success and Error Messages -->
            <?php if (!empty($successMessage)): ?>
                <p class="success"><?php echo $successMessage; ?></p>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <form method="POST" action="contact.php" id="contact-form">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                <span id="name-error" class="form-error"></span>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <span id="email-error" class="form-error"></span>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Enter the subject" required>
                <span id="subject-error" class="form-error"></span>

                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
                <span id="message-error" class="form-error"></span>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>