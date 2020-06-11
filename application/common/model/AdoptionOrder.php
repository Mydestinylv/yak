<?php

namespace app\common\model;

use app\common\task\HerdsmanTask;
use app\common\task\PastureTask;
use app\common\task\WechatTask;
use app\common\task\YaksTask;
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

    public function getAdoptionStatusAttr($value)
    {
        $array = [1=>'生长中',2=>'待屠宰', 3=>'屠宰中', 4=>'屠宰完毕', 5=>'配送中', 6=>'已收货'];
        return $array[$value];
    }

    public function getHerdsmanNameAttr($value)
    {
        $array = HerdsmanTask::valueByWhere(['id'=>$value],'name');
        return $array->data['name'];
    }

    public function getPastureNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = PastureTask::valueByWhere(['id'=>$value],'pasture_name');
        return $array->data['pasture_name'];
    }

    public function getOpenIdAttr($value)
    {
        $array = WechatTask::valueByWhere(['customer_id'=>$value],'open_id');
        return $array->data['open_id'];
    }

    public function getYaksNameAttr($value)
    {
        if(is_string($value)){
            return $value;
        }
        $array = YaksTask::valueByWhere(['id'=>$value],'yaks_name');
        return $array->data['yaks_name'];
    }
}
