@if(View::hasSection('content'))
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 4.1. Khu vực Header (Bảo mật) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cửa Hàng Phụ Kiện Xe Máy')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @yield('content')
@else
    @if(!View::hasSection('csrf_rendered'))
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif
@endif

<!-- Chat Box Styles for User -->
<style>
    #chat-box {
        position: fixed !important;
        bottom: 25px !important;
        right: 25px !important;
        z-index: 999999 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    #chat-toggle {
        padding: 12px 22px !important;
        border-radius: 50px !important;
        background: #007bff !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4) !important;
        cursor: pointer !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-decoration: none !important;
    }
    #chat-toggle:hover {
        background: #0056b3 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5) !important;
        color: #fff !important;
    }
    #chat-popup {
        position: fixed !important;
        bottom: 25px !important;
        right: 25px !important;
        width: 380px !important;
        max-width: calc(100vw - 30px) !important;
        background: #fff !important;
        border-radius: 14px !important;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.28) !important;
        overflow: hidden !important;
        z-index: 999999 !important;
        border: 1px solid rgba(0, 0, 0, 0.12) !important;
        display: none;
        flex-direction: column !important;
    }
    #chat-popup .card-header {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
        color: #fff !important;
        padding: 12px 16px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-weight: 600 !important;
    }
    #chat-popup .card-header .bot-badge {
        font-size: 11px;
        background: rgba(255, 255, 255, 0.25);
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 500;
        margin-left: 6px;
    }
    #chat-close {
        background: rgba(255, 255, 255, 0.2) !important;
        border: none !important;
        color: #fff !important;
        border-radius: 50% !important;
        width: 26px !important;
        height: 26px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 12px !important;
        cursor: pointer !important;
        font-weight: bold !important;
        transition: background 0.2s;
    }
    #chat-close:hover {
        background: rgba(255, 255, 255, 0.4) !important;
    }
    #chat-messages {
        height: 310px !important;
        max-height: 48vh !important;
        overflow-y: auto !important;
        padding: 14px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        background: #f8f9fa !important;
    }
    .message-row {
        padding: 9px 13px !important;
        border-radius: 14px !important;
        max-width: 82% !important;
        word-break: break-word !important;
        font-size: 13px !important;
        line-height: 1.45 !important;
        white-space: pre-line !important;
    }
    .user-msg {
        align-self: flex-end !important;
        background: #007bff !important;
        color: #fff !important;
        border-bottom-right-radius: 3px !important;
        margin-left: auto !important;
        text-align: left !important;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2) !important;
    }
    .admin-msg {
        align-self: flex-start !important;
        background: #ffffff !important;
        color: #212529 !important;
        border-bottom-left-radius: 3px !important;
        margin-right: auto !important;
        text-align: left !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04) !important;
    }
    /* Quick Questions Area */
    #chat-quick-questions {
        padding: 8px 12px !important;
        background: #f1f5f9 !important;
        border-top: 1px solid #e2e8f0 !important;
        display: flex !important;
        gap: 6px !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        scrollbar-width: none !important;
    }
    #chat-quick-questions::-webkit-scrollbar {
        display: none;
    }
    .chat-quick-btn {
        background: #fff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        padding: 5px 11px !important;
        border-radius: 20px !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        flex-shrink: 0 !important;
    }
    .chat-quick-btn:hover {
        background: #007bff !important;
        color: #fff !important;
        border-color: #007bff !important;
        transform: translateY(-1px);
    }
    #chat-popup .card-footer {
        padding: 10px 12px !important;
        background: #fff !important;
        border-top: 1px solid #e9ecef !important;
    }
    #chat-popup .input-group {
        display: flex !important;
        gap: 6px !important;
    }
    #chat-input {
        flex: 1 !important;
        padding: 8px 12px !important;
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        outline: none !important;
        font-size: 13px !important;
    }
    #chat-input:focus {
        border-color: #80bdff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2) !important;
    }
    #send-btn {
        background: #28a745 !important;
        color: #fff !important;
        border: none !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        transition: background 0.2s;
    }
    #send-btn:hover {
        background: #218838 !important;
    }
</style>

<!-- 4.2. Khu vực Body (Giao diện hiển thị) -->
@auth
<div id="chat-box">
    <button id="chat-toggle" class="btn btn-primary rounded-circle shadow">💬 Chat</button>
    <div id="chat-popup" class="card shadow-lg" style="display:none; border-radius: 14px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <span class="font-weight-bold">Tư vấn bán hàng</span>
                <span style="font-size: 11px; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px; margin-left: 6px;"><span style="color: #28a745; font-size: 13px;">●</span> Đang online</span>
            </div>
            <button id="chat-close" class="btn btn-sm btn-light">✕</button>
        </div>
        <div id="chat-messages" class="card-body">
            <small class="text-muted">Đang tải lịch sử...</small>
        </div>

        <!-- Chat: Gợi ý câu hỏi nhanh -->
        <div id="chat-quick-questions">
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('🚚 Phí ship và thời gian giao hàng bao lâu?')">🚚 Phí ship?</button>
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('📦 Kiểm tra đơn hàng của mình')">📦 Đơn hàng?</button>
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('💳 Shop có những hình thức thanh toán nào?')">💳 Thanh toán?</button>
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('🛠 Chính sách bảo hành và đổi trả hàng thế nào?')">🛠 Bảo hành?</button>
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('🏍️ Shop tư vấn phụ tùng cho xe của mình với!')">🏍️ Phụ tùng?</button>
            <button type="button" class="chat-quick-btn" onclick="sendQuickMessage('📞 Cho mình xin hotline và địa chỉ shop!')">📞 Hotline?</button>
        </div>

        <div class="card-footer bg-white">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off">
                <div class="input-group-append">
                    <button id="send-btn" class="btn btn-success">Gửi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div id="chat-box">
    <a href="{{ route('login') }}" id="chat-toggle" class="btn btn-primary rounded-circle shadow" title="Đăng nhập để chat với Admin">
        💬 Chat
    </a>
</div>
@endauth

<!-- 4.3. Khu vực Script (Logic xử lý) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("chat-toggle");
    const chatPopup = document.getElementById("chat-popup");
    const closeBtn = document.getElementById("chat-close");
    const sendBtn = document.getElementById("send-btn");
    const input = document.getElementById("chat-input");
    const chatBox = document.getElementById("chat-messages");

    if (!toggleBtn || !chatPopup) return; // Nếu khách chưa đăng nhập thì không chạy script chat

    // --- MỞ / ĐÓNG CHAT ---
    toggleBtn.onclick = () => {
        chatPopup.style.display = "flex";
        toggleBtn.style.display = "none";
        loadMessages();
    };

    closeBtn.onclick = () => {
        chatPopup.style.display = "none";
        toggleBtn.style.display = "inline-flex";
    };

    // --- LOAD TIN NHẮN ---
    window.loadMessages = function() {
        fetch("{{ route('user.chat.messages') }}")
            .then(res => res.json())
            .then(messages => {
                let html = "";
                if (!messages || messages.length === 0) {
                    html = `
                        <div class='text-center text-muted p-2'>
                            <p style="margin-bottom: 6px;">👋 Chào anh/chị! Em là nhân viên tư vấn của shop.</p>
                            <small>Anh/chị cần hỗ trợ tìm phụ tùng cho dòng xe nào hay kiểm tra đơn hàng, cứ nhắn trực tiếp hoặc chọn gợi ý bên dưới nhé!</small>
                        </div>
                    `;
                } else {
                    messages.forEach(msg => {
                        const isMe = msg.sender_id == "{{ Auth::id() }}";
                        // Escape HTML an toan va chuyen doi \n thanh <br>
                        const safeContent = $('<div>').text(msg.content).html().replace(/\n/g, '<br>');
                        html += `
                            <div class="message-row ${isMe ? 'user-msg' : 'admin-msg'}">
                                <strong>${isMe ? 'Bạn' : 'Tư vấn viên'}:</strong> ${safeContent}
                            </div>
                        `;
                    });
                }
                chatBox.innerHTML = html;
                chatBox.scrollTop = chatBox.scrollHeight; // Tự động cuộn xuống cuối
            })
            .catch(err => console.error("Lỗi tải tin nhắn:", err));
    };

    // --- GỬI TIN NHẮN ---
    window.sendMessage = function(customText) {
        let message = (customText !== undefined && typeof customText === 'string') ? customText.trim() : input.value.trim();
        if (message === "") return;

        // Vô hiệu hóa input/button khi đang gửi để tránh gửi lặp
        input.disabled = true;
        sendBtn.disabled = true;

        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '{{ csrf_token() }}';

        fetch("{{ route('user.chat.send') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            input.value = "";
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
            // Cập nhật lại khung chat ngay lập tức (sẽ hiển thị cả câu hỏi lẫn phản hồi tự động)
            setTimeout(loadMessages, 300);
        })
        .catch(err => {
            console.error("Lỗi gửi tin:", err);
            input.disabled = false;
            sendBtn.disabled = false;
        });
    };

    // Hàm gửi nhanh từ các nút gợi ý
    window.sendQuickMessage = function(text) {
        window.sendMessage(text);
    };

    // Sự kiện Click nút Gửi
    sendBtn.onclick = () => window.sendMessage();

    // Sự kiện nhấn phím Enter
    input.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            window.sendMessage();
        }
    });

    // --- AUTO REFRESH (3 giây/lần) ---
    setInterval(() => {
        if (chatPopup && chatPopup.style.display !== "none") {
            loadMessages();
        }
    }, 3000);
});
</script>

@if(View::hasSection('content'))
    @stack('scripts')
</body>
</html>
@endif
