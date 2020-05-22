<?php

namespace app\admin\validate;

use think\Validate;

class LogisticsOrder extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'logistics_address' => 'require|max:100',
        'logistics_company' => 'require|number',
        'logistics_code' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'logistics_address.require' => '物流地址必须',
        'logistics_address.max' => '物流地址不能超过100个字符',
        'logistics_company.require' => '物流公司必须',
        'logistics_company.number' => '物流公司须是数字',
        'logistics_code.require' => '物流单号必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => [''],
        'update' => ['id','logistics_company','logistics_address','logistics_code'],
        'delete' => [''],
    ];
}
