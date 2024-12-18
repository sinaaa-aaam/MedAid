<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn More - MedAId</title>
    <link rel="stylesheet" href="./styles/learn_more.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><span>MedAId</span></div>
        <div class="links">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="./public/login.php">Login</a>
                <a href="./public/register_proc.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <section class="learn-more-section">
            <h1>Discover the Power of MedAId</h1>
            <p>Welcome to MedAId, your AI-powered Personal Health Assistant designed to revolutionize how you manage and track your health. MedAId is here to help you stay on top of your wellness, providing personalized insights and predictions to make informed health decisions.</p>
            
            <div class="overview">
                <h2>What is MedAId?</h2>
                <p>MedAId is a web-based application that uses cutting-edge technology to empower users to monitor their health metrics, receive personalized insights, and track potential health risks. Whether you're aiming to improve your fitness, monitor your heart rate, or track your sleep, MedAId provides a comprehensive health assistant experience.</p>
            </div>

            <div class="technology">
                <h2>How MedAId Works</h2>
                <p>The application integrates PHP for backend operations, ensuring smooth and secure data management. On the frontend, it offers a responsive and user-friendly interface to interact with your health data. But what makes MedAId truly special is its use of machine learning for health predictions.</p>
                <ul>
                    <li><strong>AI-Powered Insights:</strong> Machine learning algorithms analyze your health data to provide personalized advice and predict potential health risks.</li>
                    <li><strong>Real-Time Tracking:</strong> Log and monitor your health metrics, such as steps, sleep, heart rate, and calories burned.</li>
                    <li><strong>Health Goals:</strong> Set and track your health goals effectively with MedAId’s easy-to-use interface.</li>
                </ul>
            </div>

            <div class="benefits">
                <h2>Why Choose MedAId?</h2>
                <p>MedAId is not just a tracker—it's your personal health assistant that learns from your data and provides proactive advice to help you stay healthy. Here's why MedAId is the right choice for you:</p>
                <ul>
                    <li><strong>Personalized Recommendations:</strong> Receive tailored insights based on your health data.</li>
                    <li><strong>Comprehensive Dashboard:</strong> Keep track of all your health metrics in one place, with clear and actionable insights.</li>
                    <li><strong>Predictive Health Analysis:</strong> Understand your health risks and take steps to avoid potential health issues.</li>
                    <li><strong>Easy-to-Use Interface:</strong> Our simple, responsive design makes managing your health data easy and stress-free.</li>
                </ul>
            </div>

            <div class="cta">
                <h2>Take Control of Your Health Today</h2>
                <p>MedAId is here to guide you on your health journey. Whether you want to lose weight, improve your fitness, or simply stay healthier, MedAId helps you make smarter decisions.</p>
                <a href="./public/register_proc.php" class="btn btn-primary">Get Started with MedAId</a>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 MedAId. All Rights Reserved.</p>
    </footer>
</body>
</html>
