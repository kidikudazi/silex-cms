<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use App\Traits\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Session
};

class UserAuth
{
    use Helper;

    /**
     * Time for user to remain active
     * @var integer $timeout
     */
    protected $timeout = 1200;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            if (!$request->session()->has('lastActivityTime')) {
                $request->session()->put('lastActivityTime', time());
            } elseif (time() - $request->session()->get('lastActivityTime') > $this->timeout) {
                # remove session
                $request->session()->forget('lastActivityTime');
                $request->session()->forget('user');
                $request->session()->regenerate();
                    
                return response()->json([
                    'status' => 203,
                    'message' => 'Your session expired. Kindly logout and login again to continue.'
                ], 203);
            }
        }
        if (!$request->session()->has('lastActivityTime')) {
            $request->session()->put('lastActivityTime', time());
        } elseif (time() - $request->session()->get('lastActivityTime') > $this->timeout) {
            # remove session
            $request->session()->forget('lastActivityTime');
            $request->session()->forget('user');
            $request->session()->regenerate();

            # show error message
            $error = Session::flash('error', 'Your session expired. Kindly login again.');
            return redirect()->route('login')->with($error);
        }

        # update session data
        $role = UserRole::where("user_id", auth()->id())->first();
        $role = json_decode($role->role)[0];
        Session::put('role', $role);
        $request->session()->put('lastActivityTime', time());
        Session::put('initials', $this->generateInitials(Auth::user()->name));
        return $next($request);
    }
}