<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/23
 * Time: 11:43
 */

namespace app\client\controller;
use app\common\controller\App;
use app\common\model\AdoptionOrder;
use app\common\model\SaleOrder;
use app\common\service\WechatPayService;
use app\common\task\AdoptionOrderTask;
use app\common\task\CardManageTask;
use app\common\task\CustomerTask;
use app\common\task\YaksTask;
use think\Cache;
use think\Db;
use think\Env;
use think\Request;
use app\common\model\Yaks as YaksM;

class Yaks extends App
{
    /*
     * 牦牛认养
     * */
    public function adopt(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Yaks.adopt');
            if(true !== $result) return format($result, 400);
            $list = YaksM::GetAdoptYaks($data);
            if($list['code']==400){
                return format($list['data'],400);
            }else{
                return format('ok',200,[
                    'count'=>$list['count'],
                    'data'=>$list['data']
                ]);
            }
        }else{
            return format('请正确请求接口',400);
        }
    }

    /*
     * 认领牦牛详情
     * */

    public function details(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Yaks.details');
            if(true !== $result) return format($result, 400);
            $list = YaksM::GetYaksDetails($data);
            if($list['code']==400){
                return format($list['data'],400);
            }else{
                return format('ok',200,$list['data']);
            }
        }else{
            return format('请正确请求接口',400);
        }
    }

    /*
     * 获取卡卷列表
     * */

    public function getCardList(Request $request)
    {
        if($request->isPost()){
            $where['customer_id'] = CID;
            $where['status'] = 2;
            $transfer = CardManageTask::select($where,'id,card_name,balance');
            if(!$transfer->status){
                return format('获取失败',400);
            }
            return format('',200,to_array($transfer->data));
        }else{
            return format('请正确请求接口',400);
        }
    }



    /*
     * 确认认养支付
     * */

    public function adopt_pay(Request $request)
    {
        if($request->isPost()){
            $data = $request->post();
            $result = $this->validate($data,'Yaks.adopt_pay');
            if(true !== $result) return format($result, 400);
            //判断牦牛是否已认养
            $is_adopt = YaksM::IsAdopt($data);
            if($is_adopt['code']==400) return format($is_adopt['data'],400);
            //获取客户信息
            $transfer = CustomerTask::find(['id'=>CID],'real_name,tel');
            if(!$transfer->status){
                return format('支付失败',400);
            }
            $data['customer_real_name'] = $transfer->data['real_name'];
            $data['customer_tel'] = $transfer->data['tel'];
            $data['customer_id'] = CID;
            $data['pay_time'] = date_now();
            $data['adoption_status'] = 1;
            $data['order_number'] = getAdoptCode()->data['order_code'];
            $data['pay_money'] = Env::get('yaks_price');
            if(isset($data['card_id'])){
                $card_id = $data['card_id'];
                unset($data['card_id']);
            }
            //添加认养订单
            Db::startTrans();
            $transfer = AdoptionOrderTask::save($data);
            if(!$transfer->status){
                Db::rollback();
                return format('支付失败',400);
            }
            $adoption_order_id = $transfer->data['id'];
            //支付
            switch ($data['pay_type']){
                case 1:
                    if(!isset($card_id)){
                        Db::rollback();
                        return format('卡卷ID不存在',400);
                    }
                    $where['id'] = $card_id;
                    $where['status'] = 2;
                    $transfer = CardManageTask::valueByWhere($where,'balance');
                    if(!$transfer->status){
                        Db::rollback();
                        return format('支付失败',400);
                    }
                    if($transfer->data['balance']<$data['pay_money']){
                        Db::rollback();
                        return format('余额不足',400);
                    }
                    $transfer = CardManageTask::update(['status'=>3],['id'=>$card_id]);
                    if(!$transfer->status){
                        Db::rollback();
                        return format('支付失败',400);
                    }
                    $transfer = AdoptionOrderTask::update(['pay_status'=>1],['id'=>$adoption_order_id]);
                    if(!$transfer->status){
                        Db::rollback();
                        return format('支付失败',400);
                    }
                    $transfer = AdoptionOrderTask::valueByWhere(['id'=>$adoption_order_id],'yaks_id');
                    if(!$transfer->data){
                        Db::rollback();
                        return format('支付失败', 400);
                    }
                    $transfer = YaksTask::update(['is_adoption' => 2,'adoption_tel'=>$data['customer_tel'],'adoption_time'=>date_now()],['id'=>$transfer->data['yaks_id']]);
                    if(!$transfer->data){
                        Db::rollback();
                        return format('支付失败',400);
                    }
                    Db::commit();
                    $transfer = AdoptionOrderTask::valueByWhere(['id'=>$adoption_order_id],'id,order_number');
                    return format('',200 ,to_array($transfer->data));
                    break;
                case 2:

                    break;
                case 3:
                    $where['id'] = $transfer->data['id'];
                    $transfer = AdoptionOrderTask::find($where,'customer_id as open_id,order_number as order_code,yaks_id as yaks_name,pay_money as real_price');
                    if(!$transfer->status){
                        Db::rollback();
                        return format('支付失败',400);
                    }
                    $data = to_array($transfer->data);
                    $data['body'] = '购买牦牛'.$data['yaks_name'];
                    $data['attach'] = 'yaks';
                    $data['real_price'] = $data['real_price'] * 100;
                    $transfer = WechatPayService::wechatPay($data);
                    Db::commit();
                    return format('',200,$transfer);
                    break;
                default:
                    break;
            }
        }
    }
}