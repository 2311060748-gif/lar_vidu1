<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua San Pham</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e1e4e8;
        }

        .navbar h2 {
            color: #1b1f23;
            font-size: 20px;
        }

        .navbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-right a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s;
        }

        .navbar-right a:hover, .navbar-right a.active {
            color: #ff9900;
        }

        .navbar-right span {
            color: #1b1f23;
            font-weight: 600;
        }

        .logout-btn {
            background: #d9381e;
            color: white !important;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        .container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 24px;
            color: #1b1f23;
        }

        .page-header a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .page-header a:hover {
            color: #ff9900;
        }

        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group label span {
            color: #d9381e;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dfe3e8;
            border-radius: 6px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.12);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input {
            width: auto;
        }

        .file-upload {
            border: 2px dashed #dfe3e8;
            border-radius: 6px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .file-upload:hover {
            border-color: #ff9900;
        }

        .file-upload input {
            display: none;
        }

        .file-upload i {
            font-size: 32px;
            color: #ccc;
            margin-bottom: 10px;
        }

        .file-upload p {
            color: #888;
            font-size: 14px;
        }

        .preview-img {
            max-width: 200px;
            margin-top: 15px;
            border-radius: 6px;
        }

        .current-img {
            max-width: 150px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .error-message {
            color: #d9381e;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #ff9900;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #e88a00;
        }

        .btn-secondary {
            background: #666;
        }

        .btn-secondary:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Quan Ly Cua Hang</h2>
        <div class="navbar-right">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="active">San pham</a>
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Dang xuat</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('admin.products.index') }}">
                <i class="fa-solid fa-arrow-left"></i> Quay lai danh sach
            </a>
            <h1 style="margin-top: 10px;">Sua San Pham</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Co loi xay ra:</strong>
                <ul style="margin-top: 10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Ten san pham <span>*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="code">Ma san pham (SKU) <span>*</span></label>
                        <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Danh muc <span>*</span></label>
                        <select id="category_id" name="category_id" required>
                            <option value="">-- Chon danh muc --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Gia ban (VND) <span>*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="discount_price">Gia giam (VND)</label>
                        <input type="number" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="stock">So luong trong kho <span>*</span></label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Trang thai</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="is_active" style="margin-bottom: 0; font-weight: normal;">San pham dang ban</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Mo ta san pham</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Hinh anh san pham</label>
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" class="current-img" alt="Current image">
                    @endif
                    <label class="file-upload">
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Nhan vao de chon hinh anh moi (JPG, PNG, GIF - toi da 2MB)</p>
                    </label>
                    <img id="preview" class="preview-img" style="display: none;">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">
                        <i class="fa-solid fa-save"></i> Cap nhat san pham
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Huy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
