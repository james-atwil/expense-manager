<?php

namespace App\Models\Expenses;

use App\Models\Model;
use Ramsey\Collection\Collection;

/**
 * Class Category
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $description
 *
 * @method static Category where(string|array $column, string $operator = null, mixed $value = null, $boolean = 'and')
 * @method static Category whereIn(string|array $column, array $values)
 *
 * @method static Category first()
 * @method static Category|null find(int $id)
 * @method static Category findOrFail(int $id)
 *
 * @method static Collection<Category> all()
 * @method static Collection<Category> get()
 */
class Category extends Model
{
    protected $table = 'expenses_categories';

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
