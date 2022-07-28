<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class ProfileController extends BaseController
{
    public function index() : Factory|View|Application
    {
        $user = auth()->user();

        return view('modules.system.users.profile', ['user' => $user]);
    }
}
