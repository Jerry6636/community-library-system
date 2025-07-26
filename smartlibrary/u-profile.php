<?php
include './components/db-connect.php';
include './components/header.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

// Update logic
$update_success = '';
$update_error = '';

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Get user
    $stmt = $conn->prepare("SELECT * FROM user_form WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check old password
        if ($old_pass === $user['password']) {
            if ($new_pass === $confirm_pass) {
                // Update
                $stmt = $conn->prepare("UPDATE user_form SET name=?, contact=?, email=?, gender=?, password=? WHERE id=?");
                $stmt->execute([$name, $contact, $email, $gender, $new_pass, $user_id]);
                $update_success = "Profile updated successfully!";
            } else {
                $update_error = "New passwords do not match.";
            }
        } else {
            $update_error = "Old password is incorrect.";
        }
    }
}

// Fetch profile
$stmt = $conn->prepare("SELECT * FROM user_form WHERE id = ?");
$stmt->execute([$user_id]);
$fetch_profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    header, footer {
        flex-shrink: 0;
    }

    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .profile-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        width: 100%;
        max-width: 520px;
        position: relative;
        overflow: hidden;
        animation: slideUp 0.8s ease-out;
    }

    .profile-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    .profile-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        position: relative;
    }

    .profile-avatar::before {
        content: '👤';
        font-size: 2rem;
        color: white;
    }

    .profile-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .profile-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeIn 0.5s ease-out;
    }

    .alert-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .alert-error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-grid {
        display: grid;
        gap: 1.5rem;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 500;
        background: #fafafa;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #1f2937;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 
            0 0 0 4px rgba(102, 126, 234, 0.1),
            0 10px 25px -5px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .form-input[readonly] {
        background: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
        border-color: #d1d5db;
    }

    .password-section {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        padding: 1.5rem;
        border-radius: 20px;
        margin-top: 1rem;
        border: 1px solid #e2e8f0;
    }

    .password-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .password-title::before {
        content: '🔐';
        font-size: 1.25rem;
    }

    .submit-btn {
        width: 100%;
        padding: 1.25rem 2rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: 2rem;
        position: relative;
        overflow: hidden;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 20px 25px -5px rgba(102, 126, 234, 0.3),
            0 10px 10px -5px rgba(102, 126, 234, 0.2);
    }

    .submit-btn:active {
        transform: translateY(-1px);
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .loading-spinner {
        display: none;
        position: absolute;
        top: 50%;
        right: 1.5rem;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }

    @media (max-width: 640px) {
        .profile-container {
            padding: 2rem 1.5rem;
            border-radius: 20px;
            margin: 1rem;
        }
        
        .profile-title {
            font-size: 1.5rem;
        }
        
        .form-input, .form-select {
            padding: 0.875rem 1rem;
        }
        
        .submit-btn {
            padding: 1rem 1.5rem;
        }
    }

    .icon-input {
        position: relative;
    }

    .icon-input::before {
        content: attr(data-icon);
        position: absolute;
        left: 1rem;
        top: 60%;
        transform: translateY(-30%);
        font-size: 1.25rem;
        color: #9ca3af;
        z-index: 1;
        pointer-events: none;
    }

    .icon-input .form-input {
        padding-left: 3rem;
    }
</style>

<div class="main-content">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar"></div>
            <h1 class="profile-title">Update Profile</h1>
            <p class="profile-subtitle">Keep your information up to date</p>
        </div>

        <?php if ($update_success): ?>
            <div class="alert alert-success">
                <span>✅</span>
                <span><?= $update_success ?></span>
            </div>
        <?php elseif ($update_error): ?>
            <div class="alert alert-error">
                <span>❌</span>
                <span><?= $update_error ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="showLoading()">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Registration Number</label>
                    <input type="text" class="form-input" value="<?= htmlspecialchars($fetch_profile['regno']) ?>" readonly>
                </div>

                <div class="form-group icon-input" data-icon="👤">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($fetch_profile['name']) ?>" required>
                </div>

                <div class="form-group icon-input" data-icon="📞">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" name="contact" class="form-input" value="<?= htmlspecialchars($fetch_profile['contact']) ?>" required>
                </div>

                <div class="form-group icon-input" data-icon="📧">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($fetch_profile['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" <?= $fetch_profile['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $fetch_profile['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $fetch_profile['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>

            <div class="password-section">
                <div class="password-title">Change Password</div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="old_pass" class="form-input" required maxlength="20" placeholder="Enter current password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_pass" class="form-input" required maxlength="20" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_pass" class="form-input" required maxlength="20" placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <button type="submit" name="update" class="submit-btn">
                <span class="loading-spinner" id="loadingSpinner"></span>
                Update Profile
            </button>
        </form>
    </div>
</div>

<script>
function showLoading() {
    document.getElementById('loadingSpinner').style.display = 'block';
}

// Add smooth form validation feedback
document.querySelectorAll('.form-input, .form-select').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.checkValidity()) {
            this.style.borderColor = '#10b981';
        } else {
            this.style.borderColor = '#ef4444';
        }
    });
    
    input.addEventListener('input', function() {
        this.style.borderColor = '#e5e7eb';
    });
});

// Password strength indicator (optional enhancement)
const newPassInput = document.querySelector('input[name="new_pass"]');
const confirmPassInput = document.querySelector('input[name="confirm_pass"]');

confirmPassInput.addEventListener('input', function() {
    const newPass = newPassInput.value;
    const confirmPass = this.value;
    
    if (confirmPass && newPass !== confirmPass) {
        this.style.borderColor = '#ef4444';
    } else if (confirmPass && newPass === confirmPass) {
        this.style.borderColor = '#10b981';
    } else {
        this.style.borderColor = '#e5e7eb';
    }
});
</script>

<?php include './components/footer.php'; ?>