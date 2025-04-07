@extends('layouts.master-layout')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Hành động</h3>
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
                        <a href="#">Hành động</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-item-center">
                                <h4 class="card-title">Danh sách</h4>
                                <a href="{{ route('actions.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Thêm hành động
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Create At</th>
                                            <th>Update At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Create At</th>
                                            <th>Update At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($actions as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('actions.show', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Sửa" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                          <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('actions.delete', ['id' => $item->id]) }}">
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
