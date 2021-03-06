<?php

namespace Namviet\Account\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use MongoDB\BSON\ObjectId;
use Namviet\Account\Casts\ObjectIDCast;
use Namviet\Account\Helpers\Helper;
use Namviet\Account\Overrides\Notifications\Notifiable;
use RobThree\Auth\TwoFactorAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class  User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public const ACTIVE_STATUS = 1;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created' => 'immutable_datetime',
        'modified' => 'immutable_datetime',
        'time_expired' => 'immutable_datetime',
        'code' => 'string',
        'authenticator_secret' => 'string',
        'mobile' => 'string',
        'otp_active' => 'int',
        'user' => ObjectIDCast::class,
    ];
    protected $attributes = [
        'code' => '',
    ];
    protected $collection = 'users';
    protected $connection = 'mongodb';
    protected $fillable = [
        "username",
        "password",
        "email",
        "user_group",
        "authenticator_secret",
        "status",
        "description",
        "user",
        "modified",
        "created",
        "reason_block",
        "file_uris",
        "files",
        "avatar",
        "fullname",
        "code",
        "provider_code",
        "mobile",
        "time_expired"
    ];
    protected $hidden = [
        'password'
    ];

    public static function getUsersByPermission($permission)
    {
        $idGr = self::getGroupByPermission($permission);
        $idGrObj = array_map(function ($id) {
            return new ObjectId($id);
        }, Arr::flatten($idGr));
        $userIds = self::select(['_id'])->whereIn('user_group', $idGrObj)->get()->toArray();
        return Arr::flatten($userIds);
    }

    private static function getGroupByPermission($permission)
    {
        return UserGroup::select(['_id'])->where(config('namviet_account.permission_field'), $permission)->get()->toArray();
    }

    public static function getListHtml()
    {
        $userData = User::select('username', 'fullname', '_id')->get()->toArray();
        if (empty($userData)) return [];
        $userNameList = [];
        foreach ($userData as $item) {
            $fullname = $item['fullname'] ?? '';
            $username = $item['username'] ?? '';
            $userNameList[(string)$item['_id']] = $fullname . "<span class='text-muted font-size-base d-block mr-3'>@$username</span>";
        }
        return $userNameList;
    }

    /**
     * Get the userGroup associated with the user.
     */
    public function userGroup()
    {
        return $this->hasOne(UserGroup::class, '_id', 'user_group');
    }


    public function setTimeExpiredAttribute($value)
    {
        $now = Carbon::now();
        $this->attributes['time_expired'] = $value ?? $now->addMonths(3);
    }

    public function setOtpActiveAttribute($value)
    {
        $this->attributes['otp_active'] = $value ?? 0;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getAvatarUrlAttribute()
    {
        $avatarUri = Helper::getDataFiles($this, 'avatar', false);
        return $avatarUri ? asset($avatarUri) : 'https://placehold.co/300x300.png?text=' . substr($this->fullname, 0, 1);
    }


    public function getAuthenticatorSecretAttribute()
    {
        return $this->authenticator_secret ?? app(TwoFactorAuth::class)->createSecret();
    }

    public function setAuthenticatorSecretAttribute()
    {
        $this->attributes['authenticator_secret'] = app(TwoFactorAuth::class)->createSecret();
    }

    public function getUserNotify()
    {
        $userGroupTypeIds = UserGroupType::whereIn('code', ['ND', 'CSKH'])->where('status', self::ACTIVE_STATUS)->pluck('_id')->toArray();
        $userGroupTypeIds = array_map(static function ($userGroupTypeId) {
            return new ObjectId($userGroupTypeId);
        }, $userGroupTypeIds);

        $userGroupIds = UserGroup::whereIn('user_group_type', $userGroupTypeIds)->where('status', self::ACTIVE_STATUS)->pluck('_id')->toArray();
        $userGroupIds = array_map(static function ($userGroupId) {
            return new ObjectId($userGroupId);
        }, $userGroupIds);

        return self::whereIn('user_group', $userGroupIds)->where('status', self::ACTIVE_STATUS)->pluck('_id')->toArray();
    }

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

}
