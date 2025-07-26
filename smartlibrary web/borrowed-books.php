<?php 
    include './components/db-connect.php';
    include './components/header.php'; 
    session_start();

    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)) {
        header('location:login.php');
        exit();
    }

    // Handle return book action
    if(isset($_POST['return_book'])){
        $book_id = $_POST['book_id'];
        
        // Get user's regno first
        $get_regno = $conn->prepare("SELECT regno FROM `user_form` WHERE id = ?");
        $get_regno->execute([$user_id]);
        $user_regno = $get_regno->fetchColumn();
        
        // Delete from borrow table to "return" the book
        $delete_borrow = $conn->prepare("DELETE FROM `borrow` WHERE sregno = ? AND bid = ?");
        $delete_borrow->execute([$user_regno, $book_id]);
        
        if($delete_borrow->rowCount() > 0){
            $message[] = 'Book returned successfully!';
        } else {
            $message[] = 'Something went wrong!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Borrowed Books</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-header {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin: 0 0 10px 0;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin: 0;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            background: linear-gradient(45deg, #6c757d, #5a6268);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .back-btn:hover {
            background: linear-gradient(45deg, #5a6268, #495057);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .book-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .book-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #d2691e, #ff7f50);
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .book-image {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            float: left;
            margin-right: 20px;
            margin-bottom: 15px;
        }

        .book-info {
            overflow: hidden;
        }

        .book-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }

        .book-author {
            font-size: 1rem;
            color: #666;
            margin: 0 0 10px 0;
            font-style: italic;
        }

        .book-details {
            margin: 15px 0;
            clear: both;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.95rem;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            color: #333;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            background: linear-gradient(45deg, #ff9800, #f57c00);
            color: white;
        }

        .book-actions {
            margin-top: 20px;
            text-align: center;
        }

        .return-btn {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
        }

        .return-btn:hover {
            background: linear-gradient(45deg, #d32f2f, #b71c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4);
        }

        .no-books {
            text-align: center;
            padding: 60px 20px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .no-books-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-books h3 {
            font-size: 1.5rem;
            color: #666;
            margin: 0 0 10px 0;
        }

        .no-books p {
            color: #999;
            margin: 0;
        }

        .message {
            background: linear-gradient(45deg, #4caf50, #45a049);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .books-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .book-card {
                padding: 20px;
            }
            
            .book-image {
                width: 60px;
                height: 80px;
                margin-right: 15px;
            }
            
            .book-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<?php if(isset($message)): ?>
    <?php foreach($message as $msg): ?>
        <div class="message"><?= htmlspecialchars($msg) ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="container">
    <a href="u-profile.php" class="back-btn">
        ⬅️ Back to Profile
    </a>

    <div class="page-header">
        <h1 class="page-title">My Borrowed Books</h1>
        <p class="page-subtitle">Track your reading journey and manage your borrowed books</p>
    </div>

    <?php
        // Get user's regno
        $get_regno = $conn->prepare("SELECT regno FROM `user_form` WHERE id = ?");
        $get_regno->execute([$user_id]);
        $user_regno = $get_regno->fetchColumn();
        
        // Fetch borrowed books with book details
        $select_borrowed = $conn->prepare("
            SELECT b.*, br.bid as borrowed_book_id, br.sregno
            FROM `borrow` br 
            JOIN `book` b ON br.bid = b.bid 
            WHERE br.sregno = ?
        ");
        $select_borrowed->execute([$user_regno]);
        
        if($select_borrowed->rowCount() > 0):
    ?>
        <div class="books-grid">
            <?php while($fetch_book = $select_borrowed->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="book-card">
                    <?php if($fetch_book['bpic']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($fetch_book['bpic']) ?>" 
                             alt="<?= htmlspecialchars($fetch_book['bname']) ?>" 
                             class="book-image">
                    <?php else: ?>
                        <div class="book-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            📚
                        </div>
                    <?php endif; ?>
                    
                    <div class="book-info">
                        <h3 class="book-title"><?= htmlspecialchars($fetch_book['bname']) ?></h3>
                        <p class="book-author">by <?= htmlspecialchars($fetch_book['writer']) ?></p>
                    </div>

                    <div class="book-details">
                        <div class="detail-item">
                            <span class="detail-label">Category:</span>
                            <span class="detail-value"><?= htmlspecialchars($fetch_book['category']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Rack:</span>
                            <span class="detail-value"><?= htmlspecialchars($fetch_book['rack']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="status-badge">Currently Borrowed</span>
                        </div>
                    </div>

                    <div class="book-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($fetch_book['borrowed_book_id']) ?>">
                            <button type="submit" name="return_book" class="return-btn" 
                                    onclick="return confirm('Are you sure you want to return this book?')">
                                Return Book
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-books">
            <div class="no-books-icon">📚</div>
            <h3>No Books Borrowed</h3>
            <p>You haven't borrowed any books yet. Visit the library to start your reading journey!</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php include './components/footer.php'; ?>