<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\BaseController;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class RolesController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.system.roles.index');
    }
}
