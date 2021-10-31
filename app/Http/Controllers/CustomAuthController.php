<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\Submissions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }


    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $username = (filter_var($request->email, FILTER_VALIDATE_EMAIL))? ["email" => $request->email] : ["matric" => $request->email];
        $credentials = array_merge($username, ["password" => $request->password]);//$request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function register()
    {
        return view('auth.register');
    }


    public function matric(Request $request)
    {
        $request->validate([
            'matric' => 'required'
        ]);
        $res = [];
        $userCount = User::where("matric", $request->matric)->count();
        if($userCount == 1)
        {
            $res['status'] = true;
            $res['message'] = 'User Found.';
        }else
        {
            $res['status'] = false;
            $res['message'] = 'Not Found';
        }

        return $res;
    }


    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function studentRegistration(Request $request)
    {
        $request->validate([
            'matric' => 'required',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = User::where(["matric" => $request->matric])->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect("login")->withSuccess('Registration Successful');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'matric' => $this->generateUniqueCode(),
            'role' => "admin",
            'password' => Hash::make($data['password'])
        ]);
    }


    public function dashboard()
    {
        if(Auth::check()){
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
                return view('dashboard.students', compact('clearances'));
            }
            if(\Auth::user()->role == "staff")
            {
                if(\Auth::user()->department_id != null)
                {
                    $clearances = Clearance::select("id")->where([
                        ['type', '=', 'departmental'],
                        ['managed_by', '=', \Auth::user()->department_id],
                    ])
                        ->orWhere([
                            ['type', '=', 'general'],
                            ['managed_by', '=', \Auth::user()->department_id],
                        ])
                        ->get();
                }else
                {
                    $clearances = Clearance::select("id")->where([
                        ['type', '=', 'faculty'],
                        ['managed_by', '=', \Auth::user()->faculty_id],
                    ])
                        ->get();
                }
                $submissions = Submissions::whereIn("clearance_id", $clearances->toArray())->get();
                return view('dashboard.staffs', compact('submissions'));
            }
            return view('dashboard.index');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (User::where("matric", "=", $code)->first());
        return $code;
    }

    public function uploadPics()
    {
            return view('auth.upload');
    }

    public function saveUpload(Request $request)
    {
        try{
            $validator = Validator::make(
                    request()->all(), [
                        'file' => 'mimes::jpeg,png,jpg|max:20480',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }else {
                    if($request->hasFile('file'))
                    {
                        $filenameWithExt = $request->file('file')->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('file')->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        $dir             = public_path('uploads/avatar/');

                        if(!file_exists($dir))
                        {
                            mkdir($dir, 0777, true);
                        }
                        $request->file->move(public_path('uploads/avatar'), $fileNameToStore);

                        Auth()->user()->update(['avatar'=>$fileNameToStore]);
                    }
                    return redirect()->back()->with('success', 'Picture added successfully.');
                }
        }catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
