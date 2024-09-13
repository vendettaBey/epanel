<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    // Display the list of employees
    public function index()
    {
        $employees = Employee::all();
        return view('backend.employees.index', compact('employees'));
    }

    // Show form to create a new employee
    public function create()
    {
        return view('backend.employees.create');
    }

    // Store a new employee
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'position' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->status = 1;
        if($request->hasFile('image')){
            if ($employee->image) {
                $imagePath = public_path($employee->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/employees'), $imageName);
            $employee->image = 'uploads/employees/'.$imageName;
        }

        $employee->save();

        

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    // Show the form to edit an employee
    public function edit(Employee $employee)
    {
        return view('backend.employees.edit', compact('employee'));
    }

    // Update an existing employee
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required',
            'position' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Employee::where('id',$employee->id)->first();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->status = 1;

        // Handle image upload
        if($request->hasFile('image')){
            if ($employee->image) {
                $imagePath = public_path($employee->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/employees'), $imageName);
            $employee->image = 'uploads/employees/'.$imageName;
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    // Delete an employee
    public function destroy(Employee $employee)
    {
        if ($employee->image) {
            $imagePath = public_path($employee->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    // Change employee status
    public function status(Employee $employee)
    {
        $employee->status = !$employee->status;
        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Employee status changed successfully.');
    }
}
