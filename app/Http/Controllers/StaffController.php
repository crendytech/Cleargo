<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role == "admin")
        {
            $staffs = User::where("role", "staff")->get();
            return view('staff.index', compact('staffs'));
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
            return view('staff.create', compact('faculty'));
        }
        else
        {
            return response()->json(['error' => 'Permission denied.'], 401);
        }
    }

    public function import()
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
                    'email' => 'required|email|unique:users',
                    'faculty' => 'required',
                    'department' => 'required',
                    'password' => 'required|min:6',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $staff = new User();
            $staff->name = $request->name;
            $staff->faculty_id = $request->faculty;
            if($request->department != "null") {
                $staff->department_id = $request->department;
            }
            $staff->password = Hash::make($request->password);
            $staff->matric = $this->generateUniqueCode();
            $staff->role = "staff";
            $staff->email = $request->email;
            $staff->save();

            return redirect()->route('staffs.index')->with('success', 'Staff  successfully created.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (User::where("matric", "=", $code)->first());
        return $code;
    }

    public function show(User $staff)
    {
        return redirect()->route('staffs.index', compact('staff'));
    }

    public function edit(User $staff)
    {
        if(\Auth::user()->role == "admin")
        {
            $faculty = Faculty::all()->pluck("id", "name");
            return view('staff.edit', compact('staff', 'faculty'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, User $staff)
    {
        if(\Auth::user()->role == "admin")
        {
            $rule = [
                'name' => 'required|max:100',
                'email' => 'required|email',
                'faculty' => 'required',
                'department' => 'required',
            ];
            if($request->password != "")
            {
                $rule = array_merge($rule, ["password" => "required|min:6"]);
            }

            $validator = Validator::make($request->all(), $rule);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $staff->name = $request->name;
            $staff->faculty_id = $request->faculty;
            if($request->department != null) {
                $staff->department_id = $request->department;
            }
            $staff->email = $request->email;

            if($request->password != "")
            {
                $staff->password = Hash::make($request->password);
            }
            $staff->save();

            return redirect()->route('staffs.index')->with('success', 'Staff successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy(User $user)
    {
        $res=[];
        if(\Auth::user()->role == "admin")
        {
            if($user->role == "staff") {
                $user->delete();
                $res['status'] = true;
                $res['message'] = 'Staff successfully deleted.';
            }
        }
        else
        {
            $res['status'] = true;
            $res['message'] = 'Permission denied.';
        }
        return $res;
    }
}
