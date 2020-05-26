<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class HelpfulPropaganda extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


    public function getPropagandaStatusAttr($value)
    {
        $array = [1=>'正常'];
        return $array[$value];
    }

    /*
     * 查询最新的状态为需要帮扶的一个记录
     * */

    public static function GetOneHelpful()
    {
        try{
            $list = self::where('propaganda_status',1)
                ->order('create_time desc')
                ->limit(1)
                ->select();
            return ['code'=>200,'msg'=>$list[0]];
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }

    }
}
