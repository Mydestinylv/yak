<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class HelpfulProject extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getHelpfulProjectStatusAttr($value)
    {
        $array = [1 => '正常', 2 => '已截止'];
        return $array[$value];
    }
}
