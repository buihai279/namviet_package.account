<?php

namespace Namviet\Account\Models;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\ObjectId;

class UserGroup extends Model
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    public const INACTIVE_STATUS = 0;
    const UPDATED_AT = 'modified';
    protected $collection = 'user_groups';
    protected $connection = 'mongodb';
    protected $dates = ['created', 'modified', 'deleted_at'];

    public static function getList()
    {
        return self::select('name', '_id')->get()->pluck('name', 'id')->toArray();
    }

    public static function getGroupPrivileged()
    {
//        IDS NGƯỜI DÙNG TẠO RA, ID NGƯỜI DÙNG THUỘC
        $groupIds = self::select(['_id'])->where('user', new ObjectId(Auth::id()))->get()->pluck('_id')->toArray();
        $groupCurrentId = new ObjectId(request()->session()->get('userGroup')->_id);//get current group id
        $groupIds[] = (string)$groupCurrentId;
        return array_map(function ($item) {
            return new ObjectId($item);
        }, $groupIds);
    }
}
