import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from report_styles import (
    add_p, add_heading_1, add_heading_2, add_heading_3, add_heading_4, 
    add_bullet, add_table_styled, add_diagram_box, COLOR_PRIMARY, COLOR_SECONDARY, COLOR_TEXT
)

def build_chapter_4(doc):
    add_heading_1(doc, "CHƯƠNG 4. THIẾT KẾ DỮ LIỆU VÀ LỚP")
    
    # -------------------------------------------------------------
    # 4.1. Thiết kế dữ liệu
    # -------------------------------------------------------------
    add_heading_2(doc, "4.1. Thiết kế dữ liệu")
    
    add_heading_3(doc, "4.1.1. Thực thể, thuộc tính")
    add_p(doc,
        "Cơ sở dữ liệu của Hệ thống Cửa hàng Phụ tùng Xe máy MotoParts được thiết kế chuẩn hóa đạt chuẩn dạng chuẩn 3 "
        "(Third Normal Form - 3NF), nhằm triệt tiêu tối đa sự dư thừa dữ liệu và ngăn chặn các dị thường khi Thêm, Sửa, Xóa. "
        "Dưới đây là từ điển dữ liệu (Data Dictionary) chi tiết của 7 bảng thực thể nòng cốt đang vận hành trong hệ thống:"
    )

    # Table 4.1: Users
    add_p(doc, "1. Thực thể Users (Quản lý tài khoản khách hàng, thợ kỹ thuật và quản trị viên):", bold=True)
    users_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh duy nhất của người dùng trong hệ thống"),
        ("name", "VARCHAR(255)", "NOT NULL", "Họ và tên đầy đủ của khách hàng hoặc quản trị viên"),
        ("email", "VARCHAR(255)", "UNIQUE, NOT NULL", "Địa chỉ thư điện tử dùng để đăng nhập và nhận hóa đơn"),
        ("password", "VARCHAR(255)", "NOT NULL", "Mật khẩu bảo mật đã được mã hóa băm một chiều (Bcrypt)"),
        ("role", "ENUM('admin','customer')", "DEFAULT 'customer'", "Vai trò phân quyền truy cập: 'customer' hoặc 'admin'"),
        ("verification_code", "VARCHAR(6)", "NULLABLE", "Mã OTP 6 chữ số gửi qua email phục vụ kích hoạt tài khoản"),
        ("email_verified_at", "TIMESTAMP", "NULLABLE", "Thời điểm người dùng xác thực mã OTP email thành công"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian tạo tài khoản và cập nhật gần nhất")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], users_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.1: Từ điển dữ liệu bảng Users")

    # Table 4.2: Categories
    add_p(doc, "2. Thực thể Categories (Danh mục phân loại nhóm phụ tùng xe máy):", bold=True)
    cat_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh danh mục phụ tùng"),
        ("name", "VARCHAR(255)", "NOT NULL", "Tên nhóm phụ tùng (Má Phanh, Lọc Gió, Bugi, Nhông Xích, Đèn, Gương)"),
        ("slug", "VARCHAR(255)", "UNIQUE, NOT NULL", "Chuỗi định danh thân thiện URL (ma-phanh, loc-gio, bugi, nhong-xich...)"),
        ("description", "TEXT", "NULLABLE", "Mô tả chi tiết về nhóm phụ tùng và công năng kỹ thuật"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian tạo và cập nhật bản ghi")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], cat_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.2: Từ điển dữ liệu bảng Categories")

    # Table 4.3: Products
    add_p(doc, "3. Thực thể Products (Chi tiết từng phụ tùng xe máy và số lượng tồn kho):", bold=True)
    prod_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh sản phẩm phụ tùng"),
        ("category_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Khóa ngoại liên kết tới Categories(id)"),
        ("code", "VARCHAR(100)", "NULLABLE", "Mã phụ tùng OEM tiêu chuẩn (ví dụ: 06430-KVB-305, 17210-KVB-900)"),
        ("name", "VARCHAR(255)", "NOT NULL", "Tên phụ tùng (Bộ má phanh trước Air Blade, Bugi NGK CPR6EA-9...)"),
        ("description", "TEXT", "NULLABLE", "Mô tả kỹ thuật, dòng xe tương thích, xuất xứ chính hãng"),
        ("price", "DECIMAL(12,2)", "NOT NULL, >= 0", "Đơn giá niêm yết bán lẻ phụ tùng (VNĐ)"),
        ("stock", "INT", "NOT NULL, DEFAULT 0", "Số lượng phụ tùng thực tế còn sẵn sàng trong kho"),
        ("image", "VARCHAR(255)", "NULLABLE", "Đường dẫn tập tin hình ảnh chụp thực tế phụ tùng"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian tạo và cập nhật bản ghi")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], prod_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.3: Từ điển dữ liệu bảng Products")

    # Table 4.4: Orders
    add_p(doc, "4. Thực thể Orders (Đơn đặt hàng mua phụ tùng và thông tin giao nhận):", bold=True)
    orders_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã đơn hàng duy nhất trong hệ thống"),
        ("user_id", "BIGINT UNSIGNED", "FK, NULLABLE", "Khóa ngoại liên kết tới Users(id) (NULL nếu mua không đăng nhập)"),
        ("customer_name", "VARCHAR(255)", "NOT NULL", "Họ tên người nhận phụ tùng"),
        ("customer_email", "VARCHAR(255)", "NOT NULL", "Email nhận mã đơn và hóa đơn điện tử"),
        ("customer_phone", "VARCHAR(20)", "NOT NULL", "Số điện thoại liên lạc khi bưu tá giao phụ tùng"),
        ("shipping_address", "VARCHAR(255)", "NOT NULL", "Địa chỉ giao hàng chi tiết (số nhà, đường, xã/huyện/tỉnh)"),
        ("payment_method", "ENUM('cod','momo')", "NOT NULL", "Phương thức thanh toán: COD hoặc Ví điện tử MoMo"),
        ("payment_status", "ENUM('unpaid','paid')", "DEFAULT 'unpaid'", "Trạng thái thanh toán: 'unpaid' hoặc 'paid'"),
        ("order_status", "VARCHAR(50)", "DEFAULT 'pending'", "Trạng thái đơn: pending, confirmed, completed, cancelled"),
        ("shipping_status", "VARCHAR(50)", "DEFAULT 'pending'", "Trạng thái GHN: delivering, picked, delivered, cancelled"),
        ("ghn_order_code", "VARCHAR(100)", "NULLABLE", "Mã vận đơn tạo bên hệ thống Giao Hàng Nhanh"),
        ("total_amount", "DECIMAL(12,2)", "NOT NULL", "Tổng tiền thanh toán gồm tiền phụ tùng + phí ship (VNĐ)"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian đặt hàng và cập nhật đơn")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], orders_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.4: Từ điển dữ liệu bảng Orders")

    # Table 4.5: OrderItems
    add_p(doc, "5. Thực thể OrderItems (Chi tiết số lượng và giá từng phụ tùng trong đơn):", bold=True)
    items_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh bản ghi chi tiết đơn hàng"),
        ("order_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Khóa ngoại liên kết tới Orders(id) (ON DELETE CASCADE)"),
        ("product_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Khóa ngoại liên kết tới Products(id)"),
        ("quantity", "INT", "NOT NULL, > 0", "Số lượng phụ tùng mua trong đơn"),
        ("price", "DECIMAL(12,2)", "NOT NULL", "Đơn giá phụ tùng tại thời điểm mua (bảo toàn giá lịch sử)"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian tạo và cập nhật bản ghi")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], items_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.5: Từ điển dữ liệu bảng OrderItems")

    # Table 4.6: PaymentTransactions
    add_p(doc, "6. Thực thể PaymentTransactions (Nhật ký giao dịch tài chính Cổng MoMo):", bold=True)
    trans_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh giao dịch thanh toán nội bộ"),
        ("order_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Khóa ngoại tham chiếu tới đơn hàng Orders(id)"),
        ("transaction_id", "VARCHAR(255)", "UNIQUE, NOT NULL", "Mã giao dịch MoMo trả về (transId)"),
        ("amount", "DECIMAL(12,2)", "NOT NULL", "Số tiền giao dịch thực tế thanh toán qua ví MoMo"),
        ("payment_method", "VARCHAR(50)", "DEFAULT 'momo'", "Cổng thanh toán điện tử thực hiện"),
        ("status", "VARCHAR(50)", "NOT NULL", "Trạng thái giao dịch: SUCCESS, FAILED, PENDING"),
        ("response_message", "TEXT", "NULLABLE", "Chi tiết phản hồi hoặc mã lỗi kỹ thuật từ máy chủ MoMo"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian phát sinh giao dịch tài chính")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], trans_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.6: Từ điển dữ liệu bảng PaymentTransactions")

    # Table 4.7: Messages
    add_p(doc, "7. Thực thể Messages (Lưu trữ tin nhắn tư vấn kỹ thuật phụ tùng trực tuyến):", bold=True)
    msg_dict = [
        ("id", "BIGINT UNSIGNED", "PK, Auto Increment", "Mã định danh tin nhắn"),
        ("sender_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Mã người gửi tin nhắn (tham chiếu Users(id))"),
        ("receiver_id", "BIGINT UNSIGNED", "FK, NOT NULL", "Mã người nhận tin nhắn (tham chiếu Users(id))"),
        ("message", "TEXT", "NOT NULL", "Nội dung văn bản tin nhắn hỏi đáp kỹ thuật phụ tùng"),
        ("is_read", "BOOLEAN", "DEFAULT FALSE", "Cờ đánh dấu người nhận đã đọc tin nhắn hay chưa"),
        ("created_at / updated_at", "TIMESTAMP", "NULLABLE", "Thời gian gửi tin nhắn")
    ]
    add_table_styled(doc, ["Tên trường", "Kiểu dữ liệu", "Ràng buộc (Constraints)", "Mô tả ý nghĩa nghiệp vụ"], msg_dict, [Inches(1.8), Inches(1.5), Inches(1.5), Inches(2.2)], "Bảng 4.7: Từ điển dữ liệu bảng Messages")

    add_heading_3(doc, "4.1.2. Mối quan hệ")
    add_p(doc, "Các thực thể trong hệ thống phụ tùng xe máy liên kết với nhau qua các mối quan hệ chặt chẽ:")
    add_bullet(doc, "Một nhóm danh mục (Category) có thể chứa nhiều phụ tùng xe máy (Products), mỗi phụ tùng chỉ thuộc về duy nhất một nhóm danh mục. Khóa ngoại `products.category_id` liên kết tới `categories.id`.", "Quan hệ Categories - Products (1 - N): ");
    add_bullet(doc, "Một khách hàng (User) có thể thực hiện nhiều đơn mua phụ tùng theo thời gian. Khóa ngoại `orders.user_id` liên kết tới `users.id`.", "Quan hệ Users - Orders (1 - N): ");
    add_bullet(doc, "Một đơn hàng (Order) bao gồm nhiều mặt hàng phụ tùng khác nhau (OrderItems). Khi một đơn hàng bị xóa, toàn bộ các OrderItems liên quan sẽ tự động bị xóa theo (ON DELETE CASCADE).", "Quan hệ Orders - OrderItems (1 - N): ");
    add_bullet(doc, "Mỗi sản phẩm phụ tùng (Product) có thể xuất hiện trong nhiều đơn hàng. Khóa ngoại `order_items.product_id` liên kết tới `products.id` với ràng buộc hạn chế xóa (RESTRICT) nếu phụ tùng đó đã từng phát sinh đơn hàng.", "Quan hệ Products - OrderItems (1 - N): ");
    add_bullet(doc, "Một đơn hàng có thể có một hoặc nhiều lần giao dịch thanh toán MoMo để đối soát. Khóa ngoại `payment_transactions.order_id` liên kết tới `orders.id`.", "Quan hệ Orders - PaymentTransactions (1 - N): ");
    add_bullet(doc, "Một người dùng có thể gửi hoặc nhận nhiều tin nhắn tư vấn từ thợ kỹ thuật hoặc Admin. Bảng Messages thiết lập 2 khóa ngoại độc lập `sender_id` và `receiver_id` cùng tham chiếu tới `users.id`.", "Quan hệ Users - Messages (1 - N hai chiều): ");

    add_heading_3(doc, "4.1.3. Sơ đồ thực thể quan hệ")
    diagram_erd = (
        "+-------------------+         1:N         +-------------------+\n"
        "|    CATEGORIES     |-------------------->|     PRODUCTS      |\n"
        "| - id (PK)         |                     | - id (PK)         |\n"
        "| - name, slug      |                     | - category_id(FK) |\n"
        "+-------------------+                     | - code (Mã OEM)   |\n"
        "                                          | - name, price     |\n"
        "                                          | - stock, image    |\n"
        "                                          +---------+---------+\n"
        "                                                    | 1:N\n"
        "+-------------------+         1:N                   v\n"
        "|       USERS       |------------+        +-------------------+\n"
        "| - id (PK)         |            |        |    ORDER_ITEMS    |\n"
        "| - name, email     |            |        | - id (PK)         |\n"
        "| - password, role  |            |        | - order_id (FK)   |\n"
        "+---------+---------+            |        | - product_id (FK) |\n"
        "   | 1:N  | 1:N                  v        | - quantity, price |\n"
        "   | (S)  | (R)           +---------------+---+   +-----------+\n"
        "   |      |               |      ORDERS       |   |\n"
        "   v      v               | - id (PK)         |   |\n"
        "+---------+---------+     | - user_id (FK)    |<--+ (1:N, Cascade)\n"
        "|     MESSAGES      |     | - customer_name   |\n"
        "| - id (PK)         |     | - total_amount    |\n"
        "| - sender_id (FK)  |     | - payment_status  |\n"
        "| - receiver_id(FK) |     | - shipping_status |\n"
        "| - message, is_read|     | - ghn_order_code  |\n"
        "+-------------------+     +---------+---------+\n"
        "                                    | 1:N\n"
        "                                    v\n"
        "                          +-------------------+\n"
        "                          |PAYMENT_TRANSAC'S  |\n"
        "                          | - id (PK)         |\n"
        "                          | - order_id (FK)   |\n"
        "                          | - transaction_id  |\n"
        "                          | - amount, status  |\n"
        "                          +-------------------+"
    )
    add_diagram_box(doc, diagram_erd, "Hình 4.1: Sơ đồ Quan hệ Thực thể (ERD) hoàn chỉnh của CSDL Cửa hàng Phụ tùng MotoParts")

    # -------------------------------------------------------------
    # 4.2. Thiết kế lớp
    # -------------------------------------------------------------
    add_heading_2(doc, "4.2. Thiết kế lớp")
    
    add_heading_3(doc, "4.2.1. Xác định lớp và trách nhiệm")
    add_p(doc, "Hệ thống phân chia các lớp đối tượng theo mẫu kiến trúc MVC của Laravel:")

    class_resp = [
        ("ProductController", "Controller", "Hiển thị danh mục phụ tùng xe máy, tra cứu theo mã OEM, lọc theo dòng xe, xem chi tiết phụ tùng và quản lý CRUD cho Admin."),
        ("CartController", "Controller", "Quản lý giỏ hàng trên Session: thêm phụ tùng, cập nhật số lượng mua, kiểm tra số lượng tồn kho còn lại, xóa món khỏi giỏ."),
        ("OrderController", "Controller", "Xử lý đặt hàng phụ tùng, lưu thông tin giao nhận, tính cước vận chuyển, cập nhật trạng thái đơn và giao vận GHN."),
        ("MomoController", "Controller", "Tạo chữ ký số HMAC-SHA256, chuyển hướng thanh toán MoMo và tiếp nhận phản hồi Webhook IPN Callback."),
        ("GHNController", "Controller", "Giao tiếp với API Giao Hàng Nhanh: tra cứu mã bưu cục quận/huyện, tính cước phí ship và tạo mã đơn GHN."),
        ("ChatController", "Controller", "Quản lý luồng gửi/nhận tin nhắn tư vấn kỹ thuật trực tuyến giữa khách hàng và thợ kỹ thuật cửa hàng."),
        ("AuthController", "Controller", "Xử lý đăng ký, mã hóa mật khẩu Bcrypt, sinh mã xác thực OTP gửi qua email và đăng nhập phân quyền vai trò."),
        ("Product (Model)", "Eloquent Model", "Đại diện thực thể phụ tùng xe máy, quản lý quan hệ với Category và OrderItem, cung cấp phương thức kiểm tra tồn kho."),
        ("Order (Model)", "Eloquent Model", "Đại diện đơn hàng phụ tùng, quản lý quan hệ 1-N với OrderItem, PaymentTransaction và liên kết với User.")
    ]
    add_table_styled(doc, ["Tên Lớp (Class)", "Phân loại", "Trách nhiệm nghiệp vụ cụ thể"], class_resp, [Inches(2.2), Inches(1.2), Inches(3.6)], "Bảng 4.8: Bảng mô tả trách nhiệm các lớp chính trong hệ thống MotoParts")

    add_heading_3(doc, "4.2.2. Thuộc tính, phương thức và quan hệ giữa các lớp")
    add_p(doc, "Các lớp chính có cấu trúc thuộc tính và chữ ký phương thức chuẩn hóa như sau:")
    add_bullet(doc, "Thuộc tính: `$fillable`. Phương thức: `index(): View`, `show(id: int): View`, `store(request: Request): RedirectResponse`, `update(request: Request, id: int)`, `destroy(id: int)`.", "ProductController: ");
    add_bullet(doc, "Phương thức: `index(): View`, `add(request: Request)`, `update(request: Request)`, `remove(id: int)`, `clear()`.", "CartController: ");
    add_bullet(doc, "Phương thức: `checkout(): View`, `store(request: Request): RedirectResponse`, `show(id: int): View`, `updateStatus(request: Request, id: int)`.", "OrderController: ");
    add_bullet(doc, "Thuộc tính: `$endpoint, $partnerCode, $accessKey, $secretKey`. Phương thức: `createPayment(order: Order): RedirectResponse`, `momoIpn(request: Request): JsonResponse`.", "MomoController: ");
    add_bullet(doc, "Phương thức: `calculateFee(request: Request): JsonResponse`, `createOrder(order: Order): string`.", "GHNController: ");
    add_bullet(doc, "Phương thức: `sendMessage(request: Request): JsonResponse`, `getMessages(receiverId: int): JsonResponse`.", "ChatController: ");

    add_heading_3(doc, "4.2.3. Sơ đồ lớp")
    diagram_class = (
        "+------------------------------------+       +------------------------------------+\n"
        "|         ProductController          |       |           AuthController           |\n"
        "|------------------------------------|       |------------------------------------|\n"
        "| + index(req: Request): View        |       | + login(req: Request)              |\n"
        "| + show(id: int): View              |       | + register(req: Request)           |\n"
        "| + store(req: Request)              |       | + verifyCode(req: Request)         |\n"
        "+-----------------+------------------+       +-----------------+------------------+\n"
        "                  |                                            |\n"
        "                  v                                            v\n"
        "+------------------------------------+       +------------------------------------+\n"
        "|          Product (Model)           |       |            User (Model)            |\n"
        "|------------------------------------|       |------------------------------------|\n"
        "| - code, name, price, stock, image  |       | - name, email, password, role      |\n"
        "|------------------------------------|       |------------------------------------|\n"
        "| + category(): BelongsTo            |       | + orders(): HasMany                |\n"
        "| + orderItems(): HasMany            |       | + messages(): HasMany              |\n"
        "+-----------------+------------------+       +-----------------+------------------+\n"
        "                  ^                                            |\n"
        "                  | 1:N                                        v 1:N\n"
        "+-----------------+------------------+       +------------------------------------+\n"
        "|         OrderItem (Model)          |       |            Order (Model)           |\n"
        "|------------------------------------|       |------------------------------------|\n"
        "| - order_id, product_id, quantity   |       | - customer_name, total_amount      |\n"
        "| - price: decimal                   |       | - order_status, shipping_status    |\n"
        "+-----------------+------------------+       |------------------------------------|\n"
        "                  | N:1                      | + items(): HasMany                 |\n"
        "                  +------------------------->| + transactions(): HasMany          |\n"
        "                                             +-----------------+------------------+\n"
        "                                                               |\n"
        "                     +-----------------------------------------+ 1:N\n"
        "                     v                                         v\n"
        "+------------------------------------+       +------------------------------------+\n"
        "|           MomoController           |       |      PaymentTransaction (Model)    |\n"
        "|------------------------------------|       |------------------------------------|\n"
        "| - partnerCode, secretKey: string   |       | - transaction_id, amount, status   |\n"
        "| + createPayment(order: Order)      |       +------------------------------------+\n"
        "| + momoIpn(req: Request)            |\n"
        "+------------------------------------+"
    )
    add_diagram_box(doc, diagram_class, "Hình 4.2: Sơ đồ Lớp chi tiết (Class Diagram) của Hệ thống MotoParts")

    # -------------------------------------------------------------
    # 4.3. Sơ đồ trạng thái
    # -------------------------------------------------------------
    add_heading_2(doc, "4.3. Sơ đồ trạng thái")
    
    add_heading_3(doc, "4.3.1. Sơ đồ trạng thái đối tượng Đơn đặt hàng phụ tùng (Order)")
    add_p(doc,
        "Đơn hàng phụ tùng xe máy trải qua một vòng đời nhiều giai đoạn từ lúc khách tạo đơn, "
        "thanh toán MoMo/COD, bàn giao cho bưu tá Giao Hàng Nhanh cho tới khi hoàn tất:"
    )
    diagram_state_order = (
        "  (*) [Khách hàng nhấn Xác nhận Đặt hàng]\n"
        "   |\n"
        "   v\n"
        "+---------------------+\n"
        "|       PENDING       | <--- Đơn hàng vừa tạo, chờ xác nhận thanh toán\n"
        "+----------+----------+\n"
        "           | \n"
        "           |-- (Thanh toán MoMo thành công / Cửa hàng xác nhận đơn COD)\n"
        "           v\n"
        "+---------------------+\n"
        "|      CONFIRMED      | <--- Đã xác nhận đơn, xuất kho đóng gói phụ tùng\n"
        "+----------+----------+\n"
        "           |\n"
        "           |-- (Bàn giao cho bưu tá GHN lấy hàng, tạo mã vận đơn)\n"
        "           v\n"
        "+---------------------+\n"
        "|      DELIVERING     | <--- GHN đang vận chuyển phụ tùng tới địa chỉ khách\n"
        "+----------+----------+\n"
        "           |\n"
        "           |-- (Khách đã nhận phụ tùng, kiểm tra đúng linh kiện và ký nhận)\n"
        "           v\n"
        "+---------------------+\n"
        "|      COMPLETED      | ---> (* Đơn hàng hoàn tất thành công)\n"
        "+---------------------+\n"
        "           ^\n"
        "           | (Khách hủy hoặc không liên lạc được giao hàng)\n"
        "+----------+----------+\n"
        "|      CANCELLED      | ---> (* Đơn bị hủy, tự động hoàn trả tồn kho phụ tùng)\n"
        "+---------------------+"
    )
    add_diagram_box(doc, diagram_state_order, "Hình 4.3: Sơ đồ Máy trạng thái của đối tượng Đơn hàng phụ tùng xe máy (Order)")

    add_heading_3(doc, "4.3.2. Sơ đồ trạng thái đối tượng Giao dịch Thanh toán MoMo")
    add_p(doc, "Giao dịch thanh toán tài chính MoMo phản ánh trạng thái dòng tiền:")
    diagram_state_trans = (
        "  (*) [Khách bấm Thanh toán MoMo -> Hệ thống sinh chữ ký HMAC]\n"
        "   |\n"
        "   v\n"
        "+---------------------+\n"
        "|       CREATED       | <--- Mã giao dịch và link QR thanh toán đã sẵn sàng\n"
        "+----------+----------+\n"
        "           |\n"
        "           v\n"
        "+---------------------+\n"
        "|     PROCESSING      | <--- Khách hàng đang quét mã QR trên ứng dụng MoMo\n"
        "+----+-----------+----+\n"
        "     |           |\n"
        "     | (resultCode == 0)\n"
        "     v           v (resultCode != 0 / Quá thời gian chờ 15 phút)\n"
        "+---------+ +---------+\n"
        "| SUCCESS | | FAILED  |\n"
        "+---------+ +---------+\n"
        "     |           |\n"
        "     v           v\n"
        "    (*)         (*)"
    )
    add_diagram_box(doc, diagram_state_trans, "Hình 4.4: Sơ đồ Máy trạng thái Giao dịch Thanh toán MoMo")

    add_heading_3(doc, "4.3.3. Sơ đồ trạng thái đối tượng Tài khoản Người dùng & OTP")
    add_p(doc, "Kiểm soát quyền truy cập và tính hợp lệ của tài khoản khách hàng trên hệ thống:")
    diagram_state_user = (
        "  (*) [Người dùng điền Form Đăng ký tài khoản]\n"
        "   |\n"
        "   v\n"
        "+---------------------+\n"
        "|  UNVERIFIED / PEND  | <--- Tài khoản tạo xong, email_verified_at = NULL\n"
        "+----------+----------+\n"
        "           |\n"
        "           |-- (Nhập đúng mã OTP 6 chữ số gửi qua email)\n"
        "           v\n"
        "+---------------------+\n"
        "|   ACTIVE / VERIF    | <--- Kích hoạt đầy đủ quyền mua phụ tùng & Chat\n"
        "+----------+----------+\n"
        "           |\n"
        "           |-- (Admin phát hiện tài khoản spam hoặc vi phạm chính sách -> Khóa)\n"
        "           v\n"
        "+---------------------+\n"
        "|      SUSPENDED      | ---> Bị từ chối đăng nhập vào hệ thống\n"
        "+---------------------+"
    )
    add_diagram_box(doc, diagram_state_user, "Hình 4.5: Sơ đồ Trạng thái Tài khoản Người dùng và Xác thực OTP")

    # -------------------------------------------------------------
    # 4.4. Kết luận chương 4
    # -------------------------------------------------------------
    add_heading_2(doc, "4.4. Kết luận chương 4")
    add_p(doc,
        "Chương 4 đã giải quyết triệt để bài toán thiết kế cấu trúc dữ liệu và mô hình hướng đối tượng của hệ thống MotoParts. "
        "Các thành tựu chính bao gồm:"
    )
    add_bullet(doc, "Thiết kế mô hình cơ sở dữ liệu quan hệ chuẩn hóa 3NF gồm 7 bảng thực thể nòng cốt (`users`, `categories`, `products`, `orders`, `order_items`, `payment_transactions`, `messages`);");
    add_bullet(doc, "Xây dựng sơ đồ thực thể liên kết (ERD) và bảng từ điển dữ liệu tường minh, bảo đảm tính toàn vẹn tham chiếu dữ liệu kho hàng;");
    add_bullet(doc, "Thiết kế cấu trúc tĩnh với sơ đồ lớp (Class Diagram) định nghĩa rõ ràng vai trò của các lớp Controller, Model, Service cùng thuộc tính và chữ ký phương thức;");
    add_bullet(doc, "Mô hình hóa cấu trúc động qua 3 sơ đồ máy trạng thái (Statechart Diagrams) phản ánh chính xác chu kỳ biến đổi của Đơn hàng phụ tùng, Giao dịch MoMo và Tài khoản khách hàng.");
    add_p(doc,
        "Đây là cơ sở kỹ thuật cốt lõi để bước vào Chương 5: Thiết kế giao diện và chi tiết thành phần tương tác."
    )
    
    doc.add_page_break()
