@extends('layouts.master-layout', ['title' => 'Admin - Dashboard'])
@section('css')
<style>
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
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Báo cáo</h3>
                    <h6 class="op-7 mb-2">Xin chào {{ auth()->user()->name }}, chúc bạn một ngày làm việc năng động!</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                </div>
            </div>
            <div>
                <h4>Báo cáo công việc</h4>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round" style="height: 110px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
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
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round" style="height: 110px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
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
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round" style="height: 110px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
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
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round" style="height: 110px;">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-danger bubble-shadow-small">
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Báo cáo số lượng công việc</div>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                        <span class="btn-label">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                        Export
                                    </a>
                                    <a href="#" class="btn btn-label-info btn-round btn-sm">
                                        <span class="btn-label">
                                            <i class="fa fa-print"></i>
                                        </span>
                                        Print
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="box-shadow: none;">
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
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc hôm nay cần làm</p>
                                                <h4 class="card-title">{{ $task_stats['today_tasks'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc đã hoàn thành hôm nay</p>
                                                <h4 class="card-title">{{ $task_stats['today_completed'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc tuần này cần làm</p>
                                                <h4 class="card-title">{{ $task_stats['week_tasks'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc đã hoàn thành tuần này</p>
                                                <h4 class="card-title">{{ $task_stats['week_completed'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc tháng này cần làm</p>
                                                <h4 class="card-title">{{ $task_stats['month_tasks'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc đã hoàn thành trong tháng này</p>
                                                <h4 class="card-title">{{ $task_stats['month_completed'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Việc đã hoàn thành tháng này</p>
                                                <h4 class="card-title">{{ $task_stats['month_completed'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-stats card-round">
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Tất cả công việc đã hoàn thành</p>
                                                <h4 class="card-title">{{ $task_stats['total_completed'] }}</h4>
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
            let url = `/api/v1/tasks/stats-time?year=${year}`;
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
