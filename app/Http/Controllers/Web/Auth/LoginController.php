<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class LoginController extends BaseController
{

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Sets the field name of username.
     *
     * @return string
     */
    public function username() : string
    {
        return 'name';
    }

    public function index() : Factory|View|Application
    {
        return view('modules.auth.login');
    }

    public function login(Request $request) : JsonResponse|string|RedirectResponse
    {
        $isSuccess = $this->attemptLogin($request);
        $isAjax    = $request->ajax();

        $target = '/';

        if ($isSuccess) {
            if ($isAjax) {
                return response()->json(
                    [
                        'result'   => 1,
                        'redirect' => $target,
                    ]
                );
            } else {
                return $target;
            }
        } else {
            if ($isAjax) {
                return response()->json(
                    [
                        'result' => 0,
                    ]
                );
            } else {
                return redirect()->route('login');
            }
        }
    }

    public function logout(Request $request) : JsonResponse|RedirectResponse
    {
        $isAjax = $request->ajax();

        Auth::logout();
        $request->session()->invalidate();


        if ($isAjax) {
            return response()->json(
                [
                    'result' => 1,
                ]
            );
        } else {
            return redirect()->route('login');
        }
    }

    #[ArrayShape(['name' => "mixed", 'password' => "mixed"])]
    protected function credentials(Request $request) : array
    {
        $data = $request->only('username', 'password');

        return [
            'name'     => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function attemptLogin(Request $request) : bool
    {
        return Auth::guard()->attempt($this->credentials($request), $request->filled('remember'));
    }
}
