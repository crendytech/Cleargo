<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role == "admin")
        {
            $departments = Department::all();
            return view('department.index', compact('departments'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function fetch(Request $request)
    {
        $res=[];
        if(\Auth::user()->role == "admin")
        {
            if($request->has("faculty"))
            {
                $msg = "";
                $datas = Department::where("faculty_id", $request->get("faculty"))->get();

                foreach ($datas as $data)
                {
                    if($request->has("dept"))
                    {
                        $selected = ($data->id == $request->get("dept"))?"selected":"";
                        $msg .= '<option value="'.$data->id.'" '.$selected.'>'.$data->name.'</option>';
                    }
                    else
                        $msg .= '<option value="'.$data->id.'">'.$data->name.'</option>';
                }
                $res["message"] = $msg;
                $res['status'] = true;
            }
        }
        else
        {
            $res['status'] = true;
            $res['message'] = 'Permission denied.';
        }
        return $res;
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
        return redirect()->route('departments.index', compact('department'));
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
            $validator = \Validator::make(
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

    public function destroy($id)
    {
        //$res=[];
       // if(\Auth::user()->role == "admin")
       // {
          $department = Department::find($id);
          $department->delete();
        return redirect()->back()->with('success', 'Department successfully deleted.');
      //  }
      //  else
//        {
//            $res['status'] = true;
//            $res['message'] = 'Permission denied.';
//        }
//        return $res;
    }
}
