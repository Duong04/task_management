@extends('layouts.master-layout', ['title' => 'Admin - Danh sách quyền'])

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quyền hành động</h3>
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
                        <a href="#">Phân quyền</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Quyền hành động</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                @can('general-check', ['Permission Management', 'create'])
                                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-round ms-auto">
                                        <i class="fa fa-plus"></i>
                                        Thêm quyền
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Create At</th>
                                            <th>Update At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($permissions as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @can('general-check', ['Permission Management', 'update'])
                                                            <a href="{{ route('permissions.show', ['id' => $item->id]) }}"
                                                                type="button" data-bs-toggle="tooltip" title="Sửa"
                                                                class="btn btn-link btn-primary btn-lg"
                                                                data-original-title="Edit Task">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('general-check', ['Permission Management', 'delete'])
                                                            <form class="d-flex align-items-center"
                                                                id="delete-form-{{ $item->id }}" method="POST"
                                                                action="{{ route('permissions.delete', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button data-bs-toggle="tooltip" title="Xóa"
                                                                    class="btn btn-link btn-danger delete"
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
