@extends('layouts.master-layout', ['title' => 'Admin - Danh sách người dùng'])

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản lý người dùng</h3>
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
                        <a href="#">Người dùng</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                @can('general-check', ['User Management', 'create'])
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Tạo người dùng
                                </a>
                                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-hover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>Stt</th>
                                            <th>Code</th>
                                            <th>Người dùng</th>
                                            <th>Vai trò</th>
                                            <th>Chức vụ</th>
                                            <th>Trạng thái</th>
                                            <th>Giới tính</th>
                                            <th>Phone</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày sinh</th>
                                            <th>Ngày tạo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $gender_colos = [
                                                'male' => 'badge-blue',
                                                'female' => 'badge-purple'
                                            ];

                                            $badgeColors = [
                                                'badge-red',
                                                'badge-yellow',
                                                'badge-green',
                                                'badge-blue',
                                                'badge-indigo',
                                                'badge-purple',
                                                'badge-pink',
                                            ];

                                            @endphp
                                        @foreach ($users as $item)
                                            @php
                                                $badgeClass = $badgeColors[array_rand($badgeColors)];
                                                $badgeClass2 = $badgeColors[array_rand($badgeColors)];
                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td><div>{{ $item?->userDetail?->employee_code ?? 'N/A' }}</div></td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="width: 250px">
                                                        <div class="d-block" style="width: 50px;"><img class="rounded-circle object-fit-cover" src="{{ $item->avatar }}" width="45px" height="45px" alt=""></div>
                                                        <div class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                            <b>{{ $item->name ?? 'N/A' }}</b>
                                                            <span>{{ '@'. $item->email}} </span>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                                <td><div style="width: 120px;"><span class="badge-custom {{ $badgeClass }}">{{ $item->role->name ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;"><span class="badge-custom {{ $item?->userDetail?->position?->name ?? 'badge-gray' }} {{ $item?->userDetail?->position?->name ? $badgeClass2 : '' }}">{{ $item?->userDetail?->position->name ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;" class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">{{ $item->is_active ? 'Hoạt động' : 'Không hoạt động' }}</div></td>
                                                <td><div style="width: 120px;"><span class="badge-custom {{ $item?->userDetail?->gender ?? 'badge-gray' }} {{ $item?->userDetail?->gender ? $gender_colos[$item?->userDetail?->gender] : '' }}">{{ $item?->userDetail?->gender ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;"><span class="{{ $item?->userDetail?->phone ?? 'badge-custom badge-gray' }}">{{ $item?->userDetail?->phone ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;"><span class="{{ $item?->userDetail?->address ?? 'badge-custom badge-gray' }}">{{ $item?->userDetail?->address ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;"><span class="{{ $item?->userDetail?->dob ?? 'badge-custom badge-gray' }}">{{ $item?->userDetail?->dob ?? 'N/A' }}</span></div></td>
                                                <td><div style="width: 120px;">{{ $item?->created_at ?? 'N/A' }}</div></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @can('general-check', ['User Management', 'view'])
                                                        <a href="{{ route('users.show', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Xem chi tiết" class="btn btn-link btn-warning btn-lg" data-original-title="Edit Task">
                                                            <i class="fa fa-eye"></i>
                                                          </a>
                                                @endcan
                                                          @can('general-check', ['User Management', 'update'])
                                                          <a href="{{ route('users.edit', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Sửa" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                            <i class="fa fa-edit"></i>
                                                          </a>
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
