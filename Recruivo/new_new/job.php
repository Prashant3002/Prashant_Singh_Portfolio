<?php
// Include database connection
include '../backend/db/db_connection.php';

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $job_name = trim($_POST['job_name']);
    $job_desc = trim($_POST['job_desc']);
    $min_salary = trim($_POST['min_salary']);
    $max_salary = trim($_POST['max_salary']);
    $job_type = trim($_POST['job_type']);
    $job_role = trim($_POST['job_role']);
    $job_location = trim($_POST['job_location']);
    $post_start = trim($_POST['post_start']);
    $post_end = trim($_POST['post_end']);
    
    // Validate required fields
    if (empty($job_name)) {
        $errors[] = "Job name is required.";
    }
    if (empty($job_desc)) {
        $errors[] = "Job description is required.";
    }
    if (empty($min_salary)) {
        $errors[] = "";
    }
    if (empty($max_salary)) {
        $errors[] = "";
    }
    if (empty($job_type)) {
        $errors[] = "Job type is required.";
    }
    if (empty($job_role)) {
        $errors[] = "Job role is required.";
    }
    if (empty($job_location)) {
        $errors[] = "Job location is required.";
    }
    if (empty($post_start)) {
        $errors[] = "Post start date is required.";
    }
    if (empty($post_end)) {
        $errors[] = "Post end date is required.";
    }
    

    // Insert data if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO job (job_name, job_desc, min_salary, max_salary, job_type, job_role, job_location, post_start, post_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssssss", $job_name, $job_desc, $min_salary, $max_salary, $job_type, $job_role, $job_location, $post_start, $post_end);

        if ($stmt->execute()) {
            $successMessage = "Job posted successfully!";
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
    <title>Job Posting Form</title>
</head>
<body>
    <h1>Job Posting Form</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if ($successMessage): ?>
        <div style="color: green;">
            <p><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
    <?php endif; ?>
    <form action="job.php" method="POST">

        <label for="job_name">Job Name (Required):</label>
        <input type="text" id="job_name" name="job_name" maxlength="32" required>
        <br><br>

        <label for="job_desc">Job Description:</label>
        <textarea id="job_desc" name="job_desc" maxlength="2048" rows="4"></textarea>
        <br><br>

        <label for="min_salary">Minimum Salary:</label>
        <input type="number" id="min_salary" name="min_salary" step="0.01" min="0">
        <br><br>

        <label for="max_salary">Maximum Salary:</label>
        <input type="number" id="max_salary" name="max_salary" step="0.01" min="0">
        <br><br>

        <label for="job_type">Job Type:</label>
        <input type="text" id="job_type" name="job_type" maxlength="32">
        <br><br>

        <label for="job_role">Job Role:</label>
        <input type="text" id="job_role" name="job_role" maxlength="16">
        <br><br>

        <label for="job_location">Job Location:</label>
        <input type="text" id="job_location" name="job_location" maxlength="16 ">
        <br><br>

        <label for="post_start">Post Start Date (Required):</label>
        <input type="date" id="post_start" name="post_start" required>
        <br><br>

        <label for="post_end">Post End Date (Required):</label>
        <input type="date" id="post_end" name="post_end" required>
        <br><br>

        <button type="submit">Post Job</button>
    </form>
</body>
</html>