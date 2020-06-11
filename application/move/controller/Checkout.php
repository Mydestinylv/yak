<?php

namespace app\move\controller;
use app\common\controller\App;
use app\common\task\AdoptionOrderTask;
use app\common\task\YaksTask;
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
                $attach = $data['attach'];
                switch ($attach) {
                    case 'sale':
                        $transfer = \app\common\task\SaleOrderTask::update(['pay_status'=>1],['order_code'=>$out_trade_no]);
                        break;
                    case 'helpful':
                        $transfer = \app\common\task\HelpfulListTask::update(['pay_status'=>1],['order_code'=>$out_trade_no]);
                        break;
                    case 'yaks':
                        $transfer = \app\common\task\AdoptionOrderTask::update(['pay_status'=>1],['order_number'=>$out_trade_no]);
                        if(!$transfer->status){
                            Log::error([__CLASS__ . '  ' . __FUNCTION__,
                                'failure_desc' => '更新订单信息失败',
                                'attach' => $transfer->data,
                            ]);
                            break;
                        }
                        $transfer = \app\common\task\AdoptionOrderTask::valueByWhere(['order_num'=>$out_trade_no],'yaks_id');
                        if(!$transfer->status){
                            Log::error([__CLASS__ . '  ' . __FUNCTION__,
                                'failure_desc' => '获取牦牛ID失败',
                                'attach' => $transfer->data,
                            ]);
                            break;
                        }
                        $transfer = \app\common\task\YaksTask::update(['is_adoption'=>2],['id'=>$transfer->data['yaks_id']]);
                        break;
                    default:
                        # code...
                        break;
                }

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

