<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/29
 * Time: 13:45
 */

namespace app\client\validate;


class Msg extends Base
{
    protected $rule =   [
        'to_type'  => 'require|number',
        'to_id'   => 'require|number',
        'content'   => 'require',
    ];

    protected $message  =   [
        'to_type.require' => '接收端类型必须',
        'to_type.number'     => '接收端类型必须是数字',
        'to_id.require'     => '接收人id必须',
        'to_id.number'     => '接收人id必须是数字',
        'content.require'     => '聊天内容必须',
    ];
    protected $scene = [
        'index'  =>  ['to_type','to_id'],
        'send'  =>  ['to_type','to_id','content'],
    ];
}