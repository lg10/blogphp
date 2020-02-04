<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * 用户模型关联数据库中对应的表
     */
    public $table = 'category';

    /**
     * 用户模型表的主键
     */
    public $primaryKey = 'cate_id';

    /**
     * 允许被批量操作的字段
     *
     * @var array
     */
//    protected $fillable = [
//        'username', 'password',
//    ];
    public $guarded = [];

    /**
     * 禁用user模型时间戳
     * 如果不禁用会默认数据库表中存在created_at和updated_at两个字段
     */
    public $timestamps = false;

    //筛选绑定一二级分类
    public function itree()
    {
        $cate = $this->orderBy('cate_order','asc')->get();

        //格式化，和缩进操作
        return $this->getTree($cate);
    }

    public function getTree($cates)
    {
        $arr = [];
        foreach ($cates as $k=>$v) {
            //找出一级目录
            if ($v->cate_pid == 0) {
                $arr[] = $v;
                foreach ($cates as $m=>$n) {
                    //绑定当前一级目录的二级目录|_
                    if ($v->cate_id == $n->cate_pid) {
                        //给二级目录加缩进
                        $n->cate_name = '￣|______' . $n->cate_name;
                        $arr[] = $n;
                    }
                }

            }
        }
        return $arr;
    }
}
