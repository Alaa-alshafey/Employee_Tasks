@extends('admin.layouts.app')

@section('title', 'Employees')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employees</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a class="btn btn-success" href="{{ route('employees.create') }}">Add New Employee</a>
                            </h3>

                            <div class="card-tools">
                                <form id="search-form" class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" id="search" name="query" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                           @endif

                            <table class="table table-hover" id="employees-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Salary</th>
                                        <th>Manager</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->full_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone_number }}</td>
                                            <td>{{ $employee->salary }}</td>
                                            <td>{{ $employee->managers->full_name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#search-form').on('keyup', function(event) {
                    event.preventDefault(); // Prevent the form from submitting normally

                    let query = $('#search').val();

                    $.ajax({
                        url: "{{ route('employees.search') }}",
                        type: 'POST',
                        data: {
                            query: query,
                            _token: "{{ csrf_token() }}" // Include the CSRF token for security
                        },
                        success: function(data) {
                            let tableBody = $('#employees-table tbody');
                            tableBody.empty(); // Clear the existing table rows

                            $.each(data, function(index, employee) {
                                tableBody.append(
                                    `<tr>
                                        <td>${employee.id}</td>
                                        <td>${employee.first_name} ${employee.last_name} </td>
                                        <td>${employee.email}</td>
                                        <td>${employee.phone_number}</td>
                                        <td>${employee.salary}</td>
                                        <td>${employee.manager ? employee.managers.first_name + " " + employee.managers.last_name : 'N/A'}</td>
                                        <td>
                                            <a href="/employees/${employee.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="/employees/${employee.id}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>`
                                );
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
