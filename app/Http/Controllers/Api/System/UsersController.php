<?php

namespace App\Http\Controllers\Api\System;


use App\Common\Parabuilder;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\System\UserRequest;
use App\Http\Resources\System\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass as StdClass;


class UsersController extends BaseController
{
    protected string $name     = 'User';
    protected string $model    = User::class;
    protected string $resource = UserResource::class;

    protected string $orderField = 'name_display';
    protected string $orderSort  = 'ASC';

    protected function buildKeywords(string $q, Parabuilder $whereQ): Parabuilder
    {
        $whereQ->string = [
            ' name LIKE ? ',
            ' email LIKE ? ',
            ' name_display LIKE ? ',
        ];

        for ($i = 1; $i <= count($whereQ->string); $i++) {
            $whereQ->params[] = "%$q%";
        }

        return $whereQ;
    }

    public function exists(Request $request): JsonResponse
    {
        $acceptableFields = ['name', 'email'];

        $field = $request->get('field', '');
        $value = $request->get('value', '');
        $id    = (int) $request->get('id', 0);

        $message = new StdClass();

        if (empty($field)) {
            $message->result = null;
            $message->error  = 'Field name is missing.';
            return response()->json($message, 400);
        }

        if (!in_array($field, $acceptableFields)) {
            $message->result = null;
            $message->error  = 'Valid field name are [name] and [email].';
            return response()->json($message, 400);
        }

        if (empty($value)) {
            $message->result = null;
            $message->error  = 'Value is missing.';
            return response()->json($message, 400);
        }

        $clauses = [
            [$field, '=', $value],
        ];

        if (!empty($id)) {
            $clauses[] = ['id', '!=', $id];
        }

        $user = User::where($clauses)->first();

        $message->result = !empty($user);

        if ($message->result) {
            $message->message = match ($field) {
                'name'  => __('User name is already taken.'),
                'email' => __('Email address already exists.'),
            };
        }

        return response()->json($message);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        return $this->storeRecord($request, $data);
    }

    public function updateSingle(UserRequest $request, $id)
    {
        $data = $request->validated();
        return $this->updateSingleRecord($request, $id, $data);
    }

    /**
     * @param  array  $data
     * @param  User   $record
     *
     * @return User
     */
    protected function save($data, $record): User
    {
        $record->name         = $data['email'];
        $record->password     = isset($data['password']) && trim($data['password']) != '' ? Hash::make(trim($data['password'])) : $record->password;
        $record->email        = $data['email'];
        $record->name_display = $data['name_display'];
        $record->role_id      = $data['role']['id'];

        $record->save();

        return $record;
    }
}
