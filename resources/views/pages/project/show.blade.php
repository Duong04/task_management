@extends('layouts.master-layout', ['title' => 'Admin - Chi tiết dự án'])

@section('css')
    <style>
        .btn-comment {
            max-width: 250px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 20px;
            background-color: #3858F6;
            color: #fff;
            border: 2px solid #3858F6;
            border-radius: 28px;
            cursor: pointer;
            transition: all ease 0.5s;
        }

        .btn-comment:hover {
            background-color: #fff;
            color: #3858F6;
        }

        .post-content img {
            width: 100%;
            border-radius: 1rem;
        }

        #emoji-picker,
        .emoji-picker {
            display: none;
            position: absolute;
            right: 0;
            z-index: 1000;
        }

        #emoji-button,
        .emoji-button {
            cursor: pointer;
            position: absolute;
            top: 10%;
            right: 10px;
        }

        #emoji-picker.above {
            bottom: 100%;
            margin-bottom: 5px;
        }

        #emoji-picker.below {
            top: 100%;
            margin-top: 5px;
        }

        .form-comment {
            width: 100%;
            height: 80px;
        }

        .form-comment textarea {
            width: 100%;
            height: 100%;
            transition: all ease 0.4s;
        }

        .form-comment textarea:focus {
            box-shadow: none;
            border: 1px solid #3858F6;
        }

        .form-comment button {
            border: none;
            color: #3858F6;
            background-color: transparent;
            font-size: 1.2rem;
            position: absolute;
            right: 10px;
            bottom: 10%;
        }

        .form-comment button:disabled {
            opacity: 0.7;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script type="module" src="/js/comment.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('edit-project-btn');
            const viewDiv = document.getElementById('project-view');
            const formDiv = document.getElementById('project-edit-form');
            const cancelBtn = document.getElementById('cancel-edit-project');

            editBtn.addEventListener('click', () => {
                viewDiv.classList.add('d-none');
                formDiv.classList.remove('d-none');
            });

            cancelBtn.addEventListener('click', () => {
                formDiv.classList.add('d-none');
                viewDiv.classList.remove('d-none');
            });
        });
    </script>
@endsection

@section('content')
    @php
        $status = [
            'not_started' => 'Chưa bắt đầu',
            'in_progress' => 'Đang thực hiện',
            'completed' => 'Hoàn thành',
        ];

        $priorities = [
            'low' => 'Thấp',
            'medium' => 'Trung bình',
            'high' => 'Cao',
        ];

        $status_color = [
            'not_started' => 'badge-gray',
            'in_progress' => 'badge-blue',
            'completed' => 'badge-green',
        ];

        $priority_color = [
            'low' => 'badge-green',
            'medium' => 'badge-yellow',
            'high' => 'badge-red',
        ];
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header justify-content-between">
                <h3 class="fw-bold"><a href="{{ route('projects.index') }}" class="me-1"><i class="fas fa-arrow-left"></i></a>
                    Chi tiết dự án</h3>
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-12 text-end d-flex">
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-outline-primary me-2">✏️
                            Chỉnh sửa</a>
                        <form action="{{ route('projects.delete', $project->id) }}" id="delete-form-{{ $project->id }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger delete">🗑️ Xóa</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="border rounded p-4 bg-white shadow-sm">

                        <div class="row mb-1">
                            <div class="row mb-4">
                                <div class="col-md-6 mb-2"><span>Tên dự án:</span> <br>
                                    <strong>{{ $project->name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Phân loại:</span> <br>
                                    <span
                                        class="badge-custom {{ $project->type == 'user' ? 'badge-blue' : 'badge-purple' }}">{{ $project->type == 'user' ? 'Cá nhân' : 'Phòng ban' }}</span>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <span>{{ $project->type == 'user' ? 'Người quản trị' : 'Phòng ban' }}</span> <br>
                                    <strong>{{ $project->type == 'user' ? $project->creator?->name : $project->department?->name }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Ngày bắt đầu:</span><br>
                                    <strong>{{ format_date($project->start_date) }}</strong>
                                </div>
                                <div class="col-md-6 mb-4"><span>Ngày kết thúc:</span><br>
                                    <strong>{{ format_date($project->end_date) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" style="margin-top: -12px;">
                            <span>Mô tả:</span>
                            <div>{!! $project->description !!}</div>
                        </div>
                    </div>

                    {{-- Danh sách công việc con --}}
                    <div class="border rounded p-4 bg-white shadow-sm mt-4">
                        <h6 class="mb-3">Danh sách công việc</h6>
                        @forelse ($project->tasks as $task)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div><strong>{{ $task->name }}</strong></div>

                                    <div class="d-flex align-items-center gap-2">
                                        <a data-bs-toggle="tooltip" title="Xem chi tiết"
                                            href="{{ route('tasks.show', $task->id) }}" class="text-primary"
                                            title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a data-bs-toggle="tooltip" title="sửa"
                                            href="{{ route('tasks.edit', $task->id) }}" class="text-success"
                                            title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa công việc này không?')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button data-bs-toggle="tooltip" title="Xóa" type="submit"
                                                class="btn btn-link p-0 m-0 text-danger delete" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <span class="badge {{ $status_color[$task->status] }} ms-2">
                                            {{ $status[$task->status] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <div>Người thực hiện: {{ $task->assignedTo->name ?? 'N/A' }}</div>
                                    <div>Ưu tiên:
                                        <span class="badge-custom {{ $priority_color[$task->priority] }}">
                                            {{ $priorities[$task->priority] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $task->progress }}%;"></div>
                                </div>
                                <div class="text-end mt-1 small">{{ $task->progress }}%</div>
                            </div>
                        @empty
                            <p class="text-muted">Chưa có công việc nào.</p>
                        @endforelse

                    </div>
                </div>

                {{-- Sidebar tiến độ dự án --}}
                <div class="col-md-4">
                    <div class="border rounded p-4 bg-white shadow-sm">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Tiến độ dự án
                            <button class="btn btn-sm text-success" id="edit-project-btn"data-bs-toggle="tooltip"
                                title="Sửa"><i class="fa fa-edit"></i></button>
                        </h6>

                        {{-- Hiển thị --}}
                        <div id="project-view">
                            <div class="mb-2"><strong>Trạng thái:</strong>
                                <span
                                    class="badge {{ $status_color[$project->status] }}">{{ $status[$project->status] }}</span>
                            </div>
                            <div class="mb-2"><strong>Tiến độ trung bình:</strong></div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="text-end mt-1 small">{{ $project->progress }}%</div>
                        </div>

                        <form id="project-edit-form" class="d-none mt-3"
                            action="{{ route('projects.update', ['id' => $project->id, 'redirect' => 'back']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-2"><strong>Trạng thái:</strong>
                                <select name="status" class="form-select form-select-sm mt-2">
                                    @foreach ($status as $key => $label)
                                        <option value="{{ $key }}" @selected($key == $project->status)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-sm btn-secondary me-2"
                                    id="cancel-edit-project">Hủy</button>
                                <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
