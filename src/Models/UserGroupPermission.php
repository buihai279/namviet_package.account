<?php

namespace Namviet\Account\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class UserGroupPermission extends Model
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $collection = 'user_group_permissions';
    protected $connection = 'mongodb';
    protected $dates = ['created', 'modified', 'deleted_at'];

    public static function getList()
    {
        return self::select('name', '_id')->get()->pluck('name', 'id')->toArray();
    }
}
