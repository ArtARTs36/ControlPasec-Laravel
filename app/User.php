<?php

namespace App;

use App\Models\User\Permission;
use App\Models\User\Role;
use App\Models\User\UserNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @property int id
 * @property string name
 * @property string patronymic
 * @property string family
 * @property string email
 * @property string password
 * @property string remember_token
 * @property string position
 * @property-read Role[]|Collection roles
 * @property bool is_active
 * @property-read Permission[]|Collection permissions
 * @property int gender
 * @property string avatar_url
 * @property UserNotification[]|Collection notifications
 * @property string about_me
 * @property string created_at
 * @property string update_at
 * @mixin Builder
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    const TABLE = 'users';

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'patronymic', 'family', 'is_active', 'position', 'gender', 'avatar_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('onlyCustom', function (Builder $builder) {
            $builder->with(['notifications' => function (HasMany $builder) {
                $builder->latest('created_at');
            }]);
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function getFullName()
    {
        return implode(' ', [
            $this->name,
            $this->patronymic,
            $this->family,
        ]);
    }

    public function changeActive(bool $active): self
    {
        $this->is_active = $active;
        $this->save();

        return $this;
    }

    public function getUnreadNotificationsCount()
    {
        $count = 0;
        foreach ($this->notifications as $notification) {
            if ($notification->isNotRead()) {
                $count++;
            }
        }

        return $count;
    }

    public function getAvatarUrl(): ?string
    {
        if (!preg_match('/http/i', $this->avatar_url)) {
            $this->avatar_url = '//'. request()->getHttpHost() . $this->avatar_url;
        }

        return $this->avatar_url;
    }

    public function getDays(): int
    {
        $days = (int) ((time() - strtotime($this->created_at)) / (60 * 60 * 24));

        return ($days > 0) ? $days : 1;
    }

    public function isNotActive(): bool
    {
        return $this->is_active === false;
    }
}
