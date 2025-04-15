@extends('layouts.master-layout', ['title' => 'Admin - Tạo dự án'])
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{ route('projects.index') }}" class="me-1"><i class="fas fa-arrow-left"></i></a> Tạo dự án</h3>
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
                <form class="row col-12" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-4 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên dự án ( <span class="text-danger">*</span> )</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name"
                            placeholder="Tên dự án" />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('status') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">-- Trạng thái --</option>
                            <option {{ old('status') == 'not_started' ? 'selected' : '' }} value="not_started">Chưa bắt đầu
                            </option>
                            <option {{ old('status') == 'in_progress' ? 'selected' : '' }} value="in_progress">Đang thực
                                hiện</option>
                            <option {{ old('status') == 'completed' ? 'selected' : '' }} value="completed">Hoàn thành
                            </option>
                        </select>
                        @if ($errors->first('status'))
                            <span class="text-danger fs-7">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('created_by') ? ' has-error' : '' }}">
                        <label for="created_by">Người tạo ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="created_by" id="created_by">
                            @foreach ($users as $item)
                                <option {{ old('created_by') == $item->id || auth()->id() == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('created_by'))
                            <span class="text-danger fs-7">{{ $errors->first('created_by') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('type') ? ' has-error' : '' }}">
                        <label for="type">Phân loại ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="type" id="type">
                            <option {{ old('type') == 'user' ? 'selected' : '' }} value="user">Cá nhân</option>
                            <option {{ old('type') == 'department' ? 'selected' : '' }} value="department">Phòng ban
                            </option>
                        </select>
                        @if ($errors->first('type'))
                            <span class="text-danger fs-7">{{ $errors->first('type') }}</span>
                        @endif
                    </div>

                    <div id="creator-group"
                        class="form-group col-4 {{ $errors->first('creator_id') ? ' has-error' : '' }}">
                        <label for="creator_id">Người thực hiện ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="creator_id" id="creator_id">
                            @foreach ($users as $item)
                                <option {{ old('creator_id') == $item->id || auth()->id() == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }} ({{ $item->role->name }})</option>
                            @endforeach
                        </select>
                        @if ($errors->first('creator_id'))
                            <span class="text-danger fs-7">{{ $errors->first('creator_id') }}</span>
                        @endif
                    </div>

                    <div id="department-group"
                        class="form-group col-4 {{ $errors->first('department_id') ? ' has-error' : '' }}">
                        <label for="department_id">Phòng ban ( <span class="text-danger">*</span> )</label>
                        <select class="form-control" name="department_id" id="department_id">
                            @foreach ($departments as $item)
                                <option {{ old('department_id') == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->first('department_id'))
                            <span class="text-danger fs-7">{{ $errors->first('department_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Ngày bắt đầu ( <span class="text-danger">*</span> )</label>
                        <input value="{{ old('start_date') }}" type="date" class="form-control" id="start_date"
                            name="start_date" placeholder="Mô tả dự án" />
                        @if ($errors->first('start_date'))
                            <span class="text-danger fs-7">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-4 {{ $errors->first('end_date') ? ' has-error' : '' }}">
                        <label for="end_date">Ngày kết thúc</label>
                        <input value="{{ old('end_date') }}" type="date" class="form-control" id="end_date"
                            name="end_date" placeholder="Mô tả dự án" />
                        @if ($errors->first('end_date'))
                            <span class="text-danger fs-7">{{ $errors->first('end_date') }}</span>
                        @endif
                    </div>
                    @php
                        $attachments = old('attachments', [['description' => '', 'file' => null]]);
                    @endphp
                    <div class="form-group col-12">
                        <label>Tệp đính kèm</label>
                        <div id="add-attachment-alone" class="text-primary cursor-pointer my-2 d-none btn" data-bs-toggle="tooltip" title="Thêm tệp">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div id="attachment-wrapper" class="row">
                            @foreach ($attachments as $index => $attachment)
                                <div class="col-4 d-flex flex-column mb-2 attachment-item py-2"
                                    data-index="{{ $index }}">
                                    <div class="col-md-12 d-flex align-items-center mb-2">
                                        <div class="text-danger me-2 cursor-pointer btn-remove">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <div class="text-primary cursor-pointer btn-plus add-attachment">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="upload-box w-100 text-center">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-purple"></i>
                                            <span class="text-purple">Upload File</span>
                                            <small class="file-name text-muted text-truncate d-block mt-1"></small>
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
                        <textarea name="description" class="form-control" placeholder="Mô tả" id="description" cols="30"
                            rows="10">{{ old('description') }}</textarea>
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="col-6 form-group">
                        <button class="btn btn-primary">Lưu</button>
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
            const creatorGroup = document.getElementById('creator-group');
            const departmentGroup = document.getElementById('department-group');

            function toggleFields() {
                const selectedType = typeSelect.value;

                if (selectedType === 'user') {
                    creatorGroup.style.display = 'block';
                    departmentGroup.style.display = 'none';
                } else if (selectedType === 'department') {
                    creatorGroup.style.display = 'none';
                    departmentGroup.style.display = 'block';
                }
            }

            toggleFields();

            typeSelect.addEventListener('change', toggleFields);


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
