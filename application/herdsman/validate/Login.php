<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/26
 * Time: 18:33
 */

namespace app\herdsman\validate;


use app\client\validate\Base;

class Login extends Base
{
    protected $rule =   [
        'tel'  => 'require|checkMobile',
    ];

    protected $message  =   [
        'tel.require' => '电话号码必须',
        'tel.checkMobile'     => '手机号格式不正确',
    ];
    protected $scene = [
        'login'  =>  ['tel'],
    ];
}