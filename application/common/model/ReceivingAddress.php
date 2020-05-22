<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class ReceivingAddress extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getIsDefaultAttr($value)
    {
        $array = [0 => '备用地址', 1 => '默认地址'];
        return $array[$value];
    }
}
