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
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{ route('projects.index') }}" class="me-1"><i
                            class="fas fa-arrow-left"></i></a> Chi tiết dự án</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('projects.index') }}">Quản lý dự án</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Chi tiết dự án</a></li>
                </ul>
            </div>

            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="border rounded p-4 bg-white shadow-sm">
                        <div class="row mb-3 justify-content-end">
                            <div class="col-md-6 text-end">
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-outline-primary">✏️
                                    Chỉnh sửa</a>
                                <form action="{{ route('projects.delete', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">🗑️ Xóa</button>
                                </form>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2"><span>Người giao việc:</span> <br>
                                    <strong>{{ $project->createdBy->name ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2"><span>Phân loại:</span> <br>
                                    <span class="badge-custom {{ $project->type == 'user' ? 'badge-blue' : 'badge-purple' }}">{{ $project->type == 'user' ? 'Cá nhân' : 'Phòng ban' }}</span>
                                </div>
                                <div class="col-md-6 mb-2"><span>{{ $project->type == 'user' ? 'Người thực hiện' : 'Phòng ban' }}</span> <br>
                                    <strong>{{ $project->type == 'user' ? $project->creator?->name : $project->department?->name }}</strong>
                                </div>
                                <div class="col-md-6 mb-2"><span>Ngày bắt đầu:</span><br>
                                    <strong>{{ format_date($project->start_date) }}</strong>
                                </div>
                                <div class="col-md-6 mb-2"><span>Ngày kết thúc:</span><br>
                                    <strong>{{ format_date($project->end_date) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Mô tả dự án:</strong>
                            <p class="mt-2">{!! $project->description !!}</p>
                        </div>
                    </div>

                    {{-- Danh sách công việc con --}}
                    <div class="border rounded p-4 bg-white shadow-sm mt-4">
                        <h6 class="mb-3">Danh sách công việc</h6>
                        @forelse ($project->tasks as $task)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div><strong>{{ $task->name }}</strong></div>
                                    <span
                                        class="badge {{ $status_color[$task->status] }}">{{ $status[$task->status] }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <div>Người thực hiện: {{ $task->assignedTo->name ?? 'N/A' }}</div>
                                    <div>Ưu tiên: <span
                                            class="badge-custom {{ $priority_color[$task->priority] }}">{{ $priorities[$task->priority] }}</span>
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

                    {{-- Bình luận --}}
                    <div class="border rounded p-4 bg-white shadow-sm mt-4">
                        <h6 class="mb-3">Thảo luận dự án</h6>
                        <div id="comments"></div>
                        <div class="position-relative form-comment">
                            <textarea id="comment" data-type="project" data-id="{{ $project->id }}" class="form-control comment" name="comment"
                                placeholder="Chia sẻ ý kiến của bạn tại đây"></textarea>
                            <div id="emoji-button"><i class="fas fa-smile"></i>
                                <div id="emoji-picker"><emoji-picker></emoji-picker></div>
                            </div>
                            <button disabled id="btn-comment" class="btn-comment-2"><i
                                    class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Sidebar tiến độ dự án --}}
                <div class="col-md-4">
                    <div class="border rounded p-4 bg-white shadow-sm">
                        <h6 class="mb-3">Tiến độ dự án</h6>
                        <div class="mb-2"><strong>Trạng thái:</strong>
                            <span class="badge bg-info text-dark">{{ $status[$task->status] }}</span>
                        </div>
                        <div class="mb-2"><strong>Tiến độ trung bình:</strong></div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $project->average_progress }}%;"
                                aria-valuenow="{{ $project->average_progress }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="text-end mt-1 small">{{ $project->average_progress }}%</div>
                    </div>
                    @if ($project->attachments->count())
                        <div class="col-12 mt-3">
                            <strong>Tệp đính kèm:</strong>
                            <div class="row mt-1">
                                @foreach ($project->attachments as $file)
                                    <div class="col-12 mb-3">
                                        <div
                                            class="py-3 px-2 rounded border d-flex justify-content-between align-items-center">
                                            <a href="{{ $file->file_path }}" target="_blank"
                                                class="d-inline-block text-truncate"
                                                title="Xem tệp">{{ $file->file_path }}</a>
                                            <a href="{{ $file->file_path }}" target="_blank" download
                                                class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
