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

}
