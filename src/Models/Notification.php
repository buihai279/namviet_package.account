<?php

namespace Namviet\Account\Models;

use App\Censor;
use App\Notifications\CensorCommentNotification;
use App\Notifications\CensorNotification;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

//code lại

class Notification extends Model
{
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $collection = 'notifications';
    protected $connection = 'mongodb';
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'read_at'];

    public static function getRedirectUrl($id)
    {
        $notification = Auth::user()->notifications()->where('_id', $id)->first();
        if (empty($notification)) {
            return '#';
        }
        switch ($notification->type) {
            case CensorNotification::class:
                $options = $notification->data['options'] ?? [];
                return route(Censor::routeByStatus($notification->data['options']['status_update']), ['highlight' => $options['_id'] ? [$options['_id']] : [], 'type' => $options['type'] ?? '']);
            case CensorCommentNotification::class:
                return route('censor_comment.index', ['highlight' => $notification->data['commentId'] ?? '']);
            default:
                return '';
        }
    }
}
