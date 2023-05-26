<?php

namespace OpenStrong\StrongAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{

    public $tableComments = '操作日誌表';
    protected $table = 'strongadmin_log';
    protected $guarded = [];
    protected $casts = ['log_dirty' => 'json', 'log_original' => 'json'];

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
            'route_url' => ['required', 'string', 'max:200'],
            'desc' => ['string', 'max:255'],
            'admin_user_id' => ['integer'],
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
            'id' => 'ID',
            'route_url' => '路由',
            'desc' => '操作描述',
            'log_original' => '欄位變更前內容',
            'log_dirty' => '欄位變更后內容',
            'admin_user_id' => '操作使用者',
            'created_at' => '操作時間',
            'updated_at' => 'UPDATED_AT',
        ];
    }

    public function getAttributeLabel($key)
    {
        $datas = $this->customAttributes();
        return $datas[$key] ?? $key;
    }

    /**
     * Filter Request Attributes and Retain only customAttributes
     * @param array $data
     * @param type $append_except
     * @return type
     */
    public function onlyCustomAttributes(array $data, array $append_except = [])
    {
        $except = array_merge_recursive($append_except, ['id', 'created_at', 'updated_at', 'deleted_at']);
        $attributes = $this->customAttributes();
        return collect($data)->except($except)->only(array_keys($attributes))->toArray();
    }

    /**
     * Fill the model with an array of attributes.
     * @param type $attributes
     * @return $this
     */
    public function fill($attributes)
    {
        $onlyCustomAttributes = $this->onlyCustomAttributes($attributes);
        parent::fill($onlyCustomAttributes);
        return $this;
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

}
