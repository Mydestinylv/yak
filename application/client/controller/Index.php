<?php
namespace app\client\controller;
use app\common\controller\App;
use app\common\model\BannerManage;
use app\common\model\VideoManage;
use app\common\model\VideoSurveillance;

class Index extends App
{
    public function index()
    {
        $banner_manage = BannerManage::GetBannerManage();
        $video_manage = VideoManage::GetVideo();
        $video_surveillance =VideoSurveillance::GetPastureVideo();
        return format('ok',200,[
            'banner_manage'=>$banner_manage['msg'],
            'video_manage'=>$video_manage['msg'],
            'video_surveillance'=>$video_surveillance['msg']
        ]);
    }
}