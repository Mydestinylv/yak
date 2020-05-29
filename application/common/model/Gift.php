<?php

namespace app\common\model;

use app\common\task\PastureTask;
use think\Model;
use traits\model\SoftDelete;

class Gift extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getPastureNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = PastureTask::valueByWhere(['id'=>$value],'pasture_name');
        return $array->data['pasture_name'];
    }
}
