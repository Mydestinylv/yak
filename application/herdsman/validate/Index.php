<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/28
 * Time: 15:46
 */

namespace app\herdsman\validate;


use app\client\validate\Base;

class Index extends Base
{
    protected $rule =   [
        'is_manage'  => 'require|in:1,2',
        'yaks_id'  => 'require|number',
    ];

    protected $message  =   [
        'is_manage.require' => '请传入管理类型',
        'is_manage.in:1,2'     => '管理类型错误',
        'yak_id.in:require'     => '牦牛id必须',
        'is_manage.number'     => '牦牛id必须是数字',
    ];
    protected $scene = [
        'manage'  =>  ['is_manage'],
        'details'  =>  ['yak_id'],
    ];
}