<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Notice extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getTerminalAttr($value)
    {
        $array = [1 => '客户端', 2 => '牧民', 3 => '屠宰场'];
        return $array[$value];
    }

    public function getNoticeStatusAttr($value)
    {
        $array = [1 => '正常', 2 => '已下架'];
        return $array[$value];
    }
}
