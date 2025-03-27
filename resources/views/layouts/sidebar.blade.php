<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">Support-Ticket</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main
            </li>

            <!-- Tickets menu is visible for all roles -->
            <li class="sidebar-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('tickets.index') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Tickets</span>
                </a>
            </li>

            @role('Administrator')
                <!-- Dashboard (Admin only) -->
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dashboard') }}">
                        <i class="align-middle" data-feather="home"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <!-- Categories -->
                <li class="sidebar-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('categories.index') }}">
                        <i class="align-middle" data-feather="folder"></i>
                        <span class="align-middle">Categories</span>
                    </a>
                </li>

                <!-- Labels -->
                <li class="sidebar-item {{ request()->routeIs('labels.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('labels.index') }}">
                        <i class="align-middle" data-feather="tag"></i>
                        <span class="align-middle">Labels</span>
                    </a>
                </li>

                <!-- Priorities -->
                <li class="sidebar-item {{ request()->routeIs('priorities.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('priorities.index') }}">
                        <i class="align-middle" data-feather="alert-triangle"></i>
                        <span class="align-middle">Priorities</span>
                    </a>
                </li>

                <!-- User Management -->
                <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <i class="align-middle" data-feather="users"></i>
                        <span class="align-middle">User Management</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('logs.index') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('logs.index') }}">
                        <i class="align-middle" data-feather="file-text"></i>
                        <span class="align-middle">Logs</span>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</nav>
