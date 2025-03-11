<?php
// Include database connection
include '../backend/db/db_connection.php';

$errors = [];
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recruiter_name = trim($_POST['recruiter_name']);
    $company_name = trim($_POST['company_name']);
    $company_description = trim($_POST['company_description']);
    $company_logo = trim($_POST['company_logo']);
    $company_address = trim($_POST['company_address']);
    $company_website = trim($_POST['company_website']);
    $company_phone = trim($_POST['company_phone']);
    
    // Validate required fields
    if (empty($recruiter_name)) {
        $errors[] = "Recruiter name is required.";
    }
    if (empty($company_name)) {
        $errors[] = "Company name is required.";
    }
    if (empty($company_description)) {
        $errors[] = "Company description is required.";
    }
    if (empty($company_logo)) {
        $errors[] = "Company logo is required.";
    }
    if (empty($company_address)) {
        $errors[] = "Company address is required.";
    }
    if (empty($company_website)) {
        $errors[] = "Company website is required.";
    }
    if (empty($company_phone)) {
        $errors[] = "Mobile numbet is required.";
    }

    // Insert data if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO recruiter_profile (recruiter_name, company_name, company_description, company_logo, company_address, company_website, company_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $recruiter_name, $company_name, $company_description, $company_logo, $company_address, $company_website, $company_phone);

        if ($stmt->execute()) {
            $successMessage = "Recruiter profile created successfully!";
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
    <title>Recruiter Profile Form</title>
</head>
<body>
    <h1>Recruiter Profile Form</h1>
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
    <form action="recruiter_dashboard.php" method="POST">
        <label for="recruiter_name">Recruiter Name (Required):</label>
        <input type="text" id="recruiter_name" name="recruiter_name" maxlength="32" required>
        <br><br>

        

        <label for="company_name">Company Name (Required):</label>
        <input type="text" id="company_name" name="company_name" maxlength="128" required>
        <br><br>

        <label for="company_description">Company Description:</label>
        <textarea id="company_description" name="company_description" maxlength="1024" rows="3"></textarea>
        <br><br>

        <label for="company_logo">Company Logo URL:</label>
        <input type="text" id="company_logo" name="company_logo" maxlength="128">
        <br><br>

        <label for="company_address">Company Address:</label>
        <input type="text" id="company_address" name="company_address" maxlength="256">
        <br><br>

        <label for="company_website">Company Website:</label>
        <input type="text" id="company_website" name="company_website" maxlength="64">
        <br><br>

        <label for="company_phone">Company Phone:</label>
        <input type="text" id ="company_phone" name="company_phone" maxlength="16">
        <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>