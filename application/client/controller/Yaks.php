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
}