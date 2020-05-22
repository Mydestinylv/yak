<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Menu extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getMenuTypeAttr($value)
    {
        $array = [1 => '炖菜', 2 => '炒菜', 3 => '清蒸'];
        return $array[$value];
    }
}
