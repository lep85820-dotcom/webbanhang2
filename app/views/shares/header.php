<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng - PHP MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
            font-weight: 600;
        }
        .nav-link:hover {
            color: #e0e0e0 !important;
        }
        .badge-cart {
            background-color: #ff6b6b;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            position: relative;
            top: -8px;
        }
        .container {
            max-width: 1200px;
            padding: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        }
        .card {
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/webbanhang/Product/list">
                <i class="fas fa-store"></i> Web Bán Hàng
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/list">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </li>
                    <?php if(SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/add">
                            <i class="fas fa-plus-circle"></i> Thêm sản phẩm
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/cart">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng
                            <?php
                            $cartCount = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    $cartCount += $item['quantity'];
                                }
                            }
                            if ($cartCount > 0):
                            ?>
                                <span class="badge badge-cart"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php if(SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item">
                            <span class="nav-link">
                                <?php 
                                $provider = $_SESSION['provider'] ?? 'local';
                                if ($provider === 'google') {
                                    echo '<i class="fab fa-google text-danger"></i>';
                                } elseif ($provider === 'github') {
                                    echo '<i class="fab fa-github"></i>';
                                } else {
                                    echo '<i class="fas fa-user"></i>';
                                }
                                ?>
                                <?php echo $_SESSION['username']; ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webbanhang/account/logout">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/webbanhang/account/login">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
