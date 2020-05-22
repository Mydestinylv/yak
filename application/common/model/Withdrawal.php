<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Withdrawal extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getUserTypeAttr($value)
    {
        $array = [1 => '客户', 2 => '牧民', 3 => '屠夫'];
        return $array[$value];
    }

    public function getWithdrawalStatusAttr($value)
    {
        $array = [1 => '未处理', 2 => '已处理', 3 => '已拒绝'];
        return $array[$value];
    }
}
