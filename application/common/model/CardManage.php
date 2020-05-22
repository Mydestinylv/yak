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
        $array = [1 => '已绑定', 2 => '未绑定'];
        return $array[$value];
    }
}
