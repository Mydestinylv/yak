<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/11/16
 * Time: 16:00
 */

namespace app\common\lib;


class Transfer
{
    public $message = '';
    public $status = false;
    public $data = [];
    public $code = 400;

    public function __construct($message = '',$status = false, array $data = [], $code = 400){
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
        if ($status) {
            $this->code = 200;
        } else {
            $this->code = $code;
        }
    }
}