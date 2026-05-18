<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function testFactory()
    {
        $employee = Employee::factory()->programmer()->make();
        $employee->id = "1";
        $employee->name = "Employee 1";
        $employee->save();

        $employee2 = Employee::factory()->seniorProgrammer()->create([
            "id" => "2",
            "name" => "Employee 2",
        ]);

        $employees = Employee::all();

        return response()->json([
            "data" => $employees
        ]);
    }
}
