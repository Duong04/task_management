@extends('layouts.master-layout', ['title' => 'Admin - Tạo người dùng'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><a href="{{ route('users.index') }}" class="me-1"><i class="fas fa-arrow-left"></i></a> Thêm người dùng</h3>
        </div>
        <div class="row">
          <form class="row col-12" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="col-12 row">
                <div class="row mx-0">
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên người dùng ( <span class="text-danger">*</span> )</label>
                        <input
                            value="{{ old('name') }}"
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Tên người dùng"
                        />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('email') ? ' has-error' : '' }}">
                        <label for="email">Email người dùng ( <span class="text-danger">*</span> )</label>
                        <input
                            value="{{ old('email') }}"
                            type="text"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Email người dùng"
                        />
                        @if ($errors->first('email'))
                            <span class="text-danger fs-7">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('password') ? ' has-error' : '' }}">
                        <label for="password">Mật khẩu ( <span class="text-danger">*</span> )</label>
                        <input
                            value="{{ old('password') }}"
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Mật khẩu"
                        />
                        @if ($errors->first('password'))
                            <span class="text-danger fs-7">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('role_id') ? ' has-error' : '' }}">
                        <label for="role_id">Vai trò ( <span class="text-danger">*</span> )</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Chọn vai trò</option>
                            @foreach ($roles as $role)
                                <option {{ old('role_id') == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('role_id'))
                            <span class="text-danger fs-7">{{ $errors->first('role_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.position_id') ? ' has-error' : '' }}">
                        <label for="position">Chức vụ</label>
                        <select name="user_detail[position_id]" id="position" class="form-control">
                            <option value="">Chọn chức vụ</option>
                            @foreach ($positions as $position)
                                <option {{ old('user_detail.position_id') == $position->id ? 'selected' : '' }} value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('user_detail.position_id'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.position_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('department_id') ? ' has-error' : '' }}">
                        <label for="department_id">Phòng ban</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Chọn phòng ban</option>
                            @foreach ($departments as $department)
                                <option {{ old('department_id') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('department_id'))
                            <span class="text-danger fs-7">{{ $errors->first('department_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('is_active') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái</label>
                        <select name="is_active" id="status" class="form-control">
                            <option {{ old('is_active') == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                            <option {{ !old('is_active') == '0' ? 'selected' : '' }} value="0">Không hoạt động</option>
                        </select>
                        @if ($errors->first('is_active'))
                            <span class="text-danger fs-7">{{ $errors->first('is_active') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.gender') ? ' has-error' : '' }}">
                        <label for="gender">Giới tính</label>
                        <select name="user_detail[gender]" id="gender" class="form-control">
                            <option {{ old('user_detail.gender') == 'male' ? 'selected' : '' }} value="male" selected>Nam</option>
                            <option {{ old('user_detail.gender') == 'female' ? 'selected' : '' }} value="female">Nữ</option>
                        </select>
                        @if ($errors->first('user_detail.gender'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.gender') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.phone') ? ' has-error' : '' }}">
                        <label for="phone">Số điện thoại</label>
                        <input
                            value="{{ old('user_detail.phone') }}"
                            type="phone"
                            class="form-control"
                            id="text"
                            name="user_detail[phone]"
                            placeholder="Số điện thoại"
                        />
                        @if ($errors->first('user_detail.phone'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.address') ? ' has-error' : '' }}">
                        <label for="address">Địa chỉ</label>
                        <input
                            value="{{ old('user_detail.address') }}"
                            type="text"
                            class="form-control"
                            id="address"
                            name="user_detail[address]"
                            placeholder="Địa chỉ"
                        />
                        @if ($errors->first('user_detail.address'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.address') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.dob') ? ' has-error' : '' }}">
                        <label for="dob">Ngày sinh</label>
                        <input
                            value="{{ old('user_detail.dob') }}"
                            type="date"
                            class="form-control"
                            id="dob"
                            name="user_detail[dob]"
                        />
                        @if ($errors->first('user_detail.dob'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.dob') }}</span>
                        @endif
                    </div>
                    <div class="col-12 form-group">
                        <button class="btn btn-primary">Lưu</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Hủy</a>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection