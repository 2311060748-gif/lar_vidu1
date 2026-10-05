<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Phụ Kiện Xe Máy Chính Hãng</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f4f6f8;
            color: #333;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .top-header {
            background: #1b1f23;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            border-bottom: 3px solid #ff9900;
        }

        .logo {
            color: #ff9900;
            font-size: 21px;
            font-weight: bold;
            text-decoration: none;
            white-space: nowrap;
        }

        .logo i {
            margin-right: 7px;
        }

        .search-bar {
            display: flex;
            width: 42%;
            max-width: 550px;
        }

        .search-bar input {
            width: 100%;
            height: 40px;
            padding: 8px 12px;
            border: none;
            outline: none;
            border-radius: 6px 0 0 6px;
            font-size: 14px;
        }

        .search-bar button {
            background: #ff9900;
            border: none;
            width: 48px;
            color: white;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: 0.2s;
        }

        .search-bar button:hover {
            background: #e88a00;
        }

        .cart-btn {
            color: white;
            text-decoration: none;
            background: #333;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: bold;
            position: relative;
            white-space: nowrap;
            cursor: pointer;
        }

        .cart-btn:hover {
            background: #444;
        }

        .cart-badge {
            background: #ff4d4f;
            color: white;
            border-radius: 50%;
            min-width: 19px;
            height: 19px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {
            background: #0d1117;
            padding: 0 40px;
            min-height: 54px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .navbar a {
            color: #c9d1d9;
            text-decoration: none;
            padding: 17px 14px;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 3px solid transparent;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .navbar a:hover,
        .navbar a.active {
            color: #ff9900;
            background: rgba(255, 153, 0, 0.07);
            border-bottom-color: #ff9900;
        }

        .nav-right {
            color: #9da7b3;
            font-size: 13px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-right i {
            color: #ff9900;
            margin-right: 5px;
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .auth-btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .login-btn {
            color: #ff9900;
            border: 2px solid #ff9900;
            background: transparent;
        }

        .login-btn:hover {
            background: #ff9900;
            color: white;
        }

        .register-btn {
            background: #ff9900;
            color: white;
        }

        .register-btn:hover {
            background: #e88a00;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px;
            border-right: 1px solid #333;
            border-left: 1px solid #333;
        }

        .user-info span {
            color: #ff9900;
            font-weight: bold;
        }

        .logout-btn {
            padding: 8px 16px;
            background: #e53935;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        /* =====================================================
           MAIN
        ===================================================== */

        .main-container {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 15px;
        }

        /* =====================================================
           ALERT
        ===================================================== */

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #b9dfc2;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        /* =====================================================
           UPLOAD
        ===================================================== */

        .upload-card {
            background: white;
            border-radius: 14px;
            margin-bottom: 32px;
            border: 1px solid #e7eaee;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .upload-header {
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
            background: #fffaf2;
        }

        .upload-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .upload-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #fff0d6;
            color: #ff9900;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .upload-title h3 {
            font-size: 18px;
            color: #1b1f23;
            margin-bottom: 5px;
        }

        .upload-title p {
            color: #777;
            font-size: 13px;
        }

        .upload-form-grid {
            padding: 23px 24px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group label span {
            color: #e53935;
        }

        .input-icon {
            position: relative;
        }

        .input-icon > i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 2;
        }

        .input-icon input,
        .input-icon select {
            width: 100%;
            height: 45px;
            padding: 0 14px 0 40px;
            border: 1px solid #dfe3e8;
            border-radius: 8px;
            outline: none;
            background: #fff;
            font-size: 14px;
            transition: 0.2s;
        }

        .input-icon input:focus,
        .input-icon select:focus {
            border-color: #ff9900;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.12);
        }

        .file-upload {
            height: 45px;
            border: 1px dashed #ffb84d;
            border-radius: 8px;
            background: #fffaf2;
            display: flex;
            align-items: center;
            padding: 0 15px;
            gap: 10px;
            color: #cc7a00 !important;
            cursor: pointer;
            transition: 0.2s;
        }

        .file-upload:hover {
            background: #fff4df;
            border-color: #ff9900;
        }

        .file-upload i {
            font-size: 17px;
        }

        .file-upload input {
            display: none;
        }

        #file-name {
            font-weight: normal;
            font-size: 14px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .upload-footer {
            padding: 16px 24px;
            background: #fafbfc;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .upload-note {
            color: #888;
            font-size: 12px;
        }

        .upload-note i {
            color: #ff9900;
            margin-right: 5px;
        }

        .btn-submit {
            background: #28a745;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #218838;
        }

        /* =====================================================
           OEM SEARCH
        ===================================================== */

        .oem-search-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #e7eaee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .oem-search-box h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .oem-search-box h2 i {
            color: #ff9900;
        }

        .oem-search-box p {
            color: #888;
            font-size: 13px;
        }

        .oem-search {
            display: flex;
            width: 50%;
        }

        .oem-search input {
            flex: 1;
            height: 42px;
            border: 1px solid #ddd;
            border-radius: 7px 0 0 7px;
            padding: 0 14px;
            outline: none;
        }

        .oem-search input:focus {
            border-color: #ff9900;
        }

        .oem-search button {
            border: none;
            background: #ff9900;
            color: white;
            padding: 0 18px;
            border-radius: 0 7px 7px 0;
            cursor: pointer;
            font-weight: bold;
        }

        .oem-search button:hover {
            background: #e88a00;
        }

        /* =====================================================
           CATEGORY
        ===================================================== */

        .category-section {
            margin-bottom: 35px;
        }

        .section-heading {
            margin-bottom: 15px;
        }

        .section-heading h2 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .section-heading p {
            color: #888;
            font-size: 13px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .category-card {
            background: white;
            border: 1px solid #e1e4e8;
            border-radius: 10px;
            padding: 18px;
            text-align: center;
            text-decoration: none;
            color: #24292e;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            transition: 0.2s;
        }

        .category-card:hover {
            border-color: #ff9900;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .category-card.active-card {
            border: 2px solid #ff9900;
            background-color: #fffdf5;
            color: #ff9900;
        }

        .category-icon {
            font-size: 24px;
            width: 58px;
            height: 58px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f6f7f8;
            color: #ff9900;
        }

        /* =====================================================
           PRODUCT
        ===================================================== */

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-header h2 {
            font-size: 22px;
        }

        .product-count {
            color: #777;
            font-size: 13px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            list-style: none;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            cursor: pointer;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 153, 0, 0.16), 0 4px 10px rgba(0, 0, 0, 0.05);
            border-color: #ff9900;
        }

        .product-card.search-highlight {
            border-color: #ff9900;
            background-color: #fffdf5;
        }

        .product-card.active-selected {
            border-color: #ff9900;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.35);
        }

        .product-img {
            width: 100%;
            height: 170px;
            object-fit: contain;
            background: #fafafa;
            border-radius: 7px;
            margin-bottom: 10px;
        }

        .product-code {
            color: #777;
            font-size: 12px;
        }

        .product-card h4 {
            font-size: 14px;
            margin-top: 6px;
            line-height: 1.4;
            min-height: 40px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .price {
            color: #d9381e;
            font-weight: bold;
            font-size: 16px;
        }

        .btn-add {
            background: #28a745;
            color: white;
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 7px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-add:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .empty-product {
            grid-column: 1 / -1;
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            color: #777;
            border: 1px solid #eee;
        }

        /* =====================================================
           CONTACT
        ===================================================== */

        .contact-box {
            margin-top: 35px;
            background: #1b1f23;
            border-radius: 12px;
            padding: 25px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            color: white;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .contact-item > i {
            font-size: 22px;
            color: #ff9900;
        }

        .contact-item strong {
            display: block;
            margin-bottom: 4px;
        }

        .contact-item span {
            color: #aaa;
            font-size: 13px;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1000px) {

            .top-header {
                padding: 12px 20px;
            }

            .navbar {
                padding: 0 20px;
            }

            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 850px) {

            .top-header {
                flex-wrap: wrap;
            }

            .search-bar {
                order: 3;
                width: 100%;
                max-width: none;
            }

            .nav-right {
                display: none;
            }

            .upload-form-grid {
                grid-template-columns: 1fr;
            }

            .oem-search-box {
                flex-direction: column;
                align-items: stretch;
            }

            .oem-search {
                width: 100%;
            }

            .contact-box {
                grid-template-columns: 1fr;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {

            .top-header {
                padding: 12px 15px;
            }

            .logo {
                font-size: 17px;
            }

            .navbar {
                padding: 0 10px;
                overflow-x: auto;
            }

            .navbar a {
                white-space: nowrap;
                padding: 16px 10px;
                font-size: 13px;
            }

            .main-container {
                margin-top: 18px;
            }

            .category-grid {
                grid-template-columns: 1fr 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .upload-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-submit {
                width: 100%;
            }

            .product-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }

        /* =====================================================
           PRODUCT DETAIL MODAL (POPUP CHI TIET SAN PHAM)
        ===================================================== */
        .product-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 20px;
        }

        .product-modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .product-modal {
            background: #ffffff;
            border-radius: 16px;
            max-width: 820px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(0, 0, 0, 0.05);
            transform: scale(0.92) translateY(20px);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .product-modal-backdrop.active .product-modal {
            transform: scale(1) translateY(0);
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f1f3f5;
            border: none;
            color: #495057;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .modal-close-btn:hover {
            background: #e9ecef;
            color: #e53935;
            transform: rotate(90deg);
        }

        .modal-content-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 28px;
            padding: 28px;
        }

        .modal-image-col {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-image-wrapper {
            width: 100%;
            height: 280px;
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .modal-image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .modal-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .modal-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge-item {
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .badge-oem {
            background: #fff4e6;
            color: #d97706;
            border: 1px solid #fed7aa;
        }

        .badge-authentic {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .modal-info-col {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .modal-category-tag {
            display: inline-block;
            font-size: 12px;
            color: #ff9900;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #1b1f23;
            line-height: 1.35;
            margin-bottom: 12px;
        }

        .modal-price-box {
            background: #fff8f0;
            border: 1px solid #ffe8cc;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 16px;
            display: flex;
            align-items: baseline;
            gap: 12px;
        }

        .modal-price {
            font-size: 26px;
            font-weight: 800;
            color: #d9381e;
        }

        .modal-price-label {
            font-size: 13px;
            color: #888;
        }

        .modal-desc {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .modal-features {
            list-style: none;
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13px;
            color: #4a5568;
        }

        .modal-features li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-features li i {
            color: #10b981;
        }

        .modal-quantity-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .modal-quantity-row label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .qty-control {
            display: inline-flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            background: #f8fafc;
            border: none;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
        }

        .qty-btn:hover {
            background: #e2e8f0;
        }

        .qty-input {
            width: 50px;
            height: 36px;
            text-align: center;
            border: none;
            border-left: 1px solid #cbd5e1;
            border-right: 1px solid #cbd5e1;
            font-size: 14px;
            font-weight: 600;
            outline: none;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .btn-modal-add {
            flex: 1;
            padding: 13px 18px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-modal-add:hover {
            background: #218838;
        }

        .btn-modal-buy {
            flex: 1;
            padding: 13px 18px;
            background: #ff9900;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-modal-buy:hover {
            background: #e88a00;
        }

        @media (max-width: 768px) {
            .modal-content-grid {
                grid-template-columns: 1fr;
                padding: 18px;
                gap: 18px;
            }

            .modal-image-wrapper {
                height: 220px;
            }

            .modal-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- =====================================================
         HEADER
    ===================================================== -->

    <header class="top-header">

        <a href="{{ url('/') }}" class="logo">
            <i class="fa-solid fa-motorcycle"></i>
            PHỤ KIỆN XE MÁY
        </a>

        <div class="search-bar">

            <input
                type="text"
                id="headerSearch"
                placeholder="Tìm theo tên, mã OEM, phụ tùng..."
                value="{{ $searchQuery ?? '' }}"
                autocomplete="off"
            >

            <button
                type="button"
                id="headerSearchBtn"
                title="Tìm kiếm"
            >
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

        </div>

        <a href="{{ route('cart.index') }}" class="cart-btn" id="cartBtn">
            <i class="fa-solid fa-cart-shopping"></i>
            Giỏ hàng
            <span class="cart-badge" id="cart-count">0</span>
        </a>

    </header>


    <!-- =====================================================
         NAVBAR
    ===================================================== -->

    <nav class="navbar">

        <div class="nav-left">

            <a
                href="{{ url('/') }}"
                class="{{ $selectedCategory === 'all' ? 'active' : '' }}"
            >
                <i class="fa-solid fa-house"></i>
                Trang chủ
            </a>

            <a href="{{ route('cart.index') }}">
                <i class="fa-solid fa-cart-shopping"></i>
                Giỏ hàng
            </a>

            @if (Auth::check())
                <a href="{{ route('orders.index') }}">
                    <i class="fa-solid fa-receipt"></i>
                    Đơn hàng của tôi
                </a>
            @endif

            <a href="#categories">
                <i class="fa-solid fa-list"></i>
                Danh mục phụ tùng
            </a>

            <a href="#search-oem">
                <i class="fa-solid fa-barcode"></i>
                Tra cứu OEM
            </a>

            <a href="#contact">
                <i class="fa-solid fa-phone"></i>
                Liên hệ
            </a>

        </div>

        <div class="nav-right">

            @if (Auth::check())
                <div class="user-info">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" style="color: #ff9900; text-decoration: none; font-weight: bold;">
                        <i class="fa-solid fa-cogs"></i>
                        Admin Panel
                    </a>
                @else
                    <a href="{{ route('customer.dashboard') }}" style="color: #ff9900; text-decoration: none; font-weight: bold;">
                        <i class="fa-solid fa-user-circle"></i>
                        Dashboard
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        Đăng xuất
                    </button>
                </form>
            @else
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="auth-btn login-btn">
                        <i class="fa-solid fa-sign-in-alt"></i>
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="auth-btn register-btn">
                        <i class="fa-solid fa-user-plus"></i>
                        Đăng ký
                    </a>
                </div>

                <div style="border-left: 1px solid #333; padding-left: 15px;">
                    <i class="fa-solid fa-headset"></i>
                    Hỗ trợ: 0988 123 456
                </div>
            @endif

        </div>

    </nav>


    <!-- =====================================================
         MAIN
    ===================================================== -->

    <main class="main-container">

        <!-- SUCCESS -->

        @if (session('success'))

            <div class="alert-success">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- ERROR -->

        @if ($errors->any())

            <div class="alert-error">

                <strong>
                    Có lỗi xảy ra:
                </strong>

                <ul style="margin: 8px 0 0 20px;">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- =================================================
             UPLOAD PRODUCT (CHI ADMIN)
        ================================================== -->

        @if (Auth::check() && Auth::user()->role === 'admin')
        <div class="upload-card">

            <div class="upload-header">

                <div class="upload-title">

                    <div class="upload-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>

                    <div>

                        <h3>
                            Them phu kien moi
                        </h3>

                        <p>
                            Nhap thong tin san pham va tai hinh anh len he thong
                        </p>

                    </div>

                </div>

            </div>


            <form
                action="{{ route('product.upload') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="upload-form-grid">

                    <!-- MÃ OEM -->

                    <div class="form-group">

                        <label>
                            Ma OEM
                            <span>*</span>
                        </label>

                        <div class="input-icon">

                            <i class="fa-solid fa-barcode"></i>

                            <input
                                type="text"
                                name="code"
                                placeholder="VD: 06430-KVB-305"
                                value="{{ old('code') }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- TÊN -->

                    <div class="form-group">

                        <label>
                            Ten phu kien
                            <span>*</span>
                        </label>

                        <div class="input-icon">

                            <i class="fa-solid fa-screwdriver-wrench"></i>

                            <input
                                type="text"
                                name="name"
                                placeholder="Nhap ten phu kien"
                                value="{{ old('name') }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- GIÁ -->

                    <div class="form-group">

                        <label>
                            Gia ban
                            <span>*</span>
                        </label>

                        <div class="input-icon">

                            <i class="fa-solid fa-money-bill-wave"></i>

                            <input
                                type="number"
                                name="price"
                                min="0"
                                placeholder="VD: 120000"
                                value="{{ old('price') }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- DANH MỤC -->

                    <div class="form-group">

                        <label>
                            Danh muc
                            <span>*</span>
                        </label>

                        <div class="input-icon">

                            <i class="fa-solid fa-layer-group"></i>

                            <select name="category" required>

                                <option value="">
                                    -- Chon danh muc --
                                </option>

                                <option
                                    value="ma-phanh"
                                    {{ old('category') === 'ma-phanh' ? 'selected' : '' }}
                                >
                                    May phanh / Dia
                                </option>

                                <option
                                    value="loc-gio"
                                    {{ old('category') === 'loc-gio' ? 'selected' : '' }}
                                >
                                    Loc gio / Bugi
                                </option>

                                <option
                                    value="nhong-sen-dia"
                                    {{ old('category') === 'nhong-sen-dia' ? 'selected' : '' }}
                                >
                                    Nhong sen dia
                                </option>

                                <option
                                    value="den-xe"
                                    {{ old('category') === 'den-xe' ? 'selected' : '' }}
                                >
                                    Den & Xi-nhan
                                </option>

                                <option
                                    value="guong-bao-tay"
                                    {{ old('category') === 'guong-bao-tay' ? 'selected' : '' }}
                                >
                                    Guong / Bao tay
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- HÌNH ẢNH -->

                    <div class="form-group">

                        <label>
                            Hinh anh
                            <span>*</span>
                        </label>

                        <label class="file-upload">

                            <i class="fa-solid fa-image"></i>

                            <span id="file-name">
                                Chon hinh anh
                            </span>

                            <input
                                type="file"
                                name="image"
                                id="imageInput"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                required
                            >

                        </label>

                    </div>

                </div>


                <div class="upload-footer">

                    <div class="upload-note">

                        <i class="fa-solid fa-circle-info"></i>

                        JPG, PNG, GIF - toi da 2MB

                    </div>

                    <button
                        type="submit"
                        class="btn-submit"
                    >

                        <i class="fa-solid fa-plus"></i>

                        Them san pham

                    </button>

                </div>

            </form>

        </div>
        @endif


        <!-- =================================================
             OEM SEARCH
        ================================================== -->

        <div
            id="search-oem"
            class="oem-search-box"
        >

            <div>

                <h2>

                    <i class="fa-solid fa-barcode"></i>

                    Tra cứu mã OEM

                </h2>

                <p>
                    Nhập mã OEM hoặc tên sản phẩm để tìm nhanh
                </p>

            </div>


            <div class="oem-search">

                <input
                    type="text"
                    id="oemInput"
                    placeholder="Ví dụ: lọc gió, má phanh, 06430-KVB-305..."
                    value="{{ $searchQuery ?? '' }}"
                    autocomplete="off"
                >

                <button
                    type="button"
                    id="oemSearchBtn"
                >

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Tra cứu

                </button>

            </div>

        </div>


        <!-- =================================================
             CATEGORIES
        ================================================== -->

        <div
            id="categories"
            class="category-section"
        >

            <div class="section-heading">

                <h2>
                    Danh mục phụ kiện
                </h2>

                <p>
                    Chọn danh mục để lọc sản phẩm
                </p>

            </div>


            <div class="category-grid">

                @foreach ($categories as $cat)

                    <a
                        href="{{ url('/?category=' . $cat['slug']) }}"
                        class="category-card {{ $selectedCategory === $cat['slug'] ? 'active-card' : '' }}"
                    >

                        <span class="category-icon">
                            <i class="{{ $cat['icon'] }}"></i>
                        </span>

                        <span>
                            {{ $cat['name'] }}
                        </span>

                    </a>

                @endforeach

            </div>

        </div>


        <!-- =================================================
             PRODUCT HEADER
        ================================================== -->

        <div class="product-header">

            <h2>
                Danh sach san pham
            </h2>

            <span class="product-count">
                {{ count($products) }} sản phẩm
            </span>

        </div>


        <!-- =================================================
             PRODUCT GRID
        ================================================== -->

        <div
            class="product-grid"
            id="productGrid"
        >

            @forelse ($products as $p)
                @php
                    $catName = '';
                    foreach ($categories as $cat) {
                        if ($cat['slug'] === ($p['category'] ?? '')) {
                            $catName = $cat['name'];
                            break;
                        }
                    }
                    if (empty($catName)) {
                        $catName = 'Phụ tùng xe máy';
                    }
                @endphp

                <div
                    class="product-card"
                    data-id="{{ $p['code'] ?? ($p['id'] ?? $p['name']) }}"
                    data-name="{{ $p['name'] }}"
                    data-code="{{ $p['code'] }}"
                    data-price="{{ $p['price'] }}"
                    data-formatted-price="{{ number_format($p['price'], 0, ',', '.') }} đ"
                    data-image="{{ $p['image'] }}"
                    data-category="{{ $catName }}"
                    data-description="{{ $p['description'] ?? 'Sản phẩm phụ kiện chính hãng chất lượng cao, thiết kế chuẩn theo dòng xe, đảm bảo khả năng vận hành êm ái, an toàn và tuổi thọ bền lâu.' }}"
                    title="Bấm chuột để xem chi tiết sản phẩm"
                >

                    <div>

                        <img
                            src="{{ $p['image'] }}"
                            class="product-img"
                            alt="{{ $p['name'] }}"
                            onerror="this.onerror=null;this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22400%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f1f5f9%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%2216%22%20font-weight%3D%22bold%22%20fill%3D%22%2394a3b8%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%3E%F0%9F%8F%8D%EF%B8%8F%20Ph%E1%BB%A5%20Ki%E1%BB%87n%20Xe%20M%C3%A1y%3C%2Ftext%3E%3C%2Fsvg%3E';"
                        >

                        <small class="product-code">

                            OEM:
                            {{ $p['code'] }}

                        </small>

                        <h4>
                            {{ $p['name'] }}
                        </h4>

                    </div>


                    <div class="price-row">

                        <span class="price">

                            {{ number_format($p['price'], 0, ',', '.') }} đ

                        </span>


                        <!-- KHÔNG DÙNG ONCLICK INLINE -->
                        <button
                            type="button"
                            class="btn-add add-cart-btn"
                            data-id="{{ $p['code'] ?? ($p['id'] ?? $p['name']) }}"
                            data-name="{{ $p['name'] }}"
                            data-price="{{ $p['price'] }}"
                            data-image="{{ $p['image'] ?? '' }}"
                            title="Thêm vào giỏ hàng"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>

                    </div>

                </div>

            @empty

                <div class="empty-product">

                    <i
                        class="fa-solid fa-box-open"
                        style="font-size:35px;margin-bottom:10px;color:#aaa;"
                    ></i>

                    <p>
                        Không có sản phẩm nào thuộc danh mục này.
                    </p>

                </div>

            @endforelse

            <!-- Thông báo khi tìm kiếm không thấy kết quả -->
            <div id="noSearchProduct" class="empty-product" style="grid-column: 1 / -1; display: none; text-align: center; padding: 40px 20px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin: 10px 0;">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 38px; color: #ff9900; margin-bottom: 12px; display: block;"></i>
                <h4 style="margin-bottom: 8px; font-size: 18px; color: #333;">Không tìm thấy sản phẩm phù hợp</h4>
                <p style="color: #666; margin-bottom: 18px; font-size: 14px;">Không có sản phẩm nào khớp với từ khóa "<strong id="searchKeywordDisplay" style="color: #d9381e;"></strong>".</p>
                <a href="{{ url('/') }}" class="cart-btn" id="resetSearchBtn" style="border: none; background: #ff9900; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-rotate-left"></i> Xem tất cả sản phẩm
                </a>
            </div>

        </div>


        <!-- =================================================
             CONTACT
        ================================================== -->

        <div
            id="contact"
            class="contact-box"
        >

            <div class="contact-item">

                <i class="fa-solid fa-phone"></i>

                <div>

                    <strong>
                        Hotline
                    </strong>

                    <span>
                        0988 123 456
                    </span>

                </div>

            </div>


            <div class="contact-item">

                <i class="fa-solid fa-envelope"></i>

                <div>

                    <strong>
                        Email
                    </strong>

                    <span>
                        support@phukienxemay.vn
                    </span>

                </div>

            </div>


            <div class="contact-item">

                <i class="fa-solid fa-location-dot"></i>

                <div>

                    <strong>
                        Địa chỉ
                    </strong>

                    <span>
                        Hà Nội, Việt Nam
                    </span>

                </div>

            </div>

        </div>

    </main>

    <!-- =====================================================
         POPUP CHI TIẾT SẢN PHẨM (PRODUCT DETAIL MODAL)
    ===================================================== -->
    <div class="product-modal-backdrop" id="productModalBackdrop">
        <div class="product-modal" id="productModal" role="dialog" aria-modal="true" aria-labelledby="modalProductName">
            <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Đóng">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-content-grid">
                <div class="modal-image-col">
                    <div class="modal-image-wrapper">
                        <img id="modalProductImg" src="" alt="Hình sản phẩm" onerror="this.onerror=null;this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22400%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f1f5f9%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%2216%22%20font-weight%3D%22bold%22%20fill%3D%22%2394a3b8%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%3E%F0%9F%8F%8D%EF%B8%8F%20Ph%E1%BB%A5%20Ki%E1%BB%87n%20Xe%20M%C3%A1y%3C%2Ftext%3E%3C%2Fsvg%3E';">
                    </div>
                    <div class="modal-badges">
                        <span class="badge-item badge-oem">
                            <i class="fa-solid fa-barcode"></i> OEM: <strong id="modalProductCodeBadge">---</strong>
                        </span>
                        <span class="badge-item badge-authentic">
                            <i class="fa-solid fa-shield-halved"></i> Chính hãng 100%
                        </span>
                    </div>
                </div>

                <div class="modal-info-col">
                    <div>
                        <span class="modal-category-tag" id="modalProductCategory">Phụ tùng xe máy</span>
                        <h2 class="modal-title" id="modalProductName">Tên sản phẩm</h2>

                        <div class="modal-price-box">
                            <span class="modal-price" id="modalProductPrice">0 đ</span>
                            <span class="modal-price-label">Giá niêm yết chính hãng</span>
                        </div>

                        <p class="modal-desc" id="modalProductDesc">
                            Mô tả chi tiết sản phẩm.
                        </p>

                        <ul class="modal-features">
                            <li><i class="fa-solid fa-circle-check"></i> Linh kiện mới 100%, bảo hành chính hãng uy tín</li>
                            <li><i class="fa-solid fa-truck-fast"></i> Giao hàng tận nơi toàn quốc qua Giao Hàng Nhanh (GHN)</li>
                            <li><i class="fa-solid fa-rotate-left"></i> Kiểm tra hàng trước khi thanh toán, đổi trả trong 7 ngày</li>
                        </ul>
                    </div>

                    <div>
                        <div class="modal-quantity-row">
                            <label for="modalQuantity">Số lượng:</label>
                            <div class="qty-control">
                                <button type="button" class="qty-btn" id="qtyMinus" title="Giảm số lượng">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" id="modalQuantity" class="qty-input" value="1" min="1" max="99">
                                <button type="button" class="qty-btn" id="qtyPlus" title="Tăng số lượng">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="modal-actions">
                            <button type="button" class="btn-modal-add" id="modalAddCartBtn">
                                <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                            <button type="button" class="btn-modal-buy" id="modalBuyNowBtn">
                                <i class="fa-solid fa-bolt"></i> Mua ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- =====================================================
         JAVASCRIPT
    ===================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | GIỎ HÀNG
            |--------------------------------------------------------------------------
            */

            let cart = JSON.parse(localStorage.getItem('cart') || '[]');

            const cartCountElement =
                document.getElementById('cart-count');

            function updateCartBadge() {
                const count = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                }
            }
            updateCartBadge();

            /*
            |--------------------------------------------------------------------------
            | THÊM SẢN PHẨM VÀO GIỎ
            |--------------------------------------------------------------------------
            */

            const addCartButtons =
                document.querySelectorAll('.add-cart-btn');

            addCartButtons.forEach(function (button) {

                button.addEventListener('click', function (e) {
                    e.stopPropagation();

                    const id =
                        button.getAttribute('data-id') || button.getAttribute('data-name');

                    const name =
                        button.getAttribute('data-name');

                    const price =
                        Number(
                            button.getAttribute('data-price')
                        );

                    const image =
                        button.getAttribute('data-image') || '';

                    const existing = cart.find(item => item.id == id || item.name == name);

                    if (existing) {
                        existing.quantity = (existing.quantity || 1) + 1;
                        existing.selected = true;
                    } else {
                        cart.push({
                            id: id,
                            name: name,
                            price: price,
                            image: image,
                            quantity: 1,
                            weight: 200,
                            selected: true
                        });
                    }

                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartBadge();

                    // Đồng bộ sang session Laravel
                    fetch("{{ route('cart.sync') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ cart: cart })
                    });

                    /*
                    | Hiệu ứng nút
                    */
                    const oldContent = button.innerHTML;
                    button.innerHTML = '<i class="fa-solid fa-check"></i>';
                    button.style.background = '#198754';

                    setTimeout(function () {
                        button.innerHTML = oldContent;
                        button.style.background = '';
                    }, 800);
                });

            });

            /*
            |--------------------------------------------------------------------------
            | MODAL XEM CHI TIẾT SẢN PHẨM (KHI CLICK VÀO SẢN PHẨM)
            |--------------------------------------------------------------------------
            */
            const productCards = document.querySelectorAll('.product-card');
            const modalBackdrop = document.getElementById('productModalBackdrop');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalProductImg = document.getElementById('modalProductImg');
            const modalProductCodeBadge = document.getElementById('modalProductCodeBadge');
            const modalProductCategory = document.getElementById('modalProductCategory');
            const modalProductName = document.getElementById('modalProductName');
            const modalProductPrice = document.getElementById('modalProductPrice');
            const modalProductDesc = document.getElementById('modalProductDesc');
            const modalQuantity = document.getElementById('modalQuantity');
            const qtyMinus = document.getElementById('qtyMinus');
            const qtyPlus = document.getElementById('qtyPlus');
            const modalAddCartBtn = document.getElementById('modalAddCartBtn');
            const modalBuyNowBtn = document.getElementById('modalBuyNowBtn');

            let currentModalProduct = null;

            function openProductModal(card) {
                // Đánh dấu active cho sản phẩm được bấm
                productCards.forEach(c => c.classList.remove('active-selected'));
                card.classList.add('active-selected');

                const id = card.getAttribute('data-id') || card.getAttribute('data-code') || card.getAttribute('data-name');
                const name = card.getAttribute('data-name') || '';
                const code = card.getAttribute('data-code') || '';
                const price = Number(card.getAttribute('data-price') || 0);
                const formattedPrice = card.getAttribute('data-formatted-price') || (price.toLocaleString('vi-VN') + ' đ');
                const image = card.getAttribute('data-image') || '';
                const category = card.getAttribute('data-category') || 'Phụ tùng xe máy';
                const description = card.getAttribute('data-description') || 'Sản phẩm phụ kiện chính hãng chất lượng cao.';

                currentModalProduct = {
                    id: id,
                    name: name,
                    code: code,
                    price: price,
                    image: image,
                    category: category,
                    description: description
                };

                if (modalProductName) modalProductName.textContent = name;
                if (modalProductCodeBadge) modalProductCodeBadge.textContent = code;
                if (modalProductCategory) modalProductCategory.textContent = category;
                if (modalProductPrice) modalProductPrice.textContent = formattedPrice;
                if (modalProductDesc) modalProductDesc.textContent = description;
                if (modalProductImg) {
                    modalProductImg.src = image;
                    modalProductImg.alt = name;
                }
                if (modalQuantity) modalQuantity.value = 1;

                if (modalBackdrop) {
                    modalBackdrop.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeProductModal() {
                if (modalBackdrop) {
                    modalBackdrop.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            productCards.forEach(function (card) {
                card.addEventListener('click', function (e) {
                    // Nếu bấm vào nút thêm nhanh vào giỏ hàng (+) thì không mở modal
                    if (e.target.closest('.add-cart-btn')) {
                        return;
                    }
                    openProductModal(card);
                });
            });

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', closeProductModal);
            }

            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', function (e) {
                    if (e.target === modalBackdrop) {
                        closeProductModal();
                    }
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modalBackdrop && modalBackdrop.classList.contains('active')) {
                    closeProductModal();
                }
            });

            if (qtyMinus && modalQuantity) {
                qtyMinus.addEventListener('click', function () {
                    let val = parseInt(modalQuantity.value) || 1;
                    if (val > 1) {
                        modalQuantity.value = val - 1;
                    }
                });
            }

            if (qtyPlus && modalQuantity) {
                qtyPlus.addEventListener('click', function () {
                    let val = parseInt(modalQuantity.value) || 1;
                    if (val < 99) {
                        modalQuantity.value = val + 1;
                    }
                });
            }

            function addCurrentProductToCart(qty) {
                if (!currentModalProduct) return;
                const quantity = Math.max(1, parseInt(qty) || 1);
                const existing = cart.find(item => item.id == currentModalProduct.id || item.name == currentModalProduct.name);

                if (existing) {
                    existing.quantity = (existing.quantity || 1) + quantity;
                    existing.selected = true;
                } else {
                    cart.push({
                        id: currentModalProduct.id,
                        name: currentModalProduct.name,
                        price: currentModalProduct.price,
                        image: currentModalProduct.image,
                        quantity: quantity,
                        weight: 200,
                        selected: true
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartBadge();

                fetch("{{ route('cart.sync') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ cart: cart })
                });
            }

            if (modalAddCartBtn) {
                modalAddCartBtn.addEventListener('click', function () {
                    const qty = parseInt(modalQuantity.value) || 1;
                    addCurrentProductToCart(qty);

                    const oldHtml = modalAddCartBtn.innerHTML;
                    modalAddCartBtn.innerHTML = '<i class="fa-solid fa-check"></i> Đã thêm vào giỏ!';
                    modalAddCartBtn.style.background = '#198754';

                    setTimeout(function () {
                        modalAddCartBtn.innerHTML = oldHtml;
                        modalAddCartBtn.style.background = '';
                    }, 1200);
                });
            }

            if (modalBuyNowBtn) {
                modalBuyNowBtn.addEventListener('click', function () {
                    const qty = parseInt(modalQuantity.value) || 1;
                    addCurrentProductToCart(qty);
                    window.location.href = "{{ route('cart.index') }}";
                });
            }

            /*
            |--------------------------------------------------------------------------
            | XEM GIỎ HÀNG
            |--------------------------------------------------------------------------
            */

            const cartBtn =
                document.getElementById('cartBtn');

            if (cartBtn) {
                cartBtn.addEventListener('click', function (event) {
                    event.preventDefault();
                    // Đồng bộ trước khi chuyển trang
                    fetch("{{ route('cart.sync') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ cart: cart })
                    }).finally(() => {
                        window.location.href = "{{ route('cart.index') }}";
                    });
                });
            }


            /*
            |--------------------------------------------------------------------------
            | HIỂN THỊ TÊN FILE
            |--------------------------------------------------------------------------
            */

            const imageInput =
                document.getElementById('imageInput');

            const fileName =
                document.getElementById('file-name');


            if (imageInput && fileName) {
                imageInput.addEventListener('change', function () {

                    if (
                        imageInput.files &&
                        imageInput.files.length > 0
                    ) {

                        fileName.textContent =
                            imageInput.files[0].name;

                    } else {

                        fileName.textContent =
                            'Chọn hình ảnh';

                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | TÌM KIẾM THÔNG MINH (TIẾNG VIỆT CÓ DẤU & KHÔNG DẤU, LIVE SEARCH)
            |--------------------------------------------------------------------------
            */

            const oemInput = document.getElementById('oemInput');
            const oemSearchBtn = document.getElementById('oemSearchBtn');
            const headerSearch = document.getElementById('headerSearch');
            const headerSearchBtn = document.getElementById('headerSearchBtn');
            const noSearchProduct = document.getElementById('noSearchProduct');
            const searchKeywordDisplay = document.getElementById('searchKeywordDisplay');
            const resetSearchBtn = document.getElementById('resetSearchBtn');
            const productCountElem = document.querySelector('.product-count');

            // Hàm chuyển chuỗi có dấu thành không dấu
            function removeVietnameseTones(str) {
                if (!str) return '';
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a');
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e');
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i');
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o');
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u');
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y');
                str = str.replace(/đ/g, 'd');
                str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, 'a');
                str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, 'e');
                str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, 'i');
                str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, 'o');
                str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, 'u');
                str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, 'y');
                str = str.replace(/Đ/g, 'd');
                return str.toLowerCase().trim();
            }

            let searchTimeout = null;

            function searchProducts(keyword, shouldScroll = false) {
                keyword = (keyword || '').trim();
                const rawKeyword = keyword.toLowerCase();
                const normKeyword = removeVietnameseTones(keyword);

                // Đồng bộ giá trị 2 ô input
                if (headerSearch && headerSearch.value !== keyword) {
                    headerSearch.value = keyword;
                }
                if (oemInput && oemInput.value !== keyword) {
                    oemInput.value = keyword;
                }

                const products = document.querySelectorAll('.product-card');

                // Nếu ô tìm kiếm trống: Khôi phục hiển thị ban đầu
                if (keyword === '') {
                    products.forEach(function (product) {
                        product.style.display = 'grid';
                        product.classList.remove('search-highlight');
                        product.style.boxShadow = '';
                    });
                    if (noSearchProduct) noSearchProduct.style.display = 'none';
                    if (productCountElem) {
                        productCountElem.textContent = products.length + ' sản phẩm';
                    }
                    return;
                }

                let foundCount = 0;
                let firstMatchingProduct = null;

                products.forEach(function (product) {
                    const rawName = (product.getAttribute('data-name') || '').toLowerCase();
                    const rawCode = (product.getAttribute('data-code') || '').toLowerCase();
                    const rawCategory = (product.getAttribute('data-category') || '').toLowerCase();
                    const rawDesc = (product.getAttribute('data-description') || '').toLowerCase();

                    const normName = removeVietnameseTones(rawName);
                    const normCode = removeVietnameseTones(rawCode);
                    const normCategory = removeVietnameseTones(rawCategory);
                    const normDesc = removeVietnameseTones(rawDesc);

                    const isMatch = rawName.includes(rawKeyword) ||
                                  rawCode.includes(rawKeyword) ||
                                  rawCategory.includes(rawKeyword) ||
                                  rawDesc.includes(rawKeyword) ||
                                  normName.includes(normKeyword) ||
                                  normCode.includes(normKeyword) ||
                                  normCategory.includes(normKeyword) ||
                                  normDesc.includes(normKeyword);

                    if (isMatch) {
                        product.style.display = 'grid';
                        product.classList.add('search-highlight');
                        product.style.boxShadow = '0 0 0 3px #ff9900';
                        if (!firstMatchingProduct) {
                            firstMatchingProduct = product;
                        }
                        foundCount++;
                    } else {
                        product.style.display = 'none';
                        product.classList.remove('search-highlight');
                        product.style.boxShadow = '';
                    }
                });

                // Cập nhật số lượng sản phẩm hiển thị
                if (productCountElem) {
                    productCountElem.textContent = foundCount > 0 ? ('Tìm thấy ' + foundCount + ' sản phẩm') : '0 sản phẩm';
                }

                // Xử lý khi không tìm thấy
                if (foundCount === 0) {
                    if (noSearchProduct) {
                        noSearchProduct.style.display = 'block';
                        if (searchKeywordDisplay) {
                            searchKeywordDisplay.textContent = keyword;
                        }
                    }

                    // Nếu người dùng bấm Tra cứu/Enter mà trên DOM không có (có thể do đang ở danh mục khác)
                    if (shouldScroll) {
                        const urlParams = new URLSearchParams(window.location.search);
                        const currentCat = urlParams.get('category');
                        if (currentCat && currentCat !== 'all') {
                            // Chuyển hướng sang tìm kiếm trên toàn bộ hệ thống
                            window.location.href = "{{ url('/') }}?search=" + encodeURIComponent(keyword);
                            return;
                        }
                        // Cuộn xuống thông báo không tìm thấy
                        if (noSearchProduct) {
                            noSearchProduct.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                } else {
                    if (noSearchProduct) noSearchProduct.style.display = 'none';

                    // Cuộn tới sản phẩm đầu tiên nếu người dùng bấm tìm kiếm
                    if (shouldScroll && firstMatchingProduct) {
                        firstMatchingProduct.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            }

            // Gắn sự kiện Live Search (gõ đến đâu lọc đến đó)
            if (headerSearch) {
                headerSearch.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        searchProducts(headerSearch.value, false);
                    }, 150);
                });

                headerSearch.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchProducts(headerSearch.value, true);
                    }
                });
            }

            if (headerSearchBtn) {
                headerSearchBtn.addEventListener('click', function () {
                    searchProducts(headerSearch ? headerSearch.value : '', true);
                });
            }

            if (oemInput) {
                oemInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        searchProducts(oemInput.value, false);
                    }, 150);
                });

                oemInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchProducts(oemInput.value, true);
                    }
                });
            }

            if (oemSearchBtn) {
                oemSearchBtn.addEventListener('click', function () {
                    searchProducts(oemInput ? oemInput.value : '', true);
                });
            }

            // Nút xem lại tất cả sản phẩm
            if (resetSearchBtn) {
                resetSearchBtn.addEventListener('click', function (e) {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('search') || urlParams.get('category')) {
                        return; // Cho link href tự chuyển trang về home
                    }
                    e.preventDefault();
                    if (headerSearch) headerSearch.value = '';
                    if (oemInput) oemInput.value = '';
                    searchProducts('');
                });
            }

            // Khởi chạy tìm kiếm nếu đã có từ khóa từ URL
            const initialKeyword = "{{ $searchQuery ?? '' }}";
            if (initialKeyword && initialKeyword.trim() !== '') {
                setTimeout(() => {
                    searchProducts(initialKeyword, false);
                }, 200);
            }


            /*
            |--------------------------------------------------------------------------
            | KHI CLICK NAV CATEGORY
            |--------------------------------------------------------------------------
            */

            const categoryLinks =
                document.querySelectorAll(
                    'a[href="#categories"]'
                );

            if (categoryLinks && categoryLinks.length > 0) {
                categoryLinks.forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            setTimeout(function () {

                                const categoriesElement = 
                                    document.getElementById('categories');
                                    
                                if (categoriesElement) {
                                    categoriesElement.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }

                            }, 50);

                        }
                    );

                });
            }


            /*
            |--------------------------------------------------------------------------
            | NAV OEM
            |--------------------------------------------------------------------------
            */

            const oemLinks =
                document.querySelectorAll(
                    'a[href="#search-oem"]'
                );

            if (oemLinks && oemLinks.length > 0) {
                oemLinks.forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            setTimeout(function () {

                                if (oemInput) {
                                    oemInput.focus();
                                }

                            }, 400);

                        }
                    );

                });
            }

        });

    </script>

    @include('layouts.user')
</body>
</html>