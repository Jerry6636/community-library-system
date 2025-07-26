<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
    <!-- Box-icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="./css-js/login.css" rel="stylesheet">
    <!-- <link href="./css-js/style.css" rel="stylesheet"> -->
</head> 
<body>

<?php
    include './components/db-connect.php';

    session_start();
    if (isset($_POST['login'])) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['pass'];

        $select_user = $conn->prepare("SELECT * FROM `user_form` WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() == 1) {
            $fetch_user_info = $select_user->fetch(PDO::FETCH_ASSOC);
            if ($password === $fetch_user_info['password']) {
                $_SESSION['user_id'] = $fetch_user_info['id'];
                header('location:index.php');
            } else {
                $message = 'Incorrect password.';
            }
        } else {
            $message = 'Email not found.';
        }
    }
?>

    <!-- Background Elements -->
    <div class="bg-pattern"></div>
    <div class="book-spines"></div>
    <div class="library-shelf"></div>
    <div class="paper-lines"></div>
    <div class="floating-elements">
        <div class="floating-book">📚</div>
        <div class="floating-book">📖</div>
        <div class="floating-book">📝</div>
        <div class="floating-book">🔖</div>
        <div class="floating-book">📋</div>
    </div>
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration bottom-right"></div>

    <!-- Login Form -->
    <div class="login-container">
        <form class="form" action="login.php" method="POST" id="loginForm">
            <div class="form-header">
                <i class='bx bxs-book-open'></i>
                <h2 class="form-title">Library Portal</h2>
                <p class="form-subtitle">Access your library account</p>
            </div>

            <?php if(isset($message)): ?>
                <div class="error-message">
                    <i class='bx bx-error-circle'></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="input-group">
                <input type="email" name="email" class="form-input" placeholder="Enter your email address" required 
                       oninput="this.value = this.value.replace(/\s/g, '')" />
                <i class='bx bx-envelope'></i>
            </div>

            <div class="input-group">
                <input type="password" name="pass" class="form-input" placeholder="Enter your password" required 
                       oninput="this.value = this.value.replace(/\s/g, '')" />
                <i class='bx bx-lock-alt'></i>
            </div>

            <button type="submit" name="login" class="submit-btn" id="submitBtn">
                <i class='bx bx-log-in'></i> Sign In
            </button>

            <div class="form-footer">
                <a href="#" class="forgot-link">Forgot your password?</a>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./css-js/main.js"></script>
    
    <script>
        // Add loading state to form submission
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="bx bx-loader-alt"></i> Signing In...';
        });

        // Add input focus animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>