<?php

namespace app\admin\validate;

use think\Validate;

class Upload extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'file'=>'require|file',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'file.require'=>'文件必须',
        'file.file'=>'必须是文件格式',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => [''],
        'update' => [''],
        'delete' => [''],
    ];
}
