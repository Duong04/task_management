@extends('layouts.master-layout', ['title' => 'Admin - Tạo phòng ban'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Thêm phòng ban</h3>
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
                <a href="">Quản lý phòng ban</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tạo phòng ban</a>
            </li>
            </ul>
        </div>
        <div class="row">
          <form class="row col-12" action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="col-12 row">
                <div class="row mx-0">
                    <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên phòng ban (<span class="text-danger">*</span>)</label>
                        <input
                            value="{{ old('name') }}"
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Tên phòng ban"
                        />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-6 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <input
                            value="{{ old('value') }}"
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Mô tả"
                        />
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="col-6 form-group">
                        <button class="btn btn-primary">Lưu</button>
                        <a href="{{ route('departments.index') }}" class="btn btn-outline-warning">Hủy</a>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection