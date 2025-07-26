<?php 
    include './components/db-connect.php';
    include './components/header.php'; 
    session_start();

    // Get book ID from URL
    $book_id = isset($_GET['bid']) ? $_GET['bid'] : '';

    if (!$book_id) {
        header('location:index.php');
        exit();
    }

    // Fetch book details
    $select_book = $conn->prepare("SELECT * FROM `book` WHERE bid = ?");
    $select_book->execute([$book_id]);

    if($select_book->rowCount() == 0) {
        header('location:index.php');
        exit();
    }

    $book = $select_book->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['bname']) ?> - Community Library</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            background: linear-gradient(45deg, #6c757d, #5a6268);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .back-btn:hover {
            background: linear-gradient(45deg, #5a6268, #495057);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        .book-details-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .book-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .book-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .book-header-content {
            position: relative;
            z-index: 2;
        }

        .book-image-large {
            width: 200px;
            height: 280px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .book-title-large {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .book-author-large {
            font-size: 1.3rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .book-content {
            padding: 40px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .detail-section {
            background: #f8fafc;
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #667eea;
        }

        .detail-section h3 {
            color: #2d3748;
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 1rem;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
        }

        .detail-value {
            color: #2d3748;
            font-weight: 500;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-available {
            background: linear-gradient(45deg, #48bb78, #38a169);
            color: white;
        }

        .status-borrowed {
            background: linear-gradient(45deg, #ed8936, #dd6b20);
            color: white;
        }

        .description-section {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            padding: 30px;
            margin-top: 20px;
        }

        .description-title {
            color: #2d3748;
            font-size: 1.4rem;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-text {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: justify;
        }

        .related-books {
            margin-top: 40px;
        }

        .related-title {
            color: #2d3748;
            font-size: 1.8rem;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .related-book {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .related-book:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .related-book-img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .related-book-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .related-book-author {
            font-size: 0.9rem;
            color: #718096;
        }

        .icon {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .book-header {
                padding: 30px 20px;
            }

            .book-title-large {
                font-size: 2rem;
            }

            .book-author-large {
                font-size: 1.1rem;
            }

            .book-image-large {
                width: 150px;
                height: 210px;
            }

            .book-content {
                padding: 25px 20px;
            }

            .details-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .detail-section {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .book-title-large {
                font-size: 1.5rem;
            }

            .details-grid {
                gap: 15px;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Library
        </a>

        <div class="book-details-container">
            <div class="book-header">
                <div class="book-header-content">
                    <img src="data:image/jpeg;base64,<?= base64_encode($book['bpic']) ?>" 
                         alt="<?= htmlspecialchars($book['bname']) ?>" 
                         class="book-image-large">
                    <h1 class="book-title-large"><?= htmlspecialchars($book['bname']) ?></h1>
                    <p class="book-author-large">by <?= htmlspecialchars($book['writer']) ?></p>
                </div>
            </div>

            <div class="book-content">
                <div class="details-grid">
                    <div class="detail-section">
                        <h3><i class="fas fa-info-circle icon"></i>Book Information</h3>
                        <div class="detail-item">
                            <span class="detail-label">Book ID:</span>
                            <span class="detail-value"><?= htmlspecialchars($book['bid']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Category:</span>
                            <span class="detail-value"><?= htmlspecialchars($book['category']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Author:</span>
                            <span class="detail-value"><?= htmlspecialchars($book['writer']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="status-badge status-<?= strtolower($book['status']) ?>">
                                <?= htmlspecialchars($book['status']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3><i class="fas fa-map-marker-alt icon"></i>Location & Availability</h3>
                        <div class="detail-item">
                            <span class="detail-label">Rack Location:</span>
                            <span class="detail-value"><?= htmlspecialchars($book['rack']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Availability:</span>
                            <span class="detail-value">
                                <?php if($book['status'] == 'Available'): ?>
                                    <i class="fas fa-check-circle" style="color: #48bb78; margin-right: 5px;"></i>
                                    Ready to borrow
                                <?php else: ?>
                                    <i class="fas fa-times-circle" style="color: #f56565; margin-right: 5px;"></i>
                                    Currently borrowed
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="description-section">
                    <h3 class="description-title">
                        <i class="fas fa-book-open icon"></i>
                        About This Book
                    </h3>
                    <p class="description-text">
                        <?= nl2br(htmlspecialchars($book['discription'])) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Books Section -->
        <div class="related-books">
            <h2 class="related-title">Related Books in <?= htmlspecialchars($book['category']) ?></h2>
            <div class="related-grid">
                <?php
                    // Fetch related books from same category
                    $select_related = $conn->prepare("SELECT * FROM `book` WHERE category = ? AND bid != ? AND status = 'Available' LIMIT 4");
                    $select_related->execute([$book['category'], $book['bid']]);
                    
                    if($select_related->rowCount() > 0):
                        while($related = $select_related->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <a href="book-details.php?bid=<?= $related['bid'] ?>" class="related-book">
                        <img src="data:image/jpeg;base64,<?= base64_encode($related['bpic']) ?>" 
                             alt="<?= htmlspecialchars($related['bname']) ?>" 
                             class="related-book-img">
                        <div class="related-book-title"><?= htmlspecialchars($related['bname']) ?></div>
                        <div class="related-book-author">by <?= htmlspecialchars($related['writer']) ?></div>
                    </a>
                <?php 
                        endwhile;
                    else:
                ?>
                    <p style="text-align: center; color: #718096; grid-column: 1 / -1;">
                        <i class="fas fa-book" style="margin-right: 10px;"></i>
                        No other books found in this category.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php include './components/footer.php'; ?>