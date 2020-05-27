<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Pasture extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    /*
     * 一对一关联查询未领养牦牛牧场信息
     * */
    public function adopt()
    {
        return $this->hasOne('Profile')->field('id,name,email');
    }

}
