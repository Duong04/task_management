@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật dự án'])

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{ route('projects.index') }}" class="me-1"><i class="fas fa-arrow-left"></i></a> Cập nhật dự án</h3>
            </div>
            <div class="row">
                <form class="row col-12" action="{{ route('projects.update', ['id' => $project->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên dự án ( <span class="text-danger">*</span> )</label>
                        <input value="{{ $project->name }}" type="text" class="form-control" id="name"
                            name="name" placeholder="Tên dự án" />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('status') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option {{ $project->status == 'not_started' ? 'selected' : '' }} value="not_started">Chưa hoạt
                                động</option>
                            <option {{ $project->status == 'in_progress' ? 'selected' : '' }} value="in_progress">Đang xử lý
                            </option>
                            <option {{ $project->status == 'completed' ? 'selected' : '' }} value="completed">Đã hoàn thành
                            </option>
                        </select>
                        @if ($errors->first('status'))
                            <span class="text-danger fs-7">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('type') ? ' has-error' : '' }}">
                        <label for="type">Phân loại ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="type" id="type">
                            <option {{ $project->type == 'user' ? 'selected' : '' }} value="user">Cá nhân</option>
                            <option {{ $project->type == 'department' ? 'selected' : '' }} value="department">Phòng ban
                            </option>
                        </select>
                        @if ($errors->first('type'))
                            <span class="text-danger fs-7">{{ $errors->first('type') }}</span>
                        @endif
                    </div>

                    <div id="department-group"
                        class="form-group col-4 {{ $errors->first('department_id') ? ' has-error' : '' }}">
                        <label for="department_id">Phòng ban ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="department_id" id="department_id">
                            @foreach ($departments as $item)
                                <option {{ $project->department_id == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('department_id'))
                            <span class="text-danger fs-7">{{ $errors->first('department_id') }}</span>
                        @endif
                    </div>
                    <div id="creator-group"
                        class="form-group col-4 {{ $errors->first('manager_id') ? ' has-error' : '' }}">
                        <label for="manager_id">Người quản trị ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="manager_id" id="manager_id">
                            @foreach ($users as $item)
                                <option
                                    {{ $project->manager_id == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('manager_id'))
                            <span class="text-danger fs-7">{{ $errors->first('manager_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Ngày bắt đầu</label>
                        <input value="{{ $project->start_date }}" type="date" class="form-control" id="start_date"
                            name="start_date" placeholder="Mô tả dự án" />
                        @if ($errors->first('start_date'))
                            <span class="text-danger fs-7">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('end_date') ? ' has-error' : '' }}">
                        <label for="end_date">Ngày kết thúc ( <span class="text-danger">*</span> )</label>
                        <input value="{{ $project->end_date }}" type="date" class="form-control" id="end_date"
                            name="end_date" placeholder="Mô tả dự án" />
                        @if ($errors->first('end_date'))
                            <span class="text-danger fs-7">{{ $errors->first('end_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-12 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $project->description }}</textarea>
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="col-6 form-group">
                        <button class="btn btn-primary">Cập nhật dự án</button>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-warning">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/ckeditor5-premium-features.css" />
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/",
                "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/ckeditor5-premium-features.js",
                "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/"
            }
        }
    </script>
    <link rel="stylesheet" href="/assets/master/vendor/ckeditor5.css">
    <script type="module" src="/assets/master/vendor/ckeditor5.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const departmentGroup = document.getElementById('department-group');

            function toggleFields() {
                const selectedType = typeSelect.value;

                if (selectedType === 'department') {
                    departmentGroup.style.display = 'block';
                }else if (selectedType === 'user') {
                    departmentGroup.style.display = 'none';
                }
            }

            toggleFields();

            typeSelect.addEventListener('change', toggleFields);
        });
    </script>
@endsection
