<?php
namespace app\client\controller;
use app\common\controller\App;
use app\common\model\HelpfulList;
use app\common\model\HelpfulProject;
use app\common\model\HelpfulPropaganda;
use app\common\service\WechatPayService;
use app\common\task\HelpfulListTask;
use think\Request;

class Adopt extends App
{
    /*
     * 公益项目列表
     * */
    public function index( Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Adopt.index');
            if(true !== $result) return format($result, 400);
            $list = HelpfulProject::GetHelpfulProject($data);
            if($list['code']==400){
                return format($list['data'],400);
            }else{
                return format('ok',200,[
                    'count'=>$list['count'],
                    'data'=>$list['data']
                ]);
            }
        }
    }

    /*
     * 爱心帮扶
     * */
    public function helpful()
    {
        $helpful_list = HelpfulList::GetAll();
        $helpful_project = HelpfulProject::GetOneHelpful();
        $helpful_propaganda = HelpfulPropaganda::GetOneHelpful();
        $msg = [
            'helpful_list'=>$helpful_list['msg'],
            'helpful_project'=>$helpful_project['msg'],
            'helpful_propaganda'=>$helpful_propaganda['msg'],
        ];
        return format('ok',200,$msg);
    }

    /*
     * 帮扶详情
     * */
    public function details(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Adopt.details');
            if(true !== $result) return format($result, 400);
            $list = HelpfulProject::GetHelpfulDetails($data);
            if($list['code']==400){
                return format($list['msg'],400);
            }else{
                return format('ok',200,$list['msg']);
            }
        }
    }

    public function save( Request $request)
    {
        if($request->isPost()){
            $data = $request->post();
            $result = $this->validate($data,'Adopt.save');
            if(true !== $result) return format($result, 400);
            $order_code = getHelpfulCode();
            $data['order_code'] = $order_code->data['order_code'];
            $data['pay_status'] = 0;
            $transfer = HelpfulListTask::save($data);
            if(!$transfer->status){
                return format('添加失败',400);
            }
            return format('',200,$transfer->data);
        }
    }

    public function pay( Request $request)
    {
        if($request->isPost()){
            $data = $request->post();
            $result = $this->validate($data,'Adopt.pay');
            if(true !== $result) return format($result, 400);
            $where['id'] = $data['helpful_list_id'];
            $transfer = HelpfulListTask::find($where,'order_code,helpful_price as real_price,helpful_project_id as body,customer_id as open_id');
            $transfer->data['real_price'] = $transfer->data['real_price'] * 100;
            if(!$transfer->status){
                return format('支付失败',400);
            }
            $transfer = WechatPayService::wechatPay(to_array($transfer->data));
            return format('',200,$transfer);
        }
    }
}