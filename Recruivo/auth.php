<?php
session_start();
include 'backend/db/db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'register') {
    // Initialize error array
    $errors = [];

    // Get user inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($role) || !in_array($role, ['student', 'recruiter'])) {
        $errors[] = "Please select a valid role.";
    }

    // Check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: register.php'); // Redirect back to register page
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the `users` table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id; // Get the ID of the newly created user

        // Role-specific logic
        if ($role === 'student') {
            // Validate required fields for students
            $roll_number = htmlspecialchars(trim($_POST['roll_number']));
            $degree = htmlspecialchars(trim($_POST['degree']));
            $branch = htmlspecialchars(trim($_POST['branch']));
            $year_of_passing = htmlspecialchars(trim($_POST['year_of_passing']));
        
            if (empty($roll_number)) {
                $errors[] = "Roll number is required for students.";
            }
            if (empty($degree)) {
                $errors[] = "Degree is required for students.";
            }
            if (empty($branch)) {
                $errors[] = "Branch is required for students.";
            }
            if (empty($year_of_passing)) {
                $errors[] = "Year of passing is required for students.";
            }
        
            // If validation fails, redirect with errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: register.php');
                exit();
            }
        
            // Proceed to insert into student_profiles
            $stmt = $conn->prepare("INSERT INTO student_profiles (user_id, roll_number, degree, branch, year_of_passing) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $user_id, $roll_number, $degree, $branch, $year_of_passing);
            $stmt->execute();
        
        
        } elseif ($role === 'recruiter') {
            // Prepare recruiter-specific details (optional fields can be added later)
            $company_name = '';
            $company_description = '';

            $stmt = $conn->prepare("INSERT INTO recruiter_profiles (user_id, company_name, description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $company_name, $company_description);
            $stmt->execute();
        }

        // Success message
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header('Location: register.php'); // Redirect back to register page
    } else {
        // Database error
        $errors[] = "An error occurred during registration. Please try again.";
        $_SESSION['errors'] = $errors;
        header('Location: register.php'); // Redirect back to register page
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: register.php'); // Redirect to register page if accessed improperly
    exit();
}
