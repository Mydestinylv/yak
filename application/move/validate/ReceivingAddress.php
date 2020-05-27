<?php

namespace app\move\validate;

use think\Validate;

class ReceivingAddress extends Validate
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
        'consignee_name' =>  'require|max:10',
        'consignee_tel' =>  'tel|require|',
        'consignee_add' =>  'require|max:50',
        'is_default' =>  'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'consignee_name.require' =>  '收货人姓名必须',
        'consignee_name.max' =>  '收货人姓名不能超过10个字符',
        'consignee_tel.require' =>  '收货人电话必须',
        'consignee_tel.tel' =>  '收货人电话格式错误',
        'consignee_add.max' =>  '收货人地址不能超过50个字符',
        'consignee_add.require' =>  '收货人地址必须',
        'is_default.require' =>  '是否默认地址必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['consignee_name','consignee_tel','consignee_add','is_default'],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
