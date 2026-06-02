<?php include 'app/views/shares/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-list"></i> Danh sách sản phẩm</h1>
<?php if (SessionHelper::isAdmin()): ?>
<a href="/webbanhang/Product/add" class="btn btn-success mb-3">
    <i class="fas fa-plus"></i> Thêm sản phẩm mới
</a>
<?php endif; ?>

<?php if (!empty($products)): ?>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text text-muted">
                        <?php echo htmlspecialchars(substr($product->description, 0, 100), ENT_QUOTES, 'UTF-8'); ?>...
                    </p>
                    <p class="card-text">
                        <strong class="text-danger fs-5">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                        </strong>
                    </p>
                    <?php if (isset($product->category_name)): ?>
                        <span class="badge bg-info"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between">
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                        <?php if (SessionHelper::isAdmin()): ?>
                        <div>
                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Chưa có sản phẩm nào. Hãy thêm sản phẩm mới!
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
