<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role == "admin")
        {
            $students = User::where("role", "student")->get();
            return view('student.index', compact('students'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {
        if(\Auth::user()->role == "admin")
        {
            $faculty = Faculty::all()->pluck("id", "name");
            return view('department.create', compact('faculty'));
        }
        else
        {
            return response()->json(['error' => 'Permission denied.'], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->role == "admin")
        {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:100',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $department = new Department();
            $department->name = $request->name;
            $department->faculty_id = $request->faculty;
            $department->save();

            return redirect()->route('departments.index')->with('success', 'Department  successfully created.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function show(Department $department)
    {
//        return redirect()->route('departments.index', compact('department'));
    }

    public function edit(Department $department)
    {
        if(\Auth::user()->role == "admin")
        {
            $faculty = Faculty::all()->pluck("id", "name");
            return view('department.edit', compact('department', 'faculty'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Department $department)
    {
        if(\Auth::user()->role == "admin")
        {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:100',

                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department->name = $request->name;
            $department->faculty_id = $request->faculty;
            $department->save();

            return redirect()->route('departments.index')->with('success', 'Department successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy(User $department)
    {
        $res=[];
        if(\Auth::user()->role == "admin")
        {
            $department->delete();
            $res['status'] = true;
            $res['message'] = 'Department successfully deleted.';
        }
        else
        {
            $res['status'] = true;
            $res['message'] = 'Permission denied.';
        }
        return $res;
    }

    public function showImport()
    {
        if(\Auth::user()->role == "admin")
        {
            return view('student.import');
        }
        else
        {
            return response()->json(['error' => 'Permission denied.'], 401);
        }
    }

    public function import()
    {
        try{
            if(\Auth::user()->role == "admin")
            {
                $validator = Validator::make(
                    request()->all(), [
                        'file' => 'mimes:xlsx|max:20480',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }else {
                    Excel::import(new StudentsImport, request()->file('file'));
                    return redirect()->route('students.index')->with('success', 'Students successfully imported.');
                }
            }else
            {
                return redirect()->back()->with('error' , __('Permission denied.'));
            }
        }catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
