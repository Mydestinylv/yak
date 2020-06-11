<?php
/**
 * Created by PhpStorm.
 * User: ry
 * Date: 2020/6/4
 * Time: 9:40
 */

namespace app\common\service;


use think\Config;

Class WechatPayService
{

    public static function getOpenId()
    {
        include_once APP_PATH.'/common/lib/wechat/example/WxPay.JsApiPay.php';
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        return $openId;
    }


    public static function wechatPay($data)
    {
        include_once APP_PATH.'/common/lib/wechat/example/WxPay.JsApiPay.php';
        include_once APP_PATH.'/common/lib/wechat/lib/WxPay.Api.php';
        include_once APP_PATH.'/common/lib/wechat/example/WxPay.Config.php';
        include_once APP_PATH.'/common/lib/wechat/lib/WxPay.Data.php';
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('牦牛-'.$data['body']);
        $input->SetAttach($data['attach']);
        $input->SetOut_trade_no($data['order_code']);
        $input->SetTotal_fee($data['real_price']);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag("test");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($data['open_id']);
        $config = new \WxPayConfig();
        $input->SetNotify_url($config->GetNotifyUrl());
        $order = \WxPayApi::unifiedOrder($config, $input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        //获取共享收货地址js函数参数
//        $editAddress = $tools->GetEditAddressParameters();

        return json_decode($jsApiParameters,true);
    }


}