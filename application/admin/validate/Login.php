<?php

namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'account' => 'max:20|require',
        'password' => 'max:20|require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'account.max' => '账号不能超过20个字符',
        'account.require' => '账号必须',
        'password.max' => '密码不能超过20个字符',
        'password.require' => '密码必须',
    ];

    //场景定义
    protected $scene = [
        'login' => ['account','password'],
        'save' => [''],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
