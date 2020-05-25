<?php

namespace app\admin\validate;

use think\Validate;

class HelpfulProject extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'project_title' => 'max:30|require',
        'project_content' => 'require',
        'project_cover' => 'require',
        'end_time' => 'require',
        'helpful_project_status' => 'require|number',
        'helpful_type' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'project_title.max:30' => '项目名称不能超过30个字',
        'project_title.require' => '项目名称必须',
        'project_content.require' => '项目内容必须',
        'project_cover.require' => '项目封面必须',
        'end_time.require' => '结束时间必须',
        'helpful_project_status.require' => '状态必须',
        'helpful_project_status.number' => '状态必须是数字',
        'helpful_type.require' => '帮扶类型必须',
        'helpful_type.number' => '帮扶类型必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['project_title','project_content','project_cover','end_time','helpful_project_status','helpful_type'],
        'read' => ['id'],
        'update' => ['project_title','project_content','project_cover','id','helpful_type'],
        'delete' => ['id'],
    ];
}
