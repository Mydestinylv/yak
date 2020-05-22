<?php

namespace app\admin\validate;

use think\Validate;

class Notice extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'title' => 'require|max:20',
        'content' => 'require|max:1000',
        'link' => 'require|max:100',
        'terminal' => 'require|number',
        'notice_status' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'title.require' => '标题必须',
        'title.max' => '标题不能超过20个字符',
        'content.max' => '内容不能超过1000个字符',
        'content.require' => '内容必须',
        'link.require' => '链接必须',
        'link.max' => '链接不能超过100个字符',
        'terminal.require' => '终端必须',
        'terminal.number' => '终端必须是数字',
        'notice_status.require' => '公告状态必须',
        'notice_status.number' => '公告状态必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['title','content','link','terminal','notice_status'],
        'read' => ['id'],
        'update' => ['title','content','link','terminal','notice_status','id'],
        'delete' => ['id'],
    ];
}
