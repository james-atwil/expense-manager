<?php

namespace App\Http\Resources\Expenses;

use App\Http\Resources\BaseResource;
use App\Models\Expenses\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

use function route;

/**
 * @property int      $id
 * @property string   $name
 * @property float    $amount
 * @property Category $category
 * @property User     $encoder
 * @property Carbon   $entry_at
 * @property Carbon   $created_at
 *
 * @property array    $urls
 */
class ExpenseResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    #[ArrayShape([
        'id'         => "int",
        'name'       => "string",
        'amount'     => "float",
        'category'   => "array",
        'entry_at'   => "string",
        'created_at' => "string",
    ])]
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'amount'     => $this->amount,
            'category'   => $this->category,
            'entry_at'   => $this->entry_at->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
