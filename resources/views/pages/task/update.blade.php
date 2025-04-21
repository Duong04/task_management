@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật công việc'])
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/43.3.1/ckeditor5-premium-features.css" />
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
@endsection
@section('content')
    @php
        $status_projects = [
            'not_started' => 'Chưa bắt đầu',
            'in_progress' => 'Đang thực hiện',
            'completed' => 'Hoàn thành',
        ];
    @endphp
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{ route('tasks.index') }}" class="me-1"><i class="fas fa-arrow-left"></i></a> Cập nhật công việc</h3>
            </div>
            <div class="row">
                <form class="row col-12" action="{{ route('tasks.update', ['id' => $task->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên công việc ( <span class="text-danger">*</span> )</label>
                        <input value="{{ $task->name }}" type="text" class="form-control" id="name" name="name"
                            placeholder="Tên công việc" />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('project_id') ? ' has-error' : '' }}">
                        <label for="project_id">Chọn dự án ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="project_id" id="project_id">
                            <option value="">-- Chọn dự án --</option>
                            @foreach ($projects as $item)
                                <option {{ $task->project_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ $item->name }} ({{ $status_projects[$item->status] }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('project_id'))
                            <span class="text-danger fs-7">{{ $errors->first('project_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('created_by') ? ' has-error' : '' }}">
                        <label for="created_by">Người giao việc ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="created_by" id="created_by">
                            <option value="">-- Người giao việc --</option>
                            @foreach ($users as $item)
                                <option {{ $task->created_by == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('created_by'))
                            <span class="text-danger fs-7">{{ $errors->first('created_by') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('assigned_to') ? ' has-error' : '' }}">
                        <label for="assigned_to">Người thực hiện ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="assigned_to" id="assigned_to">
                            <option value="">-- Người thực hiện --</option>
                            @foreach ($users as $item)
                                <option {{ $task->assigned_to == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('assigned_to'))
                            <span class="text-danger fs-7">{{ $errors->first('assigned_to') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('priority') ? ' has-error' : '' }}">
                        <label for="priority">Mức độ ưu tiên ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="priority" id="priority">
                            <option value="">-- Chọn độ ưu tiên --</option>
                            <option {{ $task->priority == 'low' ? 'selected' : '' }} value="low">Thấp</option>
                            <option {{ $task->priority == 'medium' ? 'selected' : '' }} value="medium">Trung bình</option>
                            <option {{ $task->priority == 'high' ? 'selected' : '' }} value="high">Cao</option>
                        </select>
                        @if ($errors->first('priority'))
                            <span class="text-danger fs-7">{{ $errors->first('priority') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('status') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">-- Trạng thái --</option>
                            <option {{ $task->status == 'not_started' ? 'selected' : '' }} value="not_started">Chưa bắt đầu</option>
                            <option {{ $task->status == 'in_progress' ? 'selected' : '' }} value="in_progress">Đang thực hiện</option>
                            <option {{ $task->status == 'completed' ? 'selected' : '' }} value="completed">Hoàn thành</option>
                        </select>
                        @if ($errors->first('status'))
                            <span class="text-danger fs-7">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('due_date') ? ' has-error' : '' }}">
                        <label for="due_date">Ngày hoàn thành ( <span class="text-danger">*</span> )</label>
                        <input value="{{ $task->due_date }}" type="date" class="form-control" id="due_date"
                            name="due_date" />
                        @if ($errors->first('due_date'))
                            <span class="text-danger fs-7">{{ $errors->first('due_date') }}</span>
                        @endif
                    </div>
                    @php
                        $attachments = $task->attachments;
                    @endphp
                    <div class="form-group col-12">
                        <label>Tệp đính kèm</label>
                        <div id="add-attachment-alone" class="text-primary cursor-pointer my-2 d-none btn" data-bs-toggle="tooltip" title="Thêm tệp">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div id="attachment-wrapper" class="row">
                            @foreach ($attachments as $index => $attachment)
                                <div class="col-4 d-flex flex-column mb-2 attachment-item py-2" data-index="{{ $index }}">
                                    <div class="col-md-12 d-flex align-items-center mb-2">
                                        <div class="text-danger me-2 cursor-pointer btn-remove">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <div class="text-primary cursor-pointer btn-plus add-attachment">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                    @if ($attachment['id'])
                                    <input type="hidden" name="attachments[{{ $index }}][id]" value="{{ $attachment['id'] }}">  
                                    @endif
                                    <div class="col-md-12">
                                        <label class="upload-box w-100 text-center">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-purple"></i>
                                            <span class="text-purple">Upload File</span>
                                            <small class="file-name text-muted text-truncate d-block mt-1">{{ $attachment['file_path'] }}</small>
                                            <input type="file" name="attachments[{{ $index }}][file]"
                                                class="form-control upload-input" hidden />
                                        </label>
                                        @error("attachments.$index.file")
                                            <span class="text-danger fs-7">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group col-12 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <textarea name="description" class="form-control" placeholder="Mô tả" id="description" cols="30" rows="10">{{ $task->description }}</textarea>
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="col-12 form-group">
                        <button class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-warning">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let wrapper = document.getElementById("attachment-wrapper");
        let addAloneBtn = document.getElementById("add-attachment-alone");
        let index = wrapper.querySelectorAll(".attachment-item").length;

        // Nếu không có item nào thì hiển thị nút + đơn
        if (index === 0) {
            showAddAloneBtn();
        }

        function showAddAloneBtn() {
            addAloneBtn.classList.remove("d-none");
        }

        function hideAddAloneBtn() {
            addAloneBtn.classList.add("d-none");
        }

        function addAttachmentItem() {
            let newItem = document.createElement("div");
            newItem.classList.add("col-4", "d-flex", "flex-column", "mb-2", "attachment-item", "py-2");
            newItem.setAttribute("data-index", index);

            newItem.innerHTML = `
        <div class="col-md-12 d-flex align-items-center mb-2">
            <div class="text-danger me-2 cursor-pointer btn-remove">
                <i class="fas fa-trash"></i>
            </div>
            <div class="text-primary cursor-pointer btn-plus add-attachment">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="col-md-12 my-2">
            <input type="text" name="attachments[${index}][description]" class="form-control" placeholder="Mô tả tệp" />
        </div>
        <div class="col-md-12">
            <label class="upload-box w-100 text-center">
                <i class="fas fa-cloud-upload-alt fa-2x text-purple"></i>
                <span class="text-purple">Upload File</span>
                <small class="file-name text-muted text-truncate d-block mt-1"></small>
                <input type="file" name="attachments[${index}][file]" class="form-control upload-input" hidden />
            </label>
        </div>
    `;

            wrapper.appendChild(newItem);
            index++;
            hideAddAloneBtn();
        }

        // Bấm nút + ở trong mỗi item
        wrapper.addEventListener("click", function(e) {
            if (e.target.closest(".add-attachment")) {
                addAttachmentItem();
            }
        });

        // Bấm nút + bên ngoài (khi không còn item nào)
        addAloneBtn.addEventListener("click", function() {
            addAttachmentItem();
        });

        // Xoá item
        wrapper.addEventListener("click", function(e) {
            if (e.target.closest(".btn-remove")) {
                let item = e.target.closest(".attachment-item");
                if (item) {
                    item.remove();

                    const items = wrapper.querySelectorAll(".attachment-item");

                    // Nếu chỉ còn 1 thì đảm bảo có nút +
                    if (items.length === 1) {
                        const onlyItem = items[0];
                        const controlBox = onlyItem.querySelector(".col-md-12.d-flex");

                        if (!controlBox.querySelector(".add-attachment")) {
                            const addBtn = document.createElement("div");
                            addBtn.className = "text-primary cursor-pointer btn-plus add-attachment";
                            addBtn.innerHTML = `<i class="fas fa-plus"></i>`;
                            controlBox.appendChild(addBtn);
                        }
                    }

                    // Nếu không còn item nào
                    if (items.length === 0) {
                        showAddAloneBtn();
                    }
                }
            }
        });

        // Hiển thị tên file khi chọn
        wrapper.addEventListener("change", function(e) {
            if (e.target.matches(".upload-input")) {
                let fileInput = e.target;
                let fileName = fileInput.files[0]?.name || '';
                fileInput.closest("label").querySelector(".file-name").textContent = fileName;
            }
        });
    });
</script>
    
@endsection
