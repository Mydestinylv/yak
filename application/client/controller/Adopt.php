<?php
namespace app\client\controller;
use app\common\controller\App;
use app\common\model\HelpfulList;
use app\common\model\HelpfulProject;
use app\common\model\HelpfulPropaganda;
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
        $msg1 = HelpfulList::GetAll();
        $msg2 = HelpfulProject::GetOneHelpful();
        $msg3 = HelpfulPropaganda::GetOneHelpful();
        $msg = [

        ];
        return format('ok',200,$msg);
    }
}