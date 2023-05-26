<?php

namespace OpenStrong\StrongAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use OpenStrong\StrongAdmin\Models\AdminRole;
use OpenStrong\StrongAdmin\Models\AdminMenu;

class AdminRoleController extends BaseController
{

    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AdminRole $adminRole)
    {
        if (!$request->expectsJson())
        {
            return $this->view('adminRole.index', ['model' => $adminRole]);
        }
        $model = AdminRole::query();
        $model->orderBy(($request->field ?: 'id'), ($request->order ?: 'desc'));
        if ($request->id)
        {
            $model->where('id', $request->id);
        }
        if ($request->name)
        {
            $model->where('name', 'like', "%{$request->name}%");
        }
        if ($request->created_at_begin && $request->created_at_end)
        {
            $model->whereBetween('created_at', [$request->created_at_begin, Carbon::parse($request->created_at_end)->endOfDay()]);
        }
        if ((isset($request->page) && $request->page <= 0) || $request->export)
        {
            $rows = $model->get();
        } else
        {
            $rows = $model->paginate($request->limit);
        }

        //$rows->makeHidden(['deleted_at']);
        return ['code' => 200, 'message' => __('admin.Success'), 'data' => $rows];
    }

    /**
     * Display the specified resource.
     *
     * @param  \OpenStrong\StrongAdmin\Models\AdminRole  $adminRole
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'id' => ['required', 'integer', Rule::exists('strongadmin_role')],
        ]);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $model = AdminRole::find($request->id);
        if ($model)
        {
            return ['code' => 200, 'message' => __('admin.Success'), 'data' => $model];
        } else
        {
            return ['code' => 5001, 'message' => __('admin.Server internal error')];
        }
    }

    /**
     * Create the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, AdminRole $adminRole)
    {
        if (!$request->expectsJson())
        {
            return $this->view('adminRole.form', ['model' => $adminRole]);
        }
        $rules = array_merge_recursive($adminRole->rules(), [
            'name' => ['unique:strongadmin_role'],
        ]);
        $messages = $adminRole->messages();
        $customAttributes = $adminRole->customAttributes();
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $adminRole->fill($request->all());
        if ($adminRole->save())
        {
            return [
                'code' => 200,
                'message' => __('admin.SuccessCreated'),
                'data' => $adminRole,
                'log' => sprintf('[%s][%s][id:%s]', $adminRole->tableComments, __('admin.SuccessCreated'), $adminRole->id)
            ];
        } else
        {
            return ['code' => 5001, 'message' => __('admin.Server internal error')];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \OpenStrong\StrongAdmin\Models\AdminRole  $adminRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminRole $adminRole)
    {
        if (!$request->expectsJson())
        {
            $model = $adminRole::find($request->id);
            return $this->view('adminRole.form', ['model' => $model]);
        }
        $rules = array_merge_recursive($adminRole->rules(), [
            'id' => ['required', 'integer', Rule::exists('strongadmin_role')],
            'name' => [Rule::unique('strongadmin_role')->ignore($request->id)],
        ]);
        $messages = $adminRole->messages();
        $customAttributes = $adminRole->customAttributes();
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $model = $adminRole::find($request->id);
        $model->fill($request->all());
        if ($model->save())
        {
            return [
                'code' => 200,
                'message' => __('admin.SuccessUpdated'),
                'data' => $model,
                'log' => sprintf('[%s][%s][id:%s]', $adminRole->tableComments, __('admin.SuccessUpdated'), $model->id),
            ];
        } else
        {
            return ['code' => 5001, 'message' => __('admin.Server internal error')];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \OpenStrong\StrongAdmin\Models\AdminRole  $adminRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdminRole $adminRole)
    {
        $validator = Validator::make($request->all(), [
                    'id' => ['required', new \OpenStrong\StrongAdmin\Rules\NotExists('strongadmin_user_role', 'admin_role_id', '請先清空該角色之下的管理員')],
        ]);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $ids = is_array($request->id) ? $request->id : [$request->id];
        $model = $adminRole::whereIn('id', $ids);
        if ($model->delete())
        {
            return [
                'code' => 200,
                'message' => __('admin.SuccessDestroyed'),
                'log' => sprintf('[%s][%s]『id:%s』', $adminRole->tableComments, __('admin.SuccessDestroyed'), json_encode($ids))
            ];
        } else
        {
            return ['code' => 5001, 'message' => __('admin.Server internal error')];
        }
    }

    public function assignPermissions(Request $request, AdminRole $adminRole)
    {
        $model = $adminRole::find($request->id);

        if (!$request->expectsJson())
        {
            $modelMenu = AdminMenu::orderBy('sort', 'DESC');
            $modelMenu->where('level', 1);
            $modelMenu->with(['children' => function ($query) {
                    $query->select('id', 'name as title', 'parent_id', 'route_url', 'status');
                    $query->with(['children' => function ($query) {
                            $query->select('id', 'name as title', 'parent_id', 'route_url', 'status');
                        }]);
                }]);
            $modelMenu->select('id', 'name as title', 'parent_id', 'route_url', 'status');
            $rows = $modelMenu->get();
            foreach ($rows as $row)
            {
                $row->spread = true;
                if ($row->status == 2)
                {
                    $row->disabled = true;
                }
                foreach ($row->children as $child)
                {
                    if ($child->status == 2 || $row->status == 2)
                    {
                        $child->disabled = true;
                    }
                    if ($model->permissions && in_array($child->id, $model->permissions['menu_id']) && count($child['children']) == 0)
                    {
                        $child->checked = true;
                    }
                    foreach ($child['children'] as $child2)
                    {
                        if ($model->permissions && in_array($child2->id, $model->permissions['menu_id']))
                        {
                            $child2->checked = true;
                            $child->spread = true;
                        }
                        if ($child2->status == 2 || $row->status == 2 || $child->status == 2)
                        {
                            $child2->disabled = true;
                        }
                    }
                }
            }
            return $this->view('adminRole.assignPermissions', ['menus' => $rows, 'model' => $model]);
        }

        $datas = $request->checkedData;
        foreach ($datas as $data)
        {
            if (!isset($data['children']))
            {
                continue;
            }
            $permissions['menu_id'][] = $data['id'];
            foreach ($data['children'] as $child)
            {
                $permissions['menu_id'][] = $child['id'];
                $permissions['menu_route_url'][] = $child['route_url'];
                if (!isset($child['children']))
                {
                    continue;
                }
                foreach ($child['children'] as $child2)
                {
                    $permissions['menu_id'][] = $child2['id'];
                    $permissions['menu_route_url'][] = $child2['route_url'];
                }
            }
        }
        $model->permissions = $permissions ?? null;
        $model->save();
        return [
            'code' => 200,
            'message' => __('admin.Success'),
            'log' => sprintf('[%s][%s]『id:%s』', $adminRole->tableComments, '分配許可權', $model->id)
        ];
    }

}
