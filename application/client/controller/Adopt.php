<?php
namespace app\client\controller;
use app\common\controller\App;
use app\common\model\HelpfulProject;
use think\Request;

class Adopt extends App
{
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
}