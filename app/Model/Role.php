<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * 用户模型关联数据库中对应的表
     */
    public $table = 'role';

    /**
     * 用户模型表的主键
     */
    public $primaryKey = 'id';

    /**
     * 允许被批量操作的字段
     *
     * @var array
     */
//    protected $fillable = [
//        'username', 'password',
//    ];
    public $guarded=[];

    /**
     * 禁用user模型时间戳
     * 如果不禁用会默认数据库表中存在created_at和updated_at两个字段
     */
    public $timestamps = false;

    /**
     * 动态关联权限模型
     */
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permissions','role_permission','role_id','permission_id');
    }
}
