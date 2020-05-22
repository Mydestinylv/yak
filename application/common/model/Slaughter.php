<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Slaughter extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getStatusAttr($value)
    {
        $array = [0 => '待屠宰', 1 => '入场等待', 2 => '杀牛', 3 => '去皮', 4 => '排酸', 5 => '去油块', 6 => '精细分割', 7 => '降温', 8 => '包装', 9 => '待上车', 10 => '已上车'];
        return $array[$value];
    }
}
