<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Library</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Modern Footer Styles */
        footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 0 20px;
            margin-top: auto;
            position: relative;
            clear: both;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }

        .sec {
            flex: 1;
            min-width: 250px;
            margin-bottom: 20px;
        }

        .sec h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #ffffff;
            font-weight: 600;
            border-bottom: 2px solid #ffd93d;
            padding-bottom: 8px;
            display: inline-block;
        }

        .aboutus p {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            font-size: 1rem;
            text-align: justify;
        }

        .quicklinks ul {
            list-style: none;
        }

        .quicklinks ul li {
            margin-bottom: 12px;
            transform: translateX(0);
            transition: all 0.3s ease;
        }

        .quicklinks ul li:hover {
            transform: translateX(10px);
        }

        .quicklinks ul li a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 8px 0;
        }

        .quicklinks ul li a:hover {
            color: #ffd93d;
        }

        .quicklinks ul li a::before {
            content: '→';
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .quicklinks ul li a:hover::before {
            margin-right: 15px;
            color: #ff6b6b;
        }

        .contactBx .info {
            list-style: none;
        }

        .contactBx .info li {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px 0;
        }

        .contactBx .info li span:first-child {
            margin-right: 10px;
            width: 25px;
        }

        .contactBx .info li i {
            font-size: 1.2rem;
            color: #ffd93d;
        }

        .contactBx .info li span:last-child,
        .contactBx .info li p {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .contactBx .info li a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contactBx .info li a:hover {
            color: #ffd93d;
        }

        /* Footer Bottom Section */
        .footer-bottom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .current-date {
            color: #ffd93d;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .sec {
                min-width: 100%;
                margin-bottom: 25px;
            }

            footer {
                padding: 30px 0 15px;
            }
        }

        @media (max-width: 480px) {
            .footer-container {
                padding: 0 15px;
            }
            
            .sec h2 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Your page content goes here -->

    <footer>
        <div class="footer-container">
            <div class="sec aboutus">
                <h2>About Us</h2>
                <p>Explore, Learn, Connect. Come browse our extensive collection of 
                    books, magazines, and audiobooks. We offer engaging events, programs,
                     and resources for all ages. Whether you're seeking knowledge,
                      a quiet space to study, or a fun family activity,
                     your journey begins at Smart Library.</p>
            </div>
            
            <div class="sec quicklinks">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            
            <div class="sec contactBx">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class='bx bxs-map'></i></span>
                        <span>Greenwich<br>SE10 0EW<br>London, UK</span>
                    </li>
                    <li>
                        <span><i class='bx bx-envelope'></i></span>
                        <p><a href="mailto:arbindkumar.singh@rave.ac.uk">arbindkumar.singh@rave.ac.uk</a></p>
                    </li>
                    <li>
                        <span><i class='bx bx-user'></i></span>
                        <p>Arbind Kumar Singh</p>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Smart Library. All rights reserved.</p>
            <div class="current-date">
                <i class='bx bx-calendar'></i>
                Today: <?php echo date('l, F j, Y'); ?>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./css-js/main.js"></script>
</body>
</html>