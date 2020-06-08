<?php

namespace app\common\model;

use app\common\task\CustomerTask;
use app\common\task\HelpfulProjectTask;
use app\common\task\WechatTask;
use think\Model;
use traits\model\SoftDelete;

class HelpfulList extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    /*
     * 获取总的帮扶金额和人数集合
     * */
    public function getBodyAttr($value)
    {
        $array = HelpfulProjectTask::valueByWhere(['id'=>$value],'project_title');
        return $array->data['project_title'];
    }

    public function getOpenIdAttr($value)
    {
        $array = WechatTask::valueByWhere(['customer_id'=>$value],'open_id');
        return $array->data['open_id'];
    }

    public static function GetAll()
    {
        $msg = self::query('SELECT COUNT(`id`) AS num,SUM(`helpful_price`) AS money FROM `yak_helpful_list` GROUP BY `helpful_project_id`');
        if($msg){
            return ['code'=>200,'msg'=>[
                'num'=>array_sum(array_column($msg, 'num')),
                'money'=>array_sum(array_column($msg, 'money')),
                'all_num'=>count($msg),
            ]];
        }else{
            return ['code'=>400,'msg'=>'查询出错啦，请重试！'];
        }
    }


    public function userinfo()
    {
        return $this->hasOne('Customer','id','customer_id')->field('id,real_name,head_img');
    }

    /*
     *查询某个帮扶项目的捐款详情
     * */
    public static function GetHelpDetails($id)
    {
        try{
            $info = self::with('userinfo')
                ->where('helpful_project_id',$id)
                ->field('id,customer_id,helpful_price,helpful_project_id,create_time')
                ->order('create_time desc')
                ->select();
            return ['code'=>200,'msg'=>$info];
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
    }

}
