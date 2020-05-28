<?php
namespace app\herdsman\controller;
use app\common\controller\App;
use app\common\model\BannerManage;
use app\common\model\Herdsman;
use app\common\model\Notice;
use app\common\model\TaskManage;
use app\common\model\Yaks;
use think\Request;

class Index extends App
{
    public function index()
    {
        $banner = BannerManage::GetBannerManage();
        $task = TaskManage::GetAllTaskManage();
        $notice = Notice::GetNotice();
        return format('ok',200,[
            'banner'=>$banner['msg'],
            'task'=>$task['msg'],
            'notice'=>$notice['msg'],
        ]);
    }

    /*
     * 管理中的牦牛和管理完毕的牦牛
     * */

    public function yak_manage(Request $request)
    {
        if($request->isPost()) {
            $data = $request->param();
            $result = $this->validate($data,'Index.manage');
            if(true !== $result) return format($result, 400);
            $list = Yaks::GetTypeManage($data);
            return format('ok',200,$list['data']);
        }
    }

    /*
     * 管理牦牛详情
     * */

    public function yak_details(Request $request)
    {
        if($request->isPost()) {
            $data = $request->param();
            $result = $this->validate($data,'Index.details');
            if(true !== $result) return format($result, 400);
            $list = Yaks::GetYakDetails($data);
            return format('ok',200,$list);
        }
    }

    /*
     * 获取任务
     * */
    public function task(Request $request)
    {
        $data = $request->param();
        $list = Herdsman::GetHerdsmanTask($data);
        return format('ok',200,$list);
    }


}