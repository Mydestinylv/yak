<?php

namespace app\common\model;

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

}
