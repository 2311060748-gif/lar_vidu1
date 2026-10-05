@extends('layouts.admin')
@section('title', 'Thông tin người dùng')
@section('content')
<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 font-weight-bold text-info"><i class="fa-solid fa-user mr-2"></i>Thông tin người dùng</h4>
            <span class="badge badge-secondary p-2">ID: #{{ $user->id }}</span>
        </div>
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-sm-4 text-muted font-weight-bold">Họ và tên:</div>
                <div class="col-sm-8 font-weight-bold text-dark">{{ $user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted font-weight-bold">Email:</div>
                <div class="col-sm-8">{{ $user->email }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted font-weight-bold">Vai trò:</div>
                <div class="col-sm-8">
                    @if($user->role === 'admin')
                        <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-shield mr-1"></i> Quản trị</span>
                    @else
                        <span class="badge badge-secondary px-2 py-1"><i class="fa-solid fa-user mr-1"></i> {{ $user->role === 'customer' ? 'Khách hàng' : 'Người dùng' }}</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted font-weight-bold">Trạng thái email:</div>
                <div class="col-sm-8">
                    @if($user->email_verified_at)
                        <span class="badge badge-success"><i class="fa-solid fa-check mr-1"></i> Đã xác thực ({{ $user->email_verified_at->format('d/m/Y H:i') }})</span>
                    @else
                        <span class="badge badge-warning text-dark"><i class="fa-solid fa-clock mr-1"></i> Chưa xác thực</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted font-weight-bold">Ngày tạo tài khoản:</div>
                <div class="col-sm-8">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A' }}</div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left mr-1"></i> ← Quay lại
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Chỉnh sửa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
