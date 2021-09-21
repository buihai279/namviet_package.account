<?php

namespace Namviet\Account\Models;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\ObjectId;

class UserGroupType extends Model
{
    use SoftDeletes;

    public const INACTIVE_STATUS = 0;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $collection = 'user_group_types';
    protected $connection = 'mongodb';
    protected $dates = ['created', 'modified', 'deleted_at'];

    public static function getList()
    {
        return self::select('name', '_id')->get()->pluck('name', 'id')->toArray();
    }

    public static function getGrTypePrivileged()
    {
//        IDS NGƯỜI DÙNG TẠO RA, ID NGƯỜI DÙNG THUỘC
        $grTypeCreate = self::select(['_id'])->where('user', new ObjectId(Auth::id()))->get()->pluck('_id')->toArray();
        $grTypeId = new ObjectId(request()->session()->get('userGroupType')->_id);
        $grTypeCreate[] = (string)$grTypeId;
        $grTypeCreate = array_map(function ($item) {
            return new ObjectId($item);
        }, $grTypeCreate);
        return $grTypeCreate;
    }
}
