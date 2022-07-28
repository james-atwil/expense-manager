<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class SettingsController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.system.settings.index');
    }

    public function list() : Response
    {
        $settings = settings();
        return response()->view('modules.system.settings.list', ['settings' => $settings])
                         ->header('Content-Type', 'application/javascript');
    }
}
