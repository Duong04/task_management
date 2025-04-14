@extends('layouts.master-layout', ['title' => 'Admin - Chi tiết công việc'])
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
                <h3 class="fw-bold mb-3"><a href="{{ route('tasks.index') }}" class="me-1"><i
                            class="fas fa-arrow-left"></i></a> Chi tiết công việc</h3>
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
                        <a href="">Quản lý công việc</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Chi tiết công việc</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="row">
                    <div class="d-flex justify-content-end align-items-start mb-3" style="gap: 10px;">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-outline-primary">✏️ Chỉnh sửa</a>
                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="d-inline"
                            id="delete-form-{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger delete">🗑️ Xóa</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="border rounded p-4 bg-white shadow-sm">
                            <div class="row mb-3">
                                <div class="col-md-6"><span>Người giao việc:</span> <br>
                                    <strong>{{ $task->createdBy->name ?? 'N/A' }}</strong></div>
                                <div class="col-md-6"><span>Người thực hiện:</span> <br>
                                    <strong>{{ $task->assignedTo->name ?? 'N/A' }}</strong></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6"><span>Hạn hoàn thành:</span><br>
                                    <strong>{{ format_date($task->due_date) }}</strong></div>
                                <div class="col-md-6">
                                    <span>Mức độ ưu tiên:</span>
                                    <br>
                                    <strong class="badge-custom {{ $priority_color[$task->priority] }}">{{ $priorities[$task->priority] }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Mô tả công việc:</strong>
                                <p class="mt-2">{!! $task->description !!}</p>
                            </div>

                            <div>
                                <strong>Tệp đính kèm:</strong>
                                <div class="row">
                                    @foreach ($task->attachments as $file)
                                        <div class="col-4 mb-3">
                                            <div class="py-3 px-2 rounded border d-flex justify-content-between align-items-center">
                                                <a href="{{ $file->file_path }}" target="_blank" class="d-inline-block text-truncate" title="Xem tệp">{{ $file->file_path }}</a>
                                                <a href="{{ $file->file_path }}" download class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>

                        {{-- Bình luận --}}
                        <div class="border rounded p-4 bg-white shadow-sm mt-4">
                            <h6 class="mb-3">Bình luận</h6>
                            {{-- @foreach ($task->comments as $comment)
                                <div class="mb-3">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-muted small">{{ \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y H:i') }}</span>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            @endforeach --}}

                            {{-- <form action="{{ route('tasks.comment', $task->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-control" rows="2" placeholder="Nhập bình luận..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Gửi</button>
                            </form> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-4 bg-white shadow-sm">
                            <h6 class="mb-3">Tiến độ công việc</h6>
                            <div class="mb-2"><strong>Trạng thái:</strong>
                                <span class="badge bg-info text-dark">{{ $status[$task->status] }}</span>
                            </div>
                            <div class="mb-2"><strong>Tiến độ hiện tại:</strong></div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="text-end mt-1 small">{{ $task->progress }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
