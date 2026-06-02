<?php include 'app/views/shares/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-edit"></i> Sửa sản phẩm</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/webbanhang/Product/edit/<?php echo $product->id; ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="card p-4">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" required
                   value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá (VND) <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" required
                   value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" min="1">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <?php if ($product->image): ?>
                <div class="mb-2">
                    <img src="/webbanhang/<?php echo $product->image; ?>" alt="Current Image" style="max-width: 150px;" class="rounded">
                    <p class="text-muted small">Hình ảnh hiện tại</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục</label>
            <select id="category_id" name="category_id" class="form-select">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat->id; ?>" <?php echo ($product->category_id == $cat->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập nhật
            </button>
            <a href="/webbanhang/Product/list" class="btn btn-secondary">
                <i class="fas fa-times"></i> Hủy
            </a>
        </div>
    </div>
</form>

<script>
function validateForm() {
    let name = document.getElementById('name').value;
    let price = document.getElementById('price').value;
    let errors = [];

    if (name.length < 10 || name.length > 100) {
        errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
    }
    if (price <= 0 || isNaN(price)) {
        errors.push('Giá phải là một số dương lớn hơn 0.');
    }
    if (errors.length > 0) {
        alert(errors.join('\n'));
        return false;
    }
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
