<?php

namespace app\admin\validate;

use think\Validate;

class Feedback extends Validate
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
        'name' => 'max:20|require',
        'tel' => 'tel|require',
        'customer_id' => 'number|require',
        'description' => 'max:1000|number',
        'feedback_status' => 'number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'name.require' => '反馈人姓名必须',
        'name.max' => '反馈人姓名不能超过20个字符',
        'tel.require' => '反馈人电话必须',
        'tel.tel' => '反馈人电话格式错误',
        'customer_id.require' => '客户ID必须',
        'customer_id.number' => '客户ID必须是数字',
        'description.require' => '问题描述必须',
        'description.max' => '问题描述不能超过1000字符',
        'feedback_status.number' => '反馈状态必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => ['id'],
        'update' => ['description','feedback_status','id'],
        'delete' => ['id'],
    ];
}
