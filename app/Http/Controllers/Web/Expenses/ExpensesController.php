<?php

namespace App\Http\Controllers\Web\Expenses;

use App\Http\Controllers\Web\BaseController;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ExpensesController extends BaseController
{
    public function index() : Factory|View|Application
    {
        return view('modules.expenses.expenses.index');
    }
}
