<?php

namespace App;

use App\Bundles\User\Models\DialogMessage;
use App\Bundles\User\Models\Permission;
use App\Bundles\User\Models\Role;
use App\Bundles\User\Models\UserNotification;
use App\Bundles\User\Repositories\PermissionRepository;
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

    public const FIELD_ID = 'id';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_NAME = 'name';
    public const FIELD_PATRONYMIC = 'patronymic';
    public const FIELD_FAMILY = 'family';
    public const FIELD_POSITION = 'position';
    public const FIELD_EMAIL = 'email';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_GENDER = 'gender';
    public const FIELD_AVATAR_URL = 'avatar_url';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_EMAIL,
        self::FIELD_PATRONYMIC,
        self::FIELD_PASSWORD,
        self::FIELD_FAMILY,
        self::FIELD_IS_ACTIVE,
        self::FIELD_GENDER,
        self::FIELD_AVATAR_URL,
        self::FIELD_POSITION,
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

    /**
     * @return HasMany
     */
    public function notifications(): HasMany
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

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return implode(' ', [
            $this->name,
            $this->patronymic,
            $this->family,
        ]);
    }

    /**
     * @param bool $active
     * @return $this
     */
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
        return request()->getSchemeAndHttpHost() . $this->avatar_url;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        $days = (int) ((time() - strtotime($this->created_at)) / (60 * 60 * 24));

        return ($days > 0) ? $days : 1;
    }

    /**
     * @return bool
     */
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

        $permissionObject = PermissionRepository::findByName($permissionName);

        return DB::table($this->permissions()->getTable())
            ->where('model_id', $this->id)
            ->where('permission_id', $permissionObject->id)
            ->exists();
    }

    /**
     * @return string
     */
    public function getDefaultGuardName(): string
    {
        return $this->guard_name;
    }

    /**
     * @return HasMany
     */
    public function recievedDialogMessages(): HasMany
    {
        return $this->hasMany(DialogMessage::class, DialogMessage::FIELD_TO_USER_ID);
    }

    /**
     * @return HasMany
     */
    public function sentDialogMessages(): HasMany
    {
        return $this->hasMany(DialogMessage::class, DialogMessage::FIELD_FROM_USER_ID);
    }

    /**
     * @return HasMany
     */
    public function recievedUnReadDialogMessages(): HasMany
    {
        return $this->recievedDialogMessages()
            ->where(DialogMessage::FIELD_IS_READ, false);
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function attachRole(Role $role): self
    {
        $this->roles()->attach($role->id);

        return $this;
    }
}
