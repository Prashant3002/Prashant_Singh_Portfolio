<?php
// Start session and validate login
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'backend/db/db_connection.php';

// Debug session data
//echo "Session user_id: " . $_SESSION['user_id'] . "<br>";
//echo "Session role: " . $_SESSION['role'] . "<br>";

// Fetch student profile data
$user_id = $_SESSION['user_id'];
$profile_query = "
    SELECT sp.roll_number, sp.first_name, sp.last_name, sp.email, sp.mobile_number, sp.skills, sp.college, sp.degree, sp.branch, sp.graduation_percent
    FROM student_profiles sp
    JOIN users u ON sp.user_id = u.user_id
    WHERE u.user_id = ?";
$profile_stmt = $conn->prepare($profile_query);
$profile_stmt->bind_param("i", $user_id);
$profile_stmt->execute();
$profile_result = $profile_stmt->get_result();

if ($profile_result->num_rows === 1) {
    $student = $profile_result->fetch_assoc();
} else {
    echo "<p>Profile not found. Please contact support.</p>";
    exit;
}

// Fetch student applications
$applications_query = "
    SELECT j.title, j.company_name, j.location, a.status, a.applied_at
    FROM applications a
    JOIN job_postings j ON a.job_id = j.job_id
    WHERE a.student_id = (SELECT profile_id FROM student_profiles WHERE user_id = ?)";
$applications_stmt = $conn->prepare($applications_query);
$applications_stmt->bind_param("i", $user_id);
$applications_stmt->execute();
$applications_result = $applications_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Recruivo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/student_dashboard.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Welcome, <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>!</h1>
        <p>Your Student Dashboard</p>
        <a href="logout.php" class="logout-button">Logout</a>
    </header>

    <main class="dashboard-container">
        <!-- Profile Information -->
        <section class="profile-section">
            <h2>Your Profile</h2>
            <div class="profile-card">
                <p><strong>Roll Number:</strong> <?php echo htmlspecialchars($student['roll_number']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['mobile_number']); ?></p>
                <p><strong>College:</strong> <?php echo htmlspecialchars($student['college']); ?></p>
                <p><strong>Degree:</strong> <?php echo htmlspecialchars($student['degree']); ?></p>
                <p><strong>Branch:</strong> <?php echo htmlspecialchars($student['branch']); ?></p>
                <p><strong>Graduation Percentage:</strong> <?php echo htmlspecialchars($student['graduation_percent']); ?>%</p>
                <p><strong>Skills:</strong> <?php echo htmlspecialchars($student['skills']); ?></p>
            </div>
        </section>

        <!-- Applications Information -->
        <section class="applications-section">
            <h2>Your Job Applications</h2>
            <div class="applications-grid">
                <?php if ($applications_result->num_rows > 0): ?>
                    <?php while ($application = $applications_result->fetch_assoc()): ?>
                        <div class="application-card">
                            <h3><?php echo htmlspecialchars($application['title']); ?></h3>
                            <p><strong>Company:</strong> <?php echo htmlspecialchars($application['company_name']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($application['location']); ?></p>
                            <p><strong>Status:</strong> <span class="status <?php echo strtolower($application['status']); ?>"><?php echo ucfirst($application['status']); ?></span></p>
                            <p><strong>Applied on:</strong> <?php echo date("F d, Y", strtotime($application['applied_at'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>You have not applied for any jobs yet.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>