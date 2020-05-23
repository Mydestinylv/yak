<?php

namespace app\admin\validate;

use think\Validate;

class HelpfulPropaganda extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'link' => 'max:50|require',
        'status' => 'require|number',
        'cover' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'link.max:50' => '链接不能超过50个字',
        'link.require' => '链接必须',
        'cover.require' => '封面必须',
        'status.require' => '状态必须',
        'status.number' => '状态必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['link','cover','propaganda_status'],
        'read' => ['id'],
        'update' => ['link','cover','propaganda_status','id'],
        'delete' => ['id'],
    ];
}
