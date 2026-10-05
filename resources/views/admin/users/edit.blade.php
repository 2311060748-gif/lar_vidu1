@extends('layouts.admin')
@section('title', 'Chỉnh sửa người dùng')
@section('content')
<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 font-weight-bold text-primary"><i class="fa-solid fa-user-pen mr-2"></i>Chỉnh sửa người dùng #{{ $user->id }}</h4>
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

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tên</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Mật khẩu mới (để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" placeholder="Để trống nếu không đổi...">
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Vai trò</label>
                    <select name="role" class="form-control" required>
                        <option value="user" @selected(old('role', $user->role) === 'user')>Người dùng</option>
                        <option value="customer" @selected(old('role', $user->role) === 'customer')>Khách hàng</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Quản trị</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
