@extends('layouts.master-layout')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Vai trò</h3>
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
                        <a href="#">Vai trò</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Quản lý vai trò</h4>
                        </div>
                        <div class="card-body">
                            <div class="row p-3">
                                <!-- Thêm vai trò -->
                                <div class="col-4 p-2">
                                    <div class="p-4 m-h-170 bg-white rounded-3 shadow d-flex justify-content-between">
                                        <div class="d-flex flex-column justify-content-between">
                                            <div>
                                                <img width="60px" src="/assets/master/img/avatar/icon/pose_m1-qLsl3hEh.png"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="img-users d-flex justify-content-end position-relative">
                                                <a href="#" class="btn btn-primary btn-round ms-auto">Thêm vai trò</a>
                                            </div>
                                            <div class="img-users d-flex justify-content-end position-relative">
                                                <p class="w-75 mt-2 text-end">Thêm vai trò nếu chưa tồn tại.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Role item - repeat this block for each role -->
                                @foreach ($roles as $item)
                                    <div class="col-4 p-2">
                                        <div class="p-4 m-h-170 bg-white rounded-3 shadow d-flex justify-content-between">
                                            <div class="d-flex flex-column justify-content-between">
                                                <h6>Total {{ $item->users_count }} users</h6>
                                                <div class="pt-3">
                                                    <h5>{{ $item->name }}</h5>
                                                    <div class="d-flex">
                                                        <a href="#" data-bs-toggle="tooltip" title="Sửa"
                                                            class="btn btn-link btn-primary btn-lg p-0">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $item->id }}" method="POST" action="#">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button data-bs-toggle="tooltip" title="Xóa"
                                                                class="btn btn-link btn-danger delete p-0 ms-3" data-id="{{ $item->id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="img-users d-flex position-relative">
                                                    <div class="img-user">
                                                        <img class="h-100 w-100 rounded-circle"
                                                            src="/assets/master/img/avatar/icon/avatar-1-sTigs3cJ.png" alt="">
                                                    </div>
                                                    <div class="img-user">
                                                        <img class="h-100 w-100 rounded-circle"
                                                            src="/assets/master/img/avatar/icon/avatar-2-wiQeFG56.png" alt="">
                                                    </div>
                                                    <div class="img-user">
                                                        <img class="h-100 w-100 rounded-circle"
                                                            src="/assets/master/img/avatar/icon/avatar-3-wR29q9GN.png" alt="">
                                                    </div>
                                                    <div class="img-user">
                                                        <div
                                                            class="h-100 w-100 rounded-circle d-flex align-items-center justify-content-center bg-light text-dark">
                                                            +5</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
