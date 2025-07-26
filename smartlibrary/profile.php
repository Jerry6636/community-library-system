<?php 
include './components/db-connect.php';
include './components/header.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
        }

        .profile-box {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            margin-top: 30px;
            transition: all 0.3s ease;
            display: flex;
            width: 100%;
            flex:1;
            justify-content: center;
        }

        .profile-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .p-i {
            margin-bottom: 25px;
        }

        .p-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #d2691e;
            box-shadow: 0 4px 20px rgba(210, 105, 30, 0.3);
            transition: transform 0.3s ease;
        }

        .p-img:hover {
            transform: scale(1.05);
        }

        .p-category {
            font-size: 1.1rem;
            color: #666;
            margin: 12px 0;
            font-weight: 500;
        }

        .p-title {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            text-decoration: none;
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        .p-title:hover {
            color: #d2691e;
        }

        .p-date {
            display: block;
            font-size: 1rem;
            color: #555;
            margin: 6px 0;
            padding: 4px 0;
        }

        .bt {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .p-btn {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(45deg, #d2691e, #ff7f50);
            color: #fff;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(210, 105, 30, 0.3);
            min-width: 120px;
            justify-content: center;
        }

        .p-btn:hover {
            background: linear-gradient(45deg, #a65312, #d2691e);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(210, 105, 30, 0.4);
        }

        .books-btn {
            background: linear-gradient(45deg, #4CAF50, #45a049) !important;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3) !important;
        }

        .books-btn:hover {
            background: linear-gradient(45deg, #45a049, #4CAF50) !important;
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4) !important;
        }

        .logout-btn {
            background: linear-gradient(45deg, #f44336, #d32f2f) !important;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3) !important;
        }

        .logout-btn:hover {
            background: linear-gradient(45deg, #d32f2f, #b71c1c) !important;
            box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4) !important;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #d2691e;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .profile-box {
                padding: 25px;
            }
            
            .bt {
                flex-direction: column;
                align-items: center;
            }
            
            .p-btn {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>

<?php
    $select_profile = $conn->prepare("SELECT * FROM `user_form` WHERE id = ?");
    $select_profile->execute([$user_id]);
    
    // Get borrowed books count from 'borrow' table using regno
    try {
        // First get the user's regno
        $get_regno = $conn->prepare("SELECT regno FROM `user_form` WHERE id = ?");
        $get_regno->execute([$user_id]);
        $user_regno = $get_regno->fetchColumn();
        
        // Count currently borrowed books using sregno
        $count_borrowed = $conn->prepare("SELECT COUNT(*) FROM `borrow` WHERE sregno = ?");
        $count_borrowed->execute([$user_regno]);
        $borrowed_count = $count_borrowed->fetchColumn();
        
        // Since borrow table only has active borrows, total count is same as borrowed count
        $total_count = $borrowed_count;
    } catch(PDOException $e) {
        // If table doesn't exist, set default values
        $borrowed_count = 0;
        $total_count = 0;
    }
    
    if($select_profile->rowCount() > 0){
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="profile-box">
       <div>
         <div class="p-i">
            <img src="./images/login.jpg" alt="Profile" class="p-img">
        </div>
        <h2 class="p-category">Registration: <?= htmlspecialchars($fetch_profile['regno']); ?></h2>
        <a href="#" class="p-title"><?= htmlspecialchars($fetch_profile['name']) ?></a>
        <span class="p-date">📧 <?= htmlspecialchars($fetch_profile['email']); ?></span>
        <span class="p-date">📱 <?= htmlspecialchars($fetch_profile['contact']); ?></span>
        
        <div class="bt">
            <a href="u-profile.php" class="p-btn">
                📝 Update Profile
            </a>
            <a href="borrowed-books.php" class="p-btn books-btn">
                📚 My Books
            </a>
            <a href="logout.php" class="p-btn logout-btn">
                🚪 Logout
            </a>
        </div>
    </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?= $borrowed_count ?></div>
            <div class="stat-label">Currently Borrowed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $total_count ?></div>
            <div class="stat-label">Total Books Read</div>
        </div>
    </div>
</div>

<?php } else { ?>
    <div class="container">
        <div class="profile-box">
            <h3>Profile not found!</h3>
            <p>Please login again.</p>
            <a href="login.php" class="p-btn">Login</a>
        </div>
    </div>
<?php } ?>

</body>
</html>

<?php 
    include './components/footer.php'; 
?>