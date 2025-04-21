<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="/" class="logo mx-auto">
                <img src="/ibpo_logo.svg" alt="navbar brand" class="navbar-brand" height="40" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : ''}}">
                    <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Báo cáo</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Quản lý</h4>
                </li>
                @can('general-check', ['Task Management', 'viewAny'])
                <li class="nav-item {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.list') ? 'active' : ''}}">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Quản lý công việc</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            @php
                                $canViewTask = auth()->user()->can('general-check', ['Task Management', 'viewAll']);
                            @endphp
                            @if (strtoupper(auth()->user()->role) == 'SUPPER ADMIN' || $canViewTask)
                            <li class="{{ request()->routeIs('tasks.all') ? 'active' : ''}}">
                                <a href="{{ route('tasks.all') }}">
                                    <span class="sub-item">Tất cả công việc</span>
                                </a>
                            </li>
                            @endif
                            <li class="{{ request()->routeIs('tasks.index') ? 'active' : ''}}">
                                <a href="{{ route('tasks.index') }}">
                                    <span class="sub-item">Việc của tôi</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('tasks.list') ? 'active' : ''}}">
                                <a href="{{ route('tasks.list') }}">
                                    <span class="sub-item">Việc tôi giao</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('general-check', ['Project Management', 'viewAny'])
                <li class="nav-item {{ request()->routeIs('projects.index') || request()->routeIs('projects.list') ? 'active' : ''}}">
                    <a data-bs-toggle="collapse" href="#projects">
                        <i class="fas fa-tasks"></i>
                        <p>Quản lý dự án</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="projects">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('projects.index') ? 'active' : ''}}">
                                <a href="{{ route('projects.index') }}">
                                    <span class="sub-item">Dự án cá nhân</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('projects.list') ? 'active' : ''}}">
                                <a href="{{ route('projects.list') }}">
                                    <span class="sub-item">Dự án của phòng ban</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('general-check', ['User Management', 'viewAny'])
                <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : ''}}">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Quản lý người dùng</p>
                    </a>
                </li>
                @endcan
                @can('general-check', ['Department Management', 'viewAny'])
                <li class="nav-item {{ request()->routeIs('departments.index') ? 'active' : ''}}">
                    <a href="{{ route('departments.index') }}">
                        <i class="fas fa-id-card"></i>
                        <p>Quản lý phòng ban</p>
                    </a>
                </li>
                @endcan
                @php
                    $canViewRole = auth()->user()->can('general-check', ['Role Management', 'viewAny']);
                    $canViewAction = auth()->user()->can('general-check', ['Action Management', 'viewAny']);
                    $canViewPermission = auth()->user()->can('general-check', ['Permission Management', 'viewAny']);
                    $canViewPosition = auth()->user()->can('general-check', ['Position Management', 'viewAny']);
                @endphp
                 @if ($canViewRole || $canViewAction || $canViewPermission || $canViewPosition)
                 <li class="nav-item {{ request()->routeIs('roles.index') || request()->routeIs('positions.index') || request()->routeIs('actions.index') || request()->routeIs('permissions.index') ? 'active' : ''}}">
                     <a data-bs-toggle="collapse" href="#sidebarLayouts">
                         <i class="fas fa-th-list"></i>
                         <p>Phân quyền</p>
                         <span class="caret"></span>
                     </a>
                     <div class="collapse" id="sidebarLayouts">
                         <ul class="nav nav-collapse">
                            @if ($canViewRole)
                            <li class="{{ request()->routeIs('roles.index') ? 'active' : ''}}">
                                <a href="{{ route('roles.index') }}">
                                    <span class="sub-item">Vai trò</span>
                                </a>
                            </li>
                            @endif
                             @if ($canViewPosition)
                             <li class="{{ request()->routeIs('positions.index') ? 'active' : ''}}">
                                 <a href="{{ route('positions.index') }}">
                                     <span class="sub-item">Chức vụ</span>
                                 </a>
                             </li>
                            @endif
                             @if ($canViewAction)
                             <li class="{{ request()->routeIs('actions.index') ? 'active' : ''}}">
                                 <a href="{{ route('actions.index') }}">
                                     <span class="sub-item">Hành động</span>
                                 </a>
                             </li>
                            @endif
                             @if ($canViewPermission)
                             <li class="{{ request()->routeIs('permissions.index') ? 'active' : ''}}">
                                 <a href="{{ route('permissions.index') }}">
                                     <span class="sub-item">Quyền hành động</span>
                                 </a>
                             </li>
                            @endif
                         </ul>
                     </div>
                 </li>
                 @endif
            </ul>
        </div>
    </div>
</div>
