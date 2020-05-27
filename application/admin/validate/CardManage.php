<?php

namespace app\admin\validate;

use think\Validate;

class CardManage extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'customer_id' => 'require',
        'card_number' => 'require|max:24',
        'secret_key' => 'require|max:128',
        'status' => 'require',
        'balance' => 'require',
        'expire_time'   =>  'require'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'customer_id.require' => '客户id必须',
        'card_number.max' => '卡号不能大于24个字符',
        'card_number.require' => '卡号必须',
        'secret_key.max' => '密钥不能大于128个字符',
        'sekey.require' => '密钥必须',
        'status.require' => '状态必须',
        'expire_time.require' => '过期时间必须',
        'balance.require' => '余额（元）必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['card_number','secret_key','balance','expire_time'],
        'read' => ['id'],
        'update' => ['id','card_number','secret_key','expire_time','balance'],
        'delete' => ['id'],
    ];
}
