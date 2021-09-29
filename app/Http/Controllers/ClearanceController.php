<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class ClearanceController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role == "admin")
        {
            $clearances = Clearance::all();
            return view('clearance.index', compact('clearances'));
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
            if($request->has("type"))
            {
                $type = $request->get("type");
                if($type == "general")
                {
                    $msg = "<option value='0'>Administrator</option>";
                    $datas = Department::all();
                    foreach ($datas as $data)
                    {
                        $msg .= '<option value="'.$data->id.'">'.$data->name.'</option>';
                    }
                    $res["message"] = $msg;
                }else
                {
                    $msg = ""; $datas = [];
                    if($type == "departmental") {
                        $datas = Department::all();
                    }
                    if($type == "faculty") {
                        $datas = Faculty::all();
                    }

                    foreach ($datas as $data)
                    {
                        $msg .= '<option value="'.$data->id.'">'.$data->name.'</option>';
                    }
                    $res["message"] = $msg;
                }
            }
            $res['status'] = true;
        }
        else
        {
            $res['status'] = true;
            $res['message'] = 'Permission denied.';
        }
        return $res;
    }

    public function printDocument()
    {
        if(\Auth::user()->role == "student")
        {
            $clearances = Clearance::where([
                ['type', '=', 'departmental'],
                ['managed_by', '=', \Auth::user()->department_id],
            ])
                ->orWhere([
                    ['type', '=', 'faculty'],
                    ['managed_by', '=', \Auth::user()->faculty_id],
                ])
                ->orWhere('type', '=', "general")
                ->get();
//            return view('pdf.index', compact('clearances'));
            $pdf = PDF::loadView('pdf.index', compact('clearances'));

            return $pdf->download('clearance_'.\Auth::user()->matric.'.pdf');
        }
    }

    public function create()
    {
        if(\Auth::user()->role == "admin")
        {
            $departments = Department::all()->pluck("id", "name");
            return view('clearance.create', compact('departments'));
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
                    'managed_by' => 'required',
                    'description' => 'required',
                    'type' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $clearance = new Clearance();
            $clearance->name = $request->name;
            $clearance->description = $request->description;
            $clearance->managed_by = $request->managed_by;
            $clearance->type = $request->type;
            $clearance->save();

            return redirect()->route('clearance.index')->with('success', 'Clearance Section  successfully created.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function show(Clearance $clearance)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(Clearance $clearance)
    {
        if(\Auth::user()->role == "admin")
        {
            $departments = Department::all()->pluck("id", "name");
            $faculties = Faculty::all()->pluck("id", "name");
            return view('clearance.edit', compact('clearance','departments', 'faculties'));
        }
        else
        {
            return response()->json(['error' => 'Permission denied.'], 401);
        }
    }

    public function update(Request $request, Clearance $clearance)
    {

    }

    public function destroy(Clearance $clearance)
    {

    }
}
