<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Yaks extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


    public function getIsAdoptionAttr($value)
    {
        $array = [1 => '未认养', 2 => '已认养'];
        return $array[$value];
    }

    public function getYaksSexAttr($value)
    {
        $array = [0 => '母', 1 => '公'];
        return $array[$value];
    }
}
