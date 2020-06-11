<?php

namespace app\common\model;

use app\common\task\ChatTask;
use app\common\task\CustomerTask;
use app\common\task\HerdsmanTask;
use app\common\task\SlaughterTask;
use think\Model;
use traits\model\SoftDelete;

class Chat extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getCustomerNameAttr ($value){
        if(!empty($value)){
            $transfer = CustomerTask::get($value);
            return $transfer->data['real_name'];
        }
    }
    public function getHerdsmanNameAttr ($value){
        if(!empty($value)){
            $transfer = HerdsmanTask::get($value);
            return $transfer->data['name'];
        }
    }
    public function getSlaughterManNameAttr ($value){
        if(!empty($value)){
            $transfer = SlaughterTask::get($value);
            return $transfer->data['name'];
        }
    }

    /*
     * 客户端查询消息
     * */

    public static function GetUserMsg($params,$customer_id)
    {
        $user_id = $customer_id;
        $to_type = $params['to_type'];
        $to_id = $params['to_id'];
        $arr = [2=>'herdsman_id',3=>'slaughter_man_id'];
        try{
            $list = self::where('customer_id',$user_id)
                ->where($arr[$to_type],$to_id)
                ->whereTime('create_time', 'between', [date('Y-m-d H:i:s',time()-(30*24*60*60)), date('Y-m-d H:i:s')])
                ->field('id,customer_id,'.$arr[$to_type].',content,type,create_time')
                ->order('create_time asc')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }

    /*
     * 牧民端获取消息
     * */
    public static function GetHerdsmanMsg($params,$herdsman_id)
    {
        $id = $herdsman_id;
        $user_id = $params['to_id'];
        try{
            $list = self::where('customer_id',$user_id)
                ->where('herdsman_id',$id)
                ->whereTime('create_time', 'between', [date('Y-m-d H:i:s',time()-(30*24*60*60)), date('Y-m-d H:i:s')])
                ->field('id,customer_id,herdsman_id,content,type,create_time')
                ->order('create_time asc')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }

    /*
     * 屠宰端获取消息
     * */
    public static function GetSlaughterManMsg($params,$slaughter_man_id)
    {
        $id = $slaughter_man_id;
        $user_id = $params['to_id'];
        try{
            $list = self::where('customer_id',$user_id)
                ->where('slaughter_man_id',$id)
                ->whereTime('create_time', 'between', [date('Y-m-d H:i:s',time()-(30*24*60*60)), date('Y-m-d H:i:s')])
                ->field('id,customer_id,slaughter_man_id,content,type,create_time')
                ->order('create_time asc')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }

    /*
     * 客户端发送消息
     * */

    public static function UserSendMsg($params,$customer_id)
    {
        $user_id = $customer_id;
        $to_type = $params['to_type'];
        $to_id = $params['to_id'];
        $arr = [2=>'herdsman_id',3=>'slaughter_man_id'];
        try{
            $list = ChatTask::save([
                'customer_id'=>$user_id,
                $arr[$to_type] =>$to_id,
                'content'=>$params['content'],
                'type'=>1,
                'create_time'=>date('Y-m-d H:i:s')
            ]);
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }

    /*
     * 牧民端发送消息
     * */

    public static function HerdsmanSendMsg($params,$herdsman_id)
    {
        $user_id = $herdsman_id;
        $to_id = $params['to_id'];
        try{
            $list = self::saveAll([
                'customer_id'=>$to_id,
                'herdsman_id' =>$user_id,
                'content'=>$params['content'],
                'type'=>2,
                'create_time'=>date('Y-m-d H:i:s')
            ]);
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }


    /*
     * 屠宰端发送消息
     * */

    public static function SlaughterManSendMsg($params,$slaughter_man_id)
    {
        $user_id = $slaughter_man_id;
        $to_id = $params['to_id'];
        try{
            $list = self::saveAll([
                'customer_id'=>$to_id,
                'slaughter_man_id' =>$user_id,
                'content'=>$params['content'],
                'type'=>2,
                'create_time'=>date('Y-m-d H:i:s')
            ]);
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }
    /*
     * 用户获取消息列表
     * */

    public static function UserGetMsgList($id)
    {
        try{
            $h_list = self::where('customer_id',$id)
                ->where('slaughter_man_id',0)
                ->group('herdsman_id')
                ->order('create_time desc')
                ->select();
            $s_list = self::where('customer_id',$id)
                ->where('herdsman_id',0)
                ->group('slaughter_man_id')
                ->order('create_time desc')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>['h_list'=>$h_list,'s_list'=>$s_list]];
    }


    /*
     * 牧民端获取消息列表
     * */

    public static function HGetMsgList($id)
    {
        try{
            $list = self::where('herdsman_id',$id)
                ->order('create_time desc')
                ->group('customer_id')
                ->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$list];
    }

}
