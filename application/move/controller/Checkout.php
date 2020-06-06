<?php

namespace app\move\controller;
use app\common\controller\App;
use think\Log;

/**
 * Created by PhpStorm.
 * User: ry
 * Date: 2020/6/5
 * Time: 14:54
 */
Class Checkout extends App
{
    public function payResult()
    {
        try {
            $xmlData = file_get_contents('php://input');
            libxml_disable_entity_loader(true);
            $data = json_decode(json_encode(simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            if ($data['return_code'] == 'SUCCESS') {
                $out_trade_no = $data['out_trade_no'];
                $transfer = \app\common\task\SaleOrderTask::update(['pay_status'=>1],['order_code'=>$out_trade_no]);
                if(!$transfer->status){
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '更新订单信息失败',
                        'attach' => $data,
                    ]);
                }
            }
            return true;
        } catch (\Exception $e) {
            exception_record($e);
        }
    }
}

