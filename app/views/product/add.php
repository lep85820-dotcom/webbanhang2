<?php include 'app/views/shares/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-plus-circle"></i> Thêm sản phẩm mới</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/webbanhang/Product/add" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="card p-4">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" required
                   placeholder="Nhập tên sản phẩm (10-100 ký tự)">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" class="form-control" rows="4"
                      placeholder="Nhập mô tả sản phẩm"></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá (VND) <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" required
                   placeholder="Nhập giá sản phẩm" min="1">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục</label>
            <select id="category_id" name="category_id" class="form-select">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu sản phẩm
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
