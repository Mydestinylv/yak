<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class AdoptionOrder extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getPayTypeAttr($value)
    {
        $array = [1 => '卡卷', 2 => '支付宝', 3 => '微信', 4 => '现金', 5 => '其他'];
        return $array[$value];
    }

    public function getPayStatusAttr($value)
    {
        $array = [0 => '异常', 1 => '支付成功', 2 => '支付失败', 3 => '其他'];
        return $array[$value];
    }
}
