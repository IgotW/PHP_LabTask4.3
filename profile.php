<?php
session_start();

// Check GET parameter
if (!isset($_GET['view']) || $_GET['view'] !== 'details') {
    header("Location: register.php");
    exit();
}

// Get user from SESSION
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile - Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  * {
    box-sizing: border-box;
  }

  body { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    min-height: 100vh; 
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    margin: 0;
    padding: 20px;
    position: relative;
    overflow-x: hidden;
  }

  /* Animated background elements */
  body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
      radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
      radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
      radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
    animation: float 20s ease-in-out infinite;
    z-index: -1;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(1deg); }
    66% { transform: translateY(10px) rotate(-1deg); }
  }

  .profile-container {
    position: relative;
    width: 100%;
    max-width: 500px;
  }

  .profile-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    box-shadow: 
      0 8px 32px 0 rgba(31, 38, 135, 0.37),
      0 0 0 1px rgba(255, 255, 255, 0.1);
    position: relative;
    transform: translateY(20px);
    opacity: 0;
    animation: slideUp 0.8s ease-out forwards;
  }

  @keyframes slideUp {
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  }

  .profile-header {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
  }

  .profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    position: relative;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }

  .profile-avatar i {
    font-size: 3rem;
    color: white;
  }

  .profile-avatar::after {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb);
    z-index: -1;
    animation: rotate 3s linear infinite;
  }

  @keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .profile-title {
    color: #2d3748;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .profile-subtitle {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
  }

  .profile-details {
    margin-bottom: 2rem;
  }

  .detail-item {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
  }

  .detail-item:nth-child(1) { animation-delay: 0.2s; }
  .detail-item:nth-child(2) { animation-delay: 0.3s; }
  .detail-item:nth-child(3) { animation-delay: 0.4s; }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .detail-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    background: rgba(255, 255, 255, 0.8);
  }

  .detail-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
  }

  .detail-content {
    flex: 1;
  }

  .detail-label {
    font-size: 0.875rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 0.25rem;
  }

  .detail-value {
    font-size: 1.1rem;
    color: #2d3748;
    font-weight: 600;
    margin: 0;
  }

  .registration-date-section {
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out forwards;
    animation-delay: 0.5s;
    opacity: 0;
    transform: translateY(20px);
  }

  .registration-date-title {
    text-align: center;
    color: #4a5568;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .registration-date-title i {
    color: #667eea;
    font-size: 0.875rem;
  }

  .profile-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }

  .stat-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    padding: 1rem 0.75rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .stat-item:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.6);
  }

  .stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.25rem;
  }

  .stat-label {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
  }

  .profile-actions {
    display: flex;
    gap: 1rem;
    animation: fadeInUp 0.6s ease-out forwards;
    animation-delay: 0.6s;
    opacity: 0;
    transform: translateY(20px);
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 16px;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.875rem 1.5rem;
    flex: 1;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-secondary-custom {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    color: #4a5568;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.875rem 1.5rem;
    flex: 1;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
  }

  .btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .btn-primary-custom:hover::before {
    left: 100%;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    text-decoration: none;
    color: white;
  }

  .btn-secondary-custom:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.95);
    border-color: rgba(102, 126, 234, 0.5);
    text-decoration: none;
    color: #667eea;
  }

  .btn-primary-custom:active,
  .btn-secondary-custom:active {
    transform: translateY(0);
  }

  /* Status badge */
  .status-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: rgba(72, 187, 120, 0.1);
    border: 2px solid rgba(72, 187, 120, 0.3);
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #2f855a;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: fadeInUp 0.6s ease-out forwards;
    animation-delay: 0.1s;
    opacity: 0;
    transform: translateY(20px);
  }

  .status-indicator {
    width: 8px;
    height: 8px;
    background: #48bb78;
    border-radius: 50%;
    animation: pulse-dot 2s ease-in-out infinite;
  }

  @keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }

  /* Responsive design */
  @media (max-width: 576px) {
    body {
      padding: 15px;
    }
    
    .profile-card {
      padding: 2rem 1.5rem;
    }
    
    .profile-title {
      font-size: 1.75rem;
    }

    .profile-actions {
      flex-direction: column;
    }

    .profile-stats {
      grid-template-columns: 1fr;
      gap: 0.75rem;
    }

    .stat-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      text-align: left;
      padding: 1rem;
    }
  }

  /* Focus indicators for accessibility */
  .btn-primary-custom:focus-visible,
  .btn-secondary-custom:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
  }
</style>
</head>
<body>
  <div class="profile-container">
    <div class="profile-card shadow-lg">
      <div class="status-badge">
        <span class="status-indicator"></span>
        Active Profile
      </div>

      <div class="profile-header">
        <div class="profile-avatar">
          <i class="fas fa-user"></i>
        </div>
        <h2 class="profile-title">Welcome Back!</h2>
        <p class="profile-subtitle">Your profile information</p>
      </div>

      <div class="registration-date-section">
        <h5 class="registration-date-title">
          <i class="fas fa-calendar-check"></i>
          Registered on
        </h5>
        <div class="profile-stats">
          <div class="stat-item">
            <div class="stat-number"><?= date('d') ?></div>
            <div class="stat-label">Day</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?= date('m') ?></div>
            <div class="stat-label">Month</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?= date('Y') ?></div>
            <div class="stat-label">Year</div>
          </div>
        </div>
      </div>

      <div class="profile-details">
        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-user"></i>
          </div>
          <div class="detail-content">
            <div class="detail-label">Full Name</div>
            <div class="detail-value"><?= htmlspecialchars($user['name']); ?></div>
          </div>
        </div>

        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-birthday-cake"></i>
          </div>
          <div class="detail-content">
            <div class="detail-label">Age</div>
            <div class="detail-value"><?= htmlspecialchars($user['age']); ?> years old</div>
          </div>
        </div>

        <div class="detail-item">
          <div class="detail-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="detail-content">
            <div class="detail-label">Email Address</div>
            <div class="detail-value"><?= htmlspecialchars($user['email']); ?></div>
          </div>
        </div>
      </div>

      <div class="profile-actions">
        <a href="register.php" class="btn-secondary-custom">
          <i class="fas fa-arrow-left"></i>
          Back
        </a>
        <a href="register.php" class="btn-primary-custom">
          <i class="fas fa-user-plus"></i>
          Register Again
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>