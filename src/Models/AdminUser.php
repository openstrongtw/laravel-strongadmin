<?php

namespace OpenStrong\StrongAdmin\Models;

use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Support\Str;

class AdminUser extends Model
{

    public $tableComments = '賬號管理';
    protected $table = 'strongadmin_user';
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['password', 'remember_token', 'api_token', 'api_token_at', 'api_token_refresh_at'];

    public function __construct(array $attributes = [])
    {
        $this->connection = config('strongadmin.storage.database.connection');
        parent::__construct($attributes);
    }

    /**
     * Validator rules
     * @param type $on
     * @return type
     */
    public function rules()
    {
        return [
            'user_name' => ['required', 'string', 'max:50'],
            'role_id' => ['required', 'array'],
            'password' => ['nullable', 'string', 'max:100'],
            'remember_token' => ['string', 'max:100'],
            'name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'introduction' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'integer', 'in:1,2'],
            'last_ip' => ['string', 'max:255'],
            'last_at' => ['date'],
            'created_at' => ['date'],
            'updated_at' => ['date'],
        ];
    }

    /**
     * Validator messages
     * @return type
     */
    public function messages()
    {
        return [];
    }

    /**
     * Validator customAttributes
     * @return type
     */
    public function customAttributes()
    {
        return [
            'id' => '管理員id',
            'user_name' => '登錄名',
            'role_id' => '角色',
            'password' => '登錄密碼',
            'remember_token' => '記住登錄',
            'name' => '姓名',
            'email' => '郵箱',
            'phone' => '手機號',
            'avatar' => '頭像',
            'introduction' => '介紹',
            'status' => '狀態',
            'last_ip' => '最近一次登錄ip',
            'last_at' => '最近一次登錄時間',
            'created_at' => '新增時間',
            'updated_at' => '更新時間',
        ];
    }

    public function getAttributeLabel($key)
    {
        $datas = $this->customAttributes();
        return $datas[$key] ?? $key;
    }

    /**
     * Fill the model with an array of attributes.
     * @param type $attributes
     * @return $this
     */
    public function fill($attributes)
    {
        foreach ($attributes as $key => $attribute)
        {
            if ($attribute === null)
            {
                unset($attributes[$key]);
            }
        }
        parent::fill($attributes);
        return $this;
    }

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'strongadmin_user_role', 'admin_user_id', 'admin_role_id');
    }

    public static function generateApiToken()
    {
        $time = time() + floatval(microtime());
        $str = 'ST.' . Str::random(32) . '.' . $time;
        return $str;
    }

}
