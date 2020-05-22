<?php

namespace app\admin\validate;

use think\Validate;

class HelpfulList extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'customer_id' => 'number|require',
        'helpful_project_id' => 'require|number',
        'helpful_price' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'customer_id.require' => '客户ID必须',
        'customer_id.number' => '客户ID必须是数字',
        'helpful_project_id.require' => '帮扶项目ID必须',
        'helpful_project_id.number' => '帮扶项目ID必须是数字',
        'helpful_price.require' => '帮扶金额必须',
        'helpful_price.number' => '帮扶金额必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['customer_id','helpful_project_id','helpful_price'],
        'read' => ['id'],
        'update' => ['customer_id','helpful_project_id','helpful_price','id'],
        'delete' => ['id'],
    ];
}
