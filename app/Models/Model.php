<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Model
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $ordering
 * @property string $notes
 * @property array  $urls
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @method static bool create(array $params)
 * @method static int count()
 *
 * @method void makeHidden($attributes)
 *
 * @method static findOrFail(string|int $id)
 */
class Model extends EloquentModel
{

    const SORT_ORDER = [
        'a' => 'ASC',
        'd' => 'DESC',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function fillNull()
    {
        foreach ($this->fillable as $attr) {
            $this->setAttribute($attr, null);
        }
    }

    public function fillBlank()
    {
        foreach ($this->fillable as $attr) {
            $this->setAttribute($attr, '');
        }
    }
}
