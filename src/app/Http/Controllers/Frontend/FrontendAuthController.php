<?php

namespace App\Http\Controllers\Frontend;


use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\Task2\NewUserRegisteredNotification;

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

            $user = User::find(auth()->user()->id);

            if ($user) {
                $user->is_logged_in = true;
                $user->save();
            }
            $cookieValue = '12312kjasdkjasomerandomcodes'; // This should be a secure random value for your app

            // Set the cookie. Customize as needed:
            $cookie = cookie(
                'frontend_user_session_cookie',     // Cookie name
                $cookieValue,                       // Cookie value
                60,                                 // Expiration time (in minutes)
                '/',                                // Path (scope of the cookie)
                null,                               // Domain (null uses the current domain)
                false,                              // Secure flag (set to true for HTTPS)
                false,                              // HttpOnly flag (set to true to prevent JavaScript access)
                'None'                              // SameSite policy ('None', 'Strict', 'Lax')
            );

            // Redirect the user and attach the cookie to the response
            return redirect()->route('frontend.landing.index')->cookie($cookie);
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

        $user                   = new User();
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $user->role_name        = 'user';
        $user->have_cash_amount = 20000;
        $user->is_logged_in     = true;
        $user->save();


        // $logged_in_user_list = User::where('is_logged_in', 1)->get();
        // $message_to_be_send_as_notification_to_logged_in_users = $user->name + 'Just Joined Us, Say Hello!';

        // broadcast(new NewUserRegisteredNotification($message_to_be_send_as_notification_to_logged_in_users, $user));

        broadcast(new NewUserRegisteredNotification($user->name));

        Notification::create([
            'message' => $user->name . ' Just joined Us, Say Hello !',
            'broardcast_to' => 'online-users'
        ]);

        Auth::login($user);

        // Redirect the user after registration (you can redirect to login or home page)
        return redirect()->route('frontend.landing.index')->with('success', 'Registration successful! Please login.');
    }

    public function logout(Request $request)
    {
        // Find the authenticated user
        $user = User::find(auth()->user()->id);

        // Update the user's login status
        if ($user) {
            $user->is_logged_in = false;
            $user->save();
        }

        // Log out the authenticated user
        Auth::logout();

        // Clear the frontend_user_session_cookie
        $cookie = cookie('frontend_user_session_cookie', '', -1, '/', null, false, false, 'None');  // Set expiration to past to delete it

        // Redirect the user to the home or login page with a success message
        return redirect()->route('frontend.landing.index')->with('success', 'You have been logged out successfully.')->cookie($cookie);
    }
}
