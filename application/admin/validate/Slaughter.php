<?php

namespace app\admin\validate;

use think\Validate;

class Slaughter extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'slaughter_house_id' => 'require|number',
        'yaks_id' => 'require|number',
        'status' => 'require|number',
        'completion_time' => 'require|date',
        'final_box' => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID必须',
        'slaughter_house_id.require' => '屠宰场ID必须',
        'slaughter_house_id.number' => '屠宰场ID必须是数字',
        'yaks_id.require' => '牦牛ID必须',
        'yaks_id.number' => '牦牛ID必须是数字',
        'status.require' => '状态必须',
        'status.number' => '状态必须是数字',
        'completion_time.date' => '完成时间格式错误',
        'completion_time.require' => '完成时间格式必须',
        'final_box.number' => '最终盒数必须是数字',
        'final_box.require' => '最终盒数必须',
    ];

    //场景定义
    protected $scene = [
        'index' => [''],
        'save' => ['slaughter_house_id', 'yaks_id', 'status', 'completion_time', 'final_box'],
        'read' => ['id'],
        'update' => ['slaughter_house_id', 'yaks_id', 'status', 'completion_time', 'final_box', 'id'],
        'delete' => ['id'],
        'slaughterBox' => ['']
    ];
}
