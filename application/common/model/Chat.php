<?php

namespace app\common\model;

use app\common\task\CustomerTask;
use app\common\task\HerdsmanTask;
use app\common\task\SlaughterTask;
use think\Model;
use traits\model\SoftDelete;

class Chat extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

    public function getCustomerNameAttr ($value){
        if(!empty($value)){
            $transfer = CustomerTask::get($value);
            return $transfer->data['real_name'];
        }
    }
    public function getHerdsmanNameAttr ($value){
        if(!empty($value)){
            $transfer = HerdsmanTask::get($value);
            return $transfer->data['name'];
        }
    }
    public function getSlaughterManNameAttr ($value){
        if(!empty($value)){
            $transfer = SlaughterTask::get($value);
            return $transfer->data['name'];
        }
    }
}
