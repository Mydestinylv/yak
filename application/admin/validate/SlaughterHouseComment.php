<?php

namespace app\admin\validate;

use think\Validate;

class SlaughterHouseComment extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'score' => 'number|require',
        'comment_content' => 'max:500|require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'score.number' => '评分必须是数字',
        'score.require' => '评分必须',
        'comment_content.max' => '评论内容不能超过500个字符',
        'comment_content.require' => '评分内容必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => [''],
        'read' => ['id'],
        'update' => ['id', 'score', 'comment_content'],
        'delete' => ['id'],
    ];
}
