<?php

namespace App\Http\Controllers\Web\Expenses;

use App\Http\Controllers\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoriesController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.expenses.categories.index');
    }
}
