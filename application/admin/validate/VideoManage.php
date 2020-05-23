<?php

namespace app\admin\validate;

use think\Validate;

class VideoManage extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'title' => 'max:20|require',
        'content' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'title.require' => '标题必须',
        'title.max' => '标题不能超过20个字符',
        'content.require' => '内容必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['title', 'content'],
        'read' => ['id'],
        'update' => ['id', 'title', 'content'],
        'delete' => ['id'],
    ];
}
