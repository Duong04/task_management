@extends('layouts.master-layout')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tạo dự án</h3>
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
                    <a href="">Dự án</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <form class="row col-12" action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                    <label for="name">Tên dự án</label>
                    <input
                        value="{{ old('name') }}"
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Tên dự án"
                    />
                    @if ($errors->first('name'))
                        <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->first('description') ? ' has-error' : '' }}">
                    <label for="description">Mô tả</label>
                    <input
                        value="{{ old('description') }}"
                        type="text"
                        class="form-control"
                        id="description"
                        name="description"
                        placeholder="Mô tả dự án"
                    />
                    @if ($errors->first('description'))
                        <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->first('start_date') ? ' has-error' : '' }}">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input
                        value="{{ old('start_date') }}"
                        type="date"
                        class="form-control"
                        id="start_date"
                        name="start_date"
                        placeholder="Mô tả dự án"
                    />
                    @if ($errors->first('start_date'))
                        <span class="text-danger fs-7">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->first('end_date') ? ' has-error' : '' }}">
                    <label for="end_date">Ngày kết thúc</label>
                    <input
                        value="{{ old('end_date') }}"
                        type="date"
                        class="form-control"
                        id="end_date"
                        name="end_date"
                        placeholder="Mô tả dự án"
                    />
                    @if ($errors->first('end_date'))
                        <span class="text-danger fs-7">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="col-6 form-group">
                    <button class="btn btn-primary">Tạo dự án</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
