<?php
// Start session to access user role
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role']; // Fetch the user's role (student, recruiter, admin)
?>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Recruivo</h2> <!-- Sidebar logo/title -->
    </div>
    <ul class="menu">
        <!-- Common Links (All Roles) -->
        <li><a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
        <li><a href="profile.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : ''; ?>">Profile</a></li>
        <li><a href="notifications.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'notifications.php' ? 'active' : ''; ?>">Notifications</a></li>
        <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'active' : ''; ?>">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li>

        <?php if ($role === 'admin'): ?>
            <!-- Admin-Specific Links -->
            <li><a href="manage_users.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
            <li><a href="manage_jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manage_jobs.php' ? 'active' : ''; ?>">Manage Jobs</a></li>
            <li><a href="feedback.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'feedback.php' ? 'active' : ''; ?>">Feedback</a></li>
        <?php elseif ($role === 'student'): ?>
            <!-- Student-Specific Links -->
            <li><a href="browse_jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'browse_jobs.php' ? 'active' : ''; ?>">Browse Jobs</a></li>
            <li><a href="my_applications.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'my_applications.php' ? 'active' : ''; ?>">My Applications</a></li>
        <?php elseif ($role === 'recruiter'): ?>
            <!-- Recruiter-Specific Links -->
            <li><a href="post_job.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'post_job.php' ? 'active' : ''; ?>">Post a Job</a></li>
            <li><a href="my_job_postings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'my_job_postings.php' ? 'active' : ''; ?>">My Job Postings</a></li>
            <li><a href="manage_applications.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manage_applications.php' ? 'active' : ''; ?>">Manage Applications</a></li>
        <?php endif; ?>
    </ul>
</div>