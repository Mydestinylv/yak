<?php

namespace app\admin\validate;

use think\Validate;

class Payment extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $regex = [

        'tel' => "^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\\d{8}$",

    ];
    protected $rule = [
        'id' => 'require',
        'name' => 'require|max:20',
        'tel' => 'require|tel',
        'payment_status' => 'require|number',
        'user_type' => 'require|number',
        'payment_price' => 'require',
        'abstract' => 'max:100',
        'remark' => 'max:1000',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'payment_status.require' => '打款状态必须',
        'payment_status.number' => '打款状态必须是数字',
        'name.require' => '姓名必须',
        'name.max' => '姓名不能超过20个字符',
        'tel.require' => '手机号码必须',
        'tel.tel' => '手机号码格式错误',
        'user_type.require' => '用户类型必须',
        'user_type.number' => '用户类型必须必须是数字',
        'payment_price.require' => '打款金额必须',
        'abstract.max:100' => '摘要不能超过100字符',
        'remark.max:1000' => '备注不能超过1000字符',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['user_type', 'payment_price', 'abstract', 'remark', 'payment_status', 'name', 'tel'],
        'read' => [''],
        'update' => ['id', 'withdrawal_status'],
        'delete' => [''],
    ];
}
