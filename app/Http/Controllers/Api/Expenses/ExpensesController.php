<?php

namespace App\Http\Controllers\Api\Expenses;


use App\Common\Parabuilder;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Expenses\ExpenseRequest;
use App\Http\Resources\Expenses\ExpenseResource;
use App\Models\Expenses\Expense;
use App\Models\User;


class ExpensesController extends BaseController
{
    protected string $name     = 'Expense';
    protected string $model    = Expense::class;
    protected string $resource = ExpenseResource::class;

    protected string $orderField = 'id';
    protected string $orderSort  = 'DESC';

    protected function buildKeywords(string $q, Parabuilder $whereQ): Parabuilder
    {
        $whereQ->string = [
            ' name LIKE ? ',
        ];

        for ($i = 1; $i <= count($whereQ->string); $i++) {
            $whereQ->params[] = "%$q%";
        }

        return $whereQ;
    }

    protected function buildFilters(array $f, Parabuilder $whereF): Parabuilder
    {
        unset($f);

        /** @var User $currentUser */
        $currentUser = auth()->user();

        $whereF->string[] = ' entry_by = ? ';
        $whereF->params[] = $currentUser->id;

        return $whereF;
    }

    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();
        return $this->storeRecord($request, $data);
    }

    public function updateSingle(ExpenseRequest $request, $id)
    {
        $data = $request->validated();
        return $this->updateSingleRecord($request, $id, $data);
    }

    /**
     * @param  array    $data
     * @param  Expense  $record
     *
     * @return Expense
     */
    protected function save($data, $record): Expense
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        $record->name        = $data['name'];
        $record->amount      = $data['amount'];
        $record->entry_at    = $data['entry_at'];
        $record->entry_by    = $currentUser->id;
        $record->category_id = $data['category']['id'];

        $record->save();

        return $record;
    }
}
