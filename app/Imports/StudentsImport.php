<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function checkExists($users, $key)
    {
        return Arr::exists($users[0], $key);
    }


    public function model(array $users)
    {
        $faculty = Faculty::firstOrCreate(["name" => $users["faculty"]]);
        $department = Department::firstOrCreate(["name" => $users["department"]], ["faculty_id" => $faculty->id]);
        $us = User::updateOrCreate(["email" => $users["email"], "matric" => $users["matric"]],[
            "name" => $users["name"],
            "faculty_id" => $faculty->id,
            "department_id" => $department->id,
            "password" => " ",
            "role" => "student",
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => "required",
            'matric' => "required",
            'faculty' => "required",
            'department' => "required",
            'email' => "required",
        ];
    }
}
