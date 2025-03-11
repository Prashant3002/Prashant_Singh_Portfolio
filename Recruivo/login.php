

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruivo - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login-register.css">
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <h1>Login to Recruivo</h1>

            <!-- Error Display Snippet -->
            <?php if (!empty($error_message)): ?>
                <div class="error-messages">
                    <p class="error"><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="login.php">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                <span id="email-error" class="form-error"></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span id="password-error" class="form-error"></span>

                <button type="submit">Login</button>
            </form>

            <p><a href="#">Forgot Password?</a></p>
            <p>New here? <a href="register.php">Create an account</a></p>
        </div>
    </div>

    <script src="assets/js/form-validation.js"></script>
</body>
</html>
