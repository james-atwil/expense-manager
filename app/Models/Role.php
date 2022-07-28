<?php

namespace App\Models;

use Ramsey\Collection\Collection;

/**
 * Class Role
 * @package App\Models
 *
 * @property int    $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $notes
 *
 * @method static Role where(string|array $column, string $operator = null, mixed $value = null, $boolean = 'and')
 * @method static Role whereIn(string|array $column, array $values)
 *
 * @method static Role first()
 * @method static Role|null find(int $id)
 * @method static Role findOrFail(int $id)
 *
 * @method static Collection<Role> get()
 */
class Role extends Model
{
    protected $table = 'system_roles';

    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'notes',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
