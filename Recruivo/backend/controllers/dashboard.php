<?php
// Start session and validate login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Include database connection and header
if (!@include '../../backend/db/db_connection.php') {
    die("Database connection file not found.");
}

if (!@include '../../includes/header.php') {
    die("Header file not found.");
}

// Fetch user information from session
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];
$user_name = $_SESSION['name'];

// Role-based data fetching
if ($user_role === 'student') {
    // Fetch student's job applications
    $query = "
        SELECT a.application_id, j.title, r.company_name, a.status, a.applied_at
        FROM applications a
        JOIN job_postings j ON a.job_id = j.job_id
        JOIN recruiter_profiles r ON j.recruiter_id = r.recruiter_id
        WHERE a.student_id = (SELECT profile_id FROM student_profiles WHERE user_id = $user_id)";
    $applications_result = $conn->query($query);

    if (!$applications_result) {
        die("Error fetching applications: " . $conn->error);
    }
} elseif ($user_role === 'recruiter') {
    // Fetch recruiter's job postings
    $query = "
        SELECT j.job_id, j.title, j.created_at, COUNT(a.application_id) AS applicant_count
        FROM job_postings j
        LEFT JOIN applications a ON j.job_id = a.job_id
        WHERE j.recruiter_id = (SELECT recruiter_id FROM recruiter_profiles WHERE user_id = $user_id)
        GROUP BY j.job_id";
    $job_postings_result = $conn->query($query);

    if (!$job_postings_result) {
        die("Error fetching job postings: " . $conn->error);
    }
} elseif ($user_role === 'admin') {
    // Fetch admin statistics
    $total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
    $total_jobs = $conn->query("SELECT COUNT(*) AS total FROM job_postings")->fetch_assoc()['total'];
    $pending_applications = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status = 'pending'")->fetch_assoc()['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Recruivo</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="header-content">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p>Role: <span class="role"><?php echo ucfirst($user_role); ?></span></p>
            <a href="../../logout.php" class="logout-button">Logout</a>
        </div>
    </header>

    <main class="dashboard-container">
        <?php if ($user_role === 'student'): ?>
            <section class="role-section student-section">
                <h2>Your Applications</h2>
                <div class="grid-container">
                    <?php if ($applications_result->num_rows > 0): ?>
                        <?php while ($application = $applications_result->fetch_assoc()): ?>
                            <div class="card application-card">
                                <h3><?php echo htmlspecialchars($application['title']); ?></h3>
                                <p><span>Company:</span> <?php echo htmlspecialchars($application['company_name']); ?></p>
                                <p><span>Status:</span> <span class="status <?php echo strtolower($application['status']); ?>">
                                    <?php echo ucfirst($application['status']); ?></span></p>
                                <p><span>Applied on:</span> <?php echo date("F d, Y", strtotime($application['applied_at'])); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No applications found. Start applying now!</p>
                    <?php endif; ?>
                </div>
            </section>
        <?php elseif ($user_role === 'recruiter'): ?>
            <section class="role-section recruiter-section">
                <h2>Your Job Postings</h2>
                <div class="grid-container">
                    <?php if ($job_postings_result->num_rows > 0): ?>
                        <?php while ($job = $job_postings_result->fetch_assoc()): ?>
                            <div class="card job-card">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><span>Posted on:</span> <?php echo date("F d, Y", strtotime($job['created_at'])); ?></p>
                                <p><span>Applicants:</span> <?php echo $job['applicant_count']; ?></p>
                                <a href="view_applicants.php?job_id=<?php echo $job['job_id']; ?>" class="action-link">View Applicants</a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No job postings found. <a href="post_job.php" class="action-link">Post a job now!</a></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php elseif ($user_role === 'admin'): ?>
            <section class="role-section admin-section">
                <h2>Admin Overview</h2>
                <div class="grid-container stats-container">
                    <div class="card">
                        <h3>Total Users</h3>
                        <p><?php echo $total_users; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Job Postings</h3>
                        <p><?php echo $total_jobs; ?></p>
                    </div>
                    <div class="card">
                        <h3>Pending Applications</h3>
                        <p><?php echo $pending_applications; ?></p>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>