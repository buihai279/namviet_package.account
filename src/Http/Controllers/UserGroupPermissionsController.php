<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Namviet\Account\Models\UserGroup;
use Namviet\Account\Models\UserGroupType;

class UserGroupPermissionsController extends Controller
{
    private const SYS_ADMIN = 'SYS_ADMIN';

    public function table(Request $request)
    {
        return view('views::user_group_permissions.table', [
            'codeGrs' => config('permission.codes'),
            'userGroupTypes' => UserGroupType::select(['name'])->get(),
            'types' => UserGroup::select(['name', 'permissions'])->get()->groupBy('user_group_type')
        ]);
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroup = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->select(['name', 'permissions', 'user_group_type'])->findOrFail($id);
        } else {
            $userGroup = UserGroup::select(['name', 'permissions', 'user_group_type'])->findOrFail($id);
        }
        $requestAll = $request->only('permissions');
        UserGroup::where('_id', $id)->update(['permissions' => $requestAll['permissions']]);
        return redirect(route('system.user_group_permission.index', ['user_group' => $id]));
    }

    public function index(Request $request)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroups = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->select(['name', 'permissions', 'user_group_type'])->orderBy('modified', 'DESC')->get();
        } else {
            $userGroups = UserGroup::select(['name', 'permissions', 'user_group_type'])->orderBy('modified', 'DESC')->get();
        }
        foreach ($userGroups as $userGroup) {
            $types[$userGroup->user_group_type ? (string)$userGroup->user_group_type : ''][] = $userGroup;
        }
        $userGroup = $request->get('user_group') ? UserGroup::find($request->get('user_group'))->toArray() : null;
        $codeGrs = config('permission.codes');
        if (Auth::user()->code !== self::SYS_ADMIN) {
            //nếu không phải sys admin thì chỉ cho phân quyền những quyền nó có thể
            foreach ($codeGrs as $key => $code) {
                $avaiable = array_intersect(array_keys($code['list']) ?? [], session()->get('userGroup')->permissions);
                foreach ($codeGrs[$key]['list'] as $k => $per) {
                    if (!in_array($k, $avaiable)) {
                        unset($codeGrs[$key]['list'][$k]);
                    }
                }
                if (empty($codeGrs[$key]['list'])) unset($codeGrs[$key]);
            }
        }
        return view('views::user_group_permissions.index', [
            'codeGrs' => $codeGrs ?? [],
            'userGroup' => $userGroup,
            'userGroupTypes' => UserGroupType::select(['name'])->get(),
            'types' => $types
        ]);
    }

}
