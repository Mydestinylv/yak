<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class SaleOrder extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getGoodsAttr($value)
    {

        $value = explode(',',$value);
        $array = [1 => '牦牛肉', 2 => '牦牛内脏', 3 => '牦牛头', 4 => '牦牛头（工艺）'];
        foreach ($array as $key => $val) {
            if(!in_array($key,$value)){
                unset($array[$key]);
            }
        }
        return implode($array,',');
    }

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

    public function getLogisticsStatusAttr($value)
    {
        $array = [0 => '已删除', 1 => '待发货', 2 => '待收货', 3 => '已收货', 4 => '待确认', 5 => '已确认）'];
        return $array[$value];
    }

    public function getLogisticsCompanyAttr($value)
    {
        $array = [0 => '顺丰', 1 => '中通', 2 => '京东'];
        return $array[$value];
    }
}
