@extends('admin.layouts.app')

@section('title', 'Tasks')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tasks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tasks</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                @role('admin')
                                <a class="btn btn-success" href="{{ route('tasks.create') }}">Add New Task</a>
                                @endrole
                            </h3>
                            <div class="card-tools">
                                <form id="searchForm_2" method="GET">
                                    <input type="text" id="searchInput_2" name="search" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Employee</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tasksTableBody">
                                    @include('admin.tasks.partials.tasks')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchForm_2').on('keyup', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var query = $('#searchInput_2').val(); // Get the search query

                $.ajax({
                    url: "{{ route('tasks.search') }}", // Use the POST route for searching
                    method: 'POST',
                    data: { 
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        search: query 
                    },
                    success: function(response) {
                        $('#tasksTableBody').html(response); // Update table body with results
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText); // Handle errors
                    }
                });
            });
        });
    </script>
@endpush
