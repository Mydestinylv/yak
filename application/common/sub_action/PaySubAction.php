<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\SaleOrder;
use app\common\service\WechatPayService;
use app\common\task\SaleOrderTask;

class PaySubAction
{
    /**
     * 删除指定资源
     */
    public static function wechatPay($param,$customer_id)
    {
        $where['id'] = $param['id'];
        $transfer = SaleOrderTask::find($where,'id,order_code,goods,real_price,customer_id as open_id');
        if(!$transfer->status){
            return new Transfer('支付失败');
        }
        $transfer->data['body'] = '购买牦牛';
        $transfer->data['real_price'] = $transfer->data['real_price']*100;
        $data = to_array($transfer->data);
        $transfer = WechatPayService::wechatPay($data);
        return new Transfer('', true,['data'=>$transfer]);
    }
}
