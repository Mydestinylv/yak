<?php

namespace app\common\model;

use app\common\lib\Transfer;
use app\common\task\PastureTask;
use think\Model;
use traits\model\SoftDelete;

class VideoSurveillance extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getPastureIdAttr($value)
    {
        $where['id'] = $value;
        $transfer = PastureTask::valueByWhere($where,'pasture_name');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return $transfer->data['pasture_name'];
    }
}
