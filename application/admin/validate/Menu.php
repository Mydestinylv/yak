<?php

namespace app\admin\validate;

use think\Validate;

class Menu extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id' => 'require',
        'menu_title' => 'require|max:20',
        'menu_cover' => 'require',
        'menu_type' => 'require|number',
        'menu_content' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'menu_title.require' => '标题必须',
        'menu_title.max' => '标题不能超过20个字符',
        'menu_cover.require' => '封面必须',
        'menu_type.require' => '菜谱类别必须',
        'menu_type.number' => '菜谱类别必须是数字',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['menu_title','menu_cover','menu_type'],
        'read' => ['id'],
        'update' => ['menu_title','menu_cover','menu_type','id'],
        'delete' => ['id'],
    ];
}
