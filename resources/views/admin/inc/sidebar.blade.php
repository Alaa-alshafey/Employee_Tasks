<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- Employees Menu (Visible to Admin only) -->
            @role('admin')
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Employees
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">   
                    <li class="nav-item">
                        <a href="{{ route('employees.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employees.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create New Employee</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole

            <!-- Departments Menu (Visible to Admin only) -->
            @role('admin')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>
                        Departments
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('departments.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Departments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('departments.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create New Department</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('employee'))
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        Tasks
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Tasks</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Logout Menu Item -->
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
