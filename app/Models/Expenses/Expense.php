<?php

namespace App\Models\Expenses;

use App\Models\Model;
use App\Models\User;
use App\Traits\Models\HasName;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Collection\Collection;

/**
 * Class User
 *
 * @package App\Models\User
 *
 * @property int      $id
 * @property string   $name
 * @property int      $category_id
 * @property int      $entry_by
 * @property float    $amount
 * @property Carbon   $entry_at
 *
 * @property Category $category
 * @property User     $encoder
 *
 * @method static Expense where(string|array $column, string $operator = null, mixed $value = null, $boolean = 'and')
 * @method static Expense whereIn(string|array $column, array $values)
 *
 * @method static Expense|null first()
 * @method static Expense|null find(int $id)
 * @method static Expense|null findOrFail(int $id)
 *
 * @method static int sum(string $column)
 *
 * @method static Collection<Expense>|null get()
 */
class Expense extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'expenses_expenses';

    protected $fillable = [
        'name',
        'category_id',
        'amount',
        'entry_at',
    ];

    protected $hidden = [
        'id',
        'category_id',
        'name',
        'amount',
        'entry_at',
        'entry_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'amount'     => 'float',
        'entry_at'   => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function encoder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entry_by');
    }

}
