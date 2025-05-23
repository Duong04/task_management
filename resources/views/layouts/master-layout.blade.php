<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicons.ico" type="image/x-icon">
    <title>{{ $title ?? 'Admin' }}</title>
    <script src="/assets/master/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["/assets/master/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/master/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/master/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/master/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/assets/master/css/demo.css" />
    <link rel="stylesheet" href="/assets/master/css/admin.css" />
    @yield('css')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('includes.aside')
        <!-- End Sidebar -->
  
        <div class="main-panel">
            @include('includes.header')
  
            @yield('content')
  
          {{-- footer --}}
            @include('includes.footer')
            {{-- end footer --}}
        </div>
  
        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
          <div class="title">Settings</div>
          <div class="custom-content">
            <div class="switcher">
              <div class="switch-block">
                <h4>Logo Header</h4>
                <div class="btnSwitch">
                  <button
                    type="button"
                    class="selected changeLogoHeaderColor"
                    data-color="dark"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="blue"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="purple"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="light-blue"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="green"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="orange"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="red"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="white"
                  ></button>
                  <br />
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="dark2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="blue2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="purple2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="light-blue2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="green2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="orange2"
                  ></button>
                  <button
                    type="button"
                    class="changeLogoHeaderColor"
                    data-color="red2"
                  ></button>
                </div>
              </div>
              <div class="switch-block">
                <h4>Navbar Header</h4>
                <div class="btnSwitch">
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="dark"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="blue"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="purple"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="light-blue"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="green"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="orange"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="red"
                  ></button>
                  <button
                    type="button"
                    class="selected changeTopBarColor"
                    data-color="white"
                  ></button>
                  <br />
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="dark2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="blue2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="purple2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="light-blue2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="green2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="orange2"
                  ></button>
                  <button
                    type="button"
                    class="changeTopBarColor"
                    data-color="red2"
                  ></button>
                </div>
              </div>
              <div class="switch-block">
                <h4>Sidebar</h4>
                <div class="btnSwitch">
                  <button
                    type="button"
                    class="changeSideBarColor"
                    data-color="white"
                  ></button>
                  <button
                    type="button"
                    class="selected changeSideBarColor"
                    data-color="dark"
                  ></button>
                  <button
                    type="button"
                    class="changeSideBarColor"
                    data-color="dark2"
                  ></button>
                </div>
              </div>
            </div>
          </div>
          <div class="custom-toggle">
            <i class="icon-settings"></i>
          </div>
        </div>
        <!-- End Custom template -->
      </div>
    <script src="/assets/master/js/core/jquery-3.7.1.min.js"></script>
    <script src="/assets/master/js/core/popper.min.js"></script>
    <script src="/assets/master/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="/assets/master/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="/assets/master/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="/assets/master/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="/assets/master/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="/assets/master/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="/assets/master/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="/assets/master/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="/assets/master/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="/assets/master/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="/assets/master/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="/assets/master/js/setting-demo.js"></script>
    <script src="/assets/master/js/demo.js"></script>
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });

        $(document).ready(function () {
          $("#basic-datatables").DataTable({language: {
            search: "Tìm kiếm:",
            lengthMenu: "Hiển thị _MENU_ mục",
            info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
            infoEmpty: "Không có dữ liệu",
            zeroRecords: "Không tìm thấy kết quả phù hợp",
            infoFiltered: "(lọc từ tổng số _MAX_ mục)",
            paginate: {
                first: "Đầu",
                last: "Cuối",
                next: "Sau",
                previous: "Trước"
            }
        }});
        });
    </script>
    <script>
      window.auth = {
          isAuthenticated: {{ Auth::check() ? 'true' : 'false' }},
          user: @json(Auth::user()->load('role'))
      };
  </script>
    <script src="/assets/master/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/master/js/sweetalert.js"></script>
    <script src="/assets/master/js/main.js"></script>
    <script src="/libraries/axios/axios.min.js"></script>
    <script type="module" src="/js/axios.js"></script>
    @yield('script')
</body>

</html>
