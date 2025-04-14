@extends('layouts.master-layout', ['title' => 'Admin - Tạo quyền'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tạo quyền</h3>
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
                    <a href="#">Tạo quyền</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <form class="row col-12" action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                    <label for="name">Tên quyền</label>
                    <input
                        value="{{ old('name') }}"
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
                <div class="col-12">
                    <h6>Cho phép thuộc hành động nào</h6>
                    <div class="row gutters-xs">
                        @foreach ($actions as $item)
                        <div class="col-auto ms-3 d-flex align-items-center mt-3">
                            <label class="colorinput me-2">
                                <input id="checkbox-{{$item->id}}" name="actions[]" type="checkbox" value="{{ $item->id }}" class="colorinput-input check-action" />
                                <span class="colorinput-color bg-info"></span>
                            </label>
                            <label for="checkbox-{{$item->id}}">{{ $item->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-6 form-group">
                    <button class="btn btn-primary">Thêm ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
