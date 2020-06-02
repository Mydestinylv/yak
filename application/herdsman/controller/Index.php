<?php
namespace app\herdsman\controller;
use app\common\controller\App;
use app\common\model\BannerManage;
use app\common\model\Herdsman;
use app\common\model\Notice;
use app\common\model\TaskManage;
use app\common\model\Yaks;
use think\Request;
use app\admin\action\UploadAction;
use think\Log;
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
            return format('ok',200,$list['data']);
        }
    }

    /*
     * 获取任务
     * */
    public function task(Request $request)
    {
        $data = $request->param();
        $list = Herdsman::GetHerdsmanTask($data);
        if($list['code']==400) {
            return format($list['data'],200);
        }else{
            return format('ok',200,$list['data']);
        }
    }

    /*
     * 上传文件
     * */

    public function upfile(Request $request)
    {
        try {
            $param = $request->param();
            $param['file'] = Request()->file('file');
            $result = $this->validate($param, 'app\admin\validate\Upload.index');
            if ($result !== true) {
                return format($result);
            }
            $transfer = UploadAction::index($param);
            if (!$transfer->status) {
                $message = $transfer->message ?: '显示资源列表失败';
                if ($this->environment === 'test') {
                    return format($message, 400, array_merge($transfer->data, [__FILE__ . ' ' . __LINE__]));
                } else {
                    Log::error([__CLASS__ . '  ' . __FUNCTION__,
                        'failure_desc' => '获取资源列表失败',
                        'attach' => compact(['param', 'transfer']),
                    ]);
                    return format($message);
                }
            }
            return format('ok', 200, $transfer->data);
        } catch (\Exception $e) {
            return format(exception_deal($e), 400);
        }
    }

    /*
     * 完成项目
     * */

    public function finish_task(Request $request)
    {
        if($request->isPost()) {
            $data = $request->param();
            $result = $this->validate($data,'Index.finish');
            if(true !== $result) return format($result, 400);
            $res = TaskManage::SaveTask($data);
            if($res['code']==400) {
                return format('失败，请重试！');
            }
            return format('ok',200);
        }
    }


}