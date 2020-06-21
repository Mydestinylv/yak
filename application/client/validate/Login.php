<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/22
 * Time: 11:32
 */

namespace app\client\validate;


class Login extends Base
{
    protected $rule =   [
        'tel'  => 'require|checkMobile',
        'password'   => 'require|checkpwd',
        'repassword'   => 'require|confirm:password',
        'code'   => 'require|number|length:4',
    ];

    protected $message  =   [
        'tel.require' => '电话号码必须',
        'tel.checkMobile'     => '手机号格式不正确',
        'tel.unique:tel'     => '该手机号已注册',
        'password.require'   => '年龄必须是数字',
        'password.checkpwd'  => '密码6-16位字符（英文/数字/符号,至少两种或下划线组合）',
        'repassword.require'  => '请确认密码',
        'repassword.confirm:password'  => '密码前后不一致',
        'code.require'  => '验证码必须',
        'code.number'  => '验证码必须是数字',
        'code.length:4'  => '验证码长度是4位',
    ];
    protected $scene = [
        'login'  =>  ['tel'],
        'register'  =>  ['tel'  => 'require|checkMobile|unique:customer','password','repassword','code'],
        'wechatLogin'  =>  [''],
        'wechatRegister'  =>  ['require|checkMobile|unique:customer','code'],
    ];

}