<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đặt vé xem phim (Movie Ticket Booking Form)</title>
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #e50914;
            --primary-hover: #b80710;
            --primary-light: #fff0f1;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            --card-bg: rgba(255, 255, 255, 0.98);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --error-color: #dc2626;
            --error-bg: #fef2f2;
            --success-color: #16a34a;
            --success-bg: #f0fdf4;
            --radius: 12px;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--bg-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--text-main);
        }

        .booking-wrapper {
            width: 100%;
            max-width: 520px;
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            padding: 28px 32px;
            text-align: center;
            position: relative;
        }

        .card-header .icon-badge {
            width: 56px;
            height: 56px;
            background: var(--primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(229, 9, 20, 0.4);
        }

        .card-header h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .card-header p {
            font-size: 13.5px;
            color: #94a3b8;
        }

        .card-body {
            padding: 32px;
        }

        /* Success Alert */
        .alert-success {
            background-color: var(--success-bg);
            border: 1px solid #bbf7d0;
            color: var(--success-color);
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 600;
            animation: slideDown 0.3s ease;
        }

        .alert-success i {
            font-size: 20px;
        }

        /* Error Summary Box (if any errors exist) */
        .alert-danger {
            background-color: var(--error-bg);
            border: 1px solid #fecaca;
            color: var(--error-color);
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-danger ul {
            margin-left: 20px;
            margin-top: 6px;
        }

        .alert-danger li {
            margin-bottom: 4px;
        }

        /* Ticket Confirmation Card */
        .ticket-receipt {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .ticket-receipt-title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ticket-receipt-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .ticket-receipt-row:last-child {
            border-bottom: none;
        }

        .ticket-receipt-label {
            color: #64748b;
        }

        .ticket-receipt-value {
            font-weight: 600;
            color: #0f172a;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .form-group label span.required {
            color: var(--error-color);
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.prefix-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 40px;
            font-size: 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            background-color: #fff;
            color: var(--text-main);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
            background-color: #fffbfa;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 12px 10px;
            padding-right: 36px;
        }

        .error-message {
            color: var(--error-color);
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background-color: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 26px;
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.3);
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(229, 9, 20, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="booking-wrapper">
        <!-- Header -->
        <div class="card-header">
            <div class="icon-badge">
                <i class="fa-solid fa-film"></i>
            </div>
            <h1>Form Đặt Vé Xem Phim</h1>
            <p>Movie Ticket Booking Form</p>
        </div>

        <!-- Body -->
        <div class="card-body">

            {{-- Thông báo thành công theo yêu cầu --}}
            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>

                {{-- Chi tiết vé vừa đặt thành công --}}
                @if(session('booking_details'))
                    @php $details = session('booking_details'); @endphp
                    <div class="ticket-receipt">
                        <div class="ticket-receipt-title">
                            <i class="fa-solid fa-ticket"></i> Thông tin vé đã đặt:
                        </div>
                        <div class="ticket-receipt-row">
                            <span class="ticket-receipt-label">Phim:</span>
                            <span class="ticket-receipt-value">{{ $details['movie_name'] }}</span>
                        </div>
                        <div class="ticket-receipt-row">
                            <span class="ticket-receipt-label">Ngày xem:</span>
                            <span class="ticket-receipt-value">{{ date('d/m/Y', strtotime($details['booking_date'])) }}</span>
                        </div>
                        <div class="ticket-receipt-row">
                            <span class="ticket-receipt-label">Số vé:</span>
                            <span class="ticket-receipt-value">{{ $details['tickets'] }} vé</span>
                        </div>
                        <div class="ticket-receipt-row">
                            <span class="ticket-receipt-label">Email nhận vé:</span>
                            <span class="ticket-receipt-value">{{ $details['email'] }}</span>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Danh sách thông báo lỗi tổng quan nếu có lỗi --}}
            @if ($errors->any())
                <div class="alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Đặt vé -->
            <form action="{{ route('movie.booking.submit') }}" method="POST" id="bookingForm" novalidate>
                @csrf

                <!-- 1. Movie Name: chọn từ danh sách (không được để trống) -->
                <div class="form-group">
                    <label for="movie_name">
                        Movie Name (Tên phim) <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-clapperboard prefix-icon"></i>
                        <select name="movie_name" id="movie_name" class="form-control @error('movie_name') is-invalid @enderror">
                            <option value="">-- Chọn phim từ danh sách --</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie }}" {{ old('movie_name') == $movie ? 'selected' : '' }}>
                                    {{ $movie }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('movie_name')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- 2. Date: không được để trống, phải lớn hơn hoặc bằng ngày hiện tại -->
                <div class="form-group">
                    <label for="booking_date">
                        Date (Ngày xem phim) <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-calendar-days prefix-icon"></i>
                        <input 
                            type="date" 
                            name="booking_date" 
                            id="booking_date" 
                            class="form-control @error('booking_date') is-invalid @enderror" 
                            value="{{ old('booking_date', $minDate ?? date('Y-m-d')) }}"
                            min="{{ $minDate ?? date('Y-m-d') }}"
                        >
                    </div>
                    <div class="form-hint">Ngày đặt phải từ ngày hôm nay trở đi.</div>
                    @error('booking_date')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- 3. Number of Tickets: không được để trống, giá trị từ 1 đến 10 -->
                <div class="form-group">
                    <label for="tickets">
                        Number of Tickets (Số lượng vé: 1 - 10) <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-ticket-simple prefix-icon"></i>
                        <input 
                            type="number" 
                            name="tickets" 
                            id="tickets" 
                            class="form-control @error('tickets') is-invalid @enderror" 
                            placeholder="Nhập số lượng vé (1 - 10)"
                            value="{{ old('tickets', 1) }}"
                            min="1" 
                            max="10"
                        >
                    </div>
                    @error('tickets')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- 4. Email: không được để trống, đúng định dạng email -->
                <div class="form-group">
                    <label for="email">
                        Email (Email người đặt) <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope prefix-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="ví dụ: nguyenvana@gmail.com"
                            value="{{ old('email') }}"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i> Đặt Vé Ngay
                </button>
            </form>

        </div>
    </div>

</body>
</html>
