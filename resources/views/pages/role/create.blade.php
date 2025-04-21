@extends('layouts.master-layout', ['title' => 'Admin - Tạo vai tròc'])

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Thêm vai trò</h3>
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
                <a href="">Phân quyền</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Thêm vai trò</a>
            </li>
            </ul>
        </div>
        <div class="row">
          <form class="row col-12" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="col-6 form-group">
                <button class="btn btn-primary">Thêm vai trò</button>
            </div>
            <div class="col-12 row">
                <div class="row mx-0">
                    <div class="form-group col-6 {{ $errors->first('name') ? ' has-error' : '' }}">
                        <label for="name">Tên quyền (<span class="text-danger">*</span>)</label>
                        <input
                            value="{{ old('name') }}"
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Tên vai trò"
                        />
                        @if ($errors->first('name'))
                            <span class="text-danger fs-7">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-6 {{ $errors->first('description') ? ' has-error' : '' }}">
                        <label for="description">Mô tả</label>
                        <input
                            value="{{ old('value') }}"
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Mô tả"
                        />
                        @if ($errors->first('description'))
                            <span class="text-danger fs-7">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group d-flex justify-content-between">
                        <h5>Quyền của vai trò</h5>
                        <div class="col-auto ms-3 d-flex align-items-center mt-3">
                            <label class="colorinput me-2">
                                <input id="select-all" name="select-all" type="checkbox" value="true" class="colorinput-input check-action" />
                                <span class="colorinput-color bg-info"></span>
                            </label>
                            <label for="select-all">Chọn tất cả</label>
                        </div>
                    </div>
                    @foreach ($permissions as $item)
                        <div class="col-12 d-flex justify-content-between">
                            <div class="form-group">
                                <div>
                                    <label for="">{{$item->name}}</label>
                                    <input type="hidden" class="parent-checkbox-{{$item->id}}" hidden name="permission_id[]" value="{{$item->id}}">
                                </div>
                            </div>
                            <div class="form-group form-check-{{$item->id}}">
                                <div class="row gutters-xs">
                                    @php
                                        $allowedActions = $item->permissionActions->pluck('action_id')->toArray();
                                    @endphp
                                    @foreach ($actions as $action)
                                        @if (in_array($action->id, $allowedActions))
                                        <div class="col-auto ms-3 d-flex align-items-center mt-3">
                                            <label class="colorinput me-2">
                                                <input id="checkbox-{{$action->id}}-{{$item->id}}" name="actions[{{$item->id}}][]" type="checkbox" value="{{$action->id}}" class="colorinput-input check-action" />
                                                <span class="colorinput-color bg-info"></span>
                                            </label>
                                            <label for="checkbox-{{$action->id}}-{{$item->id}}">{{ $action->name }}</label>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-6 form-group">
                <button class="btn btn-primary">Lưu</button>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-warning">Hủy</a>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection