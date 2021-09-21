<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;
use Namviet\Account\Models\FileManaged;
use Namviet\Account\Models\User;
use Namviet\Account\Models\UserGroupType;

class UserGroupTypesController extends Controller
{
    private const SYS_ADMIN = 'SYS_ADMIN';

    public function index(Request $request)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroupTypes = UserGroupType::whereIn('_id', UserGroupType::getGrTypePrivileged())->get();
        } else {
            $userGroupTypes = UserGroupType::all();
        }
        return view('views::user_group_types.index', [
            'userGroupTypes' => $userGroupTypes,
            'userNameList' => User::getListHtml(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $data = UserGroupType::whereIn('_id', UserGroupType::getGrTypePrivileged())->findOrFail($id);
        } else {
            $data = UserGroupType::findOrFail($id);
        }
        if ($request->getMethod() === 'POST') {
            return $this->update($request, $id);
        }
        FileManaged::showFile($data);
        return view('views::user_group_types.edit', ['data' => $data]);
    }


    private function update(Request $request, $id)
    {
        $request_data = $request->only(['name', 'code', 'description']);
        $request->validate([
            'name' => [
                'required',
                Rule::unique('user_group_types', 'name')->ignore($id, '_id'),
            ],
            'code' => 'required',
            'description' => 'required',
        ]);
        $obj = UserGroupType::find($id);
        $obj->name = $request_data['name'] ?? '';
        $obj->code = $request_data['code'] ?? '';
        $obj->description = $request_data['description'] ?? '';

        if ($obj->save()) {
            $request->session()->flash('notice', 'Update thành công!');
        } else {
            $request->session()->flash('notice', 'Có lỗi xảy ra !!!');
        }
        return redirect()->route('system.user_group_type.index');
    }

    public function add(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            return $this->store($request);
        }
        return view('views::user_group_types.add', []);
    }

    private function store(Request $request)
    {
        $request_data = $request->only(['name', 'code', 'description', 'status']);
        $request->validate([
            'name' => 'required|unique:user_group_types',
            'code' => 'required|unique:user_group_types',
            'description' => 'required',
            'status' => 'required',
        ]);
        $model = new UserGroupType();
        $model->name = $request_data['name'] ?? '';
        $model->code = $request_data['code'] ?? '';
        $model->status = (int)$request_data['status'];
        $model->user = new ObjectId(Auth::id());
        $model->description = $request_data['description'] ?? '';
        if ($model->save()) {
            $request->session()->flash('notice', 'Thêm thành công!');
        } else {
            $request->session()->flash('notice', 'Có lỗi xảy ra !!!');
        }
        return redirect()->route('system.user_group_type.index');
    }

    public function toggle(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroupType = UserGroupType::select('status')->whereIn('_id', UserGroupType::getGrTypePrivileged())->findOrFail($id);
        } else {
            $userGroupType = UserGroupType::select('status')->findOrFail($id);
        }
        $toggleStatus = isset($userGroupType->status) && $userGroupType->status === 1 ? 0 : 1;
        UserGroupType::where('_id', $id)->update(['status' => $toggleStatus]);
        return redirect(route('system.user_group_type.index'));
    }
}
