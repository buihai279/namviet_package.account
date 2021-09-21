<?php

namespace Namviet\Account\Helpers;

use DateTimeZone;
use Illuminate\Support\Arr;

class Helper
{

    public static function getDataFiles(object $object, $fieldName = 'logo', $multiple = true)
    {
        if (empty($object['file_uris'][$fieldName])) {
            return '';
        }
        if ($multiple === true) {
            return array_values($object['file_uris'][$fieldName]);
        }
        return Arr::first($object['file_uris'][$fieldName]);
    }

    public static function urlToRoute($url): ?string
    {
        return app('router')->getRoutes()->match(app('request')->create($url))->getName();
    }

    public static function isShowItemMenu($menuObj)
    {
        return count(array_intersect(self::getAllChild($menuObj), session()->get('userGroup')['permissions'])) > 0;
    }

    private static function getAllChild($menuObj)
    {
        $permissions[] = $menuObj['permission'] ?? '';
        if (!empty($menuObj['child'])) {
            $permissions = array_merge($permissions, Arr::pluck($menuObj['child'], 'permission'));
            foreach ($menuObj['child'] as $menuChild) {
                if (!empty($menuChild['child'])) {
                    $permissions = array_merge($permissions, Arr::pluck($menuChild['child'], 'permission'));
                }
            }
        }
        return $permissions;
    }

    public static function isShowBlock($menuBlock)
    {
        $permissions = [];
        if (!empty($menuBlock['items'])) {
            foreach ($menuBlock['items'] as $item) {
                $permissions = array_merge($permissions, self::getAllChild($item));
            }
        }
        return count(array_intersect($permissions, session()->get('userGroup')['permissions'])) > 0;
    }

    public static function arrPhptoJs($arr)
    {
        if (empty($arr) || !is_array($arr)) return '[]';
        return '["' . implode('","', $arr) . '"]';
    }

    public static function transformDate($dateTime)
    {
        if (is_string($dateTime) || empty($dateTime)) {
            return $dateTime;
        }
        if ($dateTime->toDateTime()) {
            return $dateTime->toDateTime()->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'))->format('Y-m-d H:i:s');
        }
        return null;
    }

    public static function hasPermission($permissionName)
    {
        if (empty($permissionName) || empty(session()->get('userGroup')['permissions'])) {
            return false;
        }
        return in_array($permissionName, session()->get('userGroup')['permissions']);
    }

    public static function hiddenMobile($mobile)
    {
        if (empty($mobile)) {
            return $mobile;
        }

        return substr($mobile, 0, -3) . 'XXX';
    }

    public static function convertDate($date)
    {
        if (empty($date)) {
            return $date;
        }

        return date('d/m/Y H:i:s', $date / 1000);
    }

}
