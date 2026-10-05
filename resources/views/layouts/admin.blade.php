@if(View::hasSection('content'))
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 4.1. Khu vực Header (Bảo mật) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản Trị Hệ Thống - Admin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Admin Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high text-warning mr-1"></i> Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house mr-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-box mr-1"></i> Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-file-invoice mr-1"></i> Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.index') }}"><i class="fa-solid fa-chart-pie mr-1"></i> Báo cáo</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users mr-1"></i> Quản lý người dùng</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item text-white mr-3">
                        <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold">
                            <i class="fa-solid fa-user-shield mr-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>
@else
    @if(!View::hasSection('csrf_rendered'))
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif
@endif

<!-- Admin Chat Box Styles -->
<style>
    #admin-chat-box {
        position: fixed !important;
        bottom: 25px !important;
        right: 25px !important;
        z-index: 999999 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    #admin-chat-box #chat-toggle {
        padding: 12px 22px !important;
        border-radius: 50px !important;
        background: #212529 !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        cursor: pointer !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
    }
    #admin-chat-box #chat-toggle:hover {
        background: #000 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
    }
    #admin-chat-box #chat-popup {
        display: none;
        position: fixed !important;
        bottom: 25px !important;
        right: 25px !important;
        width: 440px !important;
        max-width: calc(100vw - 40px) !important;
        background: #fff !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3) !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        z-index: 999999 !important;
        overflow: hidden !important;
    }
    #admin-chat-box .card-header {
        background: #212529 !important;
        color: #fff !important;
        padding: 12px 16px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }
    #admin-chat-box #chat-close {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        border: none !important;
        padding: 2px 8px !important;
        border-radius: 4px !important;
        cursor: pointer !important;
        font-weight: bold !important;
    }
    #admin-chat-box #chat-close:hover {
        background: rgba(255, 255, 255, 0.4) !important;
    }
    #admin-chat-box #user-list {
        max-height: 110px !important;
        overflow-y: auto !important;
        background: #f8f9fa !important;
        border-bottom: 1px solid #dee2e6 !important;
        display: flex !important;
        flex-wrap: wrap !important;
        padding: 8px !important;
        gap: 6px !important;
    }
    #admin-chat-box .user-item {
        padding: 5px 12px !important;
        background: #fff !important;
        border: 1px solid #ced4da !important;
        border-radius: 16px !important;
        cursor: pointer !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #495057 !important;
        transition: all 0.2s !important;
    }
    #admin-chat-box .user-item:hover {
        background: #e9ecef !important;
        border-color: #adb5bd !important;
    }
    #admin-chat-box .user-item.active {
        background: #007bff !important;
        color: #fff !important;
        border-color: #007bff !important;
    }
    #admin-chat-box #chat-messages {
        height: 270px !important;
        overflow-y: auto !important;
        padding: 12px !important;
        background: #fff !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
    }
    #admin-chat-box .msg-row {
        padding: 7px 12px !important;
        border-radius: 8px !important;
        background: #f8f9fa !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
        max-width: 85% !important;
        word-break: break-word !important;
    }
    #admin-chat-box .card-footer {
        padding: 10px 12px !important;
        background: #fff !important;
        border-top: 1px solid #dee2e6 !important;
    }
    #admin-chat-box .input-group {
        display: flex !important;
        gap: 6px !important;
    }
    #admin-chat-box #chat-input {
        flex: 1 !important;
        padding: 7px 12px !important;
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        outline: none !important;
    }
    #admin-chat-box #chat-input:focus {
        border-color: #80bdff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
    #admin-chat-box #send-btn {
        background: #28a745 !important;
        color: #fff !important;
        border: none !important;
        padding: 7px 14px !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        cursor: pointer !important;
        font-weight: 500 !important;
    }
    #admin-chat-box #send-btn:hover {
        background: #218838 !important;
    }
</style>

<!-- 4.2. Khu vực Body (Giao diện hiển thị) -->
<div id="admin-chat-box">
    <button id="chat-toggle" class="btn btn-dark shadow">💬 Chat Khách hàng</button>
    <div id="chat-popup" class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div>
                <strong><i class="fa-solid fa-comments text-warning mr-1"></i> Hỗ trợ & Nhắn tin KH</strong>
                <div id="chat-recipient-title" class="small text-info font-weight-bold" style="font-size: 11px;"></div>
            </div>
            <button id="chat-close" class="btn btn-sm btn-light">✕</button>
        </div>
        
        <!-- Search & Filter bar for selecting any customer -->
        <div class="px-2 pt-2 bg-light border-bottom">
            <input type="text" id="admin-user-search" class="form-control form-control-sm mb-1" placeholder="🔍 Tìm khách hàng để nhắn..." oninput="handleUserSearch(this.value)">
            <div class="d-flex justify-content-between align-items-center pb-1">
                <small class="text-muted font-weight-bold" style="font-size: 11px;" id="user-filter-info">Chọn khách hàng để chat</small>
                <div class="btn-group btn-group-sm">
                    <button type="button" id="filter-all-btn" class="btn btn-outline-primary btn-xs py-0 px-2 active" style="font-size: 10px;" onclick="switchUserTab('all')">Tất cả</button>
                    <button type="button" id="filter-chatted-btn" class="btn btn-outline-secondary btn-xs py-0 px-2" style="font-size: 10px;" onclick="switchUserTab('chatted')">Đã chat</button>
                </div>
            </div>
        </div>

        <div id="user-list">
            <div class="p-2 text-center text-muted"><small>Đang tải danh sách...</small></div>
        </div>

        <div id="chat-messages">
            <div class="text-center mt-5 text-muted">
                <i class="fa-solid fa-users fa-2x mb-2 text-secondary"></i>
                <div>Chọn một khách hàng để bắt đầu nhắn tin</div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control form-control-sm" placeholder="Nhập tin nhắn...">
                <div class="input-group-append">
                    <button id="send-btn" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-paper-plane"></i> Gửi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4.3. Khu vực Script (Logic xử lý) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let currentUserId = null;
let currentUserName = '';
let allUsersData = [];
let currentFilterTab = 'all'; // 'all' | 'chatted'
let currentSearchTerm = '';

const chatPopup = document.getElementById("chat-popup");
const chatMessages = document.getElementById("chat-messages");
const chatInput = document.getElementById("chat-input");
const recipientTitle = document.getElementById("chat-recipient-title");

// Mở/Đóng popup
document.getElementById("chat-toggle").onclick = () => {
    chatPopup.style.display = "block";
    loadUsers();
};

document.getElementById("chat-close").onclick = () => {
    chatPopup.style.display = "none";
};

// 1. Load danh sách User (cả khách hàng chưa nhắn)
function loadUsers(callback) {
    fetch("{{ route('admin.chat.users') }}")
        .then(res => res.json())
        .then(users => {
            allUsersData = users || [];
            renderUserList();
            if (typeof callback === 'function') callback();
        })
        .catch(err => console.error("Lỗi tải users:", err));
}

function handleUserSearch(term) {
    currentSearchTerm = term.trim().toLowerCase();
    renderUserList();
}

function switchUserTab(tab) {
    currentFilterTab = tab;
    document.getElementById('filter-all-btn').classList.toggle('active', tab === 'all');
    document.getElementById('filter-all-btn').classList.toggle('btn-outline-primary', tab === 'all');
    document.getElementById('filter-all-btn').classList.toggle('btn-outline-secondary', tab !== 'all');

    document.getElementById('filter-chatted-btn').classList.toggle('active', tab === 'chatted');
    document.getElementById('filter-chatted-btn').classList.toggle('btn-outline-primary', tab === 'chatted');
    document.getElementById('filter-chatted-btn').classList.toggle('btn-outline-secondary', tab !== 'chatted');

    renderUserList();
}

function renderUserList() {
    let filtered = allUsersData.filter(u => {
        if (currentFilterTab === 'chatted' && !u.has_chatted) return false;
        if (currentSearchTerm) {
            let matchName = (u.name || '').toLowerCase().includes(currentSearchTerm);
            let matchEmail = (u.email || '').toLowerCase().includes(currentSearchTerm);
            return matchName || matchEmail;
        }
        return true;
    });

    let html = "";
    if (filtered.length > 0) {
        filtered.forEach(user => {
            let activeClass = (currentUserId == user.id) ? 'active' : '';
            let badge = user.has_chatted 
                ? '<span class="badge badge-success ml-1" style="font-size: 9px;">Đã chat</span>' 
                : '<span class="badge badge-light border ml-1 text-muted" style="font-size: 9px;">Mới</span>';
            
            html += `<div class="user-item ${activeClass}" onclick="selectUser(${user.id}, '${escapeHtml(user.name)}')">
                <i class="fa-solid fa-user-circle mr-1"></i> ${user.name} ${badge}
            </div>`;
        });
    } else {
        html = '<div class="p-2 text-center text-muted small w-100">Không tìm thấy khách hàng</div>';
    }
    document.getElementById("user-list").innerHTML = html;
}

function escapeHtml(str) {
    return (str || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

// 2. Chọn User để chat
function selectUser(userId, userName) {
    currentUserId = userId;
    currentUserName = userName || 'Khách hàng #' + userId;
    if (recipientTitle) {
        recipientTitle.innerText = `Đang chat với: ${currentUserName}`;
    }
    // Highlight user được chọn
    document.querySelectorAll('.user-item').forEach(el => el.classList.remove('active'));
    renderUserList();
    loadMessages();
}

// 3. Load tin nhắn của User đang được chọn
function loadMessages() {
    if (!currentUserId) return;
    fetch(`/admin/chat/messages/${currentUserId}`)
        .then(res => res.json())
        .then(messages => {
            let html = "";
            if (messages && messages.length > 0) {
                messages.forEach(msg => {
                    let senderName = msg.sender_id == "{{ Auth::id() }}" ? "Bạn" : (msg.sender ? msg.sender.name : 'Khách hàng');
                    let color = msg.sender_id == "{{ Auth::id() }}" ? "#007bff" : "#212529";
                    html += `<div class="msg-row" style="color: ${color}">
                        <strong>${senderName}:</strong> ${msg.content}
                    </div>`;
                });
            } else {
                html = `<div class="text-center text-muted p-4">
                    <i class="fa-regular fa-comment-dots fa-2x mb-2 text-primary"></i>
                    <div>Chưa có tin nhắn nào với <strong>${currentUserName}</strong>.</div>
                    <small>Bạn có thể gửi tin nhắn đầu tiên để hỗ trợ khách hàng ngay!</small>
                </div>`;
            }
            chatMessages.innerHTML = html;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(err => console.error("Lỗi tải tin nhắn:", err));
}

// 4. Gửi tin nhắn cho User
function sendMessage() {
    let message = chatInput.value.trim();
    if (!message || !currentUserId) {
        if (!currentUserId) alert("Vui lòng chọn một khách hàng từ danh sách để gửi tin nhắn.");
        return;
    }

    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '{{ csrf_token() }}';

    fetch("{{ route('admin.chat.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
            message: message,
            user_id: currentUserId
        })
    })
    .then(res => res.json())
    .then(data => {
        chatInput.value = "";
        loadMessages();
        // Đánh dấu khách hàng này đã chat trong danh sách
        let u = allUsersData.find(x => x.id == currentUserId);
        if (u) u.has_chatted = true;
        renderUserList();
    })
    .catch(err => console.error("Lỗi gửi tin:", err));
}

document.getElementById("send-btn").onclick = sendMessage;
chatInput.onkeypress = (e) => { if(e.key === 'Enter') sendMessage(); };

// Mở chat với người dùng cụ thể từ bất kỳ đâu trên trang
window.openAdminChatWithUser = function(userId, userName) {
    chatPopup.style.display = "block";
    currentUserId = userId;
    currentUserName = userName;
    loadUsers(() => {
        selectUser(userId, userName);
    });
};

// 5. Polling (Tự động cập nhật mỗi 3 giây)
setInterval(() => {
    if (chatPopup && chatPopup.style.display === "block" && currentUserId) {
        loadMessages();
    }
}, 3000);
</script>

@if(View::hasSection('content'))
    @stack('scripts')
</body>
</html>
@endif
