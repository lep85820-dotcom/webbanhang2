<?php include 'app/views/shares/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-credit-card"></i> Thanh toán</h1>

<div class="row">
    <div class="col-md-7">
        <div class="card p-4 mb-4">
            <h4 class="mb-3"><i class="fas fa-user"></i> Thông tin giao hàng</h4>
            <form method="POST" action="/webbanhang/Product/processCheckout">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required
                           placeholder="Nhập họ tên người nhận">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" id="phone" name="phone" class="form-control" required
                           placeholder="Nhập số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="3" required
                              placeholder="Nhập địa chỉ giao hàng chi tiết"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block fw-bold"><i class="fas fa-wallet text-primary"></i> Phương thức thanh toán <span class="text-danger">*</span></label>
                    <div class="payment-methods row g-3">
                        <div class="col-md-6">
                            <label class="payment-method-card d-block p-3 border rounded cursor-pointer text-center bg-white shadow-sm position-relative">
                                <input type="radio" name="payment_method" value="cod" checked class="position-absolute" style="top: 15px; left: 15px; width: 18px; height: 18px;">
                                <div class="payment-method-icon mb-2">
                                    <i class="fas fa-truck fa-2x text-secondary"></i>
                                </div>
                                <span class="d-block fw-bold text-dark">Nhận hàng thanh toán (COD)</span>
                                <small class="text-muted d-block mt-1">Thanh toán bằng tiền mặt khi nhận hàng</small>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="payment-method-card d-block p-3 border rounded cursor-pointer text-center bg-white shadow-sm position-relative">
                                <input type="radio" name="payment_method" value="momo" class="position-absolute" style="top: 15px; left: 15px; width: 18px; height: 18px;">
                                <div class="payment-method-icon mb-2">
                                    <img src="/webbanhang/uploads/momo_logo.webp" alt="MoMo Logo" style="height: 40px; width: 40px; border-radius: 8px; object-fit: cover;">
                                </div>
                                <span class="d-block fw-bold text-dark">Ví MoMo (Sandbox)</span>
                                <small class="text-muted d-block mt-1">Cổng thanh toán MoMo thử nghiệm</small>
                            </label>
                        </div>
                    </div>
                </div>

                <style>
                .payment-method-card {
                    transition: all 0.3s ease;
                    border: 2px solid #dee2e6 !important;
                }
                .payment-method-card:hover {
                    border-color: #0d6efd !important;
                    transform: translateY(-2px);
                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
                }
                .cursor-pointer {
                    cursor: pointer;
                }
                /* Style highlights when input is checked */
                .payment-method-card:has(input[type="radio"]:checked) {
                    border-color: #0d6efd !important;
                    background-color: #f8f9fa !important;
                    box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.1) !important;
                }
                </style>

                <div class="d-flex justify-content-between">
                    <a href="/webbanhang/Product/cart" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check-circle"></i> Đặt hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4">
            <h4 class="mb-3"><i class="fas fa-receipt"></i> Đơn hàng của bạn</h4>
            <hr>
            <?php
            $total = 0;
            foreach ($cart as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <?php if ($item['image']): ?>
                            <img src="/webbanhang/<?php echo $item['image']; ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" class="me-3">
                        <?php endif; ?>
                        <div>
                            <strong><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <br>
                            <small class="text-muted">x<?php echo $item['quantity']; ?></small>
                        </div>
                    </div>
                    <span class="text-danger"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between">
                <h5>Tổng cộng:</h5>
                <h5 class="text-danger"><?php echo number_format($total, 0, ',', '.'); ?> VND</h5>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
