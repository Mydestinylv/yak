<?php

namespace app\move\validate;

use think\Validate;

class Customer extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'password'  =>  'require|max:20',
        'old_password'  =>  'require|max:20',
        'repeat_password'=>'require|confirm:password|max:20'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'password.require'=>'新密码必须',
        'password.max'=>'新密码不能超过20个字符',
        'old_password.require'=>'原密码必须',
        'old_password.max'=>'原密码不能超过20个字符',
        'repeat_password.require'=>'重复密码必须',
        'repeat_password.max'=>'重复密码不能超过20个字符',
        'repeat_password.confirm'=>'重复密码与新密码不一致',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
        'changePassword' => ['password','old_password','repeat_password'],
        'PasswordReset' => ['password','repeat_password'],
    ];
}
