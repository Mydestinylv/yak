<?php

namespace app\move\validate;

use think\Validate;

class Feedback extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'description'   =>  'require|max:500',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [

    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['description'],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
