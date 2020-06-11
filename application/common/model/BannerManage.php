<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class BannerManage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public static function GetBannerManage()
    {
        try{
            $banner_manage = self::field('id,picture,jump_address,is_index')->select();
        }catch (\Exception $e){
            return ['code'=>400,'msg'=>$e->getMessage()];
        }
        return ['code'=>200,'msg'=>$banner_manage];
    }
}
