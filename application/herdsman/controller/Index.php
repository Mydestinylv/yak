<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 17:07
 */

namespace app\herdsman\controller;


use app\common\controller\App;
use app\common\model\BannerManage;
use app\common\model\Notice;
use app\common\model\TaskManage;
use app\common\model\VideoSurveillance;

class Index extends App
{
    public function index()
    {
        $banner = BannerManage::GetBannerManage();
        return format('ok',200,[
            'banner'=>$banner['msg'],
            'task'=>TaskManage::GetAllTaskManage(),
            'notice'=>Notice::GetNotice(),
        ]);
    }
}