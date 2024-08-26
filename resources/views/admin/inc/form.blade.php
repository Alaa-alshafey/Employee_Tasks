<!-- resources/views/admin/inc/form.blade.php -->

<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($employee))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" class="form-control" id="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" class="form-control" id="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $employee->email ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $employee->phone_number ?? '') }}">
    </div>

    <div class="form-group">
        <label for="salary">Salary</label>
        <input type="number" name="salary" class="form-control" id="salary" value="{{ old('salary', $employee->salary ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="image">Profile Image</label>
        <input type="file" name="image" class="form-control" id="image">
        @if(isset($employee) && $employee->image)
            <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile Image" width="100">
        @endif
    </div>

    <div class="form-group">
        <label for="manager">Manager</label>
        <select name="manager" id="manager" class="form-control">
            <option value="">None</option>
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}" {{ (old('manager', $employee->manager_id ?? '') == $manager->id) ? 'selected' : '' }}>
                    {{ $manager->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="department_id">Department</label>
        <select name="department_id" id="department_id" class="form-control">
            <option value="">None</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ (old('department_id', $employee->department_id ?? '') == $department->id) ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($employee) ? 'Update Employee' : 'Add Employee' }}</button>
</form>
