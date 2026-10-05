import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from report_styles import (
    add_p, add_heading_1, add_heading_2, add_heading_3, add_heading_4, 
    add_bullet, add_table_styled, add_diagram_box, COLOR_PRIMARY, COLOR_SECONDARY, COLOR_TEXT
)

def build_chapter_1(doc):
    add_heading_1(doc, "CHƯƠNG 1. TỔNG QUAN VỀ KIẾN TRÚC VÀ THIẾT KẾ PHẦN MỀM")
    
    # -------------------------------------------------------------
    # 1.1. Thiết kế phần mềm trong quy trình phát triển
    # -------------------------------------------------------------
    add_heading_2(doc, "1.1. Thiết kế phần mềm trong quy trình phát triển")
    
    add_heading_3(doc, "1.1.1. Một số khái niệm")
    add_p(doc,
        "Để tiếp cận một cách khoa học và hệ thống vào kỹ nghệ phần mềm, trước hết cần phải làm rõ các khái niệm "
        "căn bản cấu thành nên kỷ luật này:"
    )
    add_bullet(doc, "Theo định nghĩa chuẩn của IEEE (Viện Kỹ sư Điện và Điện tử), phần mềm không chỉ bao gồm các chương trình máy tính (mã lệnh thực thi hoặc mã nguồn) mà còn bao gồm toàn bộ các cấu trúc dữ liệu cho phép chương trình thao tác với thông tin một cách thích hợp, cùng các tài liệu mô tả thao tác và cách sử dụng chương trình.", "Phần mềm (Software): ");
    add_bullet(doc, "Là việc áp dụng một cách tiếp cận có hệ thống, có kỷ luật và định lượng được vào việc phát triển, vận hành và bảo trì phần mềm; nghĩa là áp dụng kỹ nghệ vào phần mềm (IEEE Standard 610.12). Mục tiêu cốt lõi của kỹ nghệ phần mềm là tạo ra các sản phẩm phần mềm chất lượng cao, đúng hạn, trong phạm vi ngân sách dự kiến và thỏa mãn đầy đủ các yêu cầu của người dùng.", "Kỹ nghệ phần mềm (Software Engineering): ");
    add_bullet(doc, "Là khung cấu trúc bao gồm tập hợp các giai đoạn, hoạt động, nhiệm vụ và sản phẩm chuyển giao (artifacts) liên tiếp nhau, từ lúc hình thành ý tưởng ban đầu, khảo sát yêu cầu, thiết kế kiến trúc, cài đặt mã nguồn, kiểm thử, triển khai cho đến khi hệ thống bị loại bỏ hoàn toàn.", "Chu trình phát triển phần mềm (Software Development Life Cycle - SDLC): ");
    add_bullet(doc, "Là giai đoạn bản lề và mang tính quyết định trong SDLC. Thiết kế phần mềm là quá trình chuyển hóa các yêu cầu người dùng (những điều hệ thống CẦN LÀM - 'WHAT') thành một bản thiết kế chi tiết mô tả cấu trúc kỹ thuật nội tại, hành vi tương tác và phương thức hiện thực hóa (hệ thống sẽ ĐƯỢC LÀM NHƯ THẾ NÀO - 'HOW'). Theo Roger S. Pressman, thiết kế phần mềm là nơi chất lượng được cấy vào hệ thống, đóng vai trò cây cầu nối độc nhất vô nhị giữa giai đoạn phân tích yêu cầu với giai đoạn lập trình và kiểm thử.", "Thiết kế phần mềm (Software Design): ");
    
    add_heading_3(doc, "1.1.2. Chuyển đổi sang mô hình thiết kế")
    add_p(doc,
        "Một trong những thách thức lớn nhất trong kỹ nghệ phần mềm là sự đứt gãy giữa việc hiểu bài toán kinh doanh "
        "và việc tạo ra giải pháp kỹ thuật. Mô hình phân tích (Analysis Model) tập trung vào không gian bài toán (Problem Space), "
        "sử dụng ngôn ngữ của người dùng và chuyên gia nghiệp vụ để mô tả các thực thể nghiệp vụ (phụ tùng xe máy, mã phụ tùng, đơn hàng, giỏ hàng), "
        "các trường hợp sử dụng (Use Cases), kịch bản tương tác và các quy tắc kinh doanh. Tuy nhiên, lập trình viên không thể dựa trực tiếp "
        "vào mô hình phân tích để viết mã nguồn mà bắt buộc phải thông qua Mô hình thiết kế (Design Model) thuộc không gian giải pháp (Solution Space)."
    )
    add_p(doc,
        "Quá trình chuyển đổi từ mô hình phân tích sang mô hình thiết kế diễn ra qua bốn cấp độ kỹ thuật liên tục:", bold=True
    )
    add_bullet(doc, "Chuyển đổi các thực thể dữ liệu nghiệp vụ (Phụ tùng, Danh mục, Đơn hàng, Giao dịch) và sơ đồ thực thể liên kết (ERD mức khái niệm) thành mô hình cơ sở dữ liệu quan hệ cụ thể (Relational Schema mức vật lý trên MySQL), chuẩn hóa các bảng dữ liệu đạt chuẩn 3NF, xác định các trường khóa chính (Primary Key), khóa ngoại (Foreign Key), các chỉ mục (Indexes) và cơ chế toàn vẹn ràng buộc.", "1. Thiết kế Dữ liệu (Data/Class Design): ");
    add_bullet(doc, "Chuyển đổi sơ đồ Use Case và các gói phân tích thành cấu trúc tổng thể của hệ thống phần mềm, xác định các hệ thống con (Subsystems), các tầng phân chia trách nhiệm (Layers: Presentation, Business Logic, Data Access), các thành phần chính (Components) và các mối quan hệ giao tiếp, trao đổi thông điệp giữa chúng.", "2. Thiết kế Kiến trúc (Architectural Design): ");
    add_bullet(doc, "Bao gồm cả thiết kế giao diện người dùng (User Interface - UI/UX) và thiết kế giao diện phần mềm (Software Interfaces/APIs). Giao diện người dùng chuyển đổi các kịch bản tương tác Use Case thành hệ thống màn hình tra cứu phụ tùng, giỏ hàng, thanh toán; còn giao diện phần mềm xác định các chữ ký phương thức (Signatures), giao thức truyền tin (REST API, Webhook, RPC) giữa các thành phần nội bộ và giữa hệ thống với các dịch vụ bên thứ ba (Cổng MoMo, Giao Hàng Nhanh GHN).", "3. Thiết kế Giao diện (Interface Design): ");
    add_bullet(doc, "Chuyển đổi các mô tả chi tiết của từng bước xử lý Use Case thành các thuật toán cụ thể, thiết kế phương thức nội bộ của từng lớp, xác định các cấu trúc dữ liệu tạm thời, và lựa chọn các mẫu thiết kế (Design Patterns) phù hợp để tối ưu hóa tính linh hoạt của mã nguồn.", "4. Thiết kế Thành phần / Thiết kế Thành phần Chi tiết (Component-Level Design): ");
    
    add_p(doc,
        "Mối quan hệ chuyển đổi tuần tự giữa các pha trong chu trình kỹ nghệ hệ thống/thông tin được minh họa cô đọng "
        "qua sơ đồ kinh điển sau đây:"
    )
    
    diagram_sdlc = (
        "+-------------------------------------------------------------------------+\n"
        "|                 KỸ NGHỆ HỆ THỐNG / THÔNG TIN                           |\n"
        "|            (System / Information Engineering)                           |\n"
        "|                                                                         |\n"
        "|    +--------------------+            +--------------------+             |\n"
        "|    |     PHÂN TÍCH      | ---------> |      THIẾT KẾ      |             |\n"
        "|    |    (Analysis)      |            |      (Design)      |             |\n"
        "|    +--------------------+            +--------------------+             |\n"
        "+-------------------------------------------------|-----------------------+\n"
        "                                                  | Chuyển giao kỹ thuật\n"
        "                                                  v\n"
        "                                       +--------------------+\n"
        "                                       |      LẬP TRÌNH     |\n"
        "                                       |       (Code)       |\n"
        "                                       +--------------------+\n"
        "                                                  |\n"
        "                                                  v\n"
        "                                       +--------------------+\n"
        "                                       |      KIỂM THỬ      |\n"
        "                                       |       (Test)       |\n"
        "                                       +--------------------+"
    )
    add_diagram_box(doc, diagram_sdlc, "Hình 1.1: Sơ đồ chuyển đổi từ Phân tích sang Thiết kế trong Kỹ nghệ Phần mềm (Pressman Model)")

    # -------------------------------------------------------------
    # 1.2. Kiến trúc phần mềm
    # -------------------------------------------------------------
    add_heading_2(doc, "1.2. Kiến trúc phần mềm")
    
    add_heading_3(doc, "1.2.1. Khái niệm kiến trúc phần mềm")
    add_p(doc,
        "Theo định nghĩa của Viện Kỹ nghệ Phần mềm SEI (Carnegie Mellon University) trong công trình kinh điển của "
        "Len Bass, Paul Clements và Rick Kazman (Software Architecture in Practice): 'Kiến trúc phần mềm của một hệ thống "
        "là tập hợp các cấu trúc cần thiết để suy luận về hệ thống đó, bao gồm các phần tử phần mềm (software elements), "
        "các mối quan hệ giữa chúng (relations among them), cùng các thuộc tính của cả phần tử lẫn mối quan hệ'."
    )
    add_p(doc,
        "Khái niệm này khẳng định rõ ràng rằng kiến trúc phần mềm không phải là một sơ đồ hình khối duy nhất mà là một tập hợp "
        "các góc nhìn cấu trúc đa chiều. Để mô tả toàn diện một kiến trúc, Philippe Kruchten đã đề xuất Mô hình 4+1 Views (4+1 View Model), "
        "bao gồm các góc nhìn đặc trưng sau:"
    )
    add_bullet(doc, "Phản ánh các yêu cầu chức năng nghiệp vụ, phân rã hệ thống thành các lớp (Classes), đối tượng, và mối quan hệ kế thừa/liên kết. Đối tượng độc giả chính là các kỹ sư phân tích và thiết kế phần mềm.", "1. Góc nhìn Logic (Logical View): ");
    add_bullet(doc, "Phản ánh các khía cạnh đồng thời, luồng xử lý (Threads), tiến trình (Processes), cơ chế đồng bộ hóa, hiệu năng và tính sẵn sàng của hệ thống khi chạy trong thời gian thực. Phục vụ cho các kỹ sư tích hợp và kiến trúc sư hệ thống.", "2. Góc nhìn Tiến trình (Process View): ");
    add_bullet(doc, "Mô tả việc tổ chức các mô-đun mã nguồn, các gói phần mềm (Packages), thư viện dùng chung (Libraries), hệ thống quản lý mã nguồn (Source Control). Phục vụ cho lập trình viên và kỹ sư phát triển.", "3. Góc nhìn Phát triển (Development / Implementation View): ");
    add_bullet(doc, "Mô tả việc phân bổ các thành phần phần mềm lên phần cứng vật lý hoặc môi trường đám mây: máy chủ ứng dụng (Web Server Apache/Nginx), máy chủ cơ sở dữ liệu (MySQL Server), mạng truyền thông và cân bằng tải (Load Balancer). Phục vụ cho các kỹ sư triển khai và vận hành hệ thống (DevOps/SRE).", "4. Góc nhìn Triển khai (Physical / Deployment View): ");
    add_bullet(doc, "Đóng vai trò trung tâm (+1) liên kết 4 góc nhìn trên lại với nhau thông qua tập hợp các ca sử dụng then chốt của người dùng, giúp kiểm chứng xem kiến trúc có giải quyết trọn vẹn bài toán kinh doanh hay không.", "5. Góc nhìn Ca sử dụng (+1 Use Case View / Scenarios): ");

    add_diagram_box(doc,
        "                     +-------------------+\n"
        "                     |  Logical View     |\n"
        "                     |  (Class, Object)  |\n"
        "                     +---------+---------+\n"
        "                               |\n"
        "      +-------------------+    |    +-------------------+\n"
        "      | Development View  |----+----|  Process View     |\n"
        "      | (Packages, Modules)    |    |  (Threads, Sync)  |\n"
        "      +-------------------+    |    +-------------------+\n"
        "                               |\n"
        "                     +---------+---------+\n"
        "                     |  Use Case View    |  <-- Trục dung hòa then chốt\n"
        "                     |  (Scenarios)      |\n"
        "                     +---------+---------+\n"
        "                               |\n"
        "                     +---------+---------+\n"
        "                     |  Deployment View  |\n"
        "                     |  (Nodes, Network) |\n"
        "                     +-------------------+",
        "Hình 1.2: Mô hình kiến trúc 4+1 Views của Philippe Kruchten"
    )

    add_heading_3(doc, "1.2.2. Kiến trúc và các thuộc tính chất lượng")
    add_p(doc,
        "Một luận điểm nền tảng trong kiến trúc phần mềm được đúc kết bởi các chuyên gia kiến trúc hàng đầu thế giới: "
        "'Các yêu cầu chức năng (Functional Requirements) quyết định những gì hệ thống làm, nhưng chính các thuộc tính chất lượng "
        "(Quality Attributes) mới là nhân tố quyết định hình thái kiến trúc của hệ thống'. "
        "Đối với hệ thống thương mại điện tử phụ tùng xe máy, khi khách hàng tiến hành thanh toán giỏ hàng chứa nhiều linh kiện đắt tiền, "
        "hoặc hệ thống phải xử lý đồng thời hàng nghìn lượt tra cứu mã phụ tùng cùng lúc, kiến trúc phần mềm bắt buộc phải được thiết kế "
        "xoay quanh các thuộc tính chất lượng nghiêm ngặt:"
    )
    add_bullet(doc, "Thời gian phản hồi khi tra cứu danh mục phụ tùng xe máy (dưới 1.5 giây), thông lượng giao dịch (Throughput), và mức tiêu hao tài nguyên phần cứng (CPU, RAM, Băng thông mạng) khi hệ thống chịu tải.", "Hiệu năng (Performance): ");
    add_bullet(doc, "Tỷ lệ thời gian website bán hàng hoạt động liên tục 24/7 (đạt chuẩn 99.5% Up-time), cùng khả năng tự phục hồi khi xảy ra sự cố mạng kết nối API bên ngoài.", "Tính sẵn sàng (Availability): ");
    add_bullet(doc, "Bảo vệ thông tin thanh toán tài chính của khách hàng, bảo đảm tính bí mật (Confidentiality), tính toàn vẹn (Integrity), chống tấn công giả mạo Webhook IPN bằng chữ ký số HMAC-SHA256.", "An toàn và bảo mật (Security): ");
    add_bullet(doc, "Mức độ dễ dàng và chi phí khi cần bổ sung thêm danh mục phụ tùng mới, tích hợp thêm đối tác giao vận mới hoặc đổi cổng thanh toán mà không phá vỡ logic lõi hiện tại.", "Khả năng thay đổi và bảo trì (Modifiability / Maintainability): ");
    add_bullet(doc, "Khả năng nâng cao năng lực phục vụ của hệ thống (mở rộng theo chiều ngang - Horizontal Scaling hoặc chiều dọc - Vertical Scaling) khi số lượng sản phẩm phụ tùng tăng lên hàng vạn mã.", "Khả năng mở rộng (Scalability): ");
    add_bullet(doc, "Giao diện tra cứu phụ tùng rõ ràng, phân loại khoa học theo dòng xe và cụm chi tiết máy, giúp người dùng dễ dàng thao tác mua sắm mà không nhầm lẫn mã linh kiện.", "Khả năng sử dụng (Usability): ");

    add_heading_3(doc, "1.2.3. Yêu cầu có ý nghĩa kiến trúc")
    add_p(doc,
        "Không phải tất cả các yêu cầu phần mềm đều có tầm ảnh hưởng ngang nhau lên quyết định kiến trúc. "
        "Yêu cầu có ý nghĩa kiến trúc (Architecturally Significant Requirement - ASR) là những yêu cầu có tác động sâu sắc, "
        "định hình cấu trúc cốt lõi, chi phối sự phân chia các thành phần, cơ chế giao tiếp và cách quản lý tài nguyên của hệ thống."
    )
    add_p(doc,
        "Trong hệ thống MotoParts, các yêu cầu sau đây được xác định là ASRs then chốt:", bold=True
    )
    add_bullet(doc, "Yêu cầu tính toàn vẹn giao dịch đơn hàng phụ tùng: Khách hàng mua nhiều linh kiện cùng lúc phải đảm bảo tính toàn vẹn ACID, trừ tồn kho chính xác và không cho phép bán âm kho khi có tranh chấp đồng thời.");
    add_bullet(doc, "Yêu cầu bảo mật thanh toán tài chính: Giao tiếp với Cổng MoMo phải mã hóa chữ ký HMAC-SHA256, xác thực Webhook IPN hai chiều chống giả mạo.");
    add_bullet(doc, "Yêu cầu tính toán cước phí vận chuyển chính xác theo khoảng cách địa lý thông qua tích hợp API Giao Hàng Nhanh (GHN) thời gian thực.");
    add_bullet(doc, "Yêu cầu bảo mật tài khoản người dùng: Cơ chế xác thực tài khoản qua mã OTP gửi về Email nhằm phòng ngừa tài khoản ảo và spam đặt đơn.");

    # -------------------------------------------------------------
    # 1.3. Các nguyên lý thiết kế
    # -------------------------------------------------------------
    add_heading_2(doc, "1.3. Các nguyên lý thiết kế")
    
    add_heading_3(doc, "1.3.1. Trừu tượng hóa và che giấu thông tin")
    add_p(doc,
        "Trừu tượng hóa (Abstraction) là quá trình chỉ tập trung vào các đặc tính cốt lõi, bản chất của một đối tượng hoặc một hệ thống con "
        "mà bỏ qua các chi tiết cài đặt vụn vặt, không liên quan ở cấp độ hiện tại. Trừu tượng hóa cho phép các kỹ sư phần mềm kiểm soát "
        "độ phức tạp của hệ thống bằng cách chia nhỏ thành các tầng khái niệm rõ ràng."
    )
    add_p(doc,
        "Che giấu thông tin (Information Hiding) được David L. Parnas khởi xướng vào năm 1972, là nguyên tắc thiết kế yêu cầu mỗi mô-đun "
        "hoặc thành phần phần mềm chỉ nên công khai ra bên ngoài một giao diện (Interface) tối thiểu cần thiết để các thành phần khác tương tác, "
        "trong khi toàn bộ các chi tiết cấu trúc dữ liệu nội bộ, thuật toán thực thi và logic xử lý ngầm phải được đóng gói và ẩn giấu hoàn toàn. "
        "Ví dụ: Lớp `MomoService` ẩn giấu toàn bộ thuật toán tạo chuỗi rawHash và băm HMAC-SHA256, chỉ cung cấp ra ngoài phương thức đơn giản `createPaymentUrl(Order $order)`."
    )

    add_heading_3(doc, "1.3.2. Phân tách mối quan tâm và mô đun hóa")
    add_p(doc,
        "Phân tách mối quan tâm (Separation of Concerns - SoC) là nguyên lý chỉ đạo việc chia tách một chương trình phần mềm "
        "thành các phần riêng biệt, trong đó mỗi phần đảm nhận giải quyết một mối quan tâm (concern) cụ thể. Một 'mối quan tâm' "
        "có thể là nghiệp vụ logic (Business Logic), hiển thị giao diện (Presentation), lưu trữ dữ liệu (Data Persistence), "
        "hoặc các mối quan tâm cắt ngang (Cross-Cutting Concerns) như bảo mật, ghi nhật ký, kiểm tra quyền truy cập. "
        "Mô hình kiến trúc kinh điển MVC (Model-View-Controller) chính là hiện thân tiêu biểu của nguyên lý SoC."
    )
    add_p(doc,
        "Mô đun hóa (Modularity) là kỹ thuật chia hệ thống thành các khối độc lập có thể phân tích, thiết kế, cài đặt, "
        "kiểm thử và bảo trì một cách riêng rẽ. Trong hệ thống MotoParts, các mô-đun như Quản lý phụ tùng (Product), "
        "Đơn hàng (Order), Thanh toán (Payment), Vận chuyển (Shipping) và Hỗ trợ (Chat) được phân chia độc lập, "
        "giúp đội ngũ phát triển có thể làm việc song song mà không xung đột mã nguồn."
    )

    add_heading_3(doc, "1.3.3. Tính gắn kết và tính ghép nối")
    add_p(doc,
        "Tính gắn kết (Cohesion) và Tính ghép nối (Coupling) là hai thước đo định lượng và định tính quan trọng bậc nhất "
        "trong thiết kế cấu trúc phần mềm. Mục tiêu tối thượng của mọi kiến trúc sư phần mềm là đạt được: "
        "'Gắn kết cao (High Cohesion) và Ghép nối lỏng (Low/Loose Coupling)'."
    )
    add_bullet(doc, "Đo lường mức độ liên quan chặt chẽ giữa các nhiệm vụ, hàm số và trách nhiệm bên trong cùng một mô-đun. Một mô-đun có tính gắn kết cao nếu tất cả các phần tử bên trong nó cùng hướng tới thực hiện một mục tiêu nghiệp vụ duy nhất được định nghĩa rõ ràng. Ví dụ: `CartController` chỉ tập trung quản lý session giỏ hàng, thêm, xóa, cập nhật số lượng linh kiện xe máy.", "Tính gắn kết (Cohesion): ");
    add_bullet(doc, "Đo lường mức độ phụ thuộc lẫn nhau giữa các mô-đun khác nhau trong hệ thống. Một hệ thống có tính ghép nối chặt (Tight Coupling) đồng nghĩa với việc thay đổi tại một mô-đun sẽ tạo ra 'hiệu ứng domino' kéo theo sự thay đổi bắt buộc ở hàng loạt mô-đun khác. Ghép nối lỏng (Loose Coupling) đạt được khi các mô-đun chỉ tương tác với nhau thông qua các giao diện trừu tượng (Interfaces) mà không phụ thuộc vào chi tiết cài đặt cụ thể.", "Tính ghép nối (Coupling): ");

    add_table_styled(doc,
        ["Mức độ", "Loại gắn kết (Cohesion) từ Tệ -> Tốt", "Loại ghép nối (Coupling) từ Tốt -> Tệ"],
        [
            ("1", "Trùng hợp (Coincidental) - Tệ nhất: Gom bừa bãi", "Ghép nối thông điệp (Message/None) - Tốt nhất: Chỉ gửi dữ liệu qua thông điệp"),
            ("2", "Logic (Logical): Cùng nhóm chức năng nhưng qua cờ phân nhánh", "Ghép nối dữ liệu (Data Coupling): Chỉ truyền các tham số nguyên thủy đơn giản"),
            ("3", "Thời gian (Temporal): Gom các việc thực hiện cùng một thời điểm", "Ghép nối cấu trúc (Stamp Coupling): Truyền cả đối tượng/cấu trúc dữ liệu"),
            ("4", "Thủ tục (Procedural): Gom theo thứ tự các bước thực hiện", "Ghép nối điều khiển (Control Coupling): Truyền cờ điều khiển luồng mô-đun khác"),
            ("5", "Giao tiếp (Communicational): Cùng thao tác trên 1 tập dữ liệu", "Ghép nối ngoại biên (External Coupling): Phụ thuộc vào định dạng giao thức ngoài"),
            ("6", "Tuần tự (Sequential): Đầu ra của hàm này là đầu vào của hàm kia", "Ghép nối chung (Common Coupling): Nhiều mô-đun cùng truy cập biến toàn cục"),
            ("7", "Chức năng (Functional) - Tốt nhất: Thực hiện duy nhất 1 chức năng", "Ghép nối nội dung (Content Coupling) - Tệ nhất: Can thiệp trực tiếp vào mã lớp khác")
        ],
        [Inches(0.8), Inches(3.2), Inches(3.2)],
        "Bảng 1.1: Phân loại các mức độ Gắn kết (Cohesion) và Ghép nối (Coupling) trong Thiết kế Phần mềm"
    )

    add_heading_3(doc, "1.3.4. Nguyên lý SOLID")
    add_p(doc,
        "Được tổng hợp và hệ thống hóa bởi Robert C. Martin (Uncle Bob), 5 nguyên lý thiết kế hướng đối tượng SOLID "
        "đã trở thành kim chỉ nam cho việc tạo ra các hệ thống phần mềm dễ hiểu, dễ kiểm thử và có khả năng thích ứng linh hoạt "
        "với sự thay đổi liên tục của nghiệp vụ thương mại điện tử:"
    )
    
    add_p(doc, "1. S - Single Responsibility Principle (Nguyên lý Đơn trách nhiệm):", bold=True)
    add_p(doc,
        "'Một lớp chỉ nên có một và chỉ một lý do duy nhất để thay đổi'. Trong hệ thống MotoParts, mỗi lớp chỉ đảm nhận duy nhất một trách nhiệm nghiệp vụ: "
        "`ProductController` chỉ điều phối hiển thị và CRUD phụ tùng; `OrderController` quản lý luồng giỏ hàng và đặt đơn; "
        "`GHNController` chỉ lo tính phí vận chuyển và giao tiếp API GHN; `MomoController` chịu trách nhiệm tạo phiên và xử lý thanh toán MoMo. "
        "Nếu công thức tính phí của GHN thay đổi, chỉ có `GHNController` bị chỉnh sửa mà các phần quản lý phụ tùng và thanh toán không bị ảnh hưởng."
    )
    
    add_p(doc, "2. O - Open/Closed Principle (Nguyên lý Đóng/Mở):", bold=True)
    add_p(doc,
        "'Các thực thể phần mềm nên mở rộng để mở (Open for extension) nhưng đóng lại đối với việc sửa đổi (Closed for modification)'. "
        "Khi hệ thống cửa hàng phụ tùng cần bổ sung thêm cổng thanh toán VNPay hoặc ZaloPay bên cạnh Ví MoMo, "
        "chúng ta chỉ việc mở rộng bằng cách tạo lớp mới triển khai giao diện `PaymentGatewayInterface` "
        "mà không cần sửa đổi mã nguồn xử lý đơn hàng cốt lõi trong `OrderController`."
    )
    
    add_p(doc, "3. L - Liskov Substitution Principle (Nguyên lý Thay thế Liskov):", bold=True)
    add_p(doc,
        "'Các đối tượng của lớp con phải có khả năng thay thế hoàn toàn cho các đối tượng của lớp cha mà không làm thay đổi tính đúng đắn của chương trình'. "
        "Bất kỳ lớp triển khai cổng thanh toán cụ thể nào (MomoPaymentService, VNPayPaymentService) đều phải đảm bảo tuân thủ đầy đủ hợp đồng "
        "đầu vào và đầu ra của interface trừu tượng, không được trả về kiểu dữ liệu lạ hay ném ra ngoại lệ không được định nghĩa."
    )

    add_p(doc, "4. I - Interface Segregation Principle (Nguyên lý Phân tách Giao diện):", bold=True)
    add_p(doc,
        "'Khách hàng không nên bị ép buộc phải phụ thuộc vào các giao diện mà họ không sử dụng'. "
        "Thay vì thiết kế một Interface 'khổng lồ' chứa tất cả các phương thức của cửa hàng phụ tùng (quản lý kho, tính cước vận chuyển, thanh toán, gửi email), "
        "hệ thống phân tách thành nhiều giao diện chuyên biệt: `PaymentGatewayInterface`, `ShippingServiceInterface`, `ChatServiceInterface`."
    )

    add_p(doc, "5. D - Dependency Inversion Principle (Nguyên lý Đảo ngược Phụ thuộc):", bold=True)
    add_p(doc,
        "'Các mô-đun cấp cao không nên phụ thuộc vào các mô-đun cấp thấp. Cả hai nên phụ thuộc vào sự trừu tượng hóa'. "
        "Thông qua Inversion of Control (IoC Container) và Dependency Injection trong Laravel, các Controller không trực tiếp khởi tạo "
        "`new MomoService()` mà tiêm interface `PaymentGatewayInterface` qua Constructor, cho phép hoán đổi việc triển khai cụ thể dễ dàng."
    )

    # -------------------------------------------------------------
    # 1.4. Thể loại và phong cách kiến trúc
    # -------------------------------------------------------------
    add_heading_2(doc, "1.4. Thể loại và phong cách kiến trúc")
    
    add_heading_3(doc, "1.4.1. Thể loại kiến trúc")
    add_p(doc,
        "Khái niệm: Thể loại kiến trúc (Architectural Genre) là sự phân loại ở cấp độ vĩ mô, khái quát hóa các họ hệ thống phần mềm "
        "dựa trên bản chất của miền ứng dụng (Application Domain), đặc thù luồng thông tin xử lý chính và mục đích vận hành tổng quát của hệ thống."
    )
    add_p(doc, "Một số thể loại kiến trúc phổ biến:")
    add_bullet(doc, "Dữ liệu phụ tùng, khách hàng và đơn hàng được lưu trữ tập trung ở cơ sở dữ liệu quan hệ trung tâm (MySQL), các thành phần khác truy cập và thao tác dữ liệu qua ORM.", "Thể loại hướng tâm dữ liệu (Data-Centered Architecture): ");
    add_bullet(doc, "Dữ liệu di chuyển qua một chuỗi các thành phần xử lý (Pipes & Filters) tuần tự (ví dụ: luồng lọc dữ liệu sản phẩm, chuyển đổi định dạng hình ảnh phụ tùng).", "Thể loại luồng dữ liệu (Data-Flow Architecture): ");
    add_bullet(doc, "Hệ thống hoạt động dựa trên cơ chế phân cấp gọi hàm truyền thống, Controller gọi Service, Service gọi Repository/Model và trả về kết quả.", "Thể loại gọi và trả về (Call-and-Return Architecture): ");
    add_bullet(doc, "Các thành phần giao tiếp dựa trên việc phát sinh và lắng nghe sự kiện (ví dụ: sự kiện OrderCreated kích hoạt gửi email thông báo và cập nhật tồn kho phụ tùng).", "Thể loại kiến trúc hướng sự kiện (Event-Driven Architecture): ");
    add_bullet(doc, "Các nút trong mạng lưới đóng vai trò bình đẳng, tự động chia sẻ tài nguyên tính toán và lưu trữ mà không cần máy chủ trung tâm.", "Thể loại mạng ngang hàng (Peer-to-Peer Architecture): ");

    add_heading_3(doc, "1.4.2. Phong cách kiến trúc")
    add_p(doc,
        "Khái niệm: Phong cách kiến trúc (Architectural Style) là một tập hợp các quy tắc định hướng cấu trúc xác định một họ các hệ thống "
        "về mặt các loại thành phần (Components), các mối nối (Connectors) quy định cách thức giao tiếp giữa các thành phần, "
        "cùng các ràng buộc cấu trúc về cách chúng có thể được kết hợp với nhau."
    )
    add_p(doc, "Một số phong cách kiến trúc tiêu biểu:")
    add_bullet(doc, "Hệ thống được tổ chức thành các tầng phân cấp rõ rệt. Mỗi tầng đảm nhận một nhóm trách nhiệm kỹ thuật cụ thể và chỉ tương tác với tầng liền kề ngay bên dưới nó.", "Phong cách kiến trúc phân tầng (Layered / N-Tier Architecture): ");
    add_bullet(doc, "Phân tách ứng dụng thành 3 thành phần cốt lõi: Model (quản lý dữ liệu phụ tùng, đơn hàng), View (kết xuất giao diện hiển thị HTML/Blade), và Controller (tiếp nhận HTTP Request và điều phối luồng). MVC là chuẩn mực kiến trúc cho các hệ thống web thương mại điện tử hiện đại.", "Phong cách Model - View - Controller (MVC): ");
    add_bullet(doc, "Chia nhỏ ứng dụng thành tập hợp các dịch vụ nhỏ gọn triển khai độc lập, có cơ sở dữ liệu riêng biệt và giao tiếp qua API HTTP REST.", "Phong cách kiến trúc vi dịch vụ (Microservices Architecture): ");
    add_bullet(doc, "Tập trung kết nối các dịch vụ nghiệp vụ doanh nghiệp độc lập thông qua trục tích hợp dịch vụ (Enterprise Service Bus - ESB).", "Phong cách kiến trúc hướng dịch vụ (Service-Oriented Architecture - SOA): ");

    add_diagram_box(doc,
        "             [ HTTP Request: Khách xem / mua phụ tùng ]\n"
        "                                 |\n"
        "                                 v\n"
        "           +--------------------------------------------+\n"
        "           |                 CONTROLLER                 | <-----+  (Cập nhật giỏ hàng / AJAX)\n"
        "           |  (ProductController, OrderController, ...) |       |\n"
        "           +---------------------+----------------------+\n"
        "                                 |\n"
        "                  +--------------+--------------+\n"
        "                  |                             |\n"
        "                  v                             v\n"
        "   +-----------------------------+     +-----------------------------+\n"
        "   |            MODEL            |     |            VIEW             |\n"
        "   | (Product, Order, Category)  |     |   (Blade Template Engine)   |\n"
        "   +--------------+--------------+     +-----------------------------+\n"
        "                  |                             ^\n"
        "                  +-----------------------------+\n"
        "                     Cung cấp dữ liệu phụ tùng",
        "Hình 1.3: Cấu trúc cơ bản của Mẫu kiến trúc Model - View - Controller (MVC) trong Hệ thống MotoParts"
    )

    add_heading_3(doc, "1.4.3. So sánh thể loại và phong cách kiến trúc")
    add_p(doc,
        "Bảng so sánh chi tiết dưới đây phân định rạch ròi giữa Thể loại kiến trúc và Phong cách kiến trúc:"
    )

    add_table_styled(doc,
        ["Tiêu chí so sánh", "Thể loại kiến trúc (Architectural Genre)", "Phong cách kiến trúc (Architectural Style)"],
        [
            ("Mức độ trừu tượng", "Ở cấp độ bao quát toàn diện, liên quan trực tiếp đến bản chất bài toán kinh doanh.", "Ở cấp độ cấu trúc kỹ thuật cụ thể hơn, chỉ rõ cách thức tổ chức các thành phần mã nguồn."),
            ("Mục tiêu định hướng", "Định danh xem hệ thống thuộc loại nào (E-Commerce bán lẻ phụ tùng xe máy, hệ thống thời gian thực...).", "Định hướng cách ghép nối các khối thành phần, luồng điều khiển và truyền dữ liệu trong hệ thống."),
            ("Yếu tố cấu thành", "Xác định miền dữ liệu, môi trường hoạt động và phương thức tương tác người dùng tổng thể.", "Xác định tập hợp Components (Bộ điều khiển, Dữ liệu, Giao diện) và Connectors (Hàm gọi, Socket, HTTP)."),
            ("Ràng buộc cấu trúc", "Không áp đặt các quy tắc khắt khe về việc phân lớp hay giao tiếp giữa các module cụ thể.", "Đưa ra các ràng buộc nghiêm ngặt (ví dụ: trong Layered, tầng trên chỉ được gọi tầng dưới, không được đi ngược)."),
            ("Ví dụ tiêu biểu", "Data-Centered (Hướng tâm CSDL phụ tùng), E-Commerce Retail System.", "Layered 3-Tier, MVC, Microservices, Event-Driven Architecture, Repository Pattern.")
        ],
        [Inches(1.5), Inches(2.8), Inches(2.8)],
        "Bảng 1.2: So sánh chi tiết giữa Thể loại kiến trúc và Phong cách kiến trúc"
    )

    # -------------------------------------------------------------
    # 1.5. Mẫu thiết kế
    # -------------------------------------------------------------
    add_heading_2(doc, "1.5. Mẫu thiết kế")
    add_p(doc,
        "Mẫu thiết kế (Design Pattern) được định nghĩa là giải pháp tổng quát, có thể tái sử dụng cho một vấn đề phổ biến "
        "thường xuyên xảy ra trong quá trình thiết kế phần mềm hướng đối tượng trong một ngữ cảnh cụ thể. "
        "Mẫu thiết kế không phải là một đoạn mã nguồn hoàn chỉnh có thể dán trực tiếp vào chương trình, mà là một khuôn mẫu tư duy "
        "(Template) hướng dẫn cách cấu trúc các lớp và đối tượng để giải quyết triệt để vấn đề mà không phát sinh tác dụng phụ."
    )
    add_p(doc,
        "Năm 1994, nhóm 'Gang of Four' (GoF) gồm Erich Gamma, Richard Helm, Ralph Johnson và John Vlissides đã xuất bản tác phẩm bất hủ "
        "'Design Patterns: Elements of Reusable Object-Oriented Software', hệ thống hóa 23 mẫu thiết kế kinh điển chia thành 3 nhóm lớn:"
    )
    
    add_bullet(doc, "Tập trung vào cơ chế khởi tạo đối tượng một cách linh hoạt, che giấu chi tiết khởi tạo và tách rời việc tạo lập khỏi mã sử dụng đối tượng. Bao gồm: Factory Method, Abstract Factory, Builder, Prototype, Singleton.", "Nhóm Khởi tạo (Creational Patterns): ");
    add_bullet(doc, "Tập trung vào cách ghép nối, kết hợp các lớp và đối tượng lại với nhau để tạo thành các cấu trúc phức tạp hơn nhưng vẫn duy trì tính mềm dẻo. Bao gồm: Adapter, Bridge, Composite, Decorator, Facade, Flyweight, Proxy.", "Nhóm Cấu trúc (Structural Patterns): ");
    add_bullet(doc, "Tập trung vào sự phân bổ trách nhiệm, thuật toán và luồng giao tiếp, trao đổi thông điệp nhịp nhàng giữa các đối tượng. Bao gồm: Chain of Responsibility, Command, Interpreter, Iterator, Mediator, Memento, Observer, State, Strategy, Template Method, Visitor.", "Nhóm Hành vi (Behavioral Patterns): ");

    add_table_styled(doc,
        ["Nhóm Mẫu", "Tên Mẫu Thiết Kế GoF", "Ứng dụng tiêu biểu trong Hệ thống Cửa hàng Phụ tùng Xe máy (MotoParts)"],
        [
            ("Creational", "Singleton", "Quản lý đối tượng kết nối Cơ sở dữ liệu MySQL duy nhất (Database Connection Pool) và cấu hình toàn cục hệ thống cửa hàng."),
            ("Creational", "Factory Method", "Khởi tạo đối tượng cổng thanh toán tương ứng (MomoPaymentService hoặc VNPayService) dựa trên phương thức khách hàng chọn lúc Checkout."),
            ("Structural", "Facade", "Lớp `MomoController` đóng vai trò Facade che giấu sự phức tạp của việc tạo chuỗi rawHash, băm HMAC-SHA256 và gửi HTTP cURL sang máy chủ MoMo."),
            ("Structural", "Adapter", "Lớp `GHNController` chuyển đổi cấu trúc địa chỉ giao hàng và trọng lượng phụ tùng của hệ thống sang định dạng chuẩn payload của API Giao Hàng Nhanh."),
            ("Behavioral", "Strategy", "Cài đặt các chiến lược tính cước vận chuyển khác nhau (Nội thành, Liên tỉnh, Hỏa tốc) hoặc chính sách giá sỉ/lẻ cho phụ tùng xe máy."),
            ("Behavioral", "Observer", "Lắng nghe sự kiện `OrderPlacedEvent`: tự động trừ số lượng tồn kho của phụ tùng trong bảng `products`, gửi email xác nhận và ghi log giao dịch."),
            ("Behavioral", "State", "Quản lý vòng đời trạng thái của đơn hàng phụ tùng: Chờ xử lý (pending) -> Đã xác nhận (confirmed) -> Đang giao hàng (shipping) -> Đã giao (completed) / Đã hủy (cancelled).")
        ],
        [Inches(1.2), Inches(1.8), Inches(4.2)],
        "Bảng 1.3: Bảng tổng hợp các Mẫu thiết kế GoF và Ngữ cảnh ứng dụng trong Hệ thống MotoParts"
    )

    # -------------------------------------------------------------
    # 1.6. Kết luận chương 1
    # -------------------------------------------------------------
    add_heading_2(doc, "1.6. Kết luận chương 1")
    add_p(doc,
        "Chương 1 đã thiết lập một hệ thống cơ sở lý thuyết toàn diện, khoa học và vững chắc về kỹ nghệ kiến trúc và thiết kế phần mềm. "
        "Các nội dung trọng tâm đã được phân tích thấu đáo bao gồm:"
    )
    add_bullet(doc, "Làm rõ vị trí trung tâm của pha thiết kế phần mềm trong chu trình SDLC, quy luật chuyển dịch từ mô hình phân tích bài toán (Analysis Model) sang bốn khía cạnh của mô hình thiết kế giải pháp (Design Model: Dữ liệu, Kiến trúc, Giao diện, Thành phần).");
    add_bullet(doc, "Nắm vững bản chất của kiến trúc phần mềm thông qua mô hình 4+1 Views; khẳng định tầm quan trọng sống còn của các thuộc tính chất lượng (Hiệu năng, Sẵn sàng, Bảo mật, Mở rộng) và cách nhận diện các yêu cầu có ý nghĩa kiến trúc (ASRs) trong hệ thống bán phụ tùng xe máy.");
    add_bullet(doc, "Hệ thống hóa sâu sắc các nguyên lý thiết kế kinh điển: Trừu tượng hóa, Che giấu thông tin, Phân tách mối quan tâm, Mô đun hóa, quy luật Gắn kết cao - Ghép nối lỏng, và đặc biệt là bộ 5 nguyên lý SOLID.");
    add_bullet(doc, "Phân định rạch ròi giữa thể loại kiến trúc và phong cách kiến trúc; hiểu rõ cơ chế vận hành của phong cách phân tầng kết hợp mô hình MVC; cũng như nắm bắt cách thức vận dụng 23 mẫu thiết kế GoF.");
    add_p(doc,
        "Toàn bộ nền tảng lý luận này sẽ là cơ sở khoa học trực tiếp để nhóm nghiên cứu tiến hành phân tích chi tiết bài toán thực tế, "
        "đặc tả yêu cầu chức năng, mô hình hóa quy trình và thiết lập kiến trúc cho 'Hệ thống Thương mại Điện tử và Quản lý Cửa hàng Phụ tùng Xe máy Trực tuyến (MotoParts)' "
        "trong các chương tiếp theo."
    )
    
    doc.add_page_break()
