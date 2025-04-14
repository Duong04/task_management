@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật phòng ban'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Cập nhật phòng ban</h3>
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
                <a href="#">Cập nhật phòng ban</a>
            </li>
            </ul>
        </div>
        <div class="row">
          <form class="row col-12" action="{{ route('departments.update', ['id' => $department->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-12 row">
                <div class="row mx-0">
                    <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên chức vụ</label>
                        <input
                            value="{{ $department->name }}"
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Tên chức vụ"
                        />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-6 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <input
                            value="{{ $department->description }}"
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
                        <button class="btn btn-primary">Cập nhật phòng ban</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection