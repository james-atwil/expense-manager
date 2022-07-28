<?php

namespace App\Http\Resources\System;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

use function auth;
use function route;


/**
 * @property int    $id
 * @property string $slug
 * @property string $name
 * @property string $description
 */
class RoleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    #[ArrayShape([
        'id'          => "int",
        'slug'        => "string",
        'name'        => "string",
        'description' => "string",
    ])]
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $m = (int) $request->query('m', 0);  // Simplified

        return [
            'id'   => $this->id,
            'name' => $this->name,
            $this->mergeWhen($m === 0, [
                'description' => $this->description,
                'created_at'  => $this->created_at->format('Y-m-d'),
            ]),

        ];
    }
}
