<?php
// Include database connection
include 'backend/db/db_connection.php';

$errors = [];
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['full_number']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate roll_number
    if (empty($roll_number)) {
        $errors[] = "Roll number is required.";
    } else {
        // Check for duplicate roll_number
        $stmt = $conn->prepare("SELECT roll_number FROM student_profiles WHERE roll_number = ?");
        $stmt->bind_param("s", $roll_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Roll number already exists. Please use a unique roll number.";
        }
        $stmt->close();
    }

    // Validate remaining fields
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    }

    // Insert data if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO student_profiles (roll_number, first_name, last_name, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $roll_number, $first_name, $last_name, $email);

        if ($stmt->execute()) {
            $successMessage = "Registration successful!";
        } else {
            $errors[] = "Error: " . $stmt->error;
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
    <title>Recruivo - Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login-register.css">
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <h1>Create an Account</h1>

            <!-- Error Display Snippet -->
            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['errors']); // Clear errors after displaying ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <p class="success"><?php echo $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); // Clear success message ?>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST" action="../new_new/recruiter_details.php">
                <input type="hidden" name="action" value="register">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                <span id="name-error" class="form-error"></span>

                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                <span id="email-error" class="form-error"></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span id="password-error" class="form-error"></span>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                <span id="confirm-password-error" class="form-error"></span>

                <label>User Role</label>
                <select name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="recruiter">Recruiter</option>
                </select>
                <span id="role-error" class="form-error"></span>

                <button type="submit">Register</button>
            </form>

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script src="assets/js/form-validation.js"></script>
</body>
</html>