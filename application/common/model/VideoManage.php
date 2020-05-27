<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class VideoManage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public static function GetVideo()
    {
        try{
            $video = self::field('id,title,content')->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$video];
    }

}
