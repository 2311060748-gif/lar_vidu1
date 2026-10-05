<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Gửi tin nhắn từ User tới Admin kèm phản hồi tự động (Auto-reply bot)
     */
    public function send(Request $request)
    {
        // 1. Lấy nội dung từ request JSON
        $messageText = $request->input('message');

        // 2. Kiểm tra nội dung trống
        if (empty(trim($messageText))) {
            return response()->json(['error' => 'Nội dung tin nhắn không được để trống'], 400);
        }

        // 3. Xác định Admin nhận tin
        // Ưu tiên tìm user có role là admin, nếu không thấy thì mặc định lấy ID 1
        $admin = User::where('role', 'admin')->first();
        $receiverId = $admin ? $admin->id : 1;
        $userId = Auth::id();

        try {
            // 4. Lưu tin nhắn của User vào Database
            $userMessage = Message::create([
                'sender_id' => $userId,
                'receiver_id' => $receiverId,
                'content' => $messageText,
                'is_read' => false,
            ]);

            // 5. CHAT TỰ ĐỘNG (Auto-reply bot): Phản hồi tự động từ Admin/Bot
            $autoReplyContent = $this->getAutoReply($messageText, $userId);
            if ($autoReplyContent) {
                Message::create([
                    'sender_id' => $receiverId, // Gửi với tư cách Tư vấn viên / Shop
                    'receiver_id' => $userId,
                    'content' => $autoReplyContent,
                    'is_read' => false,
                ]);
            }

            // Trả về dữ liệu tin nhắn vừa tạo để Frontend hiển thị
            return response()->json($userMessage);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể gửi tin nhắn: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Lấy lịch sử chat giữa User hiện tại và Admin
     */
    public function getMessages()
    {
        $userId = Auth::id();

        // Tìm Admin để lọc tin nhắn qua lại
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        // Lấy toàn bộ hội thoại giữa 2 người
        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($userId, $adminId) {
                // Tin nhắn User gửi cho Admin
                $q->where('sender_id', $userId)
                    ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                // Tin nhắn Admin phản hồi cho User
                $q->where('sender_id', $adminId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc') // Sắp xếp theo thứ tự thời gian tăng dần
            ->get();

        return response()->json($messages);
    }

    /**
     * Tạo câu trả lời tự nhiên như người thật đang tư vấn cho khách
     */
    protected function getAutoReply($text, $userId = null)
    {
        $textLower = mb_strtolower(trim($text), 'UTF-8');

        // 1. Khách hỏi kiểm tra đơn hàng của mình
        if (preg_match('/(đơn hàng|mã đơn|kiểm tra đơn|đơn của|giao tới đâu|khi nào tới|gửi chưa|đặt hàng)/i', $textLower)) {
            if ($userId) {
                $latestOrder = \App\Models\Order::where('user_id', $userId)->latest()->first();
                if ($latestOrder) {
                    $statusText = match ($latestOrder->status) {
                        'completed' => 'Đã hoàn thành',
                        'cancelled' => 'Đã hủy',
                        'processing' => 'Đang đóng gói xử lý',
                        default => 'Đang chờ xác nhận'
                    };
                    $shippingText = $latestOrder->shipping_status ? " (Vận chuyển: {$latestOrder->shipping_status})" : '';
                    $orderCode = $latestOrder->ghn_order_code ? " - Mã vận đơn GHN: {$latestOrder->ghn_order_code}" : '';
                    
                    return "Dạ em kiểm tra thấy đơn hàng gần nhất của mình là #{$latestOrder->id}, tổng tiền " . number_format($latestOrder->total_price, 0, ',', '.') . "đ hiện {$statusText}{$shippingText}{$orderCode} ạ. Bên em đang đóng gói thật cẩn thận để gửi sớm nhất đến tay anh/chị nhé!";
                }
            }
            return "Dạ em vừa kiểm tra thì hiện tại tài khoản của mình chưa có đơn hàng nào vừa đặt ạ. Anh/chị cứ chọn phụ tùng rồi đặt hàng, shop sẽ gọi xác nhận và gửi hỏa tốc cho mình liền nha!";
        }

        // 2. Khách hỏi về sản phẩm cụ thể (tra cứu CSDL thực tế để báo kho và giá như nhân viên thật tra kho)
        $productKeywords = [
            'má phanh' => 'má phanh',
            'bố thắng' => 'má phanh',
            'lọc gió' => 'lọc gió',
            'bugi' => 'bugi',
            'nhông' => 'nhông',
            'sên' => 'sên',
            'xích' => 'sên',
            'nhớt' => 'nhớt',
            'dầu nhớt' => 'nhớt',
            'dây curoa' => 'curoa',
            'curoa' => 'curoa',
            'đèn' => 'đèn',
            'pha' => 'đèn',
            'gương' => 'gương',
            'kính' => 'gương',
            'lốp' => 'lốp',
            'vỏ' => 'vỏ',
            'bình' => 'ắc quy',
            'ắc quy' => 'ắc quy',
            'pô' => 'pô',
            'tay thắng' => 'tay thắng',
            'phuộc' => 'phuộc'
        ];

        foreach ($productKeywords as $word => $searchKey) {
            if (mb_strpos($textLower, $word) !== false) {
                // Query Database thực tế
                $foundProducts = \App\Models\Product::where('is_active', true)
                    ->where('name', 'like', "%{$searchKey}%")
                    ->take(3)
                    ->get();

                if ($foundProducts->isNotEmpty()) {
                    $productList = [];
                    foreach ($foundProducts as $prod) {
                        $priceStr = number_format($prod->discount_price ?? $prod->price, 0, ',', '.') . 'đ';
                        $productList[] = "• {$prod->name} - Giá: {$priceStr}";
                    }
                    $listText = implode("\n", $productList);
                    
                    $replies = [
                        "Dạ bên em đang có sẵn các mã này tại kho nè anh/chị ơi:\n{$listText}\nAnh/chị đang đi xe gì (Wave, Vision, Exciter, Air Blade...) để em lựa đúng đời cho mình nhé ạ!",
                        "Dạ món này bên em có sẵn hàng chính hãng nha anh/chị! Em gửi mình giá tham khảo một số mẫu shop đang có sẵn:\n{$listText}\nAnh/chị cần em hỗ trợ thêm thông số dòng nào cứ nhắn em tư vấn nha!"
                    ];
                    return $replies[array_rand($replies)];
                }
            }
        }

        // 3. Khách hỏi về dòng xe cụ thể
        $bikeMatches = [
            'vision' => 'Honda Vision',
            'air blade' => 'Honda Air Blade',
            'airblade' => 'Honda Air Blade',
            'ab' => 'Honda Air Blade',
            'lead' => 'Honda Lead',
            'sh' => 'Honda SH',
            'wave' => 'Honda Wave',
            'blade' => 'Honda Blade',
            'future' => 'Honda Future',
            'exciter' => 'Yamaha Exciter',
            'ex' => 'Yamaha Exciter',
            'winner' => 'Honda Winner',
            'sirius' => 'Yamaha Sirius',
            'jupiter' => 'Yamaha Jupiter',
            'vario' => 'Honda Vario',
            'nvx' => 'Yamaha NVX',
            'grande' => 'Yamaha Grande',
            'janus' => 'Yamaha Janus'
        ];

        foreach ($bikeMatches as $bikeKey => $bikeName) {
            if (preg_match('/\b' . preg_quote($bikeKey, '/') . '\b/i', $textLower)) {
                $bikeReplies = [
                    "Dạ dòng xe {$bikeName} bên em có đầy đủ phụ tùng bảo dưỡng (lọc gió, bugi, nhớt máy, má phanh, nhông sên dĩa/curoa) và đồ chơi kiểng chính hãng luôn ạ. Xe mình đang cần thay mới phụ tùng gì thế anh/chị?",
                    "Dạ phụ kiện cho xe {$bikeName} bên em có sẵn nhiều loại lắm ạ! Anh/chị đang cần tìm đồ bảo dưỡng định kỳ hay món nào nhắn em gửi chi tiết cho mình tham khảo nhé!"
                ];
                return $bikeReplies[array_rand($bikeReplies)];
            }
        }

        // 4. Khách hỏi còn hàng / có sẵn không
        if (preg_match('/(còn hàng|có sẵn|hết hàng|còn không|còn mẫu)/i', $textLower)) {
            $stockReplies = [
                "Dạ các mặt hàng trên web bên em hầu hết đều có sẵn tại kho nha anh/chị. Anh/chị đang quan tâm mẫu nào để em kiểm tra số lượng và giữ hàng cho mình ngay ạ!",
                "Dạ hàng bên em luôn có sẵn sẵn sàng đóng gói giao liền cho mình ạ! Anh/chị cần lấy món nào nhắn tên em hỗ trợ chốt đơn cho mình nhé!"
            ];
            return $stockReplies[array_rand($stockReplies)];
        }

        // 5. Khách hỏi giá cả / chi phí
        if (preg_match('/(giá|nhiêu|bao tiền|báo giá|chi phí|mắc|rẻ|đắt)/i', $textLower)) {
            $priceReplies = [
                "Dạ tất cả phụ tùng bên em đều niêm yết giá công khai và cam kết hàng chính hãng giá tốt nhất thị trường ạ. Anh/chị đang cần hỏi giá món phụ tùng nào hoặc dòng xe gì cứ nhắn em tra kho báo liền cho mình nha!",
                "Dạ giá bên em là giá chuẩn chính hãng cạnh tranh nhất luôn ạ. Anh/chị đang tính lấy món nào nhắn em báo giá chi tiết cho mình nhé!"
            ];
            return $priceReplies[array_rand($priceReplies)];
        }

        // 6. Vận chuyển / Phí ship / Giao hàng / GHN
        if (preg_match('/(ship|giao hàng|vận chuyển|nhận hàng|bao lâu|ghn|phí giao|phí ship)/i', $textLower)) {
            $shipReplies = [
                "Dạ bên em gửi hàng qua Giao Hàng Nhanh (GHN) trên toàn quốc nha anh/chị. Thời gian nhận hàng chỉ tầm 1 - 3 ngày tùy tỉnh thành. Phí ship rất rẻ chỉ từ 20k - 35k thôi ạ, đặc biệt khi shipper tới anh/chị được mở hộp kiểm tra đúng mẫu đúng hàng rồi mới thanh toán nên mình hoàn toàn yên tâm nhé ạ!",
                "Dạ shop ship tận nơi toàn quốc qua GHN tầm 1 - 3 ngày là mình nhận được rồi ạ. Lúc nhận hàng anh/chị cứ mở ra kiểm tra ưng ý mới gửi tiền shipper nha!"
            ];
            return $shipReplies[array_rand($shipReplies)];
        }

        // 7. Thanh toán / COD / MoMo
        if (preg_match('/(thanh toán|momo|cod|tiền mặt|chuyển khoản|trả tiền|thẻ|ngân hàng)/i', $textLower)) {
            return "Dạ bên em có 2 hình thức thanh toán rất thuận tiện:\n1. Thanh toán tiền mặt khi nhận hàng (Ship COD) - được kiểm hàng thoải mái trước khi trả tiền.\n2. Thanh toán online qua Ví điện tử MoMo siêu nhanh và bảo mật.\nAnh/chị thấy cách nào tiện nhất cho mình thì chọn lúc đặt hàng giúp em nha!";
        }

        // 8. Bảo hành / Đổi trả / Hàng chính hãng
        if (preg_match('/(bảo hành|đổi trả|lỗi|hỏng|bể|vỡ|hàng lỗi|chính hãng|uy tín|fake|nhái)/i', $textLower)) {
            return "Dạ anh/chị yên tâm 100% nha, đồ bên em bán toàn bộ là hàng chính hãng nhập trực tiếp từ nhà sản xuất, bảo hành từ 6 đến 12 tháng. Nếu nhận hàng không may bị lỗi sản xuất hoặc không đúng mẫu, shop hỗ trợ 1 đổi 1 miễn phí tận nhà trong vòng 7 ngày đầu luôn cho mình nhé!";
        }

        // 9. Giờ làm việc / Hotline / Địa chỉ shop
        if (preg_match('/(địa chỉ|ở đâu|cửa hàng|hotline|số điện thoại|sđt|liên hệ|mấy giờ|qua xem)/i', $textLower)) {
            return "Dạ cửa hàng bên em mở cửa từ 8:00 sáng đến 21:00 tối các ngày trong tuần ạ.\nHotline / Zalo hỗ trợ khách hàng: 1900 6868.\nAnh/chị có thể ghé trực tiếp shop hoặc để em gửi ship tận nơi cho tiện nha!";
        }

        // 10. Chào hỏi / Bắt đầu trò chuyện
        if (preg_match('/(chào|hello|hi\b|alo|hey|ad ơi|admin ơi|shop ơi|ad|shop)/i', $textLower)) {
            $greetings = [
                "Dạ em chào anh/chị ạ! Em có thể hỗ trợ gì cho xế yêu của mình hôm nay thế ạ? 😊",
                "Dạ shop em chào anh/chị! Không biết anh/chị đang cần tìm phụ tùng cho dòng xe nào ạ, nhắn em tư vấn cho mình liền nhé!",
                "Dạ em đây ạ! Em có thể giúp gì cho anh/chị về phụ tùng hay đơn hàng không ạ? 😊"
            ];
            return $greetings[array_rand($greetings)];
        }

        // 11. Cảm ơn / Tạm biệt / Phản hồi tích cực
        if (preg_match('/(cảm ơn|thank|tks|bye|tạm biệt|ok|oke|dạ vâng|rồi|được rồi|nha shop)/i', $textLower)) {
            $thanks = [
                "Dạ hổng có chi đâu nè! 😊 Anh/chị cần hỗ trợ gì thêm cứ nhắn em nha. Chúc anh/chị lái xe an toàn và một ngày thật nhiều niềm vui ạ! ❤️",
                "Dạ vâng ạ, có bất kỳ thắc mắc nào anh/chị cứ nhắn lại ở đây em hỗ trợ liền nhé! Em cảm ơn anh/chị nhiều ạ! ❤️",
                "Dạ em chúc anh/chị một ngày tốt lành và lái xe an toàn ạ! Cần tư vấn thêm món nào cứ ới em nha! 😊"
            ];
            return $thanks[array_rand($thanks)];
        }

        // 12. Phản hồi mặc định tự nhiên như người trực chat (không robot, không icon bot)
        $defaultReplies = [
            "Dạ em nghe đây ạ! Anh/chị đang chạy xe gì và muốn tìm món phụ tùng nào, cứ nhắn rõ giúp em để em tra kho tư vấn chuẩn bài cho mình nhé! 😊",
            "Dạ vâng anh/chị ơi! Em đang trực tin nhắn đây ạ, mình cần shop hỗ trợ phụ tùng hay kiểm tra đơn hàng gì nhắn em hỗ trợ ngay nha!",
            "Dạ em đây ạ! Anh/chị đang cần phụ tùng bảo dưỡng hay đồ nâng cấp cho dòng xe nào thế ạ? Cứ nhắn em tư vấn liền cho mình nhé! 😊"
        ];
        return $defaultReplies[array_rand($defaultReplies)];
    }
}
