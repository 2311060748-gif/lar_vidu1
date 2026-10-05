<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieBookingTest extends TestCase
{
    public function test_movie_booking_form_renders_successfully()
    {
        $response = $this->get('/movie-booking');
        $response->assertStatus(200);
        $response->assertSee('Form Đặt Vé Xem Phim');
        $response->assertSee('Movie Ticket Booking Form');
    }

    public function test_movie_booking_validation_errors()
    {
        $response = $this->post('/movie-booking', [
            'movie_name' => '',
            'booking_date' => '2020-01-01',
            'tickets' => '15',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors([
            'movie_name' => 'Movie Name không được để trống.',
            'booking_date' => 'Ngày không hợp lệ (phải là ngày hiện tại hoặc sau).',
            'tickets' => 'Số vé không hợp lệ (1–10).',
            'email' => 'Email không được để trống hoặc sai định dạng.',
        ]);
    }

    public function test_movie_booking_success()
    {
        $response = $this->post('/movie-booking', [
            'movie_name' => 'Mai (Trấn Thành)',
            'booking_date' => date('Y-m-d'),
            'tickets' => '3',
            'email' => 'test@gmail.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', 'Đặt vé thành công');
    }
}
