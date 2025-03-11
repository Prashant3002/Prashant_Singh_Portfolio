<?php
// Include database connection
include '../backend/db/db_connection.php';

$errors = [];
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roll_number = trim($_POST['roll_number']);
    $middle_name = trim($_POST['middle_name']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $mobile_number = trim($_POST['mobile_number']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $college = trim($_POST['college']);
    $course = trim($_POST['course']);
    $branch = trim($_POST['branch']);
    $year_of_passing = trim($_POST['year_of_passing']);
    $tenth_percent = trim($_POST['tenth_percent']);
    $twelfth_percent = trim($_POST['twelfth_percent']);
    $graduation_percent = trim($_POST['graduation_percent']);
    $skills = trim($_POST['skills']);
    
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
    if (empty($first_name)) {
        $errors[] = "";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (empty($mobile_number)) {
        $errors[] = "Mobile number is required.";
    }
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }
    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    }
    if (empty($college)) {
        $errors[] = "College name is required.";
    }
    if (empty($course)) {
        $errors[] = "Course is required.";
    }
    if (empty($branch)) {
        $errors[] = "Branch is required.";
    }
    if (empty($year_of_passing)) {
        $errors[] = "Year of passing is required.";
    }
    if (empty($tenth_percent)) {
        $errors[] = "Tenth percent is required.";
    }
    if (empty($twelfth_percent)) {
        $errors[] = "Twelfth percent is required.";
    }
    if (empty($graduation_percent)) {
        $errors[] = "";
    }
    if (empty($skills)) {
        $errors[] = "Skills are required.";
    }

    // Insert data if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO student_profile (roll_number, first_name, middle_name, last_name, mobile_number, gender, dob, college, course, branch, year_of_passing, tenth_percent, twelfth_percent, graduation_percent, skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param ("ssssssssssdddds", $roll_number, $first_name, $middle_name, $last_name, $mobile_number, $gender, $dob, $college, $course, $branch, $year_of_passing, $tenth_percent, $twelfth_percent, $graduation_percent, $skills);

        if ($stmt->execute()) {
            $successMessage = "Details entered successful!";
        } else {
            $errors[] = "Error: " . $stmt ->error;
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
    <title>Student Details Form</title>
</head>
<body>
    <h1>Student Details Form</h1>
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
    <form action="student_detail.php" method="POST">
        <label for="roll_number">Roll Number (Required):</label>
        <input type="text" id="roll_number" name="roll_number" maxlength="32" required>
        <br><br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" maxlength="32">
        <br><br>

        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name" maxlength="32">
        <br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" maxlength="32">
        <br><br>

        <label for="mobile_number">Mobile Number (Required):</label>
        <input type="text" id="mobile_number" name="mobile_number" maxlength="10" required pattern="[0-9]{10,16}" placeholder="Enter a valid number">
        <br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
            <option value="O">Other</option>
        </select>
        <br><br>

        <label for="dob">Date of Birth (Required):</label>
        <input type="date" id="dob" name="dob" required>
        <br><br>

        <label for="college">College:</label>
        <input type="text" id="college" name="college" maxlength="128">
        <br><br>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" maxlength="16">
        <br><br>

        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" maxlength="16">
        <br><br>

        <label for="year_of_passing">Year of Passing:</label>
        <input type="text" id="year_of_passing" name="year_of_passing" maxlength="4" pattern="[0-9]{4}" placeholder="e.g., 2024">
        <br><br>

        <label for="tenth_percent">10th Percentage:</label>
        <input type="number" id="tenth_percent" name="tenth_percent" step="0.01" max="100">
        <br><br>

        <label for="twelfth_percent">12th Percentage:</label>
        <input type="number" id="twelfth_percent" name="twelfth_percent" step="0.01" max="100">
        <br><br>

        <label for="graduation_percent">Graduation Percentage:</label>
        <input type="number" id="graduation_percent" name="graduation_percent" step="0.01" max="100">
        <br><br>

        <label for="skills">Skills:</label>
        <textarea id="skills" name="skills" maxlength="32" rows="3" placeholder="e.g., Java, Python, HTML"></textarea>
        <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>