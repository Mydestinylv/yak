<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class CardManage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


    public function getStatusAttr($value)
    {
        $array = [1 => '未绑定', 2 => '已绑定', 3=>'已使用',4=>'已过期'];
        return $array[$value];
    }
}
