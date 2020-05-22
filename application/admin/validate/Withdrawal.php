<?php

namespace app\admin\validate;

use think\Validate;

class Withdrawal extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'withdrawal_status' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'withdrawal_status.require' => '提现状态必须',
        'withdrawal_status.number' => '提现状态必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => [''],
        'update' => ['id','withdrawal_status'],
        'delete' => [''],
    ];
}
