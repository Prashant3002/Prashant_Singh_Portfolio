<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - Recruivo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/features.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Powerful Features for <span class="highlight">Modern Recruitment</span></h1>
            <p>Discover how Recruivo streamlines campus recruitment with innovative tools and features.</p>
            <a href="#features" class="cta-button">Explore Features</a>
        </div>
    </section>

    <!-- Key Features Section -->
    <section id="features" class="features-section">
        <div class="section-header">
            <h2>Key Features</h2>
            <p>Everything you need for efficient campus recruitment</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-search"></i>
                <h3>Smart Job Matching</h3>
                <p>AI-powered job recommendations based on skills and preferences.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Applicant Tracking</h3>
                <p>Comprehensive system to manage and track candidate applications.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h3>Analytics Dashboard</h3>
                <p>Detailed insights and reports for informed decision-making.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-clock"></i>
                <h3>Real-time Updates</h3>
                <p>Instant notifications about application status and interviews.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Simple steps to get started with Recruivo</p>
        </div>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Create Account</h3>
                <p>Sign up as a student or recruiter and complete your profile.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Browse Opportunities</h3>
                <p>Explore job postings or post new opportunities.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Connect & Apply</h3>
                <p>Apply to positions or review candidate applications.</p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="section-header">
            <h2>Platform Benefits</h2>
            <p>Why choose Recruivo for campus recruitment?</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <h3>For Students</h3>
                <ul>
                    <li>Personalized job recommendations</li>
                    <li>Easy application process</li>
                    <li>Real-time status updates</li>
                    <li>Career development resources</li>
                </ul>
            </div>
            <div class="benefit-card">
                <h3>For Recruiters</h3>
                <ul>
                    <li>Efficient candidate screening</li>
                    <li>Automated application tracking</li>
                    <li>Analytics and reporting</li>
                    <li>Streamlined communication</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Transform Your Recruitment Process?</h2>
            <p>Join thousands of students and recruiters already using Recruivo.</p>
            <a href="register.php" class="cta-button">Get Started Today</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>