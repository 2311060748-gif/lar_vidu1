<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Lấy danh sách người dùng (gồm người đã chat và tất cả khách hàng khác để Admin chủ động nhắn trước)
     */
    public function getUsers(Request $request)
    {
        $adminId = Auth::id();
        $search = trim($request->query('search', ''));

        // Lấy danh sách ID và tin nhắn mới nhất của những user đã tương tác với admin
        $chattedUserIds = Message::where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($msg) use ($adminId) {
                return $msg->sender_id == $adminId ? $msg->receiver_id : $msg->sender_id;
            })
            ->unique()
            ->values()
            ->toArray();

        // Lấy tất cả user (trừ admin hiện tại)
        $query = User::where('id', '!=', $adminId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->select('id', 'name', 'email', 'role')->get();

        // Sắp xếp: user đã từng chat lên đầu (theo thứ tự tin nhắn mới nhất), user chưa chat xếp sau
        $sortedUsers = $users->map(function ($user) use ($chattedUserIds) {
            $index = array_search($user->id, $chattedUserIds);
            $user->has_chatted = $index !== false;
            $user->chat_order = $index !== false ? $index : 999999;
            return $user;
        })->sortBy('chat_order')->values();

        return response()->json($sortedUsers);
    }

    /**
     * Lấy lịch sử tin nhắn của một User cụ thể
     */
    public function getMessages($userId)
    {
        $adminId = Auth::id();

        return Message::with('sender')
            ->where(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $userId)->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Admin gửi tin nhắn phản hồi
     */
    public function send(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->user_id,
            'content' => $request->message,
            'is_read' => true // Admin gửi thì mặc định là đã đọc (hoặc xử lý sau)
        ]);

        return response()->json($message);
    }
}
