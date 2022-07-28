<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ModelRequest;
use App\Http\Resources\System\RoleResource;
use App\Models\Role;


class RolesController extends BaseController
{

    protected string $name     = 'Role';
    protected string $model    = Role::class;
    protected string $resource = RoleResource::class;

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
