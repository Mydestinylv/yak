<?php

namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

    ];
	protected $rule = [
        'id' => 'require',
        'user_name' => 'require|max:20',
        'account' => 'require|max:20',
        'password' => 'require|alphaDash',
        'repeat_password'=>'require|confirm:password|alphaDash',
        'old_password' => 'require|alphaDash',
        'tel' => 'require|tel',
        'role_id' => 'number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'user_name.require' => '昵称必须',
        'user_name.max' => '昵称必须不能大于20个字符',
        'account.require' => '账号必须',
        'account.max' => '账号不能超过20个字符',
        'password.require' => '密码必须',
        'password.alphaDash' => '密码必须为字母和数字，下划线_及破折号-',
        'repeat_password.require' => '重复密码必须',
        'repeat_password.alphaDash' => '重复密码必须为字母和数字，下划线_及破折号-',
        'repeat_password.confirm' => '两次密码不一致',
        'old_password.require' => '旧密码必须',
        'old_password.alphaDash' => '旧密码必须为字母和数字，下划线_及破折号-',
        'tel.require' => '手机号码必须',
        'tel.tel' => '手机号码格式错误',
        'role_id.number' => '角色ID必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['user_name','account','password','tel','role_id','repeat_password'],
        'read' => ['id'],
        'update' => ['id'],
        'delete' => ['id'],
    ];
}
