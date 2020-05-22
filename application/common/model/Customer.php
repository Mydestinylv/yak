<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Customer extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getTypeAttr($value)
    {
        $array = [1 => '认养客户', 2 => '潜在客户'];
        return $array[$value];
    }
}
