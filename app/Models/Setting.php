<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Setting
 *
 * @package App\Models
 *
 * @property string $key
 * @property mixed  $value
 * @property string $datatype
 *
 * @method static Setting where(string $column, string $operator, mixed $value)
 *
 * @method static Setting|null first(int $id)
 * @method static Setting|null find(string $id)
 * @method static Setting|null findOrFail(int $id)
 *
 * @method static Collection<Setting>|null get()
 * @method static Collection<Setting>|null all()
 */
class Setting extends Model
{
    protected $table      = 'system_settings';
    protected $primaryKey = 'key';

    protected $fillable = [
        'key',
        'value',
    ];

    public $incrementing = false;
    public $keyType      = 'string';

}
