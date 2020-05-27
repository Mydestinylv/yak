<?php

namespace app\common\model;

use app\common\lib\Transfer;
use app\common\task\PastureTask;
use think\Model;
use traits\model\SoftDelete;

class VideoSurveillance extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';
    public function getpasture()
    {
        return $this->hasOne('Pasture','id','p_id')->field('id,pasture_name,introduce');
    }

    public function getPastureIdAttr($value)
    {
        $where['id'] = $value;
        $transfer = PastureTask::valueByWhere($where,'pasture_name');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return $transfer->data['pasture_name'];
    }

    public static function GetPastureVideo()
    {
        try{
            $video = self::with('getpasture')->field('id,surveillance_name,viewing_address,pasture_id as p_id')->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$video];
    }
}
