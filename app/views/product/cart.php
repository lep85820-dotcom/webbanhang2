<?php include 'app/views/shares/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-shopping-cart"></i> Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart as $id => $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <?php if ($item['image']): ?>
                                <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 80px; border-radius: 8px;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 8px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <strong><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        </td>
                        <td class="align-middle">
                            <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                        </td>
                        <td class="align-middle">
                            <form method="POST" action="/webbanhang/Product/updateCart" class="d-flex align-items-center" style="max-width: 150px;">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="align-middle">
                            <strong class="text-danger"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</strong>
                        </td>
                        <td class="align-middle">
                            <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-warning">
                    <td colspan="4" class="text-end"><strong class="fs-5">Tổng cộng:</strong></td>
                    <td colspan="2"><strong class="text-danger fs-5"><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="/webbanhang/Product/list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
        </a>
        <a href="/webbanhang/Product/checkout" class="btn btn-primary btn-lg">
            <i class="fas fa-credit-card"></i> Thanh Toán
        </a>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
        <h3 class="text-muted">Giỏ hàng của bạn đang trống</h3>
        <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
        <a href="/webbanhang/Product/list" class="btn btn-primary mt-3">
            <i class="fas fa-store"></i> Xem sản phẩm
        </a>
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
