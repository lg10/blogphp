<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 用户模型关联数据库中对应的表
     */
    public $table = 'article';

    /**
     * 用户模型表的主键
     */
    public $primaryKey = 'art_id';

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
     * 排序
     */
    //筛选绑定一二级分类
    public function itree()
    {
        $art = $this->orderBy('art_status','desc')->orderBy('art_order','asc')->get();
        return $art;
    }
}
