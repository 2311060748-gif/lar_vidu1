@extends('layouts.admin')
@section('title', 'Thêm người dùng')
@section('content')
<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 font-weight-bold text-success"><i class="fa-solid fa-user-plus mr-2"></i>Thêm người dùng mới</h4>
        </div>
        <div class="card-body p-4">
            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tên người dùng <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập họ và tên..." required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@domain.com" required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự..." required>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Vai trò <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Người dùng</option>
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
