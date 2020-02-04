<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * 用户模型关联数据库中对应的表
     */
    public $table = 'user';

    /**
     * 用户模型表的主键
     */
    public $primaryKey = 'user_id';

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
     * 动态关联角色模型
     */
    public function role()
    {
        return $this->belongsToMany('App\Model\Role','user_role','user_id','role_id');
    }

}
