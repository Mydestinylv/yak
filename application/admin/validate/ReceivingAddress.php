<?php

namespace app\admin\validate;

use think\Validate;

class ReceivingAddress extends Validate
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
        'customer_id' => 'require',
        'consignee_name' => 'require|max:10',
        'consignee_tel' => 'require|tel',
        'consignee_add' => 'require|max:100',
        'is_default' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'customer_id.require' => '客户id必须',
        'consignee_name.max' => '收货人姓名不能大于10个字符',
        'consignee_name.require' => '收货人姓名必须',
        'consignee_tel.require' => '收货人电话号码必须',
        'consignee_tel.tel' => '收货人电话号码错误',
        'consignee_add' => '收货地址必须',
        'consignee_add.file' => '收货地址不能大于100个字符',
        'is_default.require' => '地址类型必须',
        'is_default.number' => '地址类型必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['customer_id','consignee_name','consignee_tel','consignee_add','is_default'],
        'read' => ['id'],
        'update' => ['consignee_name','consignee_tel','consignee_add','id'],
        'delete' => ['id'],
    ];
}
