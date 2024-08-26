<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->user_type === 'admin') {
            $tasks = Task::where('manager_id' , auth()->id())->get(); // Admins can see all tasks
        } else {
            $tasks = Task::where('employee_id', Auth::id())->get(); // Employees see only their tasks
        }        return view('admin.tasks.index', compact('tasks'));
    }
    public function search(Request $request)
    {
        $query = $request->get('search');
    
        // Retrieve the current authenticated user
        $currentUser = Auth::user();
    
        if ($currentUser->user_type === 'admin') {
            // Admins see tasks assigned to them and search based on title, description, or employee details
            $tasks = Task::where('manager_id', $currentUser->id)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhereHas('employee', function($q) use ($query) {
                          $q->where('first_name', 'like', '%' . $query . '%')
                            ->orWhere('last_name', 'like', '%' . $query . '%');
                      });
                })
                ->get();
        } else {
            // Employees see tasks assigned to them and search based on title, description, or employee details
            $tasks = Task::where('employee_id', $currentUser->id)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhereHas('employee', function($q) use ($query) {
                          $q->where('first_name', 'like', '%' . $query . '%')
                            ->orWhere('last_name', 'like', '%' . $query . '%');
                      });
                })
                ->get();
        }
    
        // Return the rendered view for partial tasks
        return view('admin.tasks.partials.tasks', compact('tasks'))->render();
    }
    
    
    public function create()
    {
        $employees = User::where('user_type', 'employee')->where('manager',auth()->id())->get();
    
        return view('admin.tasks.create', compact('employees'));
    }

    public function store(TaskRequest $request)
    {
        Task::create(array_merge($request->validated(), ['manager_id' => auth()->id()]));
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        if (Auth::user()->user_type === 'employee' && $task->employee_id !== Auth::id()) {
            return redirect()->route('tasks.index'); // Employees cannot edit other employees' tasks
        }


        $employees = User::where('user_type', 'employee')->get();



        return view('admin.tasks.edit', compact('task','employees'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        if (Auth::user()->user_type === 'employee' && $task->employee_id !== Auth::id()) {
            return redirect()->route('tasks.index'); // Employees cannot update other employees' tasks
        }

        $task->update($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function show(Task $task)
    {
        if ($task->employee_id !== auth()->id() && $task->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('admin.tasks.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        if ($task->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
