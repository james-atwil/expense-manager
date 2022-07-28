<?php

namespace App\Http\Controllers\Api\Expenses;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ModelRequest;
use App\Http\Resources\Expenses\CategoryResource;
use App\Models\Expenses\Category;


class CategoriesController extends BaseController
{

    protected string $name     = 'Category';
    protected string $model    = Category::class;
    protected string $resource = CategoryResource::class;

    public function store(ModelRequest $request)
    {
        $data = $request->validated();
        return $this->storeRecord($request, $data);
    }

    public function updateSingle(ModelRequest $request, $id)
    {
        $data = $request->validated();
        return $this->updateSingleRecord($request, $id, $data);
    }
}
