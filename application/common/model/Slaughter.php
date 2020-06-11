<?php

namespace app\common\model;

use app\common\task\PastureTask;
use think\Model;
use traits\model\SoftDelete;

class Slaughter extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getStatusAttr($value)
    {
        $array = [0 => '入场等待', 1 => '接收', 2 => '杀牛', 3 => '去皮', 4 => '排酸', 5 => '去油块', 6 => '精细分割', 7 => '降温', 8 => '包装', 9 => '待上车', 10 => '已上车'];
        return $array[$value];
    }

    public function getPastureNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = PastureTask::valueByWhere(['id'=>$value],'pasture_name');
        return $array->data['pasture_name'];
    }
    public function getYaksSexAttr($value)
    {
        $array = [0 => '母', 1 => '公'];
        return $array[$value];
    }

}
