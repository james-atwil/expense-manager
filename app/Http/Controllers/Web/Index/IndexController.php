<?php

namespace App\Http\Controllers\Web\Index;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.index.index');
    }

    public function test() : Factory|View|Application
    {
        return view('modules.index.test');
    }
}
