<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieBookingController extends Controller
{
    /**
     * Danh sách các bộ phim đang chiếu
     */
    protected $movies = [
        'Mai (Trấn Thành)',
        'Lật Mặt 7: Một Điều Ước',
        'Dune: Part Two (Hành Tinh Cát 2)',
        'Kung Fu Panda 4',
        'Godzilla x Kong: The New Empire',
        'Avengers: Endgame',
        'Thám Tử Lừng Danh Conan'
    ];

    /**
     * Hiển thị Form Đặt vé xem phim
     */
    public function showForm()
    {
        $movies = $this->movies;
        $minDate = Carbon::today()->format('Y-m-d');

        return view('movie-booking', compact('movies', 'minDate'));
    }

    /**
     * Xử lý xác thực dữ liệu và đặt vé
     */
    public function processBooking(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');

        // Danh sách thông báo lỗi theo đúng yêu cầu đề bài
        $messages = [
            'movie_name.required' => 'Movie Name không được để trống.',
            'booking_date.required' => 'Ngày không hợp lệ (phải là ngày hiện tại hoặc sau).',
            'booking_date.date' => 'Ngày không hợp lệ (phải là ngày hiện tại hoặc sau).',
            'booking_date.after_or_equal' => 'Ngày không hợp lệ (phải là ngày hiện tại hoặc sau).',
            'tickets.required' => 'Số vé không hợp lệ (1–10).',
            'tickets.integer' => 'Số vé không hợp lệ (1–10).',
            'tickets.min' => 'Số vé không hợp lệ (1–10).',
            'tickets.max' => 'Số vé không hợp lệ (1–10).',
            'email.required' => 'Email không được để trống hoặc sai định dạng.',
            'email.email' => 'Email không được để trống hoặc sai định dạng.',
        ];

        // Quy tắc kiểm tra tính hợp lệ
        $validated = $request->validate([
            'movie_name' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:' . $today,
            'tickets' => 'required|integer|min:1|max:10',
            'email' => 'required|email',
        ], $messages);

        return redirect()->back()
            ->withInput()
            ->with('success', 'Đặt vé thành công')
            ->with('booking_details', $validated);
    }
}
