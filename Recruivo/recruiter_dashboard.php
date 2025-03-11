
<?php
// Start session and validate recruiter login
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'backend/db/db_connection.php';

// Fetch recruiter profile details
$user_id = $_SESSION['user_id'];
$recruiter_query = "
    SELECT rp.company_name, rp.company_logo, rp.description, u.name, u.email 
    FROM recruiter_profiles rp
    JOIN users u ON rp.user_id = u.user_id
    WHERE u.user_id = ?";
$stmt = $conn->prepare($recruiter_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recruiter_result = $stmt->get_result();

if ($recruiter_result->num_rows === 1) {
    $recruiter = $recruiter_result->fetch_assoc();
} else {
    die("Recruiter profile not found.");
}

// Fetch job postings created by the recruiter
$job_postings_query = "
    SELECT jp.job_id, jp.title, jp.created_at, (SELECT COUNT(*) FROM applications WHERE job_id = jp.job_id) AS applicant_count 
    FROM job_postings jp
    WHERE jp.recruiter_id = (SELECT recruiter_id FROM recruiter_profiles WHERE user_id = ?)";
$stmt = $conn->prepare($job_postings_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$job_postings_result = $stmt->get_result();

// Fetch applicants for each job posting (if needed later via AJAX or inline display)
$applicants_query = "
    SELECT a.application_id, s.first_name, s.last_name, s.email, a.status, a.applied_at 
    FROM applications a
    JOIN student_profiles s ON a.student_id = s.profile_id
    WHERE a.job_id = ?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Dashboard - Recruivo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/recruiter_dashboard.css">
</head>
<body>
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <h1>Welcome, <?php echo htmlspecialchars($recruiter['name']); ?>!</h1>
            <p>Your Recruiter Dashboard</p>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="dashboard-container">
        <!-- Recruiter Profile Section -->
        <section class="profile-section">
            <h2>Your Profile</h2>
            <div class="profile-card">
                <div class="profile-left">
                    <img src="uploads/<?php echo htmlspecialchars($recruiter['company_logo']) ?: 'default_logo.png'; ?>" alt="Company Logo" class="company-logo">
                </div>
                <div class="profile-right">
                    <p><strong>Company Name:</strong> <?php echo htmlspecialchars($recruiter['company_name']); ?></p>
                    <p><strong>Recruiter Name:</strong> <?php echo htmlspecialchars($recruiter['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($recruiter['email']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($recruiter['description']); ?></p>
                </div>
            </div>
        </section>

        <!-- Job Postings Section -->
        <section class="job-postings-section">
            <h2>Your Job Postings</h2>
            <div class="job-postings-grid">
                <?php if ($job_postings_result->num_rows > 0): ?>
                    <?php while ($job = $job_postings_result->fetch_assoc()): ?>
                        <div class="job-card">
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p><strong>Posted On:</strong> <?php echo date("F d, Y", strtotime($job['created_at'])); ?></p>
                            <p><strong>Applicants:</strong> <?php echo $job['applicant_count']; ?></p>
                            <a href="view_applicants.php?job_id=<?php echo $job['job_id']; ?>" class="action-link">View Applicants</a>
                            <a href="edit_job.php?job_id=<?php echo $job['job_id']; ?>" class="action-link">Edit Job</a>
                            <a href="delete_job.php?job_id=<?php echo $job['job_id']; ?>" class="action-link delete-link">Delete Job</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No job postings found. <a href="post_job.php" class="action-link">Post a job now!</a></p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>