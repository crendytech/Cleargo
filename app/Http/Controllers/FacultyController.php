<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    public function index()
    {

        $faculties = Faculty::all();

        return view('faculty.index', compact('faculties'));
//        if(\Auth::user()->type == "admin")
//        {
//        }
//        else
//        {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }

    public function create()
    {
        return view('faculty.create');
//        if(\Auth::user()->role == "admin")
//        {
//            return view('faculty.create');
//        }
//        else
//        {
//            return response()->json(['error' => __('Permission denied.')], 401);
//        }
    }

    public function store(Request $request)
    {

//        if(\Auth::user()->type == "admin")
//        {

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
        $faculty = new Faculty();
        $faculty->name = $request->name;
        $faculty->save();

        return redirect()->route('faculties.index')->with('success', 'Faculty  successfully created.');
//        }
//        else
//        {
//            return redirect()->back()->with('error', 'Permission denied.');
//        }
    }

    public function show(Faculty $faculty)
    {
//        return redirect()->route('faculties.index');
    }

    public function edit(Faculty $faculty)
    {
        if(\Auth::user()->role == "admin")
        {
            return view('faculty.edit', compact('faculty'));
        }
        else
        {
            return response()->json(['error' => 'Permission denied.'], 401);
        }
    }

    public function update(Request $request, Faculty $faculty)
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

            $faculty->name = $request->name;
            $faculty->save();

            return redirect()->route('faculties.index')->with('success', 'Faculty successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy(Faculty $faculty)
    {
//        if(\Auth::user()->type == "admin")
//        {
        $faculty->delete();

        return redirect()->route('faculty.index')->with('success', 'Faculty successfully deleted.');
//        }
//        else
//        {
//            return redirect()->back()->with('error', 'Permission denied.');
//        }
    }
}
