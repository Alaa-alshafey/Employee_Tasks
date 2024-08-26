<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::with('managers')->where('user_type', 'employee')->get();
        return view('admin.employees.index', compact('employees'));

    }


    public function search(Request $request)
    {
      
        $query = $request['query'];

        if($query){

            $employees = User::where('user_type', 'employee')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->orWhere('phone_number', 'like', "%$query%");
            })
            ->with('managers') // Include the manager relationship if needed
            ->get();

        }else{

            $employees = User::with('managers')->where('user_type', 'employee')->get();

        }

        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::where('user_type', 'admin')->get(); // Assuming admins are managers
        $departments = Department::get(); // Assuming admins are managers
        return view('admin.employees.create', compact('managers','departments'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();
        
        $employee = new User($validated);
        $employee->user_type = 'employee';
        $employee->password = Hash::make($request->password);
        
        if ($request->hasFile('image')) {
            $employee->image = Helper::uploadImage($request->file('image'));
        }

        $employee->save();

            // Assign the 'employee' role to the newly created user
            $employee->assignRole('employee');

        return redirect()->route('employees.index')->with('success', 'employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $employee)
    {
        $managers = User::where('user_type', 'admin')->get(); // Assuming admins are managers
        $departments = Department::get(); // Assuming admins are managers

        return view('admin.employees.edit', compact('employee', 'managers','departments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
// app/Http/Controllers/EmployeeController.php

public function update(Request $request, User $employee)
{
    // Handle the profile image if provided
    if ($request->hasFile('image')) {
        $employee->image = Helper::uploadImage($request->file('image'));
    }

    // Update fields if they are present in the request
    $employee->first_name = $request->input('first_name', $employee->first_name);
    $employee->last_name = $request->input('last_name', $employee->last_name);
    $employee->email = $request->input('email', $employee->email);
    $employee->phone_number = $request->input('phone_number', $employee->phone_number);
    $employee->salary = $request->input('salary', $employee->salary);
    $employee->manager = $request->input('manager', $employee->manager);
    $employee->department_id = $request->input('department_id', $employee->department_id);

    // Update password if a new one is provided
    if ($request->filled('password')) {
        $employee->password = Hash::make($request->input('password'));
    }

    // Save the employee data
    $employee->save();

    // Redirect to the employee index page
    return redirect()->route('employees.index')->with('success', 'employee Updated successfully.');
}

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
