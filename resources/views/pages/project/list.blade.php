@extends('layouts.master-layout', ['title' => 'Admin - Danh sách dự án'])

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản lý dự án</h3>
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
                        <a href="#">Dự án của phòng ban</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                <a href="{{ route('projects.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Thêm dự án
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tên dự án</th>
                                            <th>Trạng thái</th>
                                            <th>Người tạo</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Hành động</th>
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

                                            $status_color = [
                                                'not_started' => 'badge-gray',
                                                'in_progress' => 'badge-blue',
                                                'completed' => 'badge-green',
                                            ];
                                        @endphp
                                        @foreach ($projects as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td><div style="min-width: 120px;">{{ $item->name ?? 'N/A' }}</div></td>
                                                <td><div style="min-width: 120px;"><span class="badge-custom {{ $status_color[$item->status] }}">{{ $status[$item->status] ?? 'N/A' }}</span></div></td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="width: 250px">
                                                        <div class="d-block avatar avatar-sm" style="width: 50px;"><img class="rounded-circle object-fit-cover" src="{{ $item->createdBy->avatar }}" width="45px" height="45px" alt=""></div>
                                                        <div class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                            <b>{{ $item->createdBy->name ?? 'N/A' }}</b>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><div style="min-width: 120px;">{{ format_date($item->start_date) ?? 'N/A' }}</div></td>
                                                <td><div style="min-width: 120px;">{{ format_date($item->end_date) ?? 'N/A' }}</div></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('projects.show', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Xem chi tiết" class="btn btn-link text-warning" data-original-title="Edit Task">
                                                            <i class="fa fa-eye"></i>
                                                          </a>
                                                        <a href="{{ route('projects.edit', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Sửa" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                          <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('projects.delete', ['id' => $item->id]) }}">
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
