import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from report_styles import (
    add_p, add_heading_1, add_heading_2, add_heading_3, add_heading_4, 
    add_bullet, add_table_styled, add_diagram_box, COLOR_PRIMARY, COLOR_SECONDARY, COLOR_TEXT
)

def build_chapter_5(doc):
    add_heading_1(doc, "CHƯƠNG 5. THIẾT KẾ GIAO DIỆN VÀ THÀNH PHẦN")
    
    # -------------------------------------------------------------
    # 5.1. Thiết kế giao diện
    # -------------------------------------------------------------
    add_heading_2(doc, "5.1. Thiết kế giao diện")
    
    add_heading_3(doc, "5.1.1. Nguyên tắc thiết kế giao diện")
    add_p(doc,
        "Giao diện người dùng (User Interface - UI) và Trải nghiệm người dùng (User Experience - UX) là điểm chạm trực tiếp "
        "giữa khách hàng mua phụ tùng xe máy với toàn bộ hệ thống kỹ thuật ngầm. Một hệ thống có kiến trúc mạnh mẽ đến đâu cũng sẽ bị người dùng "
        "quay lưng nếu giao diện rườm rà, khó tra cứu mã phụ tùng hoặc luồng thanh toán gây nhầm lẫn. "
        "Giao diện của hệ thống MotoParts được thiết kế tuân thủ nghiêm ngặt 10 nguyên lý công thái học giao diện (Usability Heuristics) "
        "kinh điển của Jakob Nielsen (Nielsen Norman Group):"
    )

    heuristics_data = [
        ("Nguyên lý Heuristic", "Giải pháp thiết kế ứng dụng cụ thể trong Hệ thống MotoParts"),
        ("1. Trạng thái hệ thống rõ ràng (Visibility of system status)", "Khi khách hàng thêm phụ tùng vào giỏ hoặc bấm 'Thanh toán MoMo', nút bấm hiển thị icon loading xoay tròn; các thông báo Flash Session màu xanh 'Thêm giỏ hàng thành công' hoặc cảnh báo đỏ nổi bật ngay đầu trang."),
        ("2. Khớp với thế giới thực (Match between system and real world)", "Sử dụng các thuật ngữ chuyên ngành xe máy thân thuộc: 'Mã OEM', 'Má phanh trước/sau', 'Nhông sên dĩa', 'Lọc gió', 'Bugi chân dài', 'Dòng xe tương thích (Air Blade, Wave, Exciter)' thay vì dùng thuật ngữ kỹ thuật chung chung."),
        ("3. Người dùng nắm quyền kiểm soát (User control and freedom)", "Khách hàng có thể dễ dàng xóa hoặc thay đổi số lượng từng linh kiện trong Giỏ hàng, quay lại trang trước mà không bị mất dữ liệu địa chỉ đã nhập nhờ cơ chế `withInput()` của Laravel."),
        ("4. Nhất quán và theo chuẩn mực (Consistency and standards)", "Toàn bộ hệ thống sử dụng chung một bảng màu nhận diện thương hiệu (Xanh Navy #1E3A8A làm chủ đạo, Cam phụ tùng #F97316, Đỏ cảnh báo); nút bấm hành động chính (Thêm giỏ hàng, Đặt hàng) luôn nằm ở vị trí góc dưới bên phải nổi bật."),
        ("5. Phòng ngừa lỗi xảy ra (Error prevention)", "Trong form đặt hàng, ô số điện thoại giới hạn 10 số; kiểm tra số lượng mua không được vượt quá số lượng phụ tùng thực tế còn trong kho (`stock`); vô hiệu hóa nút 'Đặt hàng' khi giỏ hàng trống."),
        ("6. Nhận biết thay vì nhớ lại (Recognition rather than recall)", "Danh mục phụ tùng được trực quan hóa bằng hình ảnh chụp thực tế sản phẩm; khi vào giỏ hàng hoặc trang thanh toán, ảnh và tên linh kiện kèm giá tiền luôn hiển thị rõ để khách hàng không cần phải ghi nhớ."),
        ("7. Linh hoạt và sử dụng hiệu quả (Flexibility and efficiency)", "Hỗ trợ thanh tìm kiếm nhanh theo tên linh kiện hoặc mã OEM phụ tùng, đồng thời có thanh lọc danh mục theo từng cụm chi tiết máy (Má phanh, Lọc gió, Bugi, Đèn, Gương) cho khách hàng duyệt nhanh."),
        ("8. Thẩm mỹ và thiết kế tối giản (Aesthetic and minimalist design)", "Giao diện tuân thủ quy tắc khoảng trắng (Whitespace), loại bỏ toàn bộ các banner quảng cáo gây nhiễu; thẻ sản phẩm thiết kế dạng Card phẳng, tập trung vào ảnh linh kiện, giá và nút mua."),
        ("9. Nhận biết và khắc phục lỗi (Help users recognize errors)", "Các thông báo lỗi Validation hiển thị bằng tiếng Việt rõ ràng, chỉ đích danh trường bị sai: 'Vui lòng nhập địa chỉ nhận phụ tùng', 'Số lượng vượt quá tồn kho' kèm viền đỏ bao quanh ô nhập liệu."),
        ("10. Trợ giúp và tài liệu hướng dẫn (Help and documentation)", "Tích hợp tính năng Chat trực tuyến (Live Chat) cố định ở góc màn hình cho phép khách hàng hỏi đáp trực tiếp với thợ kỹ thuật về đời xe của mình trước khi quyết định bấm đặt mua phụ tùng.")
    ]
    add_table_styled(doc, ["10 Nguyên lý Usability Heuristics của Nielsen", "Hiện thực hóa trong Giao diện MotoParts"], heuristics_data, [Inches(2.5), Inches(4.7)], "Bảng 5.1: Ứng dụng 10 nguyên lý Heuristics của Nielsen vào thiết kế giao diện phụ tùng")

    add_heading_3(doc, "5.1.2. Người dùng và cấu trúc điều hướng")
    add_p(doc,
        "Hệ thống phân chia sơ đồ cây điều hướng (Sitemap & Navigation Structure) thành hai phân hệ độc lập có ranh giới bảo mật:"
    )
    diagram_sitemap = (
        "                                [ MOTOPARTS PORTAL ]\n"
        "                                         |\n"
        "         +-------------------------------+-------------------------------+\n"
        "         | (Khách hàng & Khách vãng lai)                                 | (Quản trị viên - Role: admin)\n"
        "         v                                                               v\n"
        "    [ Trang Chủ (/) ]                                            [ Admin Dashboard (/admin/dashboard) ]\n"
        "         |                                                               |\n"
        "         |-- [ Danh mục Phụ tùng (Má phanh, Bugi, Lọc gió) ]             |-- [ Quản lý Kho Phụ tùng (/admin/products) ]\n"
        "         |-- [ Form Đặt mua nhanh (/movie-booking, /dat-ve) ]            |       |-- Thêm mới / Sửa / Xóa linh kiện\n"
        "         |-- [ Chi tiết Phụ tùng & Mã OEM (/products/{id}) ]             |-- [ Quản lý Đơn hàng (/admin/orders) ]\n"
        "         |-- [ Giỏ hàng (/cart) ]                                        |       |-- Cập nhật trạng thái GHN\n"
        "         |-- [ Thanh toán & Tính phí GHN (/checkout) ]                   |-- [ Quản lý Giao dịch MoMo (/admin/payments) ]\n"
        "         |       |-- Thanh toán MoMo / COD                               |-- [ Quản lý Khách hàng (/admin/users) ]\n"
        "         |-- [ Lịch sử Đơn mua phụ tùng (/orders) ]                      |-- [ Bàn điều khiển Chat Tư vấn (/admin/chat) ]\n"
        "         |-- [ Khung Chat tư vấn kỹ thuật trực tuyến ]                   |-- [ Báo cáo Thống kê Doanh số (/admin/reports) ]\n"
        "         |-- [ Đăng nhập / Đăng ký / Xác thực OTP ]                      |"
    )
    add_diagram_box(doc, diagram_sitemap, "Hình 5.1: Sơ đồ Cấu trúc Điều hướng (Sitemap) của Hệ thống MotoParts")

    add_heading_3(doc, "5.1.3. Thiết kế các màn hình")
    add_p(doc, "Dưới đây là mô tả bố cục và đặc tả thiết kế của 4 màn hình trọng tâm trong hệ thống:")
    
    add_p(doc, "1. Màn hình Trang chủ và Tra cứu Danh mục Phụ tùng xe máy (`/`):", bold=True)
    add_p(doc,
        "- Thanh Banner Header: Logo thương hiệu cửa hàng phụ tùng, thanh tìm kiếm thông minh theo tên hoặc mã linh kiện, số hotline kỹ thuật, nút Giỏ hàng (kèm badge hiển thị số lượng linh kiện đang có).\n"
        "- Thanh danh mục ngang: Phân loại theo các nhóm linh kiện xe máy phổ biến nhất:\n"
        "  + 'Tất cả phụ kiện', 'Má phanh / Đĩa', 'Lọc gió / Bugi', 'Nhông sên dĩa', 'Đèn & Xi-nhan', 'Gương / Bao tay'.\n"
        "- Vùng lưới sản phẩm (Product Grid): Hiển thị dạng thẻ Card Responsive (4 cột trên Desktop, 2 cột trên Mobile):\n"
        "  + Ảnh sản phẩm sắc nét, Mã OEM (ví dụ: `06430-KVB-305`), Tên phụ tùng (ví dụ: `Bộ má phanh trước Air Blade 125`), Giá bán niêm yết (VNĐ), nhãn trạng thái 'Còn hàng' và nút 'Thêm vào giỏ hàng'."
    )

    add_p(doc, "2. Màn hình Giỏ hàng phụ tùng xe máy (`/cart`):", bold=True)
    add_p(doc,
        "- Bảng chi tiết giỏ hàng: Cột hình ảnh, Cột tên linh kiện kèm mã OEM, Cột đơn giá, Cột số lượng (hỗ trợ nút tăng/giảm số lượng AJAX), Cột thành tiền và nút Xóa linh kiện (biểu tượng thùng rác màu đỏ).\n"
        "- Khung tóm tắt thanh toán: Hiển thị Tổng tiền tạm tính, thông báo miễn phí đổi trả nếu lỗi từ nhà sản xuất, và nút 'Tiến hành Thanh toán' (Màu xanh đậm)."
    )

    add_p(doc, "3. Màn hình Thanh toán Checkout & Tích hợp GHN (`/checkout`):", bold=True)
    add_p(doc,
        "- Cột trái (Thông tin giao hàng): Nhập họ tên, số điện thoại, chọn Tỉnh/Thành phố, Quận/Huyện, Phường/Xã. Ngay khi chọn xong địa chỉ, hệ thống gọi ngầm API Giao Hàng Nhanh (GHN) để tính toán cước phí vận chuyển bưu chính chính xác và cộng dồn vào hóa đơn.\n"
        "- Lựa chọn phương thức thanh toán: Radio button giữa 'Thanh toán tiền mặt khi nhận hàng (COD)' và 'Thanh toán trực tuyến qua Ví điện tử MoMo' (kèm logo MoMo màu hồng đặc trưng).\n"
        "- Cột phải: Danh sách phụ tùng trong đơn, tiền hàng, tiền ship GHN, tổng thanh toán và nút bấm 'Xác nhận Đặt hàng'."
    )

    add_p(doc, "4. Màn hình Dashboard Quản trị Kho & Đơn hàng Admin (`/admin/orders`, `/admin/products`):", bold=True)
    add_p(doc,
        "- Sidebar điều hướng quản trị cố định bên trái.\n"
        "- Bảng quản lý đơn hàng: Thể hiện mã đơn, tên khách, số điện thoại, tổng tiền, trạng thái thanh toán ('unpaid' / 'paid'), trạng thái giao vận GHN ('delivering', 'delivered'), ngày đặt.\n"
        "- Trang chi tiết đơn hàng: Hiển thị đầy đủ danh sách các linh kiện khách đặt mua, địa chỉ nhận hàng, mã vận đơn GHN, và cho phép Admin cập nhật trạng thái đơn (Pending -> Confirmed -> Completed) chỉ bằng một click chuột."
    )

    add_heading_3(doc, "5.1.4. Thiết kế giao diện với hệ thống ngoài (MoMo, GHN, SMTP)")
    add_p(doc, "Hệ thống MotoParts thiết kế các đầu mút giao tiếp tích hợp chuẩn hóa với các nền tảng dịch vụ ngoài:")
    
    add_p(doc, "1. Giao tiếp Cổng thanh toán MoMo (MoMo Payment API):", bold=True)
    add_bullet(doc, "Phương thức HTTP POST gửi tới endpoint của MoMo (`https://test-payment.momo.vn/v2/gateway/api/create`). Dữ liệu gửi đi định dạng JSON payload chứa các trường: `partnerCode`, `requestId`, `amount`, `orderId`, `orderInfo`, `redirectUrl`, `ipnUrl`, `extraData`, `requestType='captureWallet'`, và chuỗi chữ ký số `signature`.", "Khởi tạo thanh toán (Create Payment Request): ");
    add_bullet(doc, "MoMo gửi dữ liệu ngầm Server-to-Server qua phương thức POST tới endpoint `/api/momo/ipn` của MotoParts. Dữ liệu chứa: `orderId`, `transId`, `resultCode`, `message`, `signature`. MotoParts tiến hành đối soát chữ ký HMAC và phản hồi HTTP 204 No Content hoặc HTTP 200 OK JSON.", "Thông báo thanh toán tức thời (MoMo IPN Webhook): ");

    add_table_styled(doc,
        ["Trường tham số MoMo", "Kiểu dữ liệu", "Ý nghĩa trong giao tiếp tích hợp"],
        [
            ("partnerCode", "String", "Mã định danh đối tác được MoMo cấp riêng cho cửa hàng"),
            ("orderId", "String", "Mã đơn hàng duy nhất trong hệ thống MotoParts (ví dụ: ORDER_1711234567)"),
            ("amount", "Long", "Số tiền thanh toán tiền phụ tùng + phí ship (VNĐ)"),
            ("orderInfo", "String", "Nội dung mô tả đơn hàng hiển thị trên ứng dụng MoMo của khách hàng"),
            ("redirectUrl", "String", "Đường dẫn URL trên website MotoParts để MoMo chuyển hướng khách hàng về sau khi thanh toán"),
            ("ipnUrl", "String", "Đường dẫn Webhook bí mật để máy chủ MoMo gọi thông báo kết quả ngầm"),
            ("signature", "String (Hex)", "Chữ ký băm HMAC-SHA256 bảo đảm tính toàn vẹn và chống giả mạo request")
        ],
        [Inches(1.8), Inches(1.2), Inches(4.2)],
        "Bảng 5.2: Bảng mô tả cấu trúc API tương tác với Cổng thanh toán MoMo"
    )

    add_p(doc, "2. Giao tiếp Dịch vụ Giao Hàng Nhanh (GHN Express API):", bold=True)
    add_p(doc,
        "Sử dụng giao thức HTTPS RESTful API trao đổi dữ liệu với máy chủ GHN. Header request đính kèm `Token: <GHN_API_KEY>` "
        "và `ShopId: <GHN_SHOP_ID>`. Endpoint `/shiip/public-api/v2/shipping-order/fee` tiếp nhận tọa độ quận/huyện người nhận "
        "và khối lượng gói phụ tùng để tính cước phí vận chuyển chính xác đến từng đồng."
    )

    add_p(doc, "3. Giao tiếp Máy chủ Thư điện tử (SMTP Mail Gateway):", bold=True)
    add_p(doc,
        "Hệ thống tích hợp thư viện `PHPMailer` / `Illuminate\\Mail` giao tiếp qua giao thức SMTP (cổng 587 TLS) kết nối tới "
        "máy chủ Gmail SMTP Server để gửi các email chứa mã OTP kích hoạt tài khoản và hóa đơn phụ tùng điện tử."
    )

    # -------------------------------------------------------------
    # 5.2. Thiết kế thành phần
    # -------------------------------------------------------------
    add_heading_2(doc, "5.2. Thiết kế thành phần")
    
    add_heading_3(doc, "5.2.1. Phạm vi và mục tiêu thiết kế thành phần")
    add_p(doc,
        "Thiết kế thành phần (Component-Level Design) đi sâu vào việc định nghĩa các giao diện trừu tượng (Interfaces), "
        "cấu trúc thuật toán nội bộ và luồng tương tác chi tiết giữa các đối tượng để hiện thực hóa các ca sử dụng đã đặc tả."
    )

    add_heading_3(doc, "5.2.2. Interface của các thành phần")
    add_p(doc,
        "Để đảm bảo nguyên tắc Đảo ngược phụ thuộc (DIP) và Phân tách giao diện (ISP) của SOLID, các Interface "
        "được định nghĩa độc lập làm giao kèo (Contracts) giữa các tầng:"
    )

    add_diagram_box(doc,
        "namespace App\\Contracts;\n\n"
        "// Giao kèo cho các Cổng thanh toán trực tuyến của cửa hàng phụ tùng\n"
        "interface PaymentGatewayInterface {\n"
        "    public function createPaymentUrl(Order $order): string;\n"
        "    public function verifyIpnSignature(array $payload): bool;\n"
        "    public function handleIpnCallback(array $payload): PaymentResultDTO;\n"
        "}\n\n"
        "// Giao kèo cho Dịch vụ Logistics Vận chuyển phụ tùng\n"
        "interface ShippingServiceInterface {\n"
        "    public function calculateFee(int $districtId, int $weightGram): float;\n"
        "    public function createShippingOrder(Order $order): string;\n"
        "}\n\n"
        "// Giao kèo cho Hệ thống Chat Tư vấn Kỹ thuật Phụ tùng\n"
        "interface ChatServiceInterface {\n"
        "    public function sendMessage(int $senderId, int $receiverId, string $content): Message;\n"
        "    public function getConversation(int $userId1, int $userId2): Collection;\n"
        "    public function markAsRead(int $messageId): bool;\n"
        "}",
        "Mã nguồn mô tả Interface các dịch vụ nền tảng của hệ thống MotoParts"
    )

    add_heading_3(doc, "5.2.3. Thiết kế tương tác giữa các thành phần")
    add_p(doc,
        "Sự tương tác động giữa các thành phần được thể hiện chi tiết thông qua 3 Sơ đồ tuần tự (Sequence Diagrams) sau:"
    )
    
    add_p(doc, "1. Sơ đồ tuần tự Luồng Tra cứu, Chọn mua phụ tùng và Thanh toán MoMo:", bold=True)
    diagram_seq1 = (
        "Khách hàng        CartCtrl        OrderCtrl       MomoCtrl       MoMo Gateway       MySQL DB\n"
        "    |                 |               |               |               |                 |\n"
        "    |-- [1] Thêm giỏ->|               |               |               |                 |\n"
        "    |   (part_id,qty) |-- [2] Lưu Sess|               |               |                 |\n"
        "    |-- [3] Checkout->|-------------->|               |               |                 |\n"
        "    |                 |               |-- [4] Tạo đơn |               |                 |-- [5] INSERT Order\n"
        "    |                 |               |-- [6] Pay --->|               |                 |\n"
        "    |                 |               |               |-- [7] Hash -->|                 |\n"
        "    |                 |               |               |-- [8] POST -->| Tạo phiên MoMo  |\n"
        "    |                 |               |               |<- [9] payUrl -|                 |\n"
        "    |<- [10] Chuyển hướng tới trang QR MoMo ----------+               |                 |\n"
        "    |\n"
        "    |-- [11] Quét mã QR thanh toán tiền ----------------------------->| Trừ tiền ví     |\n"
        "    |                                                                 |-- [12] POST IPN Webhook\n"
        "    |                                                 |<--------------|   (resultCode=0)|\n"
        "    |                                                 |-- [13] So khớp chữ ký HMAC      |\n"
        "    |                                                 |-- [14] UPDATE Order: 'paid' --->| (ACID Commit)\n"
        "    |                                                 |-- [15] Trừ tồn kho phụ tùng --->| (Stock = Stock - Qty)\n"
        "    |                                                 |-- [16] INSERT Transaction ----->|\n"
        "    |<- [17] Điều hướng về trang Đơn hàng thành công -|"
    )
    add_diagram_box(doc, diagram_seq1, "Hình 5.2: Sơ đồ Tuần tự Luồng Chọn mua phụ tùng và Thanh toán MoMo")

    add_p(doc, "2. Sơ đồ tuần tự Luồng Tính cước phí và tích hợp tạo đơn Giao Hàng Nhanh (GHN):", bold=True)
    diagram_seq2 = (
        "Khách hàng                 Checkout View               GHNController              GHN API Gateway\n"
        "    |                             |                           |                          |\n"
        "    |-- [1] Chọn Tỉnh/Huyện/Xã -->|                           |                          |\n"
        "    |                             |-- [2] AJAX calculateFee ->|                          |\n"
        "    |                             |   (district_id, weight)   |-- [3] Gửi POST Request ->| (Header: Token, ShopId)\n"
        "    |                             |                           |   (Payload: địa chỉ, kg) |-- [4] Tính cước phí\n"
        "    |                             |                           |<- [5] Trả về Phí ship ---|\n"
        "    |                             |<- [6] JSON response ------|\n"
        "    |                             |-- [7] Cộng dồn phí ship vào tổng tiền đơn hàng\n"
        "    |<- [8] Hiển thị tổng thanh toán mới"
    )
    add_diagram_box(doc, diagram_seq2, "Hình 5.3: Sơ đồ Tuần tự Luồng Tính cước phí vận chuyển Giao Hàng Nhanh (GHN)")

    add_p(doc, "3. Sơ đồ tuần tự Luồng Tư vấn Kỹ thuật Phụ tùng Trực tuyến (LiveChat):", bold=True)
    diagram_seq3 = (
        "Khách hàng                 ChatController              Cơ sở dữ liệu            Admin Dashboard (Thợ kỹ thuật)\n"
        "    |                             |                           |                         |\n"
        "    |-- [1] Gửi tin nhắn hỏi ----->|                           |                         |\n"
        "    |   'Má phanh AirBlade có sẵn?'|-- [2] INSERT tin nhắn --->|                         |\n"
        "    |                             |                           |-- [3] Lưu Message       |\n"
        "    |<- [4] Trả về JSON thành công|                           |                         |\n"
        "    |                             |                           |                         |\n"
        "    |                             |                           |<- [5] Polling / SSE ----|\n"
        "    |                             |<-- [6] Có tin nhắn mới ---+                         |\n"
        "    |                             |---------------------------------------------------->| Hiển thị tin nhắn mới\n"
        "    |                             |                                                     | Phát âm thanh chuông báo\n"
        "    |                             |                                                     |\n"
        "    |                             |<-- [7] Thợ gõ câu trả lời kỹ thuật -----------------|\n"
        "    |                             |-- [8] INSERT tin nhắn --->|                         |\n"
        "    |<- [9] Cập nhật tin nhắn ----|                           |"
    )
    add_diagram_box(doc, diagram_seq3, "Hình 5.4: Sơ đồ Tuần tự Luồng Tư vấn Kỹ thuật Phụ tùng Trực tuyến")

    add_heading_3(doc, "5.2.4. Thiết kế chi tiết các thành phần trọng tâm")
    add_p(doc, "Dưới đây là phân tích chi tiết mã nguồn và giải thuật xử lý cốt lõi của các Controller trọng tâm trong dự án:")
    
    add_p(doc, "1. Thành phần ProductController (Quản lý phụ tùng và tồn kho):", bold=True)
    add_p(doc,
        "- `index(Request $request)`: Tiếp nhận tham số lọc danh mục `category` hoặc từ khóa tìm kiếm theo tên hoặc mã OEM (`code`). "
        "Sử dụng Eloquent Query Builder kết hợp phân trang `paginate(12)` để giảm tải dữ liệu truyền qua mạng.\n"
        "- `store(Request $request)`: Thực hiện kiểm tra tính hợp lệ dữ liệu phụ tùng phía Server: tên bắt buộc, giá tiền là số dương, "
        "tồn kho `stock >= 0`. Tự động lưu hình ảnh phụ tùng tải lên vào thư mục `public/uploads` với tên file duy nhất tránh trùng lặp."
    )

    add_p(doc, "2. Thành phần MomoController (Xử lý tích hợp Cổng thanh toán và Mã hóa băm):", bold=True)
    add_p(doc,
        "MomoController đóng vai trò là một Facade tích hợp bảo mật:\n"
        "- Thuật toán tạo chữ ký: Tạo chuỗi ghép `rawHash` theo định dạng chuẩn hóa của MoMo: "
        "`accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet`.\n"
        "- Sử dụng hàm băm mật mã `hash_hmac('sha256', $rawHash, $secretKey)` để tạo chuỗi mã hóa 64 ký tự hex.\n"
        "- Gửi HTTP POST cURL tới máy chủ MoMo và giải mã chuỗi phản hồi JSON.\n"
        "- Tại hàm `momoIpn(Request $request)`: Tiến hành trích xuất chữ ký gửi kèm, tái tạo lại `rawHash` và so khớp băm. "
        "Nếu trùng khớp và `resultCode == 0`, kích hoạt cập nhật trạng thái đơn hàng trong Database Transaction và trừ số lượng tồn kho phụ tùng."
    )

    add_p(doc, "3. Thành phần GHNController (Tính cước vận chuyển bưu chính):", bold=True)
    add_p(doc,
        "Sử dụng cURL gửi HTTP POST tới API GHN mang theo `district_id`, `weight` tổng của các phụ tùng trong giỏ. "
        "Nhận về JSON chứa giá trị cước phí, bọc lại và trả về cho phía giao diện Checkout cập nhật tổng tiền thanh toán."
    )

    add_p(doc, "4. Thành phần ChatController (Tư vấn kỹ thuật thời gian thực):", bold=True)
    add_p(doc,
        "Cung cấp các API RESTful nhẹ cho phép Client gửi tin nhắn `POST /user/chat/send` và truy vấn tin nhắn mới `GET /user/chat/messages`. "
        "Controller lọc các tin nhắn theo cặp `sender_id` và `receiver_id`, sắp xếp tăng dần theo thời gian tạo `created_at`, "
        "và tự động chuyển cờ `is_read = true` khi đối phương mở cửa sổ chat."
    )

    add_heading_3(doc, "5.2.5. Đánh giá thiết kế thành phần")
    add_p(doc,
        "Chất lượng thiết kế của các thành phần trong hệ thống MotoParts được đánh giá dựa trên các chỉ số định lượng kỹ thuật phần mềm:"
    )

    comp_eval = [
        ("Thành phần", "Chỉ số Độ gắn kết (Cohesion)", "Chỉ số Ghép nối (Coupling)", "Đánh giá mức độ độc lập"),
        ("ProductController", "Functional Cohesion (Cao nhất - Chỉ xử lý dữ liệu phụ tùng xe máy)", "Data Coupling (Thấp - Chỉ nhận Request và trả về View/JSON)", "Rất cao: Dễ dàng mở rộng thêm các trường thuộc tính kỹ thuật mới"),
        ("MomoController", "Functional Cohesion (Cao nhất - Đóng gói toàn bộ nghiệp vụ MoMo)", "Loose Coupling (Thấp - Phụ thuộc vào interface tham số đơn)", "Rất cao: Có thể tái sử dụng cho các dự án thương mại điện tử khác"),
        ("OrderController", "Sequential Cohesion (Cao - Phối hợp Giỏ hàng -> Đơn -> Vận chuyển)", "Stamp Coupling (Trung bình - Thao tác trên đối tượng Order Model)", "Tốt: Tách biệt rõ ràng với tầng hiển thị Blade"),
        ("GHNController", "Functional Cohesion (Cao nhất - Chỉ phụ trách giao tiếp API GHN)", "Loose Coupling (Thấp - Chỉ nhận mã huyện và trả về cước phí)", "Rất cao: Độc lập hoàn toàn với cổng thanh toán MoMo"),
        ("ChatController", "Functional Cohesion (Cao nhất - Chỉ quản lý tin nhắn tư vấn)", "Data Coupling (Thấp - Chỉ thao tác trên bảng messages)", "Rất cao: Hoàn toàn không phụ thuộc vào tiến trình đặt hàng")
    ]
    add_table_styled(doc, ["Tên Thành phần", "Độ gắn kết nội tại", "Độ ghép nối liên kết", "Mức độ độc lập mô-đun"], comp_eval, [Inches(1.8), Inches(2.2), Inches(2.0), Inches(1.2)], "Bảng 5.3: Đánh giá đo lường chất lượng thiết kế thành phần hệ thống MotoParts")

    # -------------------------------------------------------------
    # 5.3. Kết luận chương 5
    # -------------------------------------------------------------
    add_heading_2(doc, "5.3. Kết luận chương 5")
    add_p(doc,
        "Chương 5 đã hoàn tất bức tranh thiết kế chi tiết ở mức độ giao diện và thành phần thực thi của hệ thống MotoParts. "
        "Các kết quả nổi bật bao gồm:"
    )
    add_bullet(doc, "Áp dụng thành công 10 nguyên lý Usability Heuristics của Jakob Nielsen vào thiết kế giao diện, tối ưu hóa trải nghiệm tra cứu phụ tùng xe máy và quy trình mua sắm của khách hàng;");
    add_bullet(doc, "Xây dựng sơ đồ cây điều hướng phân cấp trực quan và đặc tả chi tiết 4 màn hình giao diện then chốt (Trang chủ phụ tùng, Giỏ hàng, Checkout GHN/MoMo, Dashboard Admin);");
    add_bullet(doc, "Thiết kế chuẩn hóa các đầu mút tích hợp API với các dịch vụ bên thứ ba (Cổng MoMo, Giao Hàng Nhanh, Máy chủ SMTP);");
    add_bullet(doc, "Khai báo các giao diện trừu tượng (Interfaces) tuân thủ nguyên lý SOLID; mô hình hóa chi tiết sự tương tác động qua 3 Sơ đồ tuần tự (Sequence Diagrams) cho luồng Mua hàng MoMo, Tính cước phí GHN và LiveChat;");
    add_bullet(doc, "Chứng minh các thành phần đạt mức Gắn kết chức năng cao (Functional Cohesion) và Ghép nối lỏng (Loose Coupling), bảo đảm hệ thống dễ bảo trì, dễ mở rộng và kiểm thử tự động đạt độ tin cậy cao.");
    
    doc.add_page_break()
