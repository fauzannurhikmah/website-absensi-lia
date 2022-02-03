<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::orderBy('name')->paginate(10);
        if (request('search'))
            $employee = Employee::where('name', 'LIKE', '%' . request('search'))->paginate(10);
        return view('employee.index', compact('employee'));
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create(['nik' => $request->nik, 'name' => $request->name]);
        return back()->with('success', 'New employee added successfully');
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update(['nik' => $request->nik, 'name' => $request->name]);
        return back()->with('success', 'The employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'The employee Delete successfully');
    }
}
