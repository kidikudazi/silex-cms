<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        # check for token mismatch
        if ($exception instanceof TokenMismatchException) {

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 203,
                    'message' => 'Your session expired. You will need to refresh the page and login again.'
                ], 203);
            }

            try {
                # check if user is logged in
                $loggedInUser = $request->session()->get("user");

                if ($loggedInUser) {
                    $request->session()->forget("user");
                    $error = Session::flash('error', 'Your session expired. Please login to continue.');
                    return redirect()->route('auth.login')->with($error);
                } else {
                    return redirect()->to('/');
                }
            } catch (\Exception $ex) {
                return redirect()->to('/');
            }
        }

        return parent::render($request, $exception);
    }
}