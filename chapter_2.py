import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from report_styles import (
    add_p, add_heading_1, add_heading_2, add_heading_3, add_heading_4, 
    add_bullet, add_table_styled, add_diagram_box, COLOR_PRIMARY, COLOR_SECONDARY, COLOR_TEXT
)

def build_chapter_2(doc):
    add_heading_1(doc, "CHƯƠNG 2. PHÂN TÍCH YÊU CẦU VÀ THIẾT KẾ MÔ HÌNH")
    
    # -------------------------------------------------------------
    # 2.1. Tổng quan bài toán
    # -------------------------------------------------------------
    add_heading_2(doc, "2.1. Tổng quan bài toán")
    
    add_heading_3(doc, "2.1.1. Bối cảnh và hiện trạng thị trường phụ tùng xe máy")
    add_p(doc,
        "Tại Việt Nam, xe máy chiếm hơn 90% tổng số phương tiện giao thông đường bộ đang lưu hành. "
        "Với điều kiện khí hậu nhiệt đới gió mùa, độ ẩm cao và hạ tầng giao thông đô thị thường xuyên chịu cảnh ùn tắc, "
        "các chi tiết máy trên xe máy bị hao mòn cơ học và giảm sút hiệu năng rất nhanh chóng. "
        "Các nhóm linh kiện hao mòn định kỳ bắt buộc phải thay thế bao gồm: bộ má phanh (bảo đảm an toàn phanh), "
        "lọc gió (bảo vệ buồng đốt khỏi bụi bẩn), bugi (đảm bảo khả năng đánh lửa), bộ nhông sên dĩa (truyền động bánh sau), "
        "hệ thống chiếu sáng đèn pha / xi-nhan, và gương chiếu hậu."
    )
    add_p(doc,
        "Mặc dù nhu cầu thị trường là cực kỳ lớn, mô hình kinh doanh phụ tùng xe máy truyền thống tại các tiệm sửa xe "
        "và đại lý bán lẻ hiện nay đang đối mặt với những vấn đề nhức nhối sau:\n"
        "1. Thiếu tính minh bạch về nguồn gốc và giá cả: Người đi xe máy thường không biết mức giá thực tế của phụ tùng chính hãng, "
        "dễ bị các cửa hàng nhỏ lẻ nâng giá hoặc trà trộn phụ tùng giả, hàng nhái kém chất lượng (ví dụ: bố thắng dỏm dễ mất phanh khi trời mưa).\n"
        "2. Rào cản tra cứu kỹ thuật: Xe máy có hàng trăm dòng xe khác nhau (Honda Air Blade 125, Wave Alpha, Future 125, Vision, SH, Lead; "
        "Yamaha Exciter, Sirius, Grande...). Mỗi đời xe lại sử dụng mã phụ tùng OEM riêng biệt. Khách hàng thông thường rất khó biết phụ tùng nào lắp vừa xe mình.\n"
        "3. Thiếu kênh giao nhận toàn quốc: Người dùng ở vùng sâu vùng xa hoặc các tỉnh thành nhỏ khó tiếp cận được các dòng phụ tùng chính hãng, "
        "trong khi các cửa hàng lớn ở thành phố chưa có giải pháp kết nối tự động với các đơn vị vận chuyển hàng đầu như Giao Hàng Nhanh (GHN).\n"
        "4. Quản lý kho thủ công: Số lượng linh kiện xe máy lên đến hàng nghìn mã (SKU), việc quản lý sổ sách truyền thống dễ dẫn đến thất thoát, "
        "không cảnh báo được khi số lượng tồn kho chạm đáy (out of stock)."
    )

    add_heading_3(doc, "2.1.2. Vấn đề cần giải quyết và mục tiêu hệ thống")
    add_p(doc,
        "Để giải quyết triệt để các thách thức trên, đề tài tập trung xây dựng giải pháp phần mềm tổng thể "
        "'Hệ thống Thương mại Điện tử và Quản lý Cửa hàng Phụ tùng Xe máy Trực tuyến' (MotoParts Store) với các mục tiêu chiến lược sau:"
    )
    add_bullet(doc, "Xây dựng website bán hàng hiện đại, chuyên nghiệp, hiển thị trực quan các danh mục phụ tùng xe máy cốt lõi (Má phanh, Lọc gió, Bugi, Nhông sên dĩa, Đèn & Xi-nhan, Gương & Bao tay) kèm mã phụ tùng OEM chính xác.", "Số hóa danh mục phụ tùng xe máy: ");
    add_bullet(doc, "Hỗ trợ khách hàng thêm các linh kiện phụ tùng vào giỏ hàng, tự động tính tổng tiền, lựa chọn phương thức thanh toán không tiền mặt qua Ví điện tử MoMo hoặc thanh toán khi nhận hàng (COD).", "Tối ưu quy trình Giỏ hàng & Thanh toán số: ");
    add_bullet(doc, "Tích hợp trực tiếp với API của đối tác logistics Giao Hàng Nhanh (GHN) để tính toán cước phí vận chuyển bưu chính chính xác theo địa chỉ phường/xã, quận/huyện của khách hàng trên phạm vi toàn quốc.", "Tự động hóa logistics qua GHN: ");
    add_bullet(doc, "Tích hợp tính năng Chat trực tuyến (LiveChat) giữa khách hàng và nhân viên kỹ thuật cửa hàng ngay trên trang web để tư vấn độ tương thích của phụ tùng trước khi mua.", "Tư vấn kỹ thuật phụ tùng trực tuyến 24/7: ");
    add_bullet(doc, "Cung cấp cho Ban quản trị công cụ quản lý tập trung: Quản lý kho phụ tùng (CRUD sản phẩm, cập nhật tồn kho), Quản trị và duyệt đơn hàng, Theo dõi chi tiết giao dịch MoMo, và Báo cáo thống kê doanh số.", "Tự động hóa quản trị cửa hàng & Báo cáo doanh thu: ");

    add_heading_3(doc, "2.1.3. Phạm vi hệ thống")
    add_p(doc, "Hệ thống MotoParts được phân định trong phạm vi nghiệp vụ và kỹ thuật cụ thể sau:", bold=True)
    add_bullet(doc, "Xem danh sách và chi tiết các loại phụ tùng xe máy; lọc phụ tùng theo danh mục (Má phanh, Lọc gió, Bugi, Nhông xích, Đèn, Gương); sử dụng Form Đặt mua nhanh phụ tùng; quản lý giỏ hàng; nhập thông tin giao nhận và tính phí GHN; thanh toán đơn hàng bằng MoMo hoặc COD; tra cứu lịch sử đơn hàng cá nhân; trò chuyện tư vấn kỹ thuật qua LiveChat.", "Phân hệ Khách hàng (Client Portal): ");
    add_bullet(doc, "Đăng nhập bảo mật; quản lý kho phụ tùng xe máy (thêm mới, chỉnh sửa giá, mã phụ tùng, số lượng tồn kho, hình ảnh minh họa); quản lý danh mục phụ tùng; quản lý và cập nhật trạng thái đơn hàng (Pending -> Confirmed -> Delivering -> Completed -> Cancelled); theo dõi lịch sử giao dịch MoMo; tiếp nhận và phản hồi tin nhắn tư vấn khách hàng; quản lý danh sách người dùng; xem biểu đồ báo cáo doanh số.", "Phân hệ Quản trị viên (Admin Portal): ");
    add_bullet(doc, "Cổng thanh toán điện tử MoMo (MoMo Payment API qua cơ chế Redirect & Webhook IPN); Dịch vụ bưu chính Giao Hàng Nhanh (GHN Express API); Máy chủ thư điện tử (SMTP Server) phục vụ việc gửi mã OTP kích hoạt tài khoản.", "Phân hệ Tích hợp Dịch vụ Ngoài (External Integrations): ");

    # -------------------------------------------------------------
    # 2.2. Yêu cầu chức năng
    # -------------------------------------------------------------
    add_heading_2(doc, "2.2. Yêu cầu chức năng")
    
    add_heading_3(doc, "2.2.1. Danh mục yêu cầu chức năng")
    add_p(doc,
        "Dựa trên khảo sát thực tế quy trình vận hành của cửa hàng phụ tùng xe máy, hệ thống yêu cầu chức năng (Functional Requirements - FR) "
        "được phân loại chi tiết theo từng nhóm tác nhân tương tác:"
    )

    fr_data = [
        ("FR01", "Xem và tra cứu danh mục phụ tùng xe máy", "Khách vãng lai, Khách hàng", "Hiển thị danh sách các phụ tùng theo danh mục (Má phanh, Lọc gió, Bugi, Nhông sên dĩa...), lọc theo mức giá và mã sản phẩm OEM."),
        ("FR02", "Xem chi tiết phụ tùng xe máy", "Khách vãng lai, Khách hàng", "Hiển thị hình ảnh chi tiết, mã phụ tùng (Part Code), dòng xe tương thích, giá bán niêm yết, và số lượng còn trong kho."),
        ("FR03", "Đặt mua nhanh phụ tùng (Quick Booking Form)", "Khách vãng lai, Khách hàng", "Cho phép chọn tên linh kiện, chọn ngày nhận/lắp đặt, nhập số lượng mua (1-10 món), nhập email nhận thông tin đặt hàng."),
        ("FR04", "Đăng ký tài khoản và Xác thực Email OTP", "Khách vãng lai", "Đăng ký tài khoản mới; hệ thống tự động sinh mã OTP 6 chữ số và gửi qua email để kích hoạt tài khoản khách hàng."),
        ("FR05", "Đăng nhập, Đăng xuất và Bảo mật tài khoản", "Người dùng hệ thống", "Xác thực danh tính bằng email và mật khẩu; tự động phân quyền truy cập theo vai trò (Customer hoặc Admin)."),
        ("FR06", "Quản lý Giỏ hàng phụ tùng xe máy", "Khách hàng", "Thêm phụ tùng vào giỏ hàng, cập nhật tăng giảm số lượng mua, xóa từng món hoặc làm trống giỏ hàng; tự động tính tổng tiền hàng."),
        ("FR07", "Tính phí vận chuyển qua API Giao Hàng Nhanh", "Khách hàng", "Khách hàng nhập địa chỉ (Tỉnh/Thành, Quận/Huyện, Phường/Xã), hệ thống tự động gọi API GHN để tính cước phí giao hàng chính xác."),
        ("FR08", "Đặt hàng và Chọn phương thức thanh toán", "Khách hàng", "Xác nhận đơn hàng, chọn phương thức thanh toán: Trả tiền mặt khi nhận hàng (COD) hoặc Thanh toán trực tuyến qua Ví MoMo."),
        ("FR09", "Thanh toán trực tuyến bằng Ví MoMo", "Khách hàng", "Chuyển hướng sang cổng thanh toán MoMo để quét mã QR; tự động nhận kết quả thanh toán tức thời qua cơ chế Webhook IPN."),
        ("FR10", "Theo dõi lịch sử đơn hàng phụ tùng", "Khách hàng", "Xem danh sách các đơn hàng đã đặt, thông tin mã vận đơn GHN, trạng thái thanh toán và chi tiết phụ tùng trong đơn."),
        ("FR11", "Tư vấn kỹ thuật trực tuyến (Live Chat)", "Khách hàng", "Gửi và nhận tin nhắn trực tiếp với nhân viên kỹ thuật cửa hàng để hỏi về độ tương thích phụ tùng với đời xe của mình."),
        ("FR12", "Quản lý kho phụ tùng xe máy (CRUD)", "Quản trị viên (Admin)", "Thêm mới, sửa thông tin, cập nhật đơn giá, cập nhật mã OEM, số lượng tồn kho và tải lên hình ảnh phụ tùng xe máy."),
        ("FR13", "Quản lý và duyệt đơn hàng phụ tùng", "Quản trị viên (Admin)", "Xem toàn bộ đơn hàng trong hệ thống; cập nhật trạng thái đơn (Pending -> Confirmed -> Delivering -> Completed -> Cancelled)."),
        ("FR14", "Bàn điều khiển Chat Hỗ trợ khách hàng", "Quản trị viên (Admin)", "Xem danh sách các cuộc hội thoại chờ tư vấn; trả lời giải đáp thắc mắc kỹ thuật cho từng khách hàng theo thời gian thực."),
        ("FR15", "Thống kê báo cáo doanh số phụ tùng", "Quản trị viên (Admin)", "Thống kê tổng doanh thu theo ngày/tháng, số lượng đơn hàng, top các phụ tùng bán chạy nhất (Má phanh, Bugi, Lọc gió).")
    ]
    add_table_styled(doc, ["Mã FR", "Tên yêu cầu chức năng", "Tác nhân (Actor)", "Mô tả chi tiết nội dung xử lý"], fr_data, [Inches(0.8), Inches(1.8), Inches(1.4), Inches(3.0)], "Bảng 2.1: Danh mục yêu cầu chức năng của Hệ thống Cửa hàng Phụ tùng Xe máy (MotoParts)")

    add_heading_3(doc, "2.2.2. Sơ đồ use case")
    add_p(doc,
        "Hệ thống bao gồm 3 tác nhân chính (Actors) và 2 tác nhân ngoại vi (Secondary Actors):\n"
        "- Khách vãng lai (Guest): Người dùng chưa đăng nhập, có thể tra cứu phụ tùng, đặt mua nhanh, đăng ký tài khoản.\n"
        "- Khách hàng (Customer): Người dùng đã kích hoạt tài khoản qua OTP, có đầy đủ quyền mua sắm, quản lý giỏ hàng, thanh toán MoMo, tính phí GHN, theo dõi đơn và chat tư vấn.\n"
        "- Quản trị viên (Admin): Chủ cửa hàng / Thợ kỹ thuật, quản lý toàn bộ kho phụ tùng, duyệt đơn hàng, chat tư vấn kỹ thuật và xem thống kê doanh thu.\n"
        "- Cổng thanh toán MoMo: Tiếp nhận giao dịch và gửi tín hiệu xác nhận qua Webhook IPN.\n"
        "- Đối tác Giao Hàng Nhanh (GHN): Tiếp nhận thông tin địa chỉ và trả về cước phí vận chuyển bưu chính."
    )

    diagram_usecase = (
        "  +-----------------------------------------------------------------------+\n"
        "  |                   HỆ THỐNG CỬA HÀNG PHỤ TÙNG XE MÁY                   |\n"
        "  |                                                                       |\n"
        "  |   [Tra cứu danh mục phụ tùng xe máy] <----------------+               |\n"
        "  |                                                       |               |\n"
        "  |   [Đặt mua nhanh phụ tùng] <--------------------------+-- (Guest)     |\n"
        "  |            |                                          |               |\n"
        "  |            +-- <<include>> --> [Validate dữ liệu Form]|               |\n"
        "  |                                                       |               |\n"
        "  |   [Đăng ký & Xác thực Email OTP] <--------------------+               |\n"
        "  |                                                       |               |\n"
        "  |   [Đăng nhập / Đăng xuất tài khoản] <-----------------+               |\n"
        "  |                                                       |               |\n"
        "  |   [Quản lý Giỏ hàng phụ tùng] <-----------------------+-- (Customer)  |\n"
        "  |            |                                          |               |\n"
        "  |   [Đặt hàng & Thanh toán] <---------------------------+               |\n"
        "  |            |                                          |               |\n"
        "  |            +-- <<extend>> --> [Thanh toán qua MoMo] --+-> [MoMo API]  |\n"
        "  |            +-- <<include>> -> [Tính cước phí GHN] ----+-> [GHN API]   |\n"
        "  |                                                       |               |\n"
        "  |   [Chat tư vấn kỹ thuật phụ tùng] <-------------------+               |\n"
        "  |                 ^                                     |               |\n"
        "  |                 |                                     |               |\n"
        "  |   [Tiếp nhận & Trả lời tư vấn Chat] <-----------------+-- (Admin)     |\n"
        "  |                                                       |               |\n"
        "  |   [Quản lý Kho phụ tùng & Tồn kho] <------------------+               |\n"
        "  |                                                       |               |\n"
        "  |   [Quản lý Đơn hàng & Giao vận GHN] <-----------------+               |\n"
        "  |                                                       |               |\n"
        "  |   [Thống kê Báo cáo Doanh thu Bán hàng] <-------------+               |\n"
        "  +-----------------------------------------------------------------------+"
    )
    add_diagram_box(doc, diagram_usecase, "Hình 2.1: Sơ đồ Use Case tổng quan của Hệ thống MotoParts")

    add_heading_3(doc, "2.2.3. Đặc tả các use case trọng tâm")
    add_p(doc, "Dưới đây là bảng đặc tả chi tiết 4 Use Case cốt lõi nhất của hệ thống cửa hàng phụ tùng xe máy:")

    # UC01
    add_p(doc, "1. Đặc tả Ca sử dụng UC01: Tra cứu và Đặt mua phụ tùng trực tuyến", bold=True)
    uc01_data = [
        ("Mã Use Case", "UC01"),
        ("Tên Use Case", "Tra cứu và Đặt mua phụ tùng trực tuyến (Parts Ordering & Booking Form)"),
        ("Tác nhân chính", "Khách vãng lai (Guest) hoặc Khách hàng (Customer)"),
        ("Mô tả tóm tắt", "Cho phép người dùng chọn phụ tùng cần mua (Má phanh, Lọc gió, Bugi...), chọn ngày nhận/lắp đặt, nhập số lượng và email để đặt hàng."),
        ("Điều kiện tiên quyết", "Người dùng truy cập vào trang Đặt mua phụ tùng (/movie-booking hoặc /dat-ve). Hệ thống đã có danh sách phụ tùng trong kho."),
        ("Điều kiện sau thành công", "Thông tin đặt phụ tùng được lưu tạm thời vào Session, hiển thị thông báo thành công kèm hóa đơn tóm tắt linh kiện vừa đặt."),
        ("Luồng sự kiện chính (Normal Flow)", 
         "1. Người dùng truy cập biểu mẫu Đặt mua phụ tùng trực tuyến.\n"
         "2. Hệ thống tải danh mục các loại phụ tùng có sẵn và thiết lập ngày tối thiểu là ngày hôm nay.\n"
         "3. Người dùng chọn loại phụ tùng muốn mua (ví dụ: Bộ má phanh trước Air Blade 125, Lọc gió Wave RSX, Bugi NGK...).\n"
         "4. Người dùng chọn ngày nhận hàng hoặc ngày hẹn lắp đặt tại cửa hàng.\n"
         "5. Người dùng nhập số lượng linh kiện cần mua (từ 1 đến 10 món).\n"
         "6. Người dùng nhập địa chỉ email cá nhân để nhận hóa đơn và thông tin phụ tùng.\n"
         "7. Người dùng nhấn nút 'Xác nhận Đặt hàng' (Submit).\n"
         "8. Hệ thống kích hoạt bộ kiểm tra hợp lệ dữ liệu (Form Request Validation):\n"
         "   - Kiểm tra tên linh kiện: Bắt buộc chọn từ danh sách phụ tùng hợp lệ.\n"
         "   - Kiểm tra ngày: Phải có giá trị ngày hợp lệ và >= ngày hiện tại.\n"
         "   - Kiểm tra số lượng: Phải là số nguyên từ 1 đến 10 linh kiện.\n"
         "   - Kiểm tra email: Phải có định dạng thư điện tử hợp lệ theo chuẩn RFC.\n"
         "9. Hệ thống xác nhận dữ liệu hợp lệ, lưu trữ thông tin vào Session flash và chuyển hướng lại trang kèm thông báo 'Đặt vé thành công' (Đặt hàng thành công).\n"
         "10. Giao diện hiển thị Box tóm tắt thông tin chi tiết phụ tùng đã đặt."),
        ("Luồng rẽ nhánh / Ngoại lệ (Exceptions)",
         "4a. Người dùng chọn ngày trong quá khứ:\n"
         "   - Hệ thống hiển thị thông báo lỗi màu đỏ: 'Ngày không hợp lệ (phải là ngày hiện tại hoặc sau).'\n"
         "5a. Người dùng nhập số lượng ngoài khoảng 1-10 (ví dụ: 0 hoặc 15 món):\n"
         "   - Hệ thống hiển thị thông báo lỗi: 'Số vé không hợp lệ (1–10).' (Số lượng không hợp lệ).\n"
         "6a. Người dùng nhập email sai cú pháp:\n"
         "   - Hệ thống hiển thị thông báo lỗi: 'Email không được để trống hoặc sai định dạng.'")
    ]
    add_table_styled(doc, ["Thuộc tính đặc tả", "Nội dung chi tiết"], uc01_data, [Inches(1.8), Inches(5.2)], "Bảng 2.2: Bảng đặc tả chi tiết Ca sử dụng UC01 - Tra cứu và Đặt mua phụ tùng")

    # UC02
    add_p(doc, "2. Đặc tả Ca sử dụng UC02: Thanh toán đơn hàng phụ tùng qua Cổng MoMo", bold=True)
    uc02_data = [
        ("Mã Use Case", "UC02"),
        ("Tên Use Case", "Thanh toán đơn hàng phụ tùng qua Cổng MoMo (MoMo Payment Gateway)"),
        ("Tác nhân chính", "Khách hàng (Customer), Cổng thanh toán MoMo"),
        ("Mô tả tóm tắt", "Khách hàng thanh toán tiền phụ tùng qua Ví MoMo, hệ thống tạo chữ ký điện tử HMAC-SHA256, chuyển hướng quét mã QR và xử lý kết quả tự động qua Webhook IPN."),
        ("Điều kiện tiên quyết", "Khách hàng có đơn hàng ở trạng thái 'pending' với tổng tiền thanh toán hợp lệ (> 1,000 VND)."),
        ("Điều kiện sau thành công", "Đơn hàng chuyển trạng thái thanh toán 'paid', trạng thái đơn 'confirmed', lưu bản ghi giao dịch MoMo thành công."),
        ("Luồng sự kiện chính (Normal Flow)", 
         "1. Tại trang Thanh toán Checkout, khách hàng chọn phương thức 'Thanh toán trực tuyến MoMo' và bấm 'Xác nhận Thanh toán'.\n"
         "2. MomoController tạo mã đơn hàng duy nhất (orderId), requestId và thu thập các thông số đơn hàng phụ tùng.\n"
         "3. Hệ thống tạo chuỗi dữ liệu gốc (Raw Signature) và mã hóa băm bằng thuật toán HMAC-SHA256 cùng Secret Key bí mật.\n"
         "4. Hệ thống gửi HTTP POST Request mang payload JSON sang API Endpoint của MoMo.\n"
         "5. MoMo kiểm tra tính hợp lệ của chữ ký, khởi tạo phiên thanh toán và trả về đường dẫn `payUrl`.\n"
         "6. Hệ thống chuyển hướng trình duyệt của khách hàng tới trang hiển thị mã QR của MoMo.\n"
         "7. Khách hàng mở ứng dụng MoMo trên điện thoại và thực hiện quét mã QR xác nhận trừ tiền.\n"
         "8. Cổng MoMo gửi thông báo thanh toán bất đồng bộ (IPN Callback) tới endpoint `/api/momo/ipn` của hệ thống.\n"
         "9. Hệ thống kiểm tra chữ ký phản hồi của MoMo để chống giả mạo:\n"
         "   - Nếu chữ ký hợp lệ và resultCode == 0 (Thành công):\n"
         "   - Cập nhật đơn hàng: `payment_status = 'paid'`, `order_status = 'confirmed'`.\n"
         "   - Ghi lại bản ghi giao dịch vào bảng `payment_transactions`.\n"
         "10. Trình duyệt khách hàng được chuyển hướng về trang kết quả đơn hàng hiển thị biên lai thanh toán."),
        ("Luồng rẽ nhánh / Ngoại lệ (Exceptions)",
         "7a. Khách hàng hủy giao dịch hoặc số dư ví MoMo không đủ:\n"
         "   - MoMo trả về resultCode != 0. Hệ thống ghi nhận trạng thái 'FAILED' và giữ nguyên đơn hàng chờ thanh toán lại.\n"
         "8a. Chữ ký IPN nhận được không khớp với thuật toán tính toán tại máy chủ:\n"
         "   - Hệ thống từ chối cập nhật đơn hàng, ghi log cảnh báo an ninh giả mạo dữ liệu.")
    ]
    add_table_styled(doc, ["Thuộc tính đặc tả", "Nội dung chi tiết"], uc02_data, [Inches(1.8), Inches(5.2)], "Bảng 2.3: Bảng đặc tả chi tiết Ca sử dụng UC02 - Thanh toán đơn hàng qua MoMo")

    # UC03
    add_p(doc, "3. Đặc tả Ca sử dụng UC03: Quản lý danh mục phụ tùng xe máy và tồn kho", bold=True)
    uc03_data = [
        ("Mã Use Case", "UC03"),
        ("Tên Use Case", "Quản lý danh mục phụ tùng xe máy và tồn kho (Parts Inventory Management)"),
        ("Tác nhân chính", "Quản trị viên (Admin)"),
        ("Mô tả tóm tắt", "Admin thực hiện các thao tác Thêm, Sửa, Xem danh sách và Xóa thông tin phụ tùng xe máy (Mã OEM, Tên phụ tùng, Giá bán, Số lượng tồn kho, Danh mục, Ảnh)."),
        ("Điều kiện tiên quyết", "Admin đã đăng nhập thành công và được xác thực quyền vai trò 'admin' thông qua AdminMiddleware."),
        ("Điều kiện sau thành công", "Cơ sở dữ liệu kho phụ tùng được cập nhật, thông tin hiển thị trên website được đồng bộ ngay lập tức."),
        ("Luồng sự kiện chính (Normal Flow)", 
         "1. Admin chọn menu 'Quản lý Sản phẩm / Phụ tùng' trên thanh điều hướng Dashboard.\n"
         "2. Hệ thống truy vấn cơ sở dữ liệu và hiển thị bảng phụ tùng phân trang kèm ảnh, mã OEM, tên, giá bán, tồn kho và danh mục cha.\n"
         "3. Khi Admin bấm nút 'Thêm mới': Hệ thống hiển thị Form nhập liệu phụ tùng.\n"
         "4. Admin điền thông tin: Mã phụ tùng (code), Tên linh kiện, Danh mục, Đơn giá, Số lượng tồn kho, Mô tả kỹ thuật và tải lên hình ảnh phụ tùng.\n"
         "5. Admin bấm 'Lưu dữ liệu'.\n"
         "6. Hệ thống thực hiện Validation (kiểm tra kiểu file ảnh, giá > 0, tồn kho >= 0), lưu ảnh vào thư mục `public/uploads`, tạo bản ghi Product mới trong CSDL và trả về thông báo 'Thêm sản phẩm thành công'."),
        ("Luồng rẽ nhánh / Ngoại lệ (Exceptions)",
         "6a. File ảnh tải lên vượt quá dung lượng quy định (2MB) hoặc không đúng định dạng:\n"
         "   - Hệ thống hiển thị cảnh báo lỗi tải file và giữ nguyên các nội dung text trong form.")
    ]
    add_table_styled(doc, ["Thuộc tính đặc tả", "Nội dung chi tiết"], uc03_data, [Inches(1.8), Inches(5.2)], "Bảng 2.4: Bảng đặc tả chi tiết Ca sử dụng UC03 - Quản lý Phụ tùng và Tồn kho")

    # UC04
    add_p(doc, "4. Đặc tả Ca sử dụng UC04: Tư vấn kỹ thuật phụ tùng xe máy trực tuyến", bold=True)
    uc04_data = [
        ("Mã Use Case", "UC04"),
        ("Tên Use Case", "Tư vấn kỹ thuật phụ tùng xe máy trực tuyến (Technical Live Chat)"),
        ("Tác nhân chính", "Khách hàng (Customer), Quản trị viên / Thợ kỹ thuật cửa hàng (Admin)"),
        ("Mô tả tóm tắt", "Kênh trò chuyện trực tiếp hai chiều hỗ trợ giải đáp thắc mắc về đời xe, độ tương thích của phụ tùng (má phanh, nhông sên dĩa, lọc gió, bugi) và hướng dẫn tự lắp ráp."),
        ("Điều kiện tiên quyết", "Cả Khách hàng và Admin đều đã đăng nhập vào hệ thống."),
        ("Điều kiện sau thành công", "Các tin nhắn tư vấn được lưu trữ toàn vẹn trong bảng `messages` và hiển thị tuần tự theo dấu thời gian thực."),
        ("Luồng sự kiện chính (Normal Flow)", 
         "1. Khách hàng bấm vào biểu tượng bong bóng Chat ở góc dưới màn hình giao diện.\n"
         "2. Cửa sổ chat mở ra, hiển thị lịch sử các tin nhắn tư vấn cũ giữa khách hàng và cửa hàng.\n"
         "3. Khách hàng nhập nội dung hỏi về phụ tùng (ví dụ: 'Xe Air Blade 125 đời 2020 dùng má phanh mã nào?') và bấm 'Gửi'.\n"
         "4. Ứng dụng gửi HTTP POST Request chứa nội dung tới endpoint `user/chat/send`.\n"
         "5. Hệ thống lưu tin nhắn vào CSDL với `sender_id = User ID`, `receiver_id = Admin ID`, `is_read = 0`.\n"
         "6. Phía giao diện Admin, cơ chế Polling / SSE liên tục quét tin nhắn mới, tự động phát âm thanh thông báo và đưa hội thoại lên đầu danh sách.\n"
         "7. Admin / Thợ kỹ thuật chọn hội thoại, gõ câu trả lời kỹ thuật và bấm gửi lại.\n"
         "8. Khách hàng nhận được tin nhắn trả lời hiển thị ngay trên khung chat."),
        ("Luồng rẽ nhánh / Ngoại lệ (Exceptions)",
         "3a. Khách hàng gửi tin nhắn trống hoặc chỉ chứa khoảng trắng:\n"
         "   - Nút gửi bị vô hiệu hóa hoặc hệ thống từ chối xử lý request rỗng.")
    ]
    add_table_styled(doc, ["Thuộc tính đặc tả", "Nội dung chi tiết"], uc04_data, [Inches(1.8), Inches(5.2)], "Bảng 2.5: Bảng đặc tả chi tiết Ca sử dụng UC04 - Tư vấn kỹ thuật phụ tùng")

    # -------------------------------------------------------------
    # 2.3. Mô hình hóa quy trình nghiệp vụ
    # -------------------------------------------------------------
    add_heading_2(doc, "2.3. Mô hình hóa quy trình nghiệp vụ")
    
    add_heading_3(doc, "2.3.1. Quy trình Đặt mua phụ tùng và thanh toán trực tuyến")
    add_p(doc,
        "Quy trình Đặt mua phụ tùng và thanh toán trực tuyến là chuỗi nghiệp vụ cốt lõi nhất của hệ thống MotoParts, "
        "thể hiện sự phối hợp nhịp nhàng giữa Khách hàng, Hệ thống MotoParts, Dịch vụ GHN và Cổng MoMo Gateway."
    )

    diagram_wf1 = (
        "Khách hàng                       Hệ thống MotoParts                  Cổng MoMo Gateway / GHN\n"
        "    |                                    |                                    |\n"
        "    |-- [1] Chọn phụ tùng & Số lượng --->|\n"
        "    |                                    |-- [2] Kiểm tra tồn kho (stock >= qty)\n"
        "    |                                    |-- [3] Thêm vào giỏ hàng (Cart)\n"
        "    |-- [4] Nhập địa chỉ giao hàng ----->|\n"
        "    |                                    |-- [5] Gọi API GHN tính cước phí -->| (GHN API)\n"
        "    |                                    |<- [6] Trả về phí vận chuyển -------|\n"
        "    |<- [7] Hiển thị tổng tiền + Ship ---|\n"
        "    |\n"
        "    |-- [8] Chọn Thanh toán MoMo -------->\n"
        "    |                                    |-- [9] Sinh chữ ký số HMAC-SHA256\n"
        "    |                                    |-- [10] Gửi Request tạo thanh toán ->| (MoMo Gateway)\n"
        "    |                                    |                                     |-- [11] Khởi tạo giao dịch\n"
        "    |                                    |<- [12] Trả về đường dẫn QR PayURL --|\n"
        "    |<- [13] Chuyển hướng quét mã QR ----|\n"
        "    |\n"
        "    |-- [14] Quét QR & Xác nhận trừ tiền ------------------------------------->|\n"
        "    |                                                                          |-- [15] Trừ tiền ví MoMo\n"
        "    |                                    |<- [16] Gửi Webhook IPN Callback ----|\n"
        "    |                                    |-- [17] Xác thực chữ ký IPN\n"
        "    |                                    |-- [18] Cập nhật Order: 'paid'\n"
        "    |                                    |-- [19] Trừ tồn kho phụ tùng (Stock)\n"
        "    |<- [20] Điều hướng trang Thành công |\n"
        "    |    và hiển thị mã đơn hàng         |"
    )
    add_diagram_box(doc, diagram_wf1, "Hình 2.2: Sơ đồ Quy trình nghiệp vụ Đặt mua phụ tùng và Thanh toán trực tuyến")

    add_heading_3(doc, "2.3.2. Quy trình Quản lý kho phụ tùng và cập nhật tồn kho")
    add_p(doc,
        "Quy trình quản lý kho bảo đảm các thông tin về mã phụ tùng, đơn giá và số lượng hàng sẵn có trong kho "
        "luôn được cập nhật chính xác theo thời gian thực."
    )

    diagram_wf2 = (
        "Admin Quản lý kho                   Hệ thống MotoParts                  Cơ sở dữ liệu (MySQL)\n"
        "    |                                        |                                    |\n"
        "    |-- [1] Đăng nhập Admin ---------------->|\n"
        "    |                                        |-- [2] Kiểm tra AdminMiddleware\n"
        "    |                                        |--(Hợp lệ)                          |\n"
        "    |-- [3] Xem danh sách kho phụ tùng ----->|-- [4] Truy vấn Products ---------->|\n"
        "    |                                        |<- [5] Trả về danh sách phụ tùng ---|\n"
        "    |<- [6] Hiển thị bảng tồn kho phụ tùng --|\n"
        "    |\n"
        "    |-- [7] Nhập linh kiện mới ------------->|\n"
        "    |   (Mã OEM, Tên, Giá, Tồn kho, Ảnh)     |-- [8] Validate dung lượng file ảnh\n"
        "    |                                        |-- [9] Lưu ảnh vào /public/uploads\n"
        "    |                                        |-- [10] INSERT bản ghi phụ tùng --->|\n"
        "    |                                        |<- [11] Trả về kết quả INSERT ------|\n"
        "    |<- [12] Thông báo Thêm mới thành công --|\n"
        "    |    và hiển thị ngay lên trang chủ      |"
    )
    add_diagram_box(doc, diagram_wf2, "Hình 2.3: Sơ đồ Quy trình Quản lý danh mục và Nhập xuất tồn kho phụ tùng")

    add_heading_3(doc, "2.3.3. Quy trình Tư vấn kỹ thuật phụ tùng và xác thực tài khoản")
    add_p(doc,
        "Khách hàng mua phụ tùng xe máy thường cần tư vấn kỹ thuật chuyên sâu trước khi quyết định đặt hàng; "
        "đồng thời hệ thống yêu cầu xác thực OTP qua Email khi đăng ký tài khoản để ngăn ngừa việc đặt đơn ảo."
    )

    diagram_wf3 = (
        "Khách hàng                       Hệ thống MotoParts                  Máy chủ Mail (SMTP) / Admin\n"
        "    |                                    |                                    |\n"
        "    |-- [1] Điền Form Đăng ký tài khoản->|\n"
        "    |   (Tên, Email, Mật khẩu)           |-- [2] Kiểm tra email duy nhất\n"
        "    |                                    |-- [3] Mã hóa bcrypt mật khẩu\n"
        "    |                                    |-- [4] Sinh mã OTP ngẫu nhiên 6 số\n"
        "    |                                    |-- [5] Gửi email chứa mã OTP ------>| (SMTP Server)\n"
        "    |<- [6] Nhận mã OTP trong hòm thư ---+------------------------------------|\n"
        "    |\n"
        "    |-- [7] Nhập mã OTP vào trang kích hoạt->|\n"
        "    |                                    |-- [8] So khớp mã OTP trong DB\n"
        "    |                                    |--(Khớp) Cập nhật email_verified_at\n"
        "    |<- [9] Đăng nhập thành công --------|\n"
        "    |\n"
        "    |-- [10] Mở cửa sổ LiveChat --------->|\n"
        "    |    Hỏi về mã má phanh Air Blade    |-- [11] Lưu vào bảng `messages`\n"
        "    |                                    |-- [12] Bắn thông báo sang Admin -->| (Admin Dashboard)\n"
        "    |                                    |<- [13] Admin trả lời tư vấn -------|\n"
        "    |<- [14] Nhận câu trả lời kỹ thuật --|"
    )
    add_diagram_box(doc, diagram_wf3, "Hình 2.4: Sơ đồ Quy trình Tư vấn Kỹ thuật LiveChat và Xác thực Tài khoản OTP")

    # -------------------------------------------------------------
    # 2.4. Yêu cầu phi chức năng và ràng buộc
    # -------------------------------------------------------------
    add_heading_2(doc, "2.4. Yêu cầu phi chức năng và ràng buộc")
    
    add_heading_3(doc, "2.4.1. Yêu cầu phi chức năng")
    add_p(doc,
        "Các yêu cầu phi chức năng (Non-Functional Requirements - NFR) được phân loại theo mô hình FURPS+:"
    )

    nfr_data = [
        ("Khía cạnh NFR", "Mã NFR", "Tiêu chuẩn định lượng và yêu cầu chất lượng cụ thể"),
        ("Hiệu năng (Performance)", "NFR-PERF-01", "Thời gian tải trang danh mục phụ tùng không vượt quá 1.5 giây trong điều kiện mạng bình thường."),
        ("Hiệu năng (Performance)", "NFR-PERF-02", "Hệ thống có khả năng xử lý đồng thời tối thiểu 300 yêu cầu tra cứu và đặt đơn/giây mà không bị nghẽn cổ chai."),
        ("Độ tin cậy (Reliability)", "NFR-REL-01", "Hệ thống bán hàng trực tuyến hoạt động liên tục với độ sẵn sàng đạt tối thiểu 99.5% thời gian trong năm."),
        ("Độ tin cậy (Reliability)", "NFR-REL-02", "Dữ liệu đơn hàng, trừ tồn kho và thanh toán MoMo phải đảm bảo tính toàn vẹn tuyệt đối theo chuẩn ACID; không bị mất đơn khi mất kết nối mạng bất ngờ."),
        ("Bảo mật (Security)", "NFR-SEC-01", "Mật khẩu người dùng bắt buộc phải mã hóa một chiều bằng thuật toán băm Bcrypt với chi phí tính toán cao (work factor = 10)."),
        ("Bảo mật (Security)", "NFR-SEC-02", "Chống tấn công CSRF trên toàn bộ biểu mẫu đặt hàng, giỏ hàng qua CSRF Token ẩn."),
        ("Bảo mật (Security)", "NFR-SEC-03", "Chống tấn công SQL Injection bằng việc sử dụng triệt để Eloquent ORM và Prepared Statements."),
        ("Bảo mật (Security)", "NFR-SEC-04", "Giao thức thanh toán MoMo bắt buộc xác thực chữ ký băm mật mã HMAC-SHA256 hai chiều chống can thiệp số tiền."),
        ("Khả dụng (Usability)", "NFR-USA-01", "Giao diện Responsive Design, hiển thị hoàn hảo trên máy tính để bàn, máy tính bảng và điện thoại thông minh."),
        ("Bảo trì (Maintainability)", "NFR-MAI-01", "Mã nguồn tuân thủ tiêu chuẩn PSR-12; các tầng kiến trúc phân chia độc lập giúp việc thêm phương thức giao vận mới không làm hỏng logic cũ.")
    ]
    add_table_styled(doc, ["Nhóm thuộc tính", "Mã NFR", "Quy chuẩn kỹ thuật chi tiết"], nfr_data, [Inches(1.8), Inches(1.2), Inches(4.0)], "Bảng 2.6: Tổng hợp Yêu cầu phi chức năng theo mô hình FURPS+")

    add_heading_3(doc, "2.4.2. Ràng buộc")
    add_p(doc, "Hệ thống chịu sự chi phối của các ràng buộc kỹ thuật và nghiệp vụ nghiêm ngặt sau:")
    add_bullet(doc, "Ngôn ngữ phát triển PHP 8.2+, framework kiến trúc Laravel 10.x, hệ quản trị CSDL MySQL 8.0, máy chủ web Apache/XAMPP, giao diện Blade Template Engine kết hợp CSS3/JS thuần.", "Ràng buộc công nghệ: ");
    add_bullet(doc, "Phụ tùng bán ra phải có số lượng tồn kho lớn hơn 0; không được phép bán âm kho; số lượng đặt mua nhanh giới hạn từ 1 đến 10 linh kiện để ngăn chặn gom hàng đầu cơ.", "Ràng buộc nghiệp vụ cửa hàng: ");
    add_bullet(doc, "Tuân thủ quy định về giao dịch thương mại điện tử và bảo vệ dữ liệu người tiêu dùng theo Nghị định 13/2023/NĐ-CP và tiêu chuẩn an toàn thanh toán số.", "Ràng buộc pháp lý và tài chính: ");

    # -------------------------------------------------------------
    # 2.5. Kết luận chương 2
    # -------------------------------------------------------------
    add_heading_2(doc, "2.5. Kết luận chương 2")
    add_p(doc,
        "Chương 2 đã hoàn thành toàn diện giai đoạn phân tích yêu cầu cho Hệ thống Thương mại Điện tử Phụ tùng Xe máy MotoParts. "
        "Các kết quả cốt lõi đạt được bao gồm:"
    )
    add_bullet(doc, "Làm rõ bối cảnh thị trường phụ tùng xe máy tại Việt Nam, nhận diện các khó khăn lớn về nguồn gốc, mã linh kiện và công tác quản lý kho; xác lập mục tiêu số hóa bài bản.");
    add_bullet(doc, "Thiết lập danh mục 15 yêu cầu chức năng chuẩn hóa, phân định rõ quyền hạn của Guest, Customer và Admin; xây dựng sơ đồ Use Case và đặc tả chi tiết 4 Use Case quan trọng nhất.");
    add_bullet(doc, "Mô hình hóa trực quan 3 quy trình nghiệp vụ then chốt: Đặt mua phụ tùng & Thanh toán MoMo, Quản lý kho tồn kho, Tư vấn kỹ thuật LiveChat & Xác thực OTP.");
    add_bullet(doc, "Lượng hóa cụ thể các yêu cầu phi chức năng khắt khe về hiệu năng, bảo mật HMAC, độ sẵn sàng và các ràng buộc kỹ thuật.");
    add_p(doc,
        "Đây là cơ sở đầu vào hoàn chỉnh, định hình chính xác các yêu cầu có ý nghĩa kiến trúc (ASRs) "
        "để chuyển sang pha Thiết kế kiến trúc tổng thể trong Chương 3."
    )
    
    doc.add_page_break()
