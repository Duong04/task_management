@extends('layouts.auth-layout', ['title' => 'Đăng nhập'])
@section('content')
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    <a href="#"><img src="/assets/auth/images/logo-dark.svg" alt="img" /></a>
                </div>
                <div class="card my-5">
                    <form action="{{ route('action.login') }}" method="POST" class="card-body">
                        @csrf
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <h3 class="mb-0"><b>Đăng nhập</b></h3>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Email</label>
                            <input value="{{ old('email') }}" name="email" type="email" class="form-control" placeholder="Email" />
                            @if ($errors->first('email'))
                                <span class="text-danger fs-7">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input value="{{ old('password') }}" name="password" type="password" class="form-control" placeholder="Mật khẩu" />
                            @if ($errors->first('password'))
                                <span class="text-danger fs-7">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="d-flex mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                    checked="" />
                                <label class="form-check-label text-muted" for="customCheckc1">Lưu thông tin đăng nhập</label>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                        <div class="saprator mt-3">
                            <span>Đăng nhập với</span>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="d-grid">
                                    <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                                        <img src="/assets/auth/images/authentication/google.svg" alt="img" />
                                        <span class="d-none d-sm-inline-block"> Google</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                                        <img src="/assets/auth/images/authentication/twitter.svg" alt="img" />
                                        <span class="d-none d-sm-inline-block"> Twitter</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                                        <img src="/assets/auth/images/authentication/facebook.svg" alt="img" />
                                        <span class="d-none d-sm-inline-block"> Facebook</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="auth-footer row">
                    <!-- <div class=""> -->
                    <div class="col my-1">
                        <p class="m-0">Copyright © <a href="#">Sugar</a></p>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection
