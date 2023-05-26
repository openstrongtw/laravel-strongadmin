<?php

namespace OpenStrong\StrongAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenStrong\StrongAdmin\Models\AdminMenu;

class AdminMenuController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = AdminMenu::orderBy('sort', 'DESC');
        $model->where('level', 1);
        $model->with(['children' => function ($query) {
                $query->with('children');
            },]);
        $model->with('parent');
        $rows = $model->get();
        
        if ($request->expectsJson())
        {
            return ['code' => 200, 'message' => __('admin.Success'), 'data' => $rows];
        }
        return $this->view('adminMenu.index', ['rows' => $rows]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'id' => ['required', 'integer', Rule::exists('strongadmin_menu')],
        ]);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $model = AdminMenu::find($request->id);
        if ($model)
        {
            return ['code' => 200, 'message' => __('admin.Success'), 'data' => $model];
        } else
        {
            return ['code' => 5001, 'message' => __('admin.Server internal error')];
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, AdminMenu $adminMenu)
    {
        if (!$request->expectsJson())
        {
            $adminMenu->parent_id = $request->parent_id ?: 0;
            $adminMenu->level = $request->level ?: 1;
            $adminMenu->status = 1;
            $adminMenu->sort = 200;
            return $this->view('adminMenu.form', ['model' => $adminMenu]);
        }
        $rules = array_merge_recursive($adminMenu->rules(), [
            'route_url' => [Rule::unique('strongadmin_menu')->where('level', $request->level ?: 1)],
        ]);
        $messages = $adminMenu->messages();
        $customAttributes = $adminMenu->customAttributes();
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $adminMenu->fill($request->all());
        $adminMenu->route_url = trim($adminMenu->route_url, '/') ?: null;
        if ($adminMenu->save())
        {
            return ['code' => 200, 'message' => '新增成功', 'data' => $adminMenu, 'log' => sprintf('[%s][%s][id:%s]', $adminMenu->tableComments, '新增成功', $adminMenu->id)];
        } else
        {
            return ['code' => 5001, 'message' => __('common.Server internal error')];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \OpenStrong\StrongAdmin\Models\AdminMenu  $adminMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminMenu $adminMenu)
    {
        if (!$request->expectsJson())
        {
            $adminMenu = $adminMenu::find($request->id);
            $menus = AdminMenu::where('level', 1)->orderByDesc('sort')->get();
            return $this->view('adminMenu.form', ['model' => $adminMenu, 'menus' => $menus]);
        }
        $rules = array_merge_recursive($adminMenu->rules(), [
            'id' => ['required', 'integer', Rule::exists('strongadmin_menu')],
            'route_url' => [Rule::unique('strongadmin_menu')->where('level', $request->level)->ignore($request->id)],
        ]);
        $messages = $adminMenu->messages();
        $customAttributes = $adminMenu->customAttributes();
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $model = $adminMenu::find($request->id);
        $model->fill($request->all());
        $model->route_url = trim($model->route_url, '/') ?: null;
        if ($model->save())
        {
            return ['code' => 200, 'message' => '更新成功', 'data' => $model, 'log' => sprintf('[%s][%s][id:%s]', $adminMenu->tableComments, '更新成功', $model->id)];
        } else
        {
            return ['code' => 5001, 'message' => __('common.Server internal error')];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \OpenStrong\StrongAdmin\Models\AdminMenu  $adminMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdminMenu $adminMenu)
    {
        $validator = Validator::make($request->all(),
                        [
                            'id' => ['required', Rule::exists('strongadmin_menu', 'id')->where('delete_allow', 1), new \OpenStrong\StrongAdmin\Rules\NotExists(AdminMenu::class, 'parent_id', '請先刪除下級關聯數據')],
                        ],
                        [
                            'id.exists' => '該菜單被強制設定為 `不允許刪除`'
                        ]
        );
        if ($validator->fails())
        {
            return ['code' => 3001, 'message' => $validator->errors()->first(), 'data' => $validator->errors()];
        }
        $ids = is_array($request->id) ? $request->id : [$request->id];
        $model = AdminMenu::whereIn('id', $ids);
        if ($model->delete())
        {
            return ['code' => 200, 'message' => '刪除成功', 'log' => sprintf('[%s][%s]『id:%s』', $adminMenu->tableComments, __('admin.SuccessDestroyed'), json_encode($ids))];
        } else
        {
            return ['code' => 5001, 'message' => __('common.Server internal error')];
        }
    }

}
