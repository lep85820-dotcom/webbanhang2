<?php include 'app/views/shares/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <?php if ($product->image): ?>
            <img src="/webbanhang/<?php echo $product->image; ?>" class="img-fluid rounded shadow" alt="Product Image">
        <?php else: ?>
            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                <i class="fas fa-image fa-5x text-muted"></i>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h1><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="text-muted"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
        <h3 class="text-danger"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</h3>
        <hr>
        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
        </a>
        <a href="/webbanhang/Product/list" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
