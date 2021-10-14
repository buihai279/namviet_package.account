<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;
use Namviet\Account\Models\User;
use Namviet\Account\Models\UserGroup;
use Namviet\Account\Models\UserGroupType;

class UserGroupsController extends Controller
{
    private const SYS_ADMIN = 'SYS_ADMIN';

    public function index()
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroups = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->get();
        } else {
            $userGroups = UserGroup::all();
        }
        return view('views::user_groups.index', [
            'userGroups' => $userGroups,
            'userGroupTypes' => UserGroupType::getList(),
            'userNameList' => User::getListHtml(),
        ]);
    }


    public function editPermission(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroup = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->select(['name', config('namviet_account.permission_field'), 'user_group_type'])->findOrFail($id);
        } else {
            $userGroup = UserGroup::select(['name', config('namviet_account.permission_field'), 'user_group_type'])->findOrFail($id);
        }
        $requestAll = $request->only(config('namviet_account.permission_field'));
        UserGroup::where('_id', $id)->update($requestAll);
        return redirect(route('system.user_group.indexPermission', ['user_group' => $userGroup]));
    }

    public function indexPermission(Request $request)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroups = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->select(['name', config('namviet_account.permission_field'), 'user_group_type'])->orderBy('modified', 'DESC')->get();
        } else {
            $userGroups = UserGroup::select(['name', config('namviet_account.permission_field'), 'user_group_type'])->orderBy('modified', 'DESC')->get();
        }
        foreach ($userGroups as $userGroup) {
            $types[$userGroup->user_group_type ? (string)$userGroup->user_group_type : ''][] = $userGroup;
        }
        $userGroup = $request->get('user_group') ? UserGroup::find($request->get('user_group'))->toArray() : null;
        $codeGrs = config('permission.codes');
        if (Auth::user()->code !== self::SYS_ADMIN) {
            //nếu không phải sys admin thì chỉ cho phân quyền những quyền nó có thể
            foreach ($codeGrs as $key => $code) {
                $available = array_intersect(array_keys($code['list']) ?? [], session()->get('userGroup')->{config('namviet_account.permission_field')});
                foreach ($codeGrs[$key]['list'] as $k => $per) {
                    if (!in_array($k, $available, true)) {
                        unset($codeGrs[$key]['list'][$k]);
                    }
                }
                if (empty($codeGrs[$key]['list'])) unset($codeGrs[$key]);
            }
        }
        return view('views::user_groups.permission', [
            'codeGrs' => $codeGrs ?? [],
            'userGroup' => $userGroup,
            'userGroupTypes' => UserGroupType::select(['name'])->get(),
            'types' => $types
        ]);
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $data = UserGroup::whereIn('_id', UserGroup::getGroupPrivileged())->findOrFail($id);
        } else {
            $data = UserGroup::findOrFail($id);
        }
        if ($request->getMethod() === 'POST') {
            return $this->update($request, $id);
        }
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroupTypes = UserGroupType::select(['_id', 'name', 'status'])->whereIn('_id', UserGroupType::getGrTypePrivileged())->get();
        } else {
            $userGroupTypes = UserGroupType::select(['_id', 'name', 'status'])->get();
        }
        return view('views::user_groups.edit', [
            'userGroupTypes' => $userGroupTypes,
            'data' => $data
        ]);
    }


    private function update(Request $request, $id)
    {
        $request_data = $request->only(['name', 'description', 'user_group_type']);
        $request->validate([
            'name' => [
                'required',
                Rule::unique('user_groups', 'name')->ignore($id, '_id'),
            ],
            'description' => 'required',
            'user_group_type' => 'required',
        ]);
        $obj = UserGroup::find($id);
        $obj->name = $request_data['name'] ?? '';
        $obj->user_group_type = new ObjectId($request_data['user_group_type']);
        $obj->{config('namviet_account.permission_field')} = $request_data[config('namviet_account.permission_field')] ?? [];
        $obj->home_url = 'Emptys/apiEmpty';
        $obj->description = $request_data['description'] ?? '';
        if ($obj->save()) {
            $request->session()->flash('notice', 'Update thành công!');
        } else {
            $request->session()->flash('notice', 'Có lỗi xảy ra !!!');
        }
        return redirect()->route('system.user_group.index');
    }

    public function add(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            return $this->store($request);
        }
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroupTypes = UserGroupType::select(['_id', 'name'])->where('status', 1)->whereIn('_id', UserGroupType::getGrTypePrivileged())->get();
        } else {
            $userGroupTypes = UserGroupType::where('status', 1)->select('name', '_id')->get();
        }
        return view('views::user_groups.add', [
            'userGroupTypes' => $userGroupTypes,
        ]);
    }

    private function store(Request $request)
    {
        $request_data = $request->only(['name', 'description', 'status', 'user_group_type']);
        $request->validate([
            'name' => 'required|unique:user_groups',
            'description' => 'required',
            'status' => 'required',
            'user_group_type' => 'required',
        ]);
        $model = new UserGroup();
        $model->name = $request_data['name'] ?? '';
        $model->status = (int)$request_data['status'];
        $model->{config('namviet_account.permission_field')} = $request_data[config('namviet_account.permission_field')] ?? [];
        $model->home_url = 'Emptys/apiEmpty';
        $model->user = new ObjectId(Auth::id());
        $model->user_group_type = new ObjectId($request_data['user_group_type']);
        $model->description = $request_data['description'] ?? '';
        if ($model->save()) {
            $request->session()->flash('notice', 'Thêm thành công!');
        } else {
            $request->session()->flash('notice', 'Có lỗi xảy ra !!!');
        }
        return redirect()->route('system.user_group.index');
    }

    public function toggle($id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroup = UserGroup::select('status')->whereIn('_id', UserGroup::getGroupPrivileged())->findOrFail($id);
        } else {
            $userGroup = UserGroup::select('status')->findOrFail($id);
        }
        $toggleStatus = isset($userGroup->status) && $userGroup->status === 1 ? 0 : 1;
        UserGroup::where('_id', $id)->update(['status' => $toggleStatus]);
        return redirect(route('system.user_group.index'));
    }
}
