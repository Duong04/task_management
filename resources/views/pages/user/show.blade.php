@extends('layouts.master-layout', ['title' => 'Admin - Thông tin người dùng'])
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .rp-task {
            width: 150px;
        }

        .box-purple {
            background-color: rgb(222, 206, 255);
            color: rgb(140, 87, 255);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .nav-tabs {
            border-bottom: 2px solid #3fbbc0;
        }

        .nav-tabs .tab-custom {
            background-color: #f8f9fa;
            border: 1px solid #3fbbc0;
            border-bottom: none;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 10px 20px;
            color: #3fbbc0;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-tabs .tab-custom:hover {
            background-color: #e0f7f9;
            color: #31999c;
        }

        .nav-tabs .tab-custom.active {
            background-color: #3fbbc0;
            color: #ffffff;
            font-weight: 600;
            border-color: #3fbbc0;
        }

        .card select {
        display: inline-block;
        width: 100px;
        padding: 5px 12px;
        margin: 10px;
        font-size: 0.9rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card select:focus {
        outline: none;
        border-color: #157efb;
        box-shadow: 0 0 0 2px rgba(21, 126, 251, 0.2);
    }

    .chart-container {
        position: relative;
        height: 400px;
        margin-top: 20px;
    }

    /* Responsive khi ở trên mobile */
    @media (max-width: 576px) {
        .card select {
            width: 100%;
            margin: 5px 0;
        }
    }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{ route('users.index') }}" class="me-1"><i
                            class="fas fa-arrow-left"></i></a> Thông tin chi tiết</h3>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="col-4 py-5 bg-white aside-shadow">
                        <div class="text-center">
                            <div class="img-avatar mx-auto">
                                <img width="120px" height="120px" class="rounded-circle object-fit-cover"
                                    src="{{ $user->avatar }}" alt="">
                            </div>
                            <h5 class="fs-5 mt-3">{{ $user->name }}</h5>
                            <span class="badge badge-blue">{{ $user->userDetail->employee_code ?? 'N/A' }}</span>
                        </div>
                        <div class="rp-task mx-auto d-flex flex-column mt-4" style="gap: 10px;">
                            <div class="d-flex g-10 align-items-center" style="gap: 10px;">
                                <div class="btn {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                                    <i class='fab fa-snapchat-ghost'></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <strong>Trạng thái</strong>
                                    <span>{{ $user->is_active ? 'Hoạt động' : 'không hoạt động' }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div class="btn badge-yellow">
                                    <i class='fas fa-users'></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <strong>Vai trò</strong>
                                    <span class="text-nowrap">{{ $user->role->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 bg-white p-3">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-custom active" id="thongtin-tab" data-bs-toggle="tab"
                                    data-bs-target="#thongtin" type="button" role="tab" aria-controls="thongtin"
                                    aria-selected="true">
                                    Thông tin
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-custom" id="hopdong-tab" data-bs-toggle="tab"
                                    data-bs-target="#hopdong" type="button" role="tab" aria-controls="hopdong"
                                    aria-selected="false">
                                    Thống kê
                                </button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content pt-3 mt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="thongtin" role="tabpanel"
                                aria-labelledby="thongtin-tab">
                                <form class="row"
                                    action="{{ route('users.update', ['id' => $user->id, 'redirect' => 'back']) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- Họ và tên --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="name">Họ và tên</label>
                                        <input value="{{ $user->name }}" name="name" type="text"
                                            class="form-control" id="name" placeholder="Họ và tên" />
                                        @if ($errors->first('name'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input value="{{ $user->email }}" name="email" type="text"
                                            class="form-control" id="email" placeholder="example@gmail.com" />
                                        @if ($errors->first('email'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="phone">Số điện thoại</label>
                                        <input value="{{ $user?->userDetail?->phone }}" name="user_detail[phone]"
                                            type="text" class="form-control" id="phone"
                                            placeholder="Số điện thoại" />
                                        @if ($errors->first('user_detail.phone'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('user_detail.phone') }}</span>
                                        @endif
                                    </div>

                                    {{-- Trạng thái --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="gender">Giới tính</label>
                                        <select name="user_detail[gender]" class="form-control" id="gender">
                                            <option value="">-- Giới tính --</option>
                                            <option {{ $user?->userDetail?->gender == 'male' ? 'selected' : '' }}
                                                value="male">
                                                Nam</option>
                                            <option {{ $user?->userDetail?->gender == 'female' ? 'selected' : '' }}
                                                value="female">Nữ</option>
                                        </select>
                                        @if ($errors->first('user_detail.gender'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('user_detail.gender') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="is_active">Trạng thái tài khoản</label>
                                        <select name="is_active" class="form-control" id="is_active">
                                            <option value="">-- Trạng thái tài khoản --</option>
                                            <option {{ $user->is_active == 1 ? 'selected' : '' }} value="1">Hoạt động
                                            </option>
                                            <option {{ $user->is_active == 0 ? 'selected' : '' }} value="0">Không
                                                hoạt động</option>
                                        </select>
                                        @if ($errors->first('is_active'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('is_active') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="dob">Ngày sinh</label>
                                        <input value="{{ $user?->userDetail?->dob }}" name="user_detail[dob]"
                                            type="date" class="form-control" id="dob" />
                                        @if ($errors->first('user_detail.dob'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('user_detail.dob') }}</span>
                                        @endif
                                    </div>

                                    {{-- Địa chỉ --}}
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="address">Địa chỉ</label>
                                        <input name="user_detail[address]" rows="4" type="text"
                                            class="form-control" id="address" placeholder="Địa chỉ" type="text"
                                            value="{{ $user?->userDetail?->address }}">
                                        @if ($errors->first('user_detail.address'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('user_detail.address') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Hủy</a>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="hopdong" role="tabpanel" aria-labelledby="hopdong-tab">
                                <div class="card">
                                    <h4>Báo cáo công việc</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round" style="height: 110px;">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="row align-items-center">
                                                        <div class="col-icon">
                                                            <div
                                                                class="icon-big text-center icon-success bubble-shadow-small">
                                                                <i class="fas fa-calendar-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col col-stats ms-3 ms-sm-0">
                                                            <div class="numbers">
                                                                <p class="card-category">Công việc đã hoàn thành</p>
                                                                <h4 class="card-title">{{ $task_status_completed }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round" style="height: 110px;">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="row align-items-center">
                                                        <div class="col-icon">
                                                            <div
                                                                class="icon-big text-center icon-info bubble-shadow-small">
                                                                <i class="fas fa-chalkboard-teacher"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col col-stats ms-3 ms-sm-0">
                                                            <div class="numbers">
                                                                <p class="card-category">Công việc đang xử lý</p>
                                                                <h4 class="card-title">{{ $task_status_in_progress }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round" style="height: 110px;">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="row align-items-center">
                                                        <div class="col-icon">
                                                            <div
                                                                class="icon-big text-center icon-secondary bubble-shadow-small">
                                                                <i class="fas fa-clipboard-list"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col col-stats ms-3 ms-sm-0">
                                                            <div class="numbers">
                                                                <p class="card-category">Công việc chưa bắt đầu</p>
                                                                <h4 class="card-title">{{ $task_status_not_started }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round" style="height: 110px;">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="row align-items-center">
                                                        <div class="col-icon">
                                                            <div
                                                                class="icon-big text-center icon-danger bubble-shadow-small">
                                                                <i class="fas fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col col-stats ms-3 ms-sm-0">
                                                            <div class="numbers">
                                                                <p class="card-category">Công việc chậm tiến độ</p>
                                                                <h4 class="card-title">{{ $task_overdue }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex">
                                            <select id="yearSelect">
                                                @for($y = now()->year; $y >= 2020; $y--)
                                                  <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                              
                                            <select id="monthSelect">
                                                <option value="">-- Tháng --</option>
                                                @for($m = 1; $m <= 12; $m++)
                                                  <option value="{{ $m }}">Tháng {{ $m }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="barChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function renderChart(year, month = null) {
            const currentPath = window.location.pathname;

            const pathSegments = currentPath.split("/");

            const userId = pathSegments[pathSegments.length - 1];

            const url = `/api/v1/tasks/stats-time?year=${year}&user=${userId}`;
            if (month) url += `&month=${month}`;

            fetch(url)
                .then(res => res.json())
                .then(result => {
                    const ctx = document.getElementById("barChart").getContext("2d");

                    // Nếu chart cũ tồn tại, hủy nó
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    window.myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: result.labels,
                            datasets: [{
                                label: result.type === 'month' ?
                                    `Số task trong tháng ${month}/${year}` : `Số task năm ${year}`,
                                backgroundColor: "rgb(23, 125, 255)",
                                data: result.data
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                });
        }

        // Sự kiện thay đổi
        document.getElementById("yearSelect").addEventListener("change", () => {
            const year = document.getElementById("yearSelect").value;
            const month = document.getElementById("monthSelect").value;
            renderChart(year, month || null);
        });

        document.getElementById("monthSelect").addEventListener("change", () => {
            const year = document.getElementById("yearSelect").value;
            const month = document.getElementById("monthSelect").value;
            renderChart(year, month || null);
        });

        // Load mặc định
        renderChart(new Date().getFullYear());
    </script>
@endsection
