@extends('layouts.master-layout', ['title' => 'Admin - Danh sách công việc'])
@section('script')
    <script>
        $(document).ready(function () {
          var table = $('#basic-datatables-filter').DataTable();

          $('#statusFilter').on('change', function () {
              var selected = $(this).val();
              table.column(7) 
                  .search(selected)
                  .draw();
          });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản lý việc tôi giao</h3>
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
                        <a href="#">Việc tôi giao</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                @can('general-check', ['Task Management', 'create'])
                                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-round ms-auto">
                                        <i class="fa fa-plus"></i>
                                        Tạo công việc
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="mb-3">
                                    <label for="statusFilter" class="form-label">Lọc theo trạng thái:</label>
                                    <select id="statusFilter" class="form-select" style="width: 200px;">
                                        <option value="">Tất cả</option>
                                        <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                                        <option value="Đang thực hiện">Đang thực hiện</option>
                                        <option value="Hoàn thành">Hoàn thành</option>
                                    </select>
                                </div>
                                <table id="basic-datatables-filter" class="display table table-hover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th style="width: 50px;">Stt</th>
                                            <th>
                                                <div style="width: 150px;">Code</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Tên công việc</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Tên dự án</div>
                                            </th>
                                            <th>
                                                <div style="width: 250px;">Người giao việc</div>
                                            </th>
                                            <th>
                                                <div style="width: 250px;">Người thực hiện</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Tiến độ</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Trạng thái</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Độ ưu tiên</div>
                                            </th>
                                            <th>
                                                <div style="width: 150px;">Hạn hoàn thành</div>
                                            </th>
                                            <th class="text-center">
                                                <div style="width: 120px;">Thao tác</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
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
                                        @foreach ($tasks as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <div style="width: 150px;"><span
                                                            class="badge-custom badge-blue">{{ $item->task_code ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 150px;">{{ $item->name ?? 'N/A' }}</div>
                                                </td>
                                                <td>
                                                    <div style="width: 150px;">
                                                        {{ $item->project ? $item->project->name . ' (' . ($status[$item->project->status] ?? 'Unknown') . ')' : 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="width: 250px">
                                                        <div class="d-block avatar avatar-sm" style="width: 50px;"><img
                                                                class="rounded-circle object-fit-cover"
                                                                src="{{ $item->createdBy->avatar }}" width="45px"
                                                                height="45px" alt=""></div>
                                                        <div
                                                            class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                            <b>{{ $item->createdBy->name ?? 'N/A' }}</b>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="width: 250px">
                                                        <div class="d-block avatar avatar-sm" style="width: 50px;"><img
                                                                class="rounded-circle object-fit-cover"
                                                                src="{{ $item->assignedTo->avatar }}" width="45px"
                                                                height="45px" alt=""></div>
                                                        <div
                                                            class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                            <b>{{ $item->assignedTo->name ?? 'N/A' }}</b>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 150px;">
                                                        <div style="font-weight: bold; margin-bottom: 4px;">
                                                            {{ $item->progress }}%
                                                        </div>
                                                        <div
                                                            style="background-color: #e9ecef; border-radius: 10px; height: 8px; overflow: hidden;">
                                                            <div
                                                                style="
                                                                width: {{ $item->progress }}%;
                                                                background-color: #28a745;
                                                                height: 100%;
                                                            ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="width: 150px;"><span
                                                            class="badge-custom {{ $status_color[$item->status] }}">{{ $status[$item->status] ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 150px;"><span
                                                            class="badge-custom {{ $priority_color[$item->priority] }}">{{ $priorities[$item->priority] ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 150px;">{{ format_date($item->due_date) ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @can('general-check', ['Task Management', 'view'])
                                                            <a href="{{ route('tasks.show', ['id' => $item->id]) }}"
                                                                type="button" data-bs-toggle="tooltip" title="Xem chi tiết"
                                                                class="btn btn-link text-warning"
                                                                data-original-title="Edit Task">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                        @can('general-check', ['Task Management', 'update'])
                                                            <a href="{{ route('tasks.edit', ['id' => $item->id]) }}"
                                                                type="button" data-bs-toggle="tooltip" title="Sửa"
                                                                class="btn btn-link text-primary"
                                                                data-original-title="Edit Task">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('general-check', ['Task Management', 'delete'])
                                                            <form class="d-flex align-items-center"
                                                                id="delete-form-{{ $item->id }}" method="POST"
                                                                action="{{ route('tasks.delete', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button data-bs-toggle="tooltip" title="Xóa"
                                                                    class="btn btn-link text-danger delete"
                                                                    data-original-title="Remove" data-id="{{ $item->id }}">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
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
