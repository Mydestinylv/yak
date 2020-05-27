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

}
