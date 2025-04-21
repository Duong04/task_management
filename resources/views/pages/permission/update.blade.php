@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật quyền'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Cập nhật quyền</h3>
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
                    <a href="">Phân quyền</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Cập nhật quyền</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <form class="row col-12" action="{{ route('permissions.update', ['id' => $permission->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                    <label for="name">Tên quyền (<span class="text-danger">*</span>)</label>
                    <input
                        value="{{ $permission->name }}"
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Tên hành động"
                    />
                    @if ($errors->first('name'))
                        <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->first('description') ? ' has-error' : '' }}">
                    <label for="description">Mô tả</label>
                    <input
                        value="{{ $permission->description }}"
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
                <div class="col-12">
                    <h6>Cho phép thuộc hành động nào</h6>
                    <div class="row gutters-xs">
                        @foreach ($actions as $item)
                        <div class="col-auto ms-3 d-flex align-items-center mt-3">
                            <label class="colorinput me-2">
                                <input {{ $permission->permissionActions->contains('action_id', $item->id) ? 'checked' : '' }} id="checkbox-{{$item->id}}" name="actions[]" type="checkbox" value="{{ $item->id }}" class="colorinput-input check-action" />
                                <span class="colorinput-color bg-info"></span>
                            </label>
                            <label for="checkbox-{{$item->id}}">{{ $item->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-6 form-group">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-warning">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
