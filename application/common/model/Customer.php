<?php

namespace app\common\model;

use app\common\task\CustomerTask;
use app\common\task\WechatTask;
use think\Model;
use traits\model\SoftDelete;

class Customer extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getTypeAttr($value)
    {
        $array = [1 => '认养客户', 2 => '潜在客户'];
        return $array[$value];
    }

    public static function UserRegister($param)
    {
        $data = [
            'tel'=>$param['tel'],
            'head_img'=>'',
            'wechat_name'=>'',
            'user_name'=>'',
            'total_balance'=>0,
            'freezing_balance'=>0,
            'real_name'=>'',
            'id_card'=>'',
            'yaks'=>'',
            'password'=>$param['password'],
            'create_time'=>date('Y-m-d H:i:s'),
            'update_time'=>date('Y-m-d H:i:s'),
        ];
        try{
            $transfer = CustomerTask::save($data);
            if(!$transfer->status){
                return ['code'=>400,'msg'=> '注册失败'];
            }
            $wechat_data['customer_id'] = $transfer->data['id'];
            $wechat_data['open_id'] = $param['open_id'];
            $transfer = WechatTask::save($wechat_data);
            if(!$transfer->status){
                return ['code'=>400,'msg'=> '注册失败'];
            }
            return ['code'=>200,'msg'=>'ok'];
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
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
}
