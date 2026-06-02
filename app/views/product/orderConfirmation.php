<?php include 'app/views/shares/header.php'; ?>

<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-check-circle fa-5x text-success"></i>
    </div>
    <h1 class="text-success mb-3">Đặt hàng thành công!</h1>
    <?php if (isset($_SESSION['momo_success'])): ?>
        <div class="alert alert-success mx-auto col-md-6 mb-4 shadow-sm border-2">
            <i class="fas fa-check-double me-2"></i> <?php echo $_SESSION['momo_success']; unset($_SESSION['momo_success']); ?>
        </div>
    <?php endif; ?>
    <p class="lead text-muted">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
    <p class="text-muted">Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>
    <hr class="my-4">
    <a href="/webbanhang/Product/list" class="btn btn-primary btn-lg">
        <i class="fas fa-store"></i> Tiếp tục mua sắm
    </a>
</div>

<?php include 'app/views/shares/footer.php'; ?>
