<?php

namespace App\Models;

use App\Traits\Models\HasName;
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

/**
 * Class User
 *
 * @package App\Models\User
 *
 * @property int       $id
 * @property string    $name
 * @property string    $password
 * @property string    $email
 * @property string    $remember_token
 * @property string    $name_display
 * @property int       $role_id
 * @property bool      $is_active
 * @property string    $notes
 *
 * @property Role|null $role
 * @property string    $initials
 *
 * @method static User where(string|array $column, string $operator = null, mixed $value = null, $boolean = 'and')
 * @method static User whereIn(string|array $column, array $values)
 *
 * @method static User|null first()
 * @method static User|null find(int $id)
 * @method static User|null findOrFail(int $id)
 *
 * @method static User[]|null get()
 */
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'system_users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'name_display',
        'role_id',
        'is_active',
        'remember_token',
        'notes',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'role_id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function authorizeRoles($roles): bool
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }

        abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the User has a particular role.
     *
     * @param  string  $role  Role slug
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        if ($this->role()->where('slug', '=', $role)->first()) {
            return true;
        }
        return false;
    }

}
