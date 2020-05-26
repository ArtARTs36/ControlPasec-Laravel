<?php

namespace App;

use App\Models\Dialog\DialogMessage;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Models\User\UserNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @property int $id
 * @property string $name
 * @property string $patronymic
 * @property string $family
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $position
 * @property-read Role[]|Collection $roles
 * @property bool $is_active
 * @property-read Permission[]|Collection $permissions
 * @property int $gender
 * @property string $avatar_url
 * @property UserNotification[]|Collection $notifications
 * @property string $about_me
 * @property string $created_at
 * @property string $update_at
 * @mixin Builder
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    const TABLE = 'users';

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public const RELATION_NOTIFICATIONS = 'notifications';
    public const RELATION_UNREAD_NOTIFICATIONS = 'unreadNotifications';

    protected $guard_name = 'api';

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

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('onlyCustom', function (Builder $builder) {
//            $builder->with([static::RELATION_NOTIFICATIONS => function (HasMany $query) {
//                $query
//                    ->latest(UserNotification::FIELD_CREATED_AT)
//                    ->where(UserNotification::FIELD_IS_READ, false);
//            }]);
//        });
//    }

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

    /**
     * @return HasMany
     */
    public function unreadNotifications(): HasMany
    {
        return $this->notifications()
            ->latest()
            ->with(UserNotification::RELATION_TYPE)
            ->where(UserNotification::FIELD_IS_READ, false);
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
        if ($this->getAttributeValue(static::RELATION_UNREAD_NOTIFICATIONS)) {
            return $this->{static::RELATION_UNREAD_NOTIFICATIONS}->count();
        }

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

    /**
     * Determine has user the permission via role through api guard
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasApiPermission(string $permissionName): bool
    {
        return $this->hasPermission($permissionName, 'api');
    }

    /**
     * Determine has user the permission via role
     *
     * @param string $permissionName
     * @param string $guardName
     * @return bool
     */
    protected function hasPermission(string $permissionName, string $guardName)
    {
        $permission = $this->getPermissionsViaRoles()
            ->where('name', $permissionName)
            ->firstWhere('guard_name', $guardName);

        if ($permission !== null) {
            return true;
        }

        $permissionObject = Permission::findByName($permissionName);

        return DB::table($this->permissions()->getTable())
            ->where('model_id', $this->id)
            ->where('permission_id', $permissionObject->id)
            ->exists();
    }

    public function getDefaultGuardName(): string
    {
        return $this->guard_name;
    }

    public function recievedDialogMessages(): HasMany
    {
        return $this->hasMany(DialogMessage::class, DialogMessage::FIELD_TO_USER_ID);
    }

    public function sentDialogMessages(): HasMany
    {
        return $this->hasMany(DialogMessage::class, DialogMessage::FIELD_FROM_USER_ID);
    }

    public function recievedUnReadDialogMessages(): HasMany
    {
        return $this->recievedDialogMessages()
            ->where(DialogMessage::FIELD_IS_READ, false);
    }
}
