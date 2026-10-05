<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan Ly San Pham</title>
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

        .navbar-right a:hover {
            color: #ff9900;
        }

        .navbar-right a.active {
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 24px;
            color: #1b1f23;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .btn-danger {
            background: #d9381e;
        }

        .btn-danger:hover {
            background: #c62828;
        }

        .btn-secondary {
            background: #666;
        }

        .btn-secondary:hover {
            background: #555;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #b9dfc2;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:hover {
            background: #fafafa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            background: #f4f4f4;
        }

        .product-name {
            font-weight: 600;
            color: #1b1f23;
        }

        .product-code {
            font-size: 12px;
            color: #888;
        }

        .price {
            color: #d9381e;
            font-weight: 600;
        }

        .stock {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 13px;
        }

        .stock.in {
            background: #d4edda;
            color: #155724;
        }

        .stock.out {
            background: #f8d7da;
            color: #721c24;
        }

        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.active {
            background: #d4edda;
            color: #155724;
        }

        .status.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .actions a, .actions button {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .actions .edit-btn {
            background: #007bff;
            color: white;
        }

        .actions .edit-btn:hover {
            background: #0056b3;
        }

        .actions .delete-btn {
            background: #d9381e;
            color: white;
        }

        .actions .delete-btn:hover {
            background: #c62828;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ccc;
        }

        .empty-state p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Quan Ly Cua Hang</h2>
        <div class="navbar-right">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="active">San pham</a>
            <a href="#">Don hang</a>
            <a href="#">Khach hang</a>
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Dang xuat</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1>Quan Ly San Pham</h1>
            <a href="{{ route('admin.products.create') }}" class="btn">
                <i class="fa-solid fa-plus"></i> Them san pham moi
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-wrapper">
            @if ($products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Hinh anh</th>
                            <th>San pham</th>
                            <th>Danh muc</th>
                            <th>Gia</th>
                            <th>Kho</th>
                            <th>Trang thai</th>
                            <th>Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" class="product-img" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/60" class="product-img" alt="No Image">
                                    @endif
                                </td>
                                <td>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-code">SKU: {{ $product->code }}</div>
                                </td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td class="price">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                <td>
                                    <span class="stock {{ $product->stock > 0 ? 'in' : 'out' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status {{ $product->is_active ? 'active' : 'inactive' }}">
                                        {{ $product->is_active ? 'Hoat dong' : 'Khong hoat dong' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="edit-btn">
                                            <i class="fa-solid fa-edit"></i> Sua
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Ban co chan muon xoa san pham nay?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn">
                                                <i class="fa-solid fa-trash"></i> Xoa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Chua co san pham nao. <a href="{{ route('admin.products.create') }}">Them san pham dau tien</a></p>
                </div>
            @endif
        </div>
    </div>

    @include('layouts.admin')
</body>
</html>
