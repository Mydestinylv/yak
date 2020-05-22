<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class SaleOrderComment extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';


}
