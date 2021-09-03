<?php

namespace App\Http\Controllers;

use App\Models\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubmissionsController extends Controller
{
    public function index()
    {
        $submissions = \Auth::user()->submissions();

        return view('submissions.index', compact('submissions'));
    }

    public function create()
    {
//        return view('submissions.index', compact('submissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'clearance' => 'required',
                'file' => 'required|mimes:jpeg,png,jpg,pdf,doc|max:20480'
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->withInput()->with('error', $messages->first());
        }

        $fileNameToStore ="";
        if($request->hasFile('file'))
        {
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $dir             = public_path('uploads/clearance/');

            if(!file_exists($dir))
            {
                mkdir($dir, 0777, true);
            }
            $request->file->move(public_path('uploads/clearance'), $fileNameToStore);
        }

        $submission = Submissions::updateOrCreate(
            [
                'user_id' => \Auth::user()->id,
                'clearance_id' => $request->get("clearance")
            ],
            [
                'submission' => $fileNameToStore
            ]
        );
        $submission->save();
        return redirect()->route('dashboard.index')->with('success', "Submitted successfully");
    }

    public function show(Submissions $submissions)
    {
        return redirect()->route('submissions.index');
    }

    public function edit(Submissions $submissions)
    {

    }

    public function update(Request $request, Submissions $submissions)
    {
        if(!$submissions->exists)
        {
            $submissions = Submissions::where("id", $request->id)->first();
        }
        $validator = Validator::make(
            $request->all(), [
                'status' => 'required'
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return response()->json(['message' => $messages->first()], 401);
        }

        $submissions->status = $request->status;
        $submissions->approved_by = \Auth::user()->id;
        $submissions->save();
        $res["status"] = $submissions->status;
        $res["message"] = ucfirst($submissions->status)." successfully";
        return $res;
    }

    public function destroy(Submissions $submissions)
    {
        $submissions->delete();
        return redirect()->route('employee.index')->with('success', 'Entry successfully deleted.');
    }
}
