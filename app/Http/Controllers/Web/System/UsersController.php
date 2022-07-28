<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\BaseController;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UsersController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.system.users.index');
    }

    public function form($id = 0) : Factory|View|Application
    {
        $user = $id == 0 ? new User() : User::findOrFail($id);

        if ($id == 0) {
            $user->id = 0;
            $user->fillBlank();
        }

        return view('modules.system.users.form', ['user' => $user]);
    }
}
