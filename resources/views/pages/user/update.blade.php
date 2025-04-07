@extends('layouts.master-layout')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Cập nhật người dùng</h3>
            <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="">Người dùng</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Cập nhật người dùng</a>
            </li>
            </ul>
        </div>
        <div class="row">
          <form class="row col-12" action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-12 row">
                <div class="row mx-0">
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên người dùng</label>
                        <input
                            value="{{ $user->name }}"
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
                        <label for="email">Email người dùng</label>
                        <input
                            value="{{ $user->email }}"
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
                        <label for="password">Mật khẩu</label>
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
                        <label for="role_id">Vai trò</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Chọn vai trò</option>
                            @foreach ($roles as $role)
                                <option {{ $user->role_id == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
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
                                <option {{ $user->userDetail->position_id == $position->id ? 'selected' : '' }} value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('user_detail.position_id'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.position_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('is_active') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái</label>
                        <select name="is_active" id="status" class="form-control">
                            <option {{ $user->is_active ? 'selected' : '' }} value="1">Hoạt động</option>
                            <option {{ !$user->is_active ? 'selected' : '' }} value="0">Không hoạt động</option>
                        </select>
                        @if ($errors->first('is_active'))
                            <span class="text-danger fs-7">{{ $errors->first('is_active') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.gender') ? ' has-error' : '' }}">
                        <label for="gender">Giới tính</label>
                        <select name="user_detail[gender]" id="gender" class="form-control">
                            <option {{ $user->userDetail->gender == 'male' ? 'selected' : '' }} value="male" selected>Nam</option>
                            <option {{ $user->userDetail->gender == 'female' ? 'selected' : '' }} value="female">Nữ</option>
                        </select>
                        @if ($errors->first('user_detail.gender'))
                            <span class="text-danger fs-7">{{ $errors->first('user_detail.gender') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('user_detail.phone') ? ' has-error' : '' }}">
                        <label for="phone">Số điện thoại</label>
                        <input
                            value="{{ $user->userDetail->phone }}"
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
                            value="{{ $user->userDetail->address }}"
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
                            value="{{ $user->userDetail->dob }}"
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
                        <button class="btn btn-primary">Cập nhật người dùng</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection