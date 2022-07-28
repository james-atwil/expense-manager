<?php

namespace App\Http\Resources\System;

use App\Http\Resources\BaseResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

use function route;

/**
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $name_display
 * @property Role   $role
 *
 * @property array  $urls
 */
class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $m = (int) $request->query('m', 0);  // Simplified

        /** @var User $user */
        $user = auth()->user();

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'name_display' => $this->name_display,
            'role'         => [
                'id'   => $this->role->id,
                'name' => $this->role->name,
            ],
            'created_at'  => $this->created_at->format('Y-m-d'),
        ];
    }
}
