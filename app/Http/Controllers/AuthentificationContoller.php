<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
// use Str;


class AuthentificationContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('HomePage.index');
    }
    public function ShowReset()
    {
        return view('auth.resetPassword');
    }
    public function showNewPasswordForm($token)
    {
        // Pass the token to the view to include it in a hidden field
        return view('auth.newPassword', ['token' => $token]);
    }
    public function ResetPassord(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            return redirect()->route('auth.login')->with('success', 'Reset password link has been sent to your email');
        } else {
            return back()->with('fail', 'No account found for this email');
        }
    }
    public function newPassword(Request $request)
    {
        $token = $request->input('token'); // Retrieve the token from the request
        $user = User::where('remember_token', $token)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->remember_token = null; // Ensure to nullify the token
            $user->save();

            return redirect()->route('auth.login')->with('success', 'Password has been reset');
        } else {
            return back()->with('fail', 'Invalid token');
        }
    }


    // public function newPassword(Request $request){

    //     $user = User::where('remember_token', $request->token)->first();

    //     if($user){
    //         $user->password = Hash::make($request->password);
    //         // $user->remember_token = null;
    //         $user->save();
    //         //reset token
    //         // $user->remember_token = null;
    //         return redirect()->route('auth.login')->with('success', 'Password has been reset');
    //     }
    //     else{
    //         return back()->with('fail', 'Invalid token'. dd($request->token));
    //     }
    // }

    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        return view('auth.login')->with('success', 'You are now logged out');
        //flash message
    }
    public function check(Request $request)
    {
        // $credentials = [
        //     'name' => $request->name, // Make sure 'name' is the correct field you use for login.
        //     'password' => $request->password,
        // ];

        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('name', $request->name)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('LoggedUser', $user->role_id);
                return redirect('/product')->with('success', 'You are now logged in');
            } else {
                return back()->with('fail', 'Invalid password');
            }
        } else {
            return back()->with('fail', 'No account found for this email');
        }
    }

    // public function check(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('name', $request->name)->first();
    //     if($user){
    //         if(Hash::check($request->password, $user->password)){
    //             $request->session()->put('LoggedUser', $user->id);
    //             return redirect('/product')->with('success', 'You are now logged in');
    //         }else{
    //             return back()->with('fail', 'Invalid password');
    //         }
    //     }else{
    //         return back()->with('fail', 'No account found for this email');
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'username' => 'required|min:3|max:16',
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
            // 'password' => 'required|confirmed|min:8|strong_password:8',
        ]);
        // User::create($request->all());
        //mass asignement
        User::create([
            'name' => $request->username,
            'email' => $request->email,
            // hash the password 

            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role_id' => 20
        ]);
        return redirect('/login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
