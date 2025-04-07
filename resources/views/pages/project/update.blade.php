@extends('layouts.master-layout')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Cập nhật dự án</h3>
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
            <form class="row col-12" action="{{ route('projects.update', ['id' => $project->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                    <label for="name">Tên dự án</label>
                    <input
                        value="{{ $project->name }}"
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
                        value="{{ $project->description }}"
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
                <div class="form-group col-4 {{ $errors->first('status') ? ' has-error' : '' }}">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-control">
                        <option {{ $project->status == 'not_started' ? 'selected' : '' }} value="not_started">Chưa hoạt động</option>
                        <option {{ $project->status == 'in_progress' ? 'selected' : '' }} value="in_progress">Đang xử lý</option>
                        <option {{ $project->status == 'completed' ? 'selected' : '' }} value="completed">Đã hoàn thành</option>
                    </select>
                    @if ($errors->first('status'))
                        <span class="text-danger fs-7">{{ $errors->first('status') }}</span>
                    @endif
                </div>
                <div class="form-group col-4 {{ $errors->first('start_date') ? ' has-error' : '' }}">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input
                        value="{{ $project->start_date }}"
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
                <div class="form-group col-4 {{ $errors->first('end_date') ? ' has-error' : '' }}">
                    <label for="end_date">Ngày kết thúc</label>
                    <input
                        value="{{ $project->end_date }}"
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
                    <button class="btn btn-primary">Cập nhật dự án</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
