<?php
session_start();
include '../db/db_connection.php'; // Database connection

// Initialize an array to store error messages
$errors = [];

// Handle Login Request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "login") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If there are no errors, proceed with login
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                // Redirect user based on their role
                if ($user['role'] === "student") {
                    header("Location: student_dashboard.php");
                } elseif ($user['role'] === "recruiter") {
                    header("Location: recruiter_dashboard.php");
                } elseif ($user['role'] === "admin") {
                    header("Location: admin_dashboard.php");
                }
                exit;
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No account found with this email.";
        }
        $stmt->close();
    }

    // Store errors in session and redirect back to login page
    $_SESSION['errors'] = $errors;
    header("Location: login.php");
    exit;
}

// Handle Registration Request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "register") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $role = trim($_POST['role']);

    // Validate input
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($confirmPassword)) {
        $errors[] = "Confirm password is required.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($role) || !in_array($role, ['student', 'recruiter'])) {
        $errors[] = "Invalid role selected.";
    }

    // Check if email is already registered
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "An account with this email already exists.";
            $stmt->close();
        }
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful. Please log in.";
            header("Location: login.php");
        } else {
            $errors[] = "An error occurred. Please try again.";
        }
        $stmt->close();
    }

    // Store errors in session and redirect back to registration page
    $_SESSION['errors'] = $errors;
    header("Location: register.php");
    exit;
}