@extends('layouts.master-layout')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tạo hành động</h3>
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
                    <a href="#">Tạo hành động</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <form class="row col-12" action="{{ route('actions.store') }}" method="POST">
                @csrf
                <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                    <label for="name">Tên hành động</label>
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
                <div class="form-group col-6 {{ $errors->first('value') ? ' has-error' : '' }}">
                    <label for="value">Bí danh</label>
                    <input
                        value="{{ old('value') }}"
                        type="text"
                        class="form-control"
                        id="value"
                        name="value"
                        placeholder="Bí danh"
                    />
                    @if ($errors->first('value'))
                        <span class="text-danger fs-7">{{ $errors->first('value') }}</span>
                    @endif
                </div>
                <div class="col-12">
                    <h6>Cho phép thuộc quyền nào</h6>
                    <div class="row gutters-xs">
                        @foreach ($permissions as $item)
                        <div class="col-auto ms-3 d-flex align-items-center mt-3">
                            <label class="colorinput me-2">
                                <input id="checkbox-{{$item->id}}" name="permissions[]" type="checkbox" value="{{ $item->id }}" class="colorinput-input check-action" />
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
