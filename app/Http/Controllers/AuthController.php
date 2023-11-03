<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset as MailPasswordReset;
use App\Models\PasswordReset;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Mail,
    Validator,
    Session,
    URL,
    View,
};
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Helper;

    /**
     * Login
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if (!$login) {
                $error = Session::flash('error', 'Invalid login credentials');
                return redirect()->back()->with($error)->withInput();
            }

            Session::put('user', $request->email);
            return redirect()->to('admin/home');
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Sorry, login failed. Please try again.');
            return redirect()->back()->withInput()->with($error);
        }
    }

    /**
     * Reset Password
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PasswordReset $passwordReset
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request, PasswordReset $passwordReset)
    {
        try {
            $rules = [ "email" => "required" ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            # validate user
            $user = User::where("email", $request->email)->first();
            if (!$user) {
                $error = Session::flash('error', 'Sorry, no record with this email address.');
                return redirect()->back()->with($error)->withInput();
            }

            try {
                $token = $this->checkField($passwordReset, "token", Str::uuid());        
                PasswordReset::create([ "email" => $request->email, "token" => $token ]);
                
                # send mail
                $data = ["url" => URL::to("/auth/new/password/{$token}")];
                Mail::to($request->email)->send(new MailPasswordReset($data, "Password Reset"));

                $success = Session::flash('success', 'Password reset link has been sent to your mail!');
                return redirect()->back()->with($success);
            } catch (\Exception $ex) {
                $error = Session::flash('error', "Sorry, your password reset failed. Please try again.");
                return redirect()->back()->with($error)->withInput();
            }
        } catch (\Exception $ex) {
            $error = Session::flash('error', "Sorry, your password reset request could not be completed.");
            return redirect()->back()->with($error)->withInput();
        }
    }

    /**
     * Reset Password
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function verifyPasswordToken(Request $request, $token)
    {
        try {
            $verify = PasswordReset::where("token", $token)->first();
            if (!$verify) return redirect()->to('/');
            return view::make('auth.new_password')->with($verify->token);
        } catch (\Exception $ex) {
            return redirect()->to('/');
        }
    }

    /**
     * Reset Password
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, $token)
    {
        try {
            $rules = [
                "password" => "required|min:8",
                "confirm_password" => "required|same:password"
            ];
 
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            # validate user token
            $user = PasswordReset::where("token", $token)->first();
            if (!$user) return redirect()->to('/');

            try {
                # update password
                $password = Hash::make($request->password);
                User::where("email", $user->email)->first()->update([ "password" => $password ]);
                
                # delete record
                $user->delete();
                
                $message = Session::flash('success', 'Password updated successfully.');
                return redirect()->route('login')->with($message);
            } catch (\Exception $ex) {
                $error = Session::flash('error', "Sorry, your password reset failed. Please try again.");
                return redirect()->back()->with($error);
            }
        } catch (\Exception $ex) {
            $error = Session::flash('error', "Sorry, your password reset request could not be completed.");
            return redirect()->back()->with($error);
        }
    }
}