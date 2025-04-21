<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function login(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication was successful, redirect to dashboard or home page
            return redirect()->route('frontend.landing.index');  // Adjust route name as needed
        }

        // Authentication failed, return with an error message
        return redirect()->route('frontend.login')->with('error', 'Invalid credentials');
    }



    public function register(Request $request)
    {
        // Validation for the registration form
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',  // `confirmed` is used to password matches the `password_confirmation` field
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create new user
        // $user = User::create([
        //     'name'                => $request->name,
        //     'email'               => $request->email,
        //     'have_cash_amount'    => rand(20000, 20000),
        //     'role_name'           => 'user',
        //     'password'            => Hash::make($request->password),  // Encrypt the password
        //     // 'have_cash_amount' => rand(50, 20000),
        // ]);

        $user                   = new User();
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $user->role_name        = 'user';
        $user->have_cash_amount = 20000;
        $user->save();

        Auth::login($user);

        // Redirect the user after registration (you can redirect to login or home page)
        return redirect()->route('frontend.landing.index')->with('success', 'Registration successful! Please login.');
    }

    public function logout(Request $request)
    {
        // Log out the authenticated user
        Auth::logout();

        // Redirect the user to the home or login page with a success message
        return redirect()->route('frontend.landing.index')->with('success', 'You have been logged out successfully.');
    }
}
