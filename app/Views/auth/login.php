<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Invoice App</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background elements */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background-color: rgba(227, 51, 32, 0.03);
            top: -100px;
            right: -100px;
            z-index: 1;
        }

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background-color: rgba(227, 51, 32, 0.02);
            bottom: -50px;
            left: -50px;
            z-index: 1;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background-color: var(--primary);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 40px 32px;
            z-index: 2;
            position: relative;
        }

        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .login-logo .logo-box {
            width: 96px;
            height: 96px;
            border-radius: 18px;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .login-logo .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        @media (max-width: 480px) {
            .login-logo .logo-box {
                width: 80px;
                height: 80px;
                border-radius: 16px;
            }
        }

        .login-logo .logo-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .login-logo .logo-title span {
            color: var(--secondary);
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-logo">
        <div class="logo-box">
            <img src="<?= base_url('image/logo.webp') ?>" alt="Bhinneka Transport">
        </div>
    </div>
    
    <div class="login-header">
        <h2>Selamat Datang</h2>
        <p>Silakan masuk ke Dashboard Halaman Admin</p>
    </div>

    <!-- Session Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" style="padding: 10px; margin-bottom: 16px;">
            <i class="fa-solid fa-circle-check"></i>
            <div style="font-size: 0.8rem;"><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" style="padding: 10px; margin-bottom: 16px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div style="font-size: 0.8rem;"><?= session()->getFlashdata('error') ?></div>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <div style="position: relative;">
                <i class="fa-regular fa-user" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="text" name="username" id="username" class="form-control" style="padding-left: 40px;" placeholder="Masukkan username" value="<?= old('username') ?>" required autocomplete="username" autofocus>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div style="position: relative;">
                <i class="fa-solid fa-lock" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="password" name="password" id="password" class="form-control" style="padding-left: 40px;" placeholder="Masukkan password" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary login-btn">
            Masuk <i class="fa-solid fa-right-to-bracket"></i>
        </button>
    </form>
</div>

</body>
</html>
