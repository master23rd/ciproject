<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CI Phone Store</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-box {
            width: 100%;
            max-width: 420px;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.25);
            overflow: hidden;
            background: #fff;
        }
        
        .card-header {
            background: transparent;
            border-bottom: none;
            text-align: center;
            padding: 40px 30px 20px;
        }
        
        .login-logo {
            font-size: 2.8rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        
        .login-logo i {
            color: #667eea;
            margin-right: 10px;
        }
        
        .card-header p {
            color: #666;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .card-body {
            padding: 20px 40px 30px;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .input-group {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-right: none;
            color: #667eea;
            padding: 12px 15px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-left: none;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #667eea;
        }
        
        .form-check {
            padding-left: 1.8em;
        }
        
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.2em;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-label {
            color: #555;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .card-footer {
            background: #f8f9fa;
            border-top: 1px solid #eee;
            padding: 20px;
        }
        
        .card-footer a {
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .card-footer a:hover {
            color: #764ba2;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: #fff5f5;
            color: #c53030;
        }
        
        .alert-success {
            background: #f0fff4;
            color: #276749;
        }
        
        /* Floating animation for logo */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .login-logo i {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="card">
            <div class="card-header">
                <div class="login-logo">
                    <i class="bi bi-phone-fill"></i>Admin
                </div>
                <p>Sign in to your admin panel</p>
				 <!-- Demo Credentials -->
				<div class="alert alert-info mb-3">
					<small>
						<strong><i class="fas fa-info-circle me-1"></i>Demo:</strong>
						admin / admin123
					</small>
				</div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/do_login') ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label">Email or Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="Enter your email or username" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <!-- <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div> -->
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="<?= base_url() ?>" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Back to Store
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
