<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 用户模型关联数据库中对应的表
     */
    public $table = 'user';

    /**
     * 用户模型表的主键
     */
    public $primaryKey = 'id';

    /**
     * 允许被批量操作的字段
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * 禁用user模型时间戳
     * 如果不禁用会默认数据库表中存在created_at和updated_at两个字段
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
