<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class TaskManage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';
    public static function GetAllTaskManage()
    {
        try{
            $data = self::field('id,task_name,order')
                ->where('finish_time','>',date_now())
                ->order('order asc')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$data];
    }

    public static function SaveTask($params)
    {
        try{
            $res = self::where('id',$params['task_id'])->update([
                'enclosure_url'=>$params['enclosure_url'],
                'finish_time' => date('Y-m-d H:i:s')
            ]);
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>'ok'];
    }

}
