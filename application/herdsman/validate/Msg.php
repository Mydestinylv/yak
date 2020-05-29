<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/29
 * Time: 14:27
 */

namespace app\herdsman\validate;


use app\client\validate\Base;

class Msg extends Base
{
    protected $rule =   [
        'to_id'   => 'require|number',
        'content'   => 'require',
    ];

    protected $message  =   [
        'to_id.require'     => '接收人id必须',
        'to_id.number'     => '接收人id必须是数字',
        'content.require'     => '聊天内容必须',
    ];
    protected $scene = [
        'index'  =>  ['to_id'],
        'send'  =>  ['to_id','content'],
    ];
}