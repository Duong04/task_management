@extends('layouts.master-layout')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản lý công việc</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Quản lý công việc</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Công việc</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Tạo công việc
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Code</th>
                                            <th>Tên công việc</th>
                                            <th>Tên dự án</th>
                                            <th>Trạng thái</th>
                                            <th>Độ ưu tiên</th>
                                            <th>Người tạo</th>
                                            <th>Người thực hiện</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Code</th>
                                            <th>Tên công việc</th>
                                            <th>Tên dự án</th>
                                            <th>Trạng thái</th>
                                            <th>Độ ưu tiên</th>
                                            <th>Người tạo</th>
                                            <th>Người thực hiện</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $status = [
                                                'not_started' => 'Chưa hoạt động',
                                                'in_progress' => 'Đang xử lý',
                                                'completed' => 'Đã hoàn thành',
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
                                        @endphp
                                        @foreach ($tasks as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td><div style="width: 150px;">{{ $item->task_code ?? 'N/A' }}</div></td>
                                                <td><div style="width: 150px;">{{ $item->name ?? 'N/A' }}</div></td>
                                                <td>
                                                    <div style="width: 150px;">
                                                        {{ $item->project 
                                                            ? ($item->project->name . ' (' . ($status[$item->project->status] ?? 'Unknown') . ')') 
                                                            : 'N/A' 
                                                        }}
                                                    </div>
                                                </td>                                                
                                                <td><div style="width: 150px;"><span class="badge-custom {{ $status_color[$item->status] }}">{{ $status[$item->status] ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 150px;"><span class="badge-custom {{ $status_color[$item->status] }}">{{ $priorities[$item->priority] ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 150px;">{{ $item->createdBy->name ?? 'N/A' }}</div></td>
                                                <td><div style="width: 150px;">{{ $item->assignedTo->name ?? 'N/A' }}</div></td>
                                                <td><div style="width: 150px;">{{ $item->start_date ?? 'N/A' }}</div></td>
                                                <td><div style="width: 150px;">{{ $item->end_date ?? 'N/A' }}</div></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('tasks.show', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Sửa" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                          <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('tasks.delete', ['id' => $item->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                              data-bs-toggle="tooltip"
                                                              title="Xóa"
                                                              class="btn btn-link btn-danger delete"
                                                              data-original-title="Remove"
                                                              data-id="{{ $item->id }}"
                                                            >
                                                              <i class="fa fa-times"></i>
                                                            </button>
                                                          </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
