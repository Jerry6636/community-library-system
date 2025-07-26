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
    <title>Smart Library - Enhanced UI</title>
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

        /* Hero Section - Keep existing good design */
        .home {
            color: white;
            text-align: center;
            padding: 80px 20px;
            background-image: 
                linear-gradient(135deg, rgba(106, 17, 203, 0.8), rgba(37, 117, 252, 0.8)),
                url('./images/b.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .home::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(1px);
        }

        .home-text {
            position: relative;
            z-index: 2;
        }

        .home-title {
            font-size: 3.5em;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .home-subtitle {
            font-size: 1.4em;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        /* Enhanced Filter Section */
        .filter-section {
            background: white;
            padding: 40px 20px;
            margin-top: -30px;
            position: relative;
            z-index: 10;
            border-radius: 30px 30px 0 0;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.1);
        }

        .filter-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-title {
            font-size: 2em;
            color: #2d3748;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .filter-subtitle {
            color: #718096;
            font-size: 1.1em;
        }

        /* Enhanced Filter Buttons */
        .post-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 35px;
            padding: 0 20px;
        }

        .filter-item {
            position: relative;
            padding: 14px 28px;
            background: linear-gradient(145deg, #f8fafc, #e2e8f0);
            border: 2px solid transparent;
            border-radius: 25px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            color: #4a5568;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            text-transform: capitalize;
        }

        .filter-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .filter-item:hover::before {
            left: 100%;
        }

        .filter-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 117, 252, 0.2);
            border-color: rgba(37, 117, 252, 0.3);
        }

        .filter-item.active-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            border-color: transparent;
        }

        .filter-item.active-filter:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
        }

        /* Enhanced Search Bar */
        .search-container {
            max-width: 500px;
            margin: 0 auto 40px;
            position: relative;
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            width: 100%;
            padding: 18px 50px 18px 24px;
            border: 2px solid #e2e8f0;
            border-radius: 25px;
            outline: none;
            font-size: 16px;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .search-bar input:focus {
            border-color: #667eea;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .search-bar input::placeholder {
            color: #a0aec0;
        }

        .search-icon {
            position: absolute;
            right: 20px;
            color: #a0aec0;
            font-size: 18px;
            pointer-events: none;
        }

        /* Enhanced Book Cards */
        .post {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin: 0 20px 40px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .post-box {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .post-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .post-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .post-box:hover::before {
            transform: scaleX(1);
        }

        .post-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .post-box:hover .post-img {
            transform: scale(1.05);
        }

        .post-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .category {
            font-size: 0.8em;
            color: #667eea;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .post-title {
            font-size: 1.3em;
            color: #2d3748;
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
            text-decoration: none;
            line-height: 1.3;
            transition: color 0.3s ease;
        }

        .post-title:hover {
            color: #667eea;
        }

        .post-date {
            font-size: 0.85em;
            color: #a0aec0;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .post-description {
            font-size: 0.95em;
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: auto;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .profile {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            background: #f8fafc;
            margin: 0 -20px -20px;
        }

        .profile-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .profile-name {
            font-size: 0.95em;
            color: #2d3748;
            font-weight: 600;
        }

        .empty {
            text-align: center;
            color: #e53e3e;
            font-size: 1.2em;
            margin: 40px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .post-box {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .home-title {
                font-size: 2.5em;
            }
            
            .home-subtitle {
                font-size: 1.2em;
            }
            
            .post {
                grid-template-columns: 1fr;
                margin: 0 15px;
            }
            
            .filter-item {
                padding: 12px 20px;
                font-size: 14px;
            }
            
            .search-bar input {
                padding: 16px 45px 16px 20px;
            }
        }

        @media (max-width: 480px) {
            .home {
                padding: 60px 15px;
            }
            
            .filter-section {
                padding: 30px 15px;
            }
            
            .post-filter {
                gap: 8px;
            }
            
            .filter-item {
                padding: 10px 16px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">COmmunity Library</h2>
            <span class="home-subtitle">Your gateway to knowledge and endless discoveries</span>
        </div>
    </section>

    <!-- Enhanced Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <h2 class="filter-title">Explore Our Collection</h2>
            <p class="filter-subtitle">Find the perfect book for your next adventure</p>
        </div>

        <!-- Filter Buttons -->
        <div class="post-filter container" id="filterBar">
            <span class="filter-item active-filter" data-filter="all">
                <i class="fas fa-th-large" style="margin-right: 8px;"></i>All Books
            </span>
            <?php
                $select_rack = $conn->prepare("SELECT * FROM `rack`");
                $select_rack->execute();
                if($select_rack->rowCount() > 0){
                    while($fetch_rack = $select_rack->fetch(PDO::FETCH_ASSOC)){
                        // Define icons for different categories
                        $category_icons = [
                            'science' => 'fas fa-flask',
                            'maths' => 'fas fa-calculator',
                            'mathematics' => 'fas fa-calculator',
                            'history' => 'fas fa-landmark',
                            'literature' => 'fas fa-book',
                            'technology' => 'fas fa-laptop-code',
                            'programming' => 'fas fa-code',
                            'physics' => 'fas fa-atom',
                            'chemistry' => 'fas fa-vial',
                            'biology' => 'fas fa-leaf',
                            'philosophy' => 'fas fa-brain',
                            'psychology' => 'fas fa-head-side-virus',
                            'economics' => 'fas fa-chart-line',
                            'art' => 'fas fa-palette',
                            'music' => 'fas fa-music',
                            'sports' => 'fas fa-running',
                            'cooking' => 'fas fa-utensils',
                            'travel' => 'fas fa-globe',
                            'health' => 'fas fa-heartbeat',
                            'business' => 'fas fa-briefcase'
                        ];
                        
                        $category_lower = strtolower($fetch_rack['category']);
                        $icon = isset($category_icons[$category_lower]) ? $category_icons[$category_lower] : 'fas fa-book';
            ?>
            <span class="filter-item" data-filter="<?= htmlspecialchars($fetch_rack['category']); ?>">
                <i class="<?= $icon; ?>" style="margin-right: 8px;"></i><?= htmlspecialchars($fetch_rack['category']); ?>
            </span>
            <?php
                    }
                } else {
                    echo '<p class="empty"><i class="fas fa-exclamation-triangle" style="margin-right: 10px;"></i>No categories added yet!</p>';
                }
            ?>
        </div>

        <!-- Enhanced Search Bar -->
        <div class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search by book name, author, or topic...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <!-- Book Cards -->
    <div class="post container" id="postContainer" style="margin-top: 15px" >
        <?php
            $select_books = $conn->prepare("SELECT * FROM `book` WHERE `status` = 'Available'");
            $select_books->execute();
            if($select_books->rowCount() > 0){
                while($fetch_books = $select_books->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="post-box <?= htmlspecialchars($fetch_books['category']); ?>" data-title="<?= strtolower($fetch_books['bname']); ?>" data-writer="<?= strtolower($fetch_books['writer']); ?>">
            <img src="data:image/jpeg;base64,<?= base64_encode($fetch_books['bpic']); ?>" class="post-img" alt="<?= htmlspecialchars($fetch_books['bname']); ?>" />
            <div class="post-content">
                <h2 class="category"><?= htmlspecialchars($fetch_books['category']); ?></h2>
                <!-- <a href="#" class="post-title"><?= htmlspecialchars($fetch_books['bname']); ?></a> -->
                 <a href="book-details.php?bid=<?= $fetch_books['bid']; ?>" class="post-title"><?= htmlspecialchars($fetch_books['bname']); ?></a>
                <span class="post-date">Book ID: <?= htmlspecialchars($fetch_books['bid']); ?></span>
                <p class="post-description"><?= htmlspecialchars($fetch_books['discription']); ?></p>
            </div>
            <div class="profile">
                <img src="./images/pro.jpg" alt="<?= htmlspecialchars($fetch_books['writer']); ?>" class="profile-img">
                <span class="profile-name"><?= htmlspecialchars($fetch_books['writer']); ?></span>
            </div>
        </div>
        <?php
                }
            } else {
                echo '<p class="empty"><i class="fas fa-book-open" style="margin-right: 10px;"></i>No books added yet!</p>';
            }
        ?>
    </div>

    <!-- Enhanced Filter & Search Script -->
    <script>
        // Enhanced Category Filter with animations
        document.querySelectorAll('.filter-item').forEach((btn, index) => {
            // Stagger animation for filter buttons
            btn.style.animationDelay = `${index * 0.1}s`;
            
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-item').forEach(b => {
                    b.classList.remove('active-filter');
                });
                
                // Add active class to clicked button
                btn.classList.add('active-filter');
                
                const filter = btn.getAttribute('data-filter').toLowerCase();

                // Filter posts with animation
                document.querySelectorAll('.post-box').forEach((card, cardIndex) => {
                    const match = filter === 'all' || card.classList.contains(filter);
                    
                    if (match) {
                        card.style.display = 'block';
                        card.style.animationDelay = `${cardIndex * 0.1}s`;
                        card.style.animation = 'none';
                        card.offsetHeight; // Trigger reflow
                        card.style.animation = 'fadeInUp 0.6s ease-out both';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Clear search when filtering
                document.getElementById('searchInput').value = '';
            });
        });

        // Enhanced Search with debouncing
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const search = this.value.toLowerCase();
            
            searchTimeout = setTimeout(() => {
                let visibleCount = 0;
                
                document.querySelectorAll('.post-box').forEach((card, index) => {
                    const title = card.getAttribute('data-title');
                    const writer = card.getAttribute('data-writer');
                    const matches = title.includes(search) || writer.includes(search);
                    
                    if (matches) {
                        card.style.display = 'block';
                        card.style.animationDelay = `${visibleCount * 0.05}s`;
                        card.style.animation = 'none';
                        card.offsetHeight; // Trigger reflow
                        card.style.animation = 'fadeInUp 0.4s ease-out both';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Remove active filter when searching
                if (search.length > 0) {
                    document.querySelectorAll('.filter-item').forEach(b => {
                        b.classList.remove('active-filter');
                    });
                }
            }, 200);
        });

        // Add some interactive effects
        document.querySelectorAll('.post-box').forEach(box => {
            box.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            box.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Smooth scroll behavior for better UX
        document.querySelectorAll('.filter-item').forEach(item => {
            item.addEventListener('click', () => {
                document.getElementById('postContainer').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>
</body>
</html>

<?php 
    include './components/footer.php'; 
?>