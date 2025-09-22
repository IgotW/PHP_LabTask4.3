<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modern Registration</title>
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

  .registration-container {
    position: relative;
    width: 100%;
    max-width: 450px;
  }

  .card {
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

  .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  }

  .form-title {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
  }

  .form-title h2 {
    color: #2d3748;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .form-title p {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
  }

  .form-group {
    margin-bottom: 1.5rem;
    position: relative;
  }

  .form-label {
    color: #4a5568;
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-label i {
    font-size: 0.875rem;
    color: #667eea;
  }

  .form-control {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
  }

  .form-control:focus {
    background: rgba(255, 255, 255, 0.95);
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    outline: none;
    transform: translateY(-2px);
  }

  .form-control:hover:not(:focus) {
    border-color: rgba(102, 126, 234, 0.5);
    transform: translateY(-1px);
  }

  .form-control.is-invalid {
    border-color: #e53e3e;
    animation: shake 0.5s ease-in-out;
  }

  @keyframes shake {
    0%, 20%, 40%, 60%, 80% { transform: translateX(0); }
    10%, 30%, 50%, 70% { transform: translateX(-5px); }
  }

  .invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #e53e3e;
    font-weight: 500;
  }

  .btn-register {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 16px;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    padding: 1rem 2rem;
    width: 100%;
    margin-top: 1rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }

  .btn-register::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .btn-register:hover::before {
    left: 100%;
  }

  .btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
  }

  .btn-register:active {
    transform: translateY(0);
  }

  .btn-register:disabled {
    background: #cbd5e0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }



  /* Responsive design */
  @media (max-width: 576px) {
    body {
      padding: 15px;
    }
    
    .card {
      padding: 2rem 1.5rem;
    }
    
    .form-title h2 {
      font-size: 1.75rem;
    }
  }

  /* Focus indicators for accessibility */
  .form-control:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
  }

  .btn-register:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
  }

  /* Input validation states */
  .form-control.is-valid {
    border-color: #48bb78;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2348bb78' d='m2.3 6.73.4-.4L4.1 7.7l3.1-3.1.4.4L4.1 8.6z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px;
    padding-right: 3rem;
  }

  /* Micro-interactions */
  .form-group {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
  }

  .form-group:nth-child(1) { animation-delay: 0.1s; }
  .form-group:nth-child(2) { animation-delay: 0.2s; }
  .form-group:nth-child(3) { animation-delay: 0.3s; }
  .form-group:nth-child(4) { animation-delay: 0.4s; }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
</head>
<body>
  <div class="registration-container">
    <div class="card shadow-lg">
      <div class="form-title">
        <h2>Create Account</h2>
        <p>Join us today and get started</p>
      </div>
      <form method="post" action="register_process.php" class="needs-validation" novalidate>
        <div class="form-group">
          <label for="name" class="form-label">
            <i class="fas fa-user"></i>
            Full Name
          </label>
          <input type="text" name="name" id="name" class="form-control" required 
                 placeholder="Enter your full name">
          <div class="invalid-feedback">Please enter your full name.</div>
        </div>

        <div class="form-group">
          <label for="age" class="form-label">
            <i class="fas fa-birthday-cake"></i>
            Age
          </label>
          <input type="number" name="age" id="age" class="form-control" min="1" max="120" required
                 placeholder="Enter your age">
          <div class="invalid-feedback">Please enter a valid age (1-120).</div>
        </div>

        <div class="form-group">
          <label for="email" class="form-label">
            <i class="fas fa-envelope"></i>
            Email Address
          </label>
          <input type="email" name="email" id="email" class="form-control" required
                 placeholder="Enter your email address">
          <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <button type="submit" class="btn btn-register">
          Create Account
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (() => {
      'use strict';
      
      // Bootstrap form validation
      const forms = document.querySelectorAll('.needs-validation');
      
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Add shake animation to invalid fields
            const invalidFields = form.querySelectorAll(':invalid');
            invalidFields.forEach(field => {
              field.classList.add('is-invalid');
              field.addEventListener('animationend', () => {
                field.classList.remove('is-invalid');
              }, { once: true });
            });
          }
          
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>
</html>
