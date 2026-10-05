@extends('layouts.admin')
@section('title', 'Quản lý người dùng')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fa-solid fa-users text-primary mr-2"></i>Danh sách người dùng</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success shadow-sm">
            <i class="fa-solid fa-user-plus mr-1"></i> + Thêm người dùng
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="70" class="text-center">ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th width="150" class="text-center">Vai trò</th>
                        <th width="200" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $user->id }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if(auth()->id() === $user->id)
                                    <span class="badge badge-info ml-1">Bạn</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->role === 'admin')
                                    <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-shield mr-1"></i> Quản trị</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1"><i class="fa-solid fa-user mr-1"></i> {{ $user->role === 'customer' ? 'Khách hàng' : 'Người dùng' }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(auth()->id() !== $user->id)
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="openAdminChatWithUser({{ $user->id }}, '{{ addslashes($user->name) }}')" title="Nhắn tin với khách hàng này">
                                        <i class="fa-solid fa-comment-dots"></i> Chat
                                    </button>
                                @endif
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye"></i> Xem
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?')" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Không có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
