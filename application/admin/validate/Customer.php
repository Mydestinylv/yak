<?php

namespace app\admin\validate;

use think\Validate;

class Customer extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */

    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

        'id_card' => "/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?/"
    ];
    protected $rule = [
        'id' => 'require',
        'head_img' => 'require',
        'wechat_name' => 'max:15|require',
        'tel' => 'tel|require',
        'user_name' => 'max:15|require',
        'real_name' => 'max:10|require',
        'password' => 'length:8,16|require',
        'type' => 'require',
        'id_card' => 'id_card|require',
        'yaks' => 'max:15|require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'head_img.require' => '头像必须',
        'wechat_name.max' => '微信昵称不能大于15个字符',
        'wechat_name.require' => '微信昵称必须',
        'real_name.max' => '真实姓名不能大于10个字符',
        'real_name.require' => '真实姓名必须',
        'tel.tel' => '手机号码格式不对',
        'tel.require' => '手机号码必须',
        'user_name.max' => '客户账号不能大于15个字符',
        'user_name.require' => '客户账号必须',
        'password.length' => '客户密码长度在8~16',
        'password.require' => '客户密码必须',
        'id_card.id_card' => '身份证错误',
        'id_card.require' => '身份证必须',
        'yaks.max' => '认养牦牛名称不能大于15个字符',
        'yaks.require' => '认养牦牛名称必须',

    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['wechat_name', 'tel', 'user_name', 'password', 'id_card', 'yaks', 'head_img','real_name'],
        'read' => ['id'],
        'update' => ['wechat_name', 'tel', 'user_name', 'id_card', 'yaks', 'head_img','real_name','id'],
        'delete' => ['id'],
        'password_reset' => ['id','password'],
    ];
}
