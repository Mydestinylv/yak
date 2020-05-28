<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Herdsman extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    /*
     * 远程一对多关联查询
     * */
    public function gettask()
    {
        return $this->hasMany('TaskManage','pasture_id','pasture_id');
    }

    /*
     * 查询登陆信息
     * */

    public static function dologin($param)
    {
        $userInfo = self::where('tel',$param['tel'])->field('id,tel,password')->find();
        if(empty($userInfo)) return ['code'=>400,'msg'=>'账号不存在'];
        if($userInfo['password']==pswCrypt($param['password'])){
            return ['code'=>200,'msg'=>'ok','data'=>$userInfo];
        }else{
            return ['code'=>400,'msg'=>'密码错误!'];
        }
    }

    /*
     * 获取当前牧民的任务
     * 这里使用远程一对多
     * */
    public static function GetHerdsmanTask($params)
    {
        $herdsman_id = $params['id'];
        try{
            $list = self::with('adopt')->where('id',$herdsman_id)
                ->field('*')->where('herdsman_id',$params['id'])->select();
        }catch (\Exception $e){
            return ['data'=>$e->getMessage(),'code'=>400];
        }
        return ['data'=>$list,'code'=>200];
    }



}
