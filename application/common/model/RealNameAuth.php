<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class RealNameAuth extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


    public function getStatusAttr($value)
    {
        $array = [1 => '待处理', 2 => '已处理', 3 => '已拒绝'];
        return $array[$value];
    }
}
