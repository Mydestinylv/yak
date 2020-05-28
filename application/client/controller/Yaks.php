<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/23
 * Time: 11:43
 */

namespace app\client\controller;
use app\common\controller\App;
use think\Request;
use app\common\model\Yaks as YaksM;
use wxpay\Config;

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
     * 确认认养支付
     * */

    public function adopt_pay(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Yaks.adopt_pay');
            if(true !== $result) return format($result, 400);
            $is_adopt = YaksM::IsAdopt($data);
            if($is_adopt['code']==400) return format($is_adopt['data'],400);
            $goods_name = '牦牛"'.$is_adopt['data']['yaks_name'].'"认养';
            $order_no = Config::CreateOutTradeNo();
            $money = 0.01 ;
            $a = \wxpay\Index::pay($goods_name,$order_no,$money);
            if($a == 200){
                return format('ok',200,$a['msg']);
            }else{
                return format($a['msg'],400);
            }
        }
    }
}